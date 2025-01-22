<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsAttribute extends Model
{
    use HasFactory;

    public static function getProductStock($product_id,$tamano){
        $getProductStock = ProductsAttribute::select('stock')->where(['product_id'=>$product_id,'tamano'=>$tamano])->first();
        return $getProductStock->stock;
    }

    public static function getAttributeStatus($product_id,$tamano){
        $getAttributeStatus = ProductsAttribute::select('status')->where(['product_id'=>$product_id,'tamano'=>$tamano])->first();
        return $getAttributeStatus->status;
    }
}
