<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Session;
use Auth;
use Omnipay\Omnipay;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Cart;

class PaypalController extends Controller
{

    private $gateway;
    
    public function __construct(){
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true);
    }

    public function paypal(){
        if(Session::has('order_id')){
            return view('front.paypal.paypal');
        }else{
            return redirect('cart');
        }
    }

    public function pay(Request $request){
        try{    
            $paypal_amount = round(Session::get('grand_total'), 2);
            $response = $this->gateway->purchase(array(
                'amount' => $paypal_amount,
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => url('success'),
                'cancelUrl' => url('error')
            ))->send();

            if($response->isRedirect()){
                $response->redirect();
            }else{
                return $response->getMessage();
            }

        }catch(\Throwable $th){
            return $th->getMessage();
        }
    }

    public function success(Request $request){
        if(!Session::has('order_id')){
            return redirect('cart');
        }
        if($request->input('paymentId') && $request->input('PayerID')){

            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId')
            ));
            $response = $transaction->send();
            if($response->isSuccessful()){
                $arr = $response->getData();
                $payment = new Payment;
                $payment->order_id = Session::get('order_id');
                $payment->user_id = Auth::user()->id;
                $payment->payment_id = $arr['id'];
                $payment->payer_id = $arr['payer']['payer_info']['payer_id'];
                $payment->payer_email = $arr['payer']['payer_info']['email'];
                $payment->amount = $arr['transactions'][0]['amount']['total'];
                $payment->currency = env('PAYPAL_CURRENCY');
                $payment->payment_status = $arr['state'];
                $payment->save();
                /* return "El pago se ha realizado correctamente. Su transacción es ". $arr['id']; */

                // actualizar el pedido
                $order_id = Session::get('order_id');

                //Actualizar el status a pagado
                Order::where('id',$order_id)->update(['order_status'=>'Pagado']);

                $orderDetails = Order::with('orders_products')->where('id',$order_id)->first()->toArray();

                //enviar el mensaje de email
                $email = Auth::user()->email;
                $messageData = [
                    'email' => $email,
                    'name' => Auth::user()->name,
                    'order_id' => $order_id,
                    'orderDetails' => $orderDetails
                ];
                Mail::send('emails.order',$messageData,function($message)use($email){
                    $message->to($email)->subject('Pedido Realizado..! Gracias por su compra, te esperamos pronto!');
                });

                //reducir el stock
                foreach($orderDetails['orders_products'] as $key => $order){
                    $getProductStock = ProductsAttribute::getProductStock($order['product_id'],$order['producto_tamano']);
                    $newStock = $getProductStock - $order['producto_qty'];
                    ProductsAttribute::where(['product_id'=>$order['product_id'],'tamano'=>$order['producto_tamano']])->update(['stock'=>$newStock]);
                }
                
                Cart::where('user_id',Auth::user()->id)->delete();
                return view('front.paypal.success');

            }else{
                return $response->getMessage();
            }

        }else{
            return "Pago Rechazado!";
        }
    }

    public function error(){
        /* return "El usuario rechazó el pago"; */
        return view('front.paypal.fail');
    }
}
