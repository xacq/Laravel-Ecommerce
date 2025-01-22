<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\User;
use App\Models\Brand;
use App\Models\Section;
use Session;
use Auth;

class CouponsController extends Controller
{
    public function coupons(){
        Session::put('page','coupons');
        $adminTipo = Auth::guard('admin')->user()->tipo;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;
        if($adminTipo == "vendedor"){
            $vendorStatus = Auth::guard('admin')->user()->status;
            if($vendorStatus==0){
                return redirect("admin/update-vendor-details/personal")->with('error_message','Su cuenta de proveedor aún no está aprobada. Por favor asegúrese de llenar su formulario válido: datos personales, comerciales y bancarios');
            }
            $coupons = Coupon::where('vendor_id',$vendor_id)->get()->toArray();
        }else{
            $coupons = Coupon::get()->toArray();
        }
        
        /* dd($coupons); */
        return view('admin.coupons.coupons')->with(compact('coupons'));
    }

    public function updateCouponStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Coupon::where('id',$data['coupon_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'coupon_id'=>$data['coupon_id']]);
        
        }
    }

    public function deleteCoupon($id){
        //Eliminar marca
        Coupon::where('id',$id)->delete();
        $message = "Cupón eliminada correctamente";
        return redirect()->back()->with('success_message',$message);
    }

    public function addEditCoupon(Request $request, $id=null){
        if($id==""){
            //Agregar cupon
            $title = "Agregar Cupón";
            $coupon = new Coupon;
            $selCats = array();
            $selBrands = array();
            $selUsers = array();
            $message = "Cupón agregado correctamente";
        }else{
            //Actulizar cupon
            $title = "Editar Cupón";
            $coupon = Coupon::find($id);
            $selCats = explode(',',$coupon['categories']);
            $selBrands = explode(',',$coupon['brands']);
            $selUsers = explode(',',$coupon['users']);
            $message= "Cupón actualizado correctamente";    
        }

        if($request->isMethod('post')){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */

           $rules = [
            'categories' => 'required',
            'brands' => 'required',
            'cupon_opcion' => 'required',
            'cupon_tipo' => 'required',
            'amount_tipo' => 'required',
            'amount' => 'required|numeric',
            'fecha_caducidad' => 'required',
            ];
            $customMessages = [
                'categories.required' => 'Seleccione la Categoria',
                'brands.required' => 'Seleccione la Marca',
                'cupon_opcion.regex' => 'Seleccione la Opción del Cupón',
                'cupon_tipo.required' => 'Seleccione la tipo del Cupón',
                'amount_tipo.required' => 'Código del producto no es válido',
                'amount.required' => 'Ingrese el Monto de Cupón',
                'amount.numeric' => 'Monto del Cupón no es válido, debe ser numérico',
                'fecha_caducidad.required' => 'Ingrese la Fecha de Caducidad'
            ];
            $this->validate($request,$rules,$customMessages);

            if(isset($data['categories'])){
                $categories = implode(",",$data['categories']);
            }else{
                $categories = "";
            }

            if(isset($data['brands'])){
                $brands = implode(",",$data['brands']);
            }else{
                $brands = "";
            }

            if(isset($data['users'])){
                $users = implode(",",$data['users']);
            }else{
                $users = "";
            }

            if($data['cupon_opcion']=="Automatic"){
                $cupon_codigo = str_random(8);
            }else{
                $cupon_codigo = $data['cupon_codigo'];
            }

            $adminTipo = Auth::guard('admin')->user()->tipo;
            if($adminTipo=="vendedor"){
                $coupon->vendor_id = Auth::guard('admin')->user()->vendor_id;
            }else{
                $coupon->vendor_id = 0;
            }

            $coupon->cupon_opcion = $data['cupon_opcion'];
            $coupon->cupon_codigo = $cupon_codigo;
            $coupon->categories = $categories;
            $coupon->brands = $brands;
            $coupon->users = $users;
            $coupon->cupon_tipo = $data['cupon_tipo'];
            $coupon->amount_tipo = $data['amount_tipo'];
            $coupon->amount = $data['amount'];
            $coupon->fecha_caducidad = $data['fecha_caducidad'];
            $coupon->status = 1;
            $coupon->save();
            return redirect('admin/coupons')->with('success_message',$message);

        }

        // Obtener la sección con la categoría y subcategoría
        $categories = Section::with('categories')->get()->toArray();
        // Obtener las marcas
        $brands = Brand::where('status',1)->get()->toArray();

        //obtener todos los email de usuarios
        $users = User::select('email')->where('status',1)->get();

        return view('admin.coupons.add_edit_coupon')->with(compact('title','coupon','categories','brands','users','selCats','selBrands','selUsers'));
    }   
}
