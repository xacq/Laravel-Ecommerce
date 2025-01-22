<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliveryAddress;
use App\Models\Country;
use Auth;
use Validator;

class AddressController extends Controller
{
    /* public function getDeliveryAddress(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $deliveryAddresses = DeliveryAddress::where('id',$data['addressid'])->first()->toArray();
            return response()->json(['address'=>$deliveryAddresses]);
        }
    }

    public function saveDeliveryAddress(Request $request){
        if($request->ajax()){
            $validator = Validator::make($request->all(), [
                'delivery_nombre' => 'required|string|max:100',
                'delivery_direccion' => 'required|string|max:100',
                'delivery_ciudad' => 'required|string|max:100',
                'delivery_estado' => 'required|string|max:100',
                'delivery_pais' => 'required|string|max:100',
                'delivery_pincodigo' => 'required|digits:6',
                'delivery_celular' => 'required|numeric|digits:10',
            ], [
                'delivery_nombre.required' => 'El nombre de entrega es obligatorio.',
                'delivery_direccion.required' => 'La dirección de entrega es obligatoria.',
                'delivery_ciudad.required' => 'La ciudad de entrega es obligatoria.',
                'delivery_estado.required' => 'El estado de entrega es obligatorio.',
                'delivery_pais.required' => 'El país de entrega es obligatorio.',
                'delivery_pincodigo.required' => 'El código PIN de entrega es obligatorio.',
                'delivery_pincodigo.digits' => 'El código PIN de entrega debe tener exactamente 6 dígitos.',
                'delivery_celular.required' => 'El número de celular de entrega es obligatorio.',
                'delivery_celular.numeric' => 'El número de celular de entrega debe ser un número.',
                'delivery_celular.digits' => 'El número de celular de entrega debe tener exactamente 10 dígitos.',
            ]);
            
            if($validator->passes()){
                $data = $request->all();
                //echo "<pre>"; print_r($data); die;
                $address = array();
                $address['user_id']=Auth::user()->id;
                $address['nombre']=$data['delivery_nombre'];
                $address['direccion']=$data['delivery_direccion'];
                $address['ciudad']=$data['delivery_ciudad'];
                $address['estado']=$data['delivery_estado'];
                $address['pais']=$data['delivery_pais'];
                $address['pincodigo']=$data['delivery_pincodigo'];
                $address['celular']=$data['delivery_celular'];
                if(!empty($data['delivery_id'])){
                    
                    //editar la direccion de delivery
                    DeliveryAddress::where('id',$data['delivery_id'])->update($address);
                }else{
                    //$address['status']=1;
                    //agregar la direccion de delivery
                    DeliveryAddress::create($address);

                }
                $deliveryAddresses = DeliveryAddress::deliveryAddresses();
                $countries = Country::where('status',1)->get()->toArray();
                return response()->json([
                    'view'=>(String)View::make('front.products.delivery_addresses')->with(compact('deliveryAddresses','countries'))
                ]);
            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

        }
    }

    public function removeDeliveryAddress(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            DeliveryAddress::where('id',$data['addressid'])->delete();
            $deliveryAddresses = DeliveryAddress::deliveryAddresses();
            $countries = Country::where('status',1)->get()->toArray();
            return response()->json([
                'view'=>(String)View::make('front.products.delivery_addresses')->with(compact('deliveryAddresses','countries'))
            ]);
        }
    } */

    public function getDeliveryAddress(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $deliveryAddresses = DeliveryAddress::where('id',$data['addressid'])->first()->toArray();
            return response()->json(['address'=>$deliveryAddresses]);
        }
    }

    public function saveDeliveryAddress(Request $request){
        if($request->ajax()){
            $validator = Validator::make($request->all(), [
                'delivery_nombre' => 'required|string|max:100',
                'delivery_direccion' => 'required|string|max:100',
                'delivery_ciudad' => 'required|string|max:100',
                'delivery_estado' => 'required|string|max:100',
                'delivery_pais' => 'required|string|max:100',
                'delivery_pincodigo' => 'required|digits:10',
                'delivery_celular' => 'required|numeric|digits:10',
            ], [
                'delivery_nombre.required' => 'El nombre de entrega es obligatorio.',
                'delivery_direccion.required' => 'La dirección de entrega es obligatoria.',
                'delivery_ciudad.required' => 'La ciudad de entrega es obligatoria.',
                'delivery_estado.required' => 'El estado de entrega es obligatorio.',
                'delivery_pais.required' => 'El país de entrega es obligatorio.',
                'delivery_pincodigo.required' => 'El código PIN de entrega es obligatorio.',
                'delivery_pincodigo.digits' => 'El código PIN de entrega debe tener exactamente 6 dígitos.',
                'delivery_celular.required' => 'El número de celular de entrega es obligatorio.',
                'delivery_celular.numeric' => 'El número de celular de entrega debe ser un número.',
                'delivery_celular.digits' => 'El número de celular de entrega debe tener exactamente 10 dígitos.',
            ]);

            if($validator->passes()){
                $data = $request->all();
                $address = array();
                $address['user_id']=Auth::user()->id;
                $address['nombre']=$data['delivery_nombre'];
                $address['direccion']=$data['delivery_direccion'];
                $address['ciudad']=$data['delivery_ciudad'];
                $address['estado']=$data['delivery_estado'];
                $address['pais']=$data['delivery_pais'];
                $address['pincodigo']=$data['delivery_pincodigo'];
                $address['celular']=$data['delivery_celular'];
                if(!empty($data['delivery_id'])){
                    
                    //editar la direccion de delivery
                    DeliveryAddress::where('id',$data['delivery_id'])->update($address);
                }else{
                    //$address['status']=1;
                    //agregar la direccion de delivery
                    DeliveryAddress::create($address);

                }
                $deliveryAddresses = DeliveryAddress::deliveryAddresses();
                $countries = Country::where('status',1)->get()->toArray();
                return response()->json([
                    'view'=>(String)View::make('front.products.delivery_addresses')->with(compact('deliveryAddresses','countries'))
                ]);
            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }
        }
    }

    public function removeDeliveryAddress(Request $request){
        if($request->ajax()){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            DeliveryAddress::where('id',$data['addressid'])->delete();
            $deliveryAddresses = DeliveryAddress::deliveryAddresses();
            $countries = Country::where('status',1)->get()->toArray();
            return response()->json([
                'view'=>(String)View::make('front.products.delivery_addresses')->with(compact('deliveryAddresses','countries'))
            ]);
        }
    }
}
