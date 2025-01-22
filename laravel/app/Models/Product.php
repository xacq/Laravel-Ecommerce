<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function section(){
        return $this->belongsTo('App\Models\Section','section_id');
    }

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id');
    }

    public function brand(){
        return $this->belongsTo('App\Models\Brand','brand_id');
    }

    public function attributes(){
        return $this->hasMany('App\Models\ProductsAttribute');
    }

    public function images(){
        return $this->hasMany('App\Models\ProductsImage');
    }

    public function vendor(){
        return $this->belongsTo('App\Models\Vendor','vendor_id')->with('vendorbusinessdetails');
    }

    public static function getDiscountPrice($product_id){
        $proDetails = Product::select('producto_precio','producto_descuento','category_id')->where('id',$product_id)->first();
        $proDetails = json_decode(json_encode($proDetails),true);
        $catDetails = Category::select('categoria_descuento')->where('id',$proDetails['category_id'])->first();
        $catDetails = json_decode(json_encode($catDetails),true);

        if($proDetails['producto_descuento']>0){
            //si el desuento del prducto existe
            $discounted_price = $proDetails['producto_precio'] - ($proDetails['producto_precio']*$proDetails['producto_descuento']/100);

        }else if($catDetails['categoria_descuento']>0){
            //si el decueto de l categria no exste pero lel decuento esta en el panel admin
            $discounted_price = $proDetails['producto_precio'] - ($proDetails['producto_precio']*$catDetails['categoria_descuento']/100);
        }else{
            $discounted_price = 0;
        }
        return $discounted_price;
    }

    public static function getDiscountAttributePrice($product_id,$tamano){
        $proAttrPrice = ProductsAttribute::where(['product_id'=>$product_id,'tamano'=>$tamano])->first()->toArray();
        $proDetails = Product::select('producto_descuento','category_id')->where('id',$product_id)->first();
        $proDetails = json_decode(json_encode($proDetails),true);
        $catDetails = Category::select('categoria_descuento')->where('id',$proDetails['category_id'])->first();
        $catDetails = json_decode(json_encode($catDetails),true);
        if($proDetails['producto_descuento']>0){
            //si el desuento del prducto existe
            $final_price = $proAttrPrice['precio'] - ($proAttrPrice['precio']*$proDetails['producto_descuento']/100);
            $discount = $proAttrPrice['precio'] - $final_price;

        }else if($catDetails['categoria_descuento']>0){
            //si el decueto de l categria no exste pero lel decuento esta en el panel admin
            $final_price = $proAttrPrice['precio'] - ($proAttrPrice['precio']*$catDetails['categoria_descuento']/100);
            $discount = $proAttrPrice['precio'] - $final_price;
        }else{
            $final_price = $proAttrPrice['precio'];
            $discount = 0;
        }
        return array('producto_precio'=>$proAttrPrice['precio'],'final_price'=>$final_price,'discount'=>$discount);
    }

    public static function isProductNew($product_id){
        //obtener los 3 prodicts
        $productIds = Product::select('id')->where('status',1)->orderby('id','Desc')->limit(3)->pluck('id');
        $productIds = json_decode(json_encode($productIds),true);
        /* dd($productIds); */
        if(in_array($product_id,$productIds)){
            $isProductNew = "Si";

        }else{
            $isProductNew = "No";
        }
        return $isProductNew;
    }

    public static function getProductImage($product_id){
        $getProductImage = Product::select('producto_image')->where('id', $product_id)->first()->toArray();
        return $getProductImage['producto_image'];
    }

    public static function getProductStatus($product_id){
        $getProductStatus = Product::select('status')->where('id',$product_id)->first();
        return $getProductStatus->status;
    }

    public static function deleteCartProduct($product_id){
        Cart::where('product_id',$product_id)->delete();
    }

}
