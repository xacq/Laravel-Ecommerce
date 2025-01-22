<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrdersProduct;
use Auth;

class OrderController extends Controller
{
    public function orders($id=null){
        if(empty($id)){
            $orders = Order::with('orders_products')->where('user_id',Auth::user()->id)->orderBy('id','Desc')->get()->toArray();
            return view('front.orders.orders')->with(compact('orders'));
        }else{
            $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
            /* dd($orderDetails); */
            return view('front.orders.order_details')->with(compact('orderDetails'));
        }
    }

     public function thanksOnline(Request $request)
    {
        // Aquí manejas los datos del request, como $request->id y $request->clientTransactionId
        $id = $request->id;
        $clientTransactionId = $request->clientTransactionId;

        // Puedes hacer algo con estos datos, como actualizar la orden en la base de datos, etc.

        // Por ahora, solo vamos a retornan una vista con los datos
        return view('front.products.thanks_online', compact('id','clientTransactionId'));
    }
}
