<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Vendor;
use Validator;
use DB;

class VendorController extends Controller
{
    public function loginRegister(){
        
        return view('front.vendors.login_register');
    }

    public function vendorRegister(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */

            //validar el vendedor
            $rules = [
                "nombre" => "required",
                "email" => "required|email|unique:admins|unique:vendors",
                "celular" => "required|min:10|numeric|unique:admins|unique:vendors",
                'password' => [
                    'required',
                    'min:8',
                    'regex:/[A-Z]/', // Al menos una letra mayúscula
                    'regex:/[a-z]/', // Al menos una letra minúscula
                    'regex:/[0-9]/', // Al menos un número
                    'regex:/[@$!%*?&]/', // Al menos un carácter especial
                ],
                "accept" => "required"
            ];
            $customMessages = [
                "nombre.required" => "Nombre es obligatorio",
                "email.required" => "Email es obligatorio",
                "email.unique" => "Este email ya existe",
                "celular.required" => "Celular es obligatorio",
                "celular.unique" => "Este celular ya existe",
                'password.required' => 'La contraseña es obligatoria.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'password.regex' => 'La contraseña debe contener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.',
                "accept.required" => "Por favor acepte lo terminos",
                
            ];
            $validator = Validator::make($data,$rules,$customMessages);
            if($validator->fails()){
                return Redirect::back()->withErrors($validator);
            }

            DB::beginTransaction();

            // Crear la cuenta del vendedor
            //insertar los detalles del vendedor en la tabla
            $vendor = new Vendor;
            $vendor->nombre = $data['nombre'];
            $vendor->celular = $data['celular'];
            $vendor->email = $data['email'];

            $vendor->status = 0;

            //obtener el tiempo o la fecha en la base de datos 
            date_default_timezone_set('America/Guayaquil');
            $vendor->created_at = date("Y-m-d H:i:s");
            $vendor->updated_at = date("Y-m-d H:i:s");
            $vendor->save();

            $vendor->save();

            $vendor_id = DB::getPdo()->lastInsertId();

            //insertar los detalles del administrador en la tabla
            $admin = new Admin;
            $admin->tipo = 'vendedor';
            $admin->vendor_id = $vendor_id;
            $admin->nombre = $data['nombre'];
            $admin->celular = $data['celular'];
            $admin->email = $data['email'];
            $admin->password = bcrypt($data['password']);
            $admin->status = 0;

            //obtener el tiempo o la fecha en la base de datos 
            date_default_timezone_set('America/Guayaquil');
            $admin->created_at = date("Y-m-d H:i:s");
            $admin->updated_at = date("Y-m-d H:i:s");
            $admin->save();

            //enviar el correo de confirmacion
            $email = $data['email'];
            $messageData = [
                'email' => $data['email'],
                'nombre' => $data['nombre'],
                'code' => base64_encode($data['email'])
            ];

            Mail::send('emails.vendor_confirmation',$messageData, function($message)use($email){
                $message->to($email)->subject('Confirma tu cuenta de vendedor');
            });

            DB::commit();

            //dirigirse al vendedro con un mensaje exitoso
            $message = "Gracias por registrarse como vendedor. Por favor confirme su email para activar su cuenta.";
            return redirect()->back()->with('success_message',$message);

        }
    }

    public function confirmVendor($email){
        //Codigo vendedor email
        $email = base64_decode($email);

        $vendorCount = Vendor::where('email',$email)->count();
        if($vendorCount>0){
            //email del vendedor esta activado o no
            $vendorDetails = Vendor::where('email',$email)->first();
            if($vendorDetails->confirmar=="Si"){
                $message = "Tu cuenta de vendedor ya está confirmada. Puedes iniciar sesión.";
                return redirect('vendor/login-register')->with('error_message',$message);
            }else{
                //actualizar confirma la cuenta admis/vendedores
                Admin::where('email',$email)->update(['confirmar'=>'Si']);
                Vendor::where('email',$email)->update(['confirmar'=>'Si']);
                
                //enviar un email de su registro
                $messageData = [
                    'email' => $email,
                    'nombre' => $vendorDetails->nombre,
                    'celular' => $vendorDetails->celular
                ];

                Mail::send('emails.vendor_confirmed',$messageData, function($message)use($email){
                    $message->to($email)->subject('Tu cuenta de vendedor está confirmada');
                });

                //redirigirse a login/register del vendedor 
                $message = "Tu email de vendedor está confirmada. Puede iniciar sesión y completar la información";
                return redirect('vendor/login-register')->with('success_message',$message);
            }
        }else{
            abort(404);
        }

    }

    public function forgotPasswordVendor(Request $request){
        if($request->ajax()){
            $data =$request->all();
            /* echo "<pre>"; print_r($data); die; */
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:150|exists:admins'
            ], [
                'email.exists' => 'Este email no existe'
            ]);
            if($validator->passes()){
                $vendorDetails = Admin::where('email',$data['email'])->first();
                $new_password = Str::random(16);
                Admin::where('email',$data['email'])->update(['password'=>bcrypt($new_password)]);
                $vendorDetails = Admin::where('email',$data['email'])->first()->toArray();
                $email = $data['email'];
                $messageData = ['nombre'=>$vendorDetails['nombre'],'email'=>$email,'password'=>$new_password];
                Mail::send('emails.vendor_forgot_password',$messageData,function($message)use($email){
                    $message->to($email)->subject('Nueva contraseña');
                });
                //Mostrar el mensage de éxito
                return response()->json(['type'=>'success','message'=>'Nueva contraseña enviada a su correo electrónico registrado.']);

            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }
        }else{
            return view('front.vendors.forgot_password'); 
        }
        
    }
}
