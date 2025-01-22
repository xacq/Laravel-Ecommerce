<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use App\Models\Country;
use Auth;
use Validator;
use Session;
use Hash;

class UserController extends Controller
{
    public function loginRegister(){
        return view('front.users.login_register');
    }

    public function userRegister(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'celular' => 'required|numeric|digits:10',
                'email' => 'required|email|max:150|unique:users',
                'password' => [
                    'required',
                    'min:8',
                    'regex:/[A-Z]/', // Al menos una letra mayúscula
                    'regex:/[a-z]/', // Al menos una letra minúscula
                    'regex:/[0-9]/', // Al menos un número
                    'regex:/[@$!%*?&]/', // Al menos un carácter especial
                ],
                'accept' => 'required',
            ], [
                'name.required' => 'El nombre es obligatorio.',
                'name.string' => 'El nombre debe ser una cadena de texto.',
                'name.max' => 'El nombre no debe superar los 100 caracteres.',
                
                'celular.required' => 'El número de celular es obligatorio.',
                'celular.numeric' => 'El número de celular debe ser numérico.',
                'celular.digits' => 'El número de celular debe tener 10 dígitos.',
                
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
                'email.max' => 'El correo electrónico no debe superar los 150 caracteres.',
                'email.unique' => 'El correo electrónico ya está en uso.',
                
                'password.required' => 'La contraseña es obligatoria.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'password.regex' => 'La contraseña debe contener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.',
                
                'accept.required' => 'Por favor acepte los términos y condiciones.',
            ]);
            
            if($validator->passes()){
                //registro del usuario
                $user = new User;
                $user->name = $data['name'];
                $user->celular = $data['celular'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->status = 0;
                $user->save();
                
                /* Activar el usuario sólo cuando el usuario confirma su cuenta de correo electrónico */
                $email = $data['email'];
                $messageData = ['name'=>$data['name'],'email'=>$data['email'],'code'=>base64_encode($data['email'])];
                Mail::send('emails.confirmation',$messageData,function($message)use($email){
                    $message->to($email)->subject('Confirma tu cuenta de correo electronico');
                });

                // Redirigir al usuario con mensaje de éxito
                $redirectTo = url('user/login-register');
                return response()->json(['type'=>'success','url'=>$redirectTo,'message'=>'Gracias por registrarte. 
                Por favor confirme tu email para activar tu cuenta']);

                /* Activar el usuario directamente sin enviar ningún email de confirmación */

                /* //enviar un email d eregistro
                $email = $data['email'];
                $messageData = ['name'=>$data['name'],'celular'=>$data['celular'],'email'=>$data['email']];
                Mail::send('emails.register',$messageData,function($message)use($email){
                    $message->to($email)->subject('Bienvenido');
                }); */

                /* if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                    $redirectTo = url('cart');

                    //actualizar el carro con el usuraio id
                    if(!empty(Session::get('session_id'))){
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                    }
                    
                    return response()->json(['type'=>'success','url'=>$redirectTo]);
                } */


            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

        }
    }

    public function userAccount(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'ciudad' => 'required|string|max:100',
                'estado' => 'required|string|max:100',
                'direccion' => 'required|string|max:100',
                'celular' => 'required|numeric|digits:10',
                'pincodigo' => 'required|numeric|digits:10'
            ], [
                'name.required' => 'El nombre es obligatorio.',
                'name.string' => 'El nombre debe ser una cadena de texto.',
                'name.max' => 'El nombre no debe superar los 100 caracteres.',
                
                'celular.required' => 'El número de celular es obligatorio.',
                'celular.numeric' => 'El número de celular debe ser numérico.',
                'celular.digits' => 'El número de celular debe tener 10 dígitos.',
            ]);

            if($validator->passes()){
                //actualizar los detalles del usuario
                User::where('id',Auth::user()->id)->update(['name'=>$data['name'],'celular'=>$data['celular'],'ciudad'=>$data['ciudad'],'estado'=>$data['estado'],'pais'=>$data['pais'],'pincodigo'=>$data['pincodigo'],'direccion'=>$data['direccion']]);

                //Redirigir al usuario con mensaje de éxito
                return response()->json(['type'=>'success','message'=>'Los detalles se actualizaron correctamente!']);
            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

        }else{
            $countries = Country::where('status',1)->get()->toArray();
            return view('front.users.user_account')->with(compact('countries'));
        }

    }

    public function userUpdatePassword(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */

            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'new_password' => 'required|min:8|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[\W_]/',
                'confirm_password' => 'required|min:8|same:new_password|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[\W_]/'
            ], [
                'new_password.required' => 'La nueva contraseña es obligatoria.',
                'new_password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
                'new_password.regex' => 'La nueva contraseña debe contener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial.',
                'confirm_password.required' => 'La confirmación de la contraseña es obligatoria.',
                'confirm_password.min' => 'La confirmación de la contraseña debe tener al menos 8 caracteres.',
                'confirm_password.same' => 'La confirmación de la contraseña debe coincidir con la nueva contraseña.'
            ]);
            

            if($validator->passes()){
                
                $current_password = $data['current_password'];
                $checkPassword = User::where('id',Auth::user()->id)->first();
                if(Hash::check($current_password, $checkPassword->password)){
                    // actualizar la contrasena
                    $user = User::find(Auth::user()->id);
                    $user->password = bcrypt($data['new_password']);
                    $user->save();

                    //Redirigir al usuario con mensaje de éxito
                    return response()->json(['type'=>'success','message'=>'Tu contraseña fue actualizada correctamente!']);

                }else{
                    //Redirigir al usuario con mensaje de error
                    return response()->json(['type'=>'incorrect','message'=>'Tu contraseña actual es incorrecta!']);
                }


                //Redirigir al usuario con mensaje de éxito
                return response()->json(['type'=>'success','message'=>'Los detalles se actualizaron correctamente!']);
            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }

        }else{
            $countries = Country::where('status',1)->get()->toArray();
            return view('front.users.user_account')->with(compact('countries'));
        }

    }

    public function forgotPassword(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:150|exists:users'
            ], [
                'email.exists' => 'Este email no existe'
            ]);
            if($validator->passes()){
                //general la nueva contrasena
                $new_password = Str::random(16);

                //Actualizar la nueva contrasena
                User::where('email',$data['email'])->update(['password'=>bcrypt($new_password)]);

                //obtener los detalles del usuario
                $userDetails = User::where('email',$data['email'])->first()->toArray();

                //enviar un email al usuario
                $email = $data['email'];
                $messageData = ['name'=>$userDetails['name'],'email'=>$email,'password'=>$new_password];
                Mail::send('emails.user_forgot_password',$messageData,function($message)use($email){
                    $message->to($email)->subject('Nueva contraseña');
                });

                //Mostrar el mensage de éxito
                return response()->json(['type'=>'success','message'=>'Nueva contraseña enviada a su correo electrónico registrado.']);


            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }
        }else{
            return view('front.users.forgot_password');
        }   
    }

    public function userLogin(Request $request){
        if($request->ajax()){
            $data= $request->all();
            /* echo "«pre>"; print_r($data); die; */

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:150|exists:users',
                'password' => 'required|min:8'
            ]);

            if($validator->passes()){

                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                    if(Auth::user()->status==0){
                        Auth::logout();
                        return response()->json(['type'=>'inactive','message'=>'Tu cuenta no esta activada, por favor confirma en tu correo electrónico para activarla.']);
                    }

                    //actualizar el carro con el usuraio id
                    if(!empty(Session::get('session_id'))){
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                    }

                    $redirectTo = url('cart');
                    return response()->json(['type'=>'success','url'=>$redirectTo]);
                }else{
                    return response()->json(['type'=>'incorrect','message'=>'Email o Contrasena incorrectos!']);
                }

            }else{
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }
        } 
    }

    public function userLogout(){
        Auth::logout();
        Session::flush();
        return redirect('/');
    }

    public function confirmAccount($code){
        $email = base64_decode($code);
        $userCount = User::where('email',$email)->count();
        if($userCount>0){
            $userDetails = User::where('email',$email)->first();
            if($userDetails->status==1){
                // Redirigir al usuario a la página de inicio de sesión/registro con mensaje de error
                return redirect('user/login-register')->with('error_message','La cuenta ya está activada. Puedes iniciar sesión ahora.');
            }else{
                User::where('email',$email)->update(['status'=>1]);

                //enviar la bienvenida email
                $messageData = ['name'=>$userDetails->name,'celular'=>$userDetails->celular,'email'=>$email];
                Mail::send('emails.register',$messageData,function($message)use($email){
                    $message->to($email)->subject('Bienvenido');
                });

                // Redirigir al usuario a la página de inicio de sesión/registro con mensaje correcto
                return redirect('user/login-register')->with('success_message','La cuenta ya está activada. Puedes iniciar sesión ahora.');
            }
        }else{
            abort(404);
        }
    }
}
