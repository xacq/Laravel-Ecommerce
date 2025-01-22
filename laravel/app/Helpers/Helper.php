<?php
use App\Models\Cart;
function totalCartItems(){
    if(Auth::check()){
        $user_id = Auth::user()->id;
        $totalCartItems = Cart::where('user_id',$user_id)->sum('cantidad');
    }else{
        $session_id = Session::get('session_id');
        $totalCartItems = Cart::where('session_id',$session_id)->sum('cantidad');
    }
    return $totalCartItems;
}

function getCartItems(){
    if(Auth::check()){
        //si el usuario inicio sesion / 
        $getCartItems = Cart::with(['product'=>function($query){
            $query->select('id','category_id','producto_nombre','producto_codigo','producto_color','producto_image');
        }])->orderby('id','Desc')->where('user_id',Auth::user()->id)->get()->toArray();        
    }else{
        //si el usuario no inicio sesion
        $getCartItems = Cart::with(['product'=>function($query){
            $query->select('id','category_id','producto_nombre','producto_codigo','producto_color','producto_image');
        }])->orderby('id','Desc')->where('session_id',Session::get('session_id'))->get()->toArray();
        
    }
    return $getCartItems;
}
