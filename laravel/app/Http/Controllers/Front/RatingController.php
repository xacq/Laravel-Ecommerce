<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating;
use Auth;

class RatingController extends Controller
{
    public function addRating(Request $request){
        if(!Auth::check()){
            $message = "Inicie sesión para califique este producto!";
            return redirect()->back()->with('error_message',$message);
        }
        if($request->isMethod('post')){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */

            $user_id = Auth::user()->id;
            $ratingCount = Rating::where(['user_id'=>$user_id,'product_id'=>$data['product_id']])->count();
            if($ratingCount>0){
                $message = "¡Tu calificación ya existe para este producto!";
                return redirect()->back()->with('error_message',$message);
            }else{
                if(empty($data['clasificacion'])){
                    $message = "¡Agregue una calificación para este producto!";
                    return redirect()->back()->with('error_message',$message);
                }else{
                    /* echo "Add calidjd"; die; */
                    $rating = new Rating;
                    $rating->user_id = $user_id;
                    $rating->product_id = $data['product_id'];
                    $rating->opiniones = $data['opiniones'];
                    $rating->clasificacion = $data['clasificacion'];
                    $rating->status = 0;
                    $rating->save();
                    $message = "¡Gracias por calificar este producto! Se mostrará una vez aprobado.";
                    return redirect()->back()->with('success_message',$message);
                }
                
            }
        }
    }
}
