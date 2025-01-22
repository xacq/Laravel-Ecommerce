<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    public function vendorbusinessdetails(){
        return $this->belongsTo('App\Models\VendorsBusinessDetail','id','vendor_id');
    }

    public static function getVendorShop($vendorid){
        $getVendorShop = VendorsBusinessDetail::select('nombre_tienda')->where('vendor_id',$vendorid)->first()->toArray();
        return $getVendorShop['nombre_tienda'];
    }

    public static function getVendorComision($vendorid){
        $getVendorComision = Vendor::select('comision')->where('id',$vendorid)->first()->toArray();
        return $getVendorComision['comision'];
    }
}
