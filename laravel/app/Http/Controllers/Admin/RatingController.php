<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating;
use Session;

class RatingController extends Controller
{
    public function ratings(){
        Session::put('page','ratings');
        $ratings = Rating::with(['user','product'])->get()->toArray();
        return view('admin.ratings.ratings')->with(compact('ratings'));
    }

    public function updateRatingStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Rating::where('id',$data['rating_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'rating_id'=>$data['rating_id']]);
        
        }
    }

    public function deleteRating($id){
        //Eliminar marca
        Rating::where('id',$id)->delete();
        $message = "Calificación eliminada correctamente";
        return redirect()->back()->with('success_message',$message);
    }
}
