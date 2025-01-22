<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ShippingCharge;
use Session;

class ShippingController extends Controller
{
    public function shippingCharges(){
        Session::put('page','shipping');
        $shippingCharges = ShippingCharge::get()->toArray();
        /* dd($shippingCharges); */
        return view('admin.shipping.shipping_charges')->with(compact('shippingCharges'));
    }

    public function updateShippingStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ShippingCharge::where('id',$data['shipping_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'shipping_id'=>$data['shipping_id']]);
        
        }
    }

    public function editShippingCharges($id, Request $request)
    {
        Session::put('page', 'shipping');
        
        if ($request->isMethod('post')) {
            // Validar que 'tarifa' contenga solo números (incluyendo decimales)
            $request->validate([
                'tarifa' => 'required|numeric'
            ], [
                'tarifa.required' => 'El campo tarifa es obligatorio.',
                'tarifa.numeric' => 'El campo tarifa debe ser un número válido (0.00)'
            ]);
            
            $data = $request->all();
            
            // Asegurarse de que 'tarifa' esté en el formato correcto (reemplazar coma por punto)
            $tarifa = str_replace(',', '.', $data['tarifa']);
            
            // Realizar la actualización
            ShippingCharge::where('id', $id)->update(['tarifa' => $tarifa]);
            $message = "Cargo de Envio actualizado correctamente!";
            
            return redirect()->back()->with('success_message', $message);
        }
        
        $shippingDetails = ShippingCharge::where('id', $id)->first();
        $title = "Editar el cargo de envio";
        return view('admin.shipping.edit_shipping_charges')->with(compact('shippingDetails', 'title'));
    }

}
