<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    public static function couponDetails($cupon_codigo){
        $couponDetails = Coupon::where('cupon_codigo',$cupon_codigo)->first()->toArray();
        return $couponDetails;
    }
}
