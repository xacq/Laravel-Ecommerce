<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ShippingCharge;

class ShippingCharge extends Model
{
    use HasFactory;

    public static function getShippingCharges($pais){
        $getShippingCharges = ShippingCharge::select('tarifa')->where('pais', $pais)->first();
        return $getShippingCharges->tarifa;
    }
}
