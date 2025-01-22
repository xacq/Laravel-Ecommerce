<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Hash; 
use Auth;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\VendorsBusinessDetail;
use App\Models\VendorsBankDetail;
use App\Models\Country;
use App\Models\Section;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Brand;
use App\Models\User;
use App\Models\NewsletterSubscriber;

use Image;
use Session;

class AdminController extends Controller
{
    public function dashboard(){
        Session::put('page','dashboard');
        $sectionsCount = Section::count();
        $categoriesCount = Category::count();
        $productsCount = Product::count();
        $ordersCount = Order::count();
        $couponsCount = Coupon::count();
        $brandsCount = Brand::count();
        $usersCount = User::count();
        $NewsletterSubscribersCount = NewsletterSubscriber::count();
        return view('admin.dashboard')->with(compact('sectionsCount','categoriesCount','productsCount','ordersCount','couponsCount','brandsCount','usersCount','NewsletterSubscribersCount'));
    }

    public function updateAdminPassword(Request $request){
        Session::put('page','update_admin_password');
        if($request->isMethod('post')){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            //verificar si la contrasena actual ingresada por el administrador es correcta
            if(Hash::check($data['contrasena_actual'],Auth::guard('admin')->user()->password)){
                //verificar si la nueva contrasena es igual que en a confirmar contrasena
                if($data['confirmar_contrasena']==$data['nueva_contrasena']){
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['nueva_contrasena'])]);
                    return redirect()->back()->with('success_message','Contraseña se actualizo correctamente');
                }else{
                    return redirect()->back()->with('error_message','La contraseña no coiciden');
                }  
            }else{
                return redirect()->back()->with('error_message','Contraseña actual es incorrecta');
            }
        }
        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.settings.update_admin_password')->with(compact('adminDetails'));
    }

    public function updateVendorPassword(Request $request){
        Session::put('page','update_vendor_password');
        if($request->isMethod('post')){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            //verificar si la contrasena actual ingresada por el administrador es correcta
            if(Hash::check($data['contrasena_actual'],Auth::guard('admin')->user()->password)){
                //verificar si la nueva contrasena es igual que en a confirmar contrasena
                if($data['confirmar_contrasena']==$data['nueva_contrasena']){
                    Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['nueva_contrasena'])]);
                    return redirect()->back()->with('success_message','Contraseña se actualizo correctamente');
                }else{
                    return redirect()->back()->with('error_message','La contraseña no coiciden');
                }  
            }else{
                return redirect()->back()->with('error_message','Contraseña actual es incorrecta');
            }
        }
        $adminDetails = Admin::where('email',Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.settings.update_vendor_password')->with(compact('adminDetails'));
    }

    public function checkAdminPassword(Request $request){
        $data = $request->all();
        /* echo "<pre>"; print_r($data); die; */
        if(Hash::check($data['contrasena_actual'],Auth::guard('admin')->user()->password)){
            return "true";
        }else{
            return "false";
        } 
    }

    public function updateAdminDetails(Request $request){
        Session::put('page','update_admin_details');
        if($request->isMethod('post')){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */

            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric',

            ];
            $customMessages = [
                'admin_name.required' => 'Nombre es obligatorio',
                'admin_name.regex' => 'Nombre no es válido',
                'admin_mobile.required' => 'Celular es obligatorio',
                'admin_mobile.numeric' => 'Celular: Debe ingresar solo números'
            ];
            $this->validate($request,$rules,$customMessages);
 
            //Upload Admin Photo
            if ($request->hasFile('admin_image')) {
                $image = $request->file('admin_image');
                if ($image->isValid()) {
                    // Genera un nombre único para la imagen
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    
                    // Define la ruta donde se guardará la imagen (fuera de laravel)
                    $imagePath = base_path('../admin/images/photos');

                    // Crear la carpeta si no existe
                    if (!is_dir($imagePath)) {
                        mkdir($imagePath, 0755, true);
                    }

                    // Mueve la imagen a la ruta especificada
                    $image->move($imagePath, $imageName);
                }
            } else if (!empty($data['actual_admin_image'])) {
                $imageName = $data['actual_admin_image'];
            } else {
                $imageName = "";
            }

            //actualizar detalles admin
            Admin::where('id',Auth::guard('admin')->user()->id)->update(['nombre'=>$data['admin_name']
            ,'celular'=>$data['admin_mobile'],'imagen'=>$imageName]);
            return redirect()->back()->with('success_message','Datos actualizados correctamente');
        }
        return view('admin.settings.update_admin_details');
    }

    public function updateVendorDetails($slug,Request $request){
        if($slug=="personal"){
            Session::put('page','update_personal_details');
            if($request->isMethod('post')){
                $data = $request->all();
 
                $rules = [
                    'vendor_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'vendor_ciudad' => 'required|regex:/^[\pL\s\-]+$/u',
                    'vendor_pais' => 'required|regex:/^[\pL\s\-]+$/u',
                    'vendor_celular' => 'required|numeric',
                    'vendor_codigopin' => 'required|numeric',
    
                ];
                $customMessages = [
                    'vendor_name.required' => 'Nombre es obligatorio',
                    'vendor_ciudad.required' => 'Ciudad es obligatorio',
                    'vendor_name.regex' => 'Nombre no es válido',
                    'vendor_ciudad.regex' => 'Ciudad no es válido',
                    'vendor_pais.regex' => 'Pais no es válido',
                    'vendor_celular.required' => 'Celular es obligatorio',
                    'vendor_celular.numeric' => 'Celular: Debe ingresar solo números',
                    'vendor_codigopin.numeric' => 'Codigo pin: Debe ingresar solo números'
                ];
                $this->validate($request,$rules,$customMessages);
     
                //Upload Admin Photo
                if ($request->hasFile('vendor_image')) {
                    $image = $request->file('vendor_image');
                    if ($image->isValid()) {
                        // Genera un nombre único para la imagen
                        $imageName = time() . '.' . $image->getClientOriginalExtension();
                        
                        // Define la ruta donde se guardará la imagen (fuera de laravel)
                        $imagePath = base_path('../admin/images/photos');

                        // Crear la carpeta si no existe
                        if (!is_dir($imagePath)) {
                            mkdir($imagePath, 0755, true);
                        }

                        // Mueve la imagen a la ruta especificada
                        $image->move($imagePath, $imageName);
                    }
                } else if (!empty($data['actual_vendor_image'])) {
                    $imageName = $data['actual_vendor_image'];
                } else {
                    $imageName = "";
                }
    
                //actualizar tabla admin
                Admin::where('id',Auth::guard('admin')->user()->id)->update(['nombre'=>$data['vendor_name']
                ,'celular'=>$data['vendor_celular'],'imagen'=>$imageName]);
                //Actualizar tabla vendedor
                Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->update(['nombre'=>$data['vendor_name']
                ,'celular'=>$data['vendor_celular'],'direccion'=>$data['vendor_direccion'],'ciudad'=>$data['vendor_ciudad'],'estado'=>$data['vendor_estado'],'pais'=>$data['vendor_pais']
                ,'codigopin'=>$data['vendor_codigopin']]);
                return redirect()->back()->with('success_message','Datos Vendedor actualizados correctamente');
            }
            $vendorDetails = Vendor::where('id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        }else if($slug=="business"){    
            Session::put('page','update_business_details');
            if($request->isMethod('post')){
                $data = $request->all();
                

                $rules = [
                    'nombre_tienda' => 'required|regex:/^[\pL\s\-]+$/u',
                    'ciudad_tienda' => 'required|regex:/^[\pL\s\-]+$/u',
                    'pais_tienda' => 'required|regex:/^[\pL\s\-]+$/u',
                    'celular_tienda' => 'required|numeric',
                    'codigopin_tienda' => 'required|numeric',
    
                ];
                $customMessages = [
                    'nombre_tienda.required' => 'Nombre es obligatorio',
                    'ciudad_tienda.required' => 'Ciudad es obligatorio',
                    'nombre_tienda.regex' => 'Nombre no es válido',
                    'ciudad_tienda.regex' => 'Ciudad no es válido',
                    'pais_tienda.regex' => 'Pais no es válido',
                    'celular_tienda.required' => 'Celular es obligatorio',
                    'celular_tienda.numeric' => 'Celular: Debe ingresar solo números',
                    'codigopin_tienda.numeric' => 'Codigo pin: Debe ingresar solo números',

                ];
                $this->validate($request,$rules,$customMessages);
     
                //Upload Admin Photo
                if ($request->hasFile('address_proof_image')) {
                    $image = $request->file('address_proof_image');
                    if ($image->isValid()) {
                        // Genera un nombre único para la imagen
                        $imageName = time() . '.' . $image->getClientOriginalExtension();
                        
                        // Define la ruta donde se guardará la imagen
                        $imagePath = base_path('../admin/images/proofs');

                        // Crear la carpeta si no existe
                        if (!is_dir($imagePath)) {
                            mkdir($imagePath, 0755, true);
                        }

                        // Mueve la imagen a la ruta especificada
                        $image->move($imagePath, $imageName);
                    }
                } else if (!empty($data['actual_address_proof'])) {
                    $imageName = $data['actual_address_proof'];
                } else {
                    $imageName = "";
                }
                $vendorCount = VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
                if ($vendorCount > 0) {
                    // Actualizar tabla detalles de negocio
                    VendorsBusinessDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update([
                        'nombre_tienda' => $data['nombre_tienda'],
                        'celular_tienda' => $data['celular_tienda'],
                        'direccion_tienda' => $data['direccion_tienda'],
                        'ciudad_tienda' => $data['ciudad_tienda'],
                        'estado_tienda' => $data['estado_tienda'],
                        'pais_tienda' => $data['pais_tienda'],
                        'codigopin_tienda' => $data['codigopin_tienda'],
                        'business_licencia_numero' => $data['business_licencia_numero'] ?? null,
                        'usd_moneda' => $data['usd_moneda'] ?? null,
                        'pan_number' => $data['pan_number'] ?? null, // Verifica si existe
                        'address_proof' => $data['address_proof'] ?? null,
                        'address_proof_image' => $imageName,
                    ]);
                } else {
                    // Insertar tabla detalles de negocio
                    VendorsBusinessDetail::insert([
                        'vendor_id' => Auth::guard('admin')->user()->vendor_id,
                        'nombre_tienda' => $data['nombre_tienda'],
                        'celular_tienda' => $data['celular_tienda'],
                        'direccion_tienda' => $data['direccion_tienda'],
                        'ciudad_tienda' => $data['ciudad_tienda'],
                        'estado_tienda' => $data['estado_tienda'],
                        'pais_tienda' => $data['pais_tienda'],
                        'codigopin_tienda' => $data['codigopin_tienda'],
                        'business_licencia_numero' => $data['business_licencia_numero'] ?? null,
                        'usd_moneda' => $data['usd_moneda'] ?? null,
                        'pan_number' => $data['pan_number'] ?? null, // Verifica si existe
                        'address_proof' => $data['address_proof'] ?? null,
                        'address_proof_image' => $imageName,
                    ]);
                }
                return redirect()->back()->with('success_message','Datos Vendedor actualizados correctamente');
            }
            $vendorCount = VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
            if($vendorCount>0){
                $vendorDetails = VendorsBusinessDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
            }else{
                $vendorDetails = array();
            }
                       
        }else if($slug=="bank"){
            Session::put('page','update_bank_details');
            if($request->isMethod('post')){
                $data = $request->all();
                

                $rules = [
                    'cuenta_personal_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'banco_name' => 'required',
                    'cuenta_numero' => 'required|numeric',
                    'banco_ifsc_code' => 'required',
                ];
                $customMessages = [
                    'cuenta_personal_name.required' => 'Nombre de la cuenta personal es obligatorio',
                    'cuenta_personal_name.regex' => 'Nombre de la cuenta personal no es válido',
                    'banco_name.required' => 'Nombre del banco es obligatorio',
                    'cuenta_numero.required' => 'Numero de la cuenta es obligatorio',
                    'cuenta_numero.numeric' => 'Numero de cuenta: debe ser solo numeros',
                    'banco_ifsc_code.required' => 'Codigo bancario es obligatorio',

                ];
                $this->validate($request,$rules,$customMessages);
    
                $vendorCount = VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
                if($vendorCount>0){
                //Actualizar tabla baco del vendedor
                    VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->update(['cuenta_personal_name'=>$data['cuenta_personal_name']
                    ,'banco_name'=>$data['banco_name'],'cuenta_numero'=>$data['cuenta_numero'],'banco_ifsc_code'=>$data['banco_ifsc_code']]);
                }else{
                    VendorsBankDetail::insert(['vendor_id'=>Auth::guard('admin')->user()->vendor_id,'cuenta_personal_name'=>$data['cuenta_personal_name']
                    ,'banco_name'=>$data['banco_name'],'cuenta_numero'=>$data['cuenta_numero'],'banco_ifsc_code'=>$data['banco_ifsc_code']]);
                }
                return redirect()->back()->with('success_message','Datos Vendedor actualizados correctamente');
            }
            $vendorCount = VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->count();
            if($vendorCount>0){
                $vendorDetails = VendorsBankDetail::where('vendor_id',Auth::guard('admin')->user()->vendor_id)->first()->toArray();
            }else{
                $vendorDetails = array();
            }
            
        }
        $countries = Country::where('status',1)->get()->toArray();
        return view('admin.settings.update_vendor_details')->with(compact('slug','vendorDetails','countries'));
    }

    public function updateVendorComision(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            // Validar que la comisión sea un número válido sin comas
            $request->validate([
                'comision' => [
                    'required',
                    'regex:/^\d+(\.\d+)?$/', // Expresión regular para números sin comas
                ]
            ], [
                'comision.required' => 'El campo de comisión es obligatorio.',
                'comision.regex' => 'La comisión debe ser un número válido sin comas (utilice punto como separador decimal).'
            ]);
            
            //actualiar la tabla vendors
            Vendor::where('id',$data['vendor_id'])->update(['comision'=>$data['comision']]);
            return redirect()->back()->with('success_message','Comisión del vendedor actualizada correctamente!');
        }
    }
 
    public function login(Request $request){
        //echo $contrasena = Hash::make('12345'); die;
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];

            $customMessages = [
                //Mensahe personaliado en los campos de inicio de sesion
                'email.required' => 'El email es obligatorio',
                'email.email' => 'Email válido es requerido',
                'password.required' => 'La contraseña es obligatorio',
            ];

            $this->validate($request,$rules,$customMessages);

            /* if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password'],'status'=>1])){
                return redirect('admin/dashboard');
            }else{
                return redirect()->back()->with('error_message','Email o contraseña Incorrecta');
            } */
            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password']])){
                if(Auth::guard('admin')->user()->tipo=="vendedor" && Auth::guard('admin')->user()->confirmar=="No"){
                    return redirect()->back()->with('error_message','Por favor confirmar su correo para activar su cuenta de vendedor');
                }else if(Auth::guard('admin')->user()->tipo!="vendedor" && Auth::guard('admin')->user()->status=="0"){
                    return redirect()->back()->with('error_message','Tu cuenta de administrador no está activa');
                }else{
                    return redirect('admin/dashboard');
                }
                
            }else{
                return redirect()->back()->with('error_message','Email o contraseña Incorrecta');
            }

        }
        return view('admin.login');
    }

    public function admins($tipo=null){
        $admins = Admin::query();
        if(!empty($tipo)){
            $admins = $admins->where('tipo',$tipo);
            $title  = ucfirst($tipo)."es";
            // Define el nombre de la página en función del tipo
        switch ($tipo) {
            case 'superadmin':
                $sessionPage = 'view_admins';
                $title = "Administradores";
                break;
            case 'subadministrador':
                $sessionPage = 'view_subadmins';
                $title = "Sub Administradores";
                break;
            case 'vendedor':
                $sessionPage = 'view_vendors';
                $title = "Vendedores";
                break;
        }

        Session::put('page', $sessionPage);
        }else{
            $title  = "Todos: Administrador/SubAsminstrador/Vendedor";
            Session::put('page','view_all');
        }
        $admins = $admins->get()->toArray();
        /* dd($admins); */
        return view('admin.admins.admins')->with(compact('admins','title'));
    }

    public function viewVendorDetails($id){
        $vendorDetails = Admin::with('vendorPersonal','vendorBusiness','vendorBank')->where('id',$id)->first();
        $vendorDetails = json_decode(json_encode($vendorDetails),true);
        /* dd($vendorDetails); */
        return view('admin.admins.view_vendor_details')->with(compact('vendorDetails'));
    } 
    
    public function updateAdminStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Admin::where('id',$data['admin_id'])->update(['status'=>$status]);
            $adminDetails = Admin::where('id',$data['admin_id'])->first()->toArray();
            if($adminDetails['tipo']=="vendedor" && $status==1){
                Vendor::where('id',$adminDetails['vendor_id'])->update(['status'=>$status]);
                //enviar correo electrónico de aprobación
                $email = $adminDetails['email'];
                $messageData = [
                    'email' => $adminDetails['email'],
                    'nombre' => $adminDetails['nombre'],
                    'celular' => $adminDetails['celular']
                ];

                Mail::send('emails.vendor_approved',$messageData, function($message)use($email){
                    $message->to($email)->subject('La cuenta de vendedor esta aprovada');
                });
            }

            return response()->json(['status'=>$status,'admin_id'=>$data['admin_id']]);
        
        }
    } 

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
