<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsFilter extends Model
{
    use HasFactory;

    public static function getFilterName($filtro_id){
        $getFilterName = ProductsFilter::select('filtro_nombre')->where('id',$filtro_id)->first();
        return $getFilterName->filtro_nombre;
    }

    public function filter_value(){
        return $this->hasMany('App\Models\ProductsFiltersValue','filtro_id');
    }

    public static function productFilters(){
        $productFilters = ProductsFilter::with('filter_value')->where('status',1)->get()->toArray();
        /* dd($productFilters); */
        return $productFilters;
    }

    public static function filterAvailable($filtro_id,$category_id){
        $filterAvailable = ProductsFilter::select('cat_ids')->where(['id'=>$filtro_id,'status'=>1])->first()->toArray();
        $catIdsArr = explode(",",$filterAvailable['cat_ids']);
        if(in_array($category_id,$catIdsArr)){
            $available = "Si";
        }else{
            $available = "No";
        }
        return $available;
    } 

    public static function getSizes($url){
        $categoryDetails = Category::categoryDetails($url);
        $getProductIds = Product::select('id')->whereIn('category_id',$categoryDetails['catIds'])->pluck('id')->toArray();
        $getProductSizes = ProductsAttribute::select('tamano')->whereIn('product_id',$getProductIds)->groupBy('tamano')->pluck('tamano')->toArray();
        /* echo "<pre>"; print_r($getProductSizes); die; */
        return $getProductSizes;

    } 

    public static function getColors($url){
        $categoryDetails = Category::categoryDetails($url);
        $getProductIds = Product::select('id')->whereIn('category_id',$categoryDetails['catIds'])->pluck('id')->toArray();
        $getProductColors = Product::select('producto_color')->whereIn('id',$getProductIds)->groupBy('producto_color')->pluck('producto_color')->toArray();
        /* echo "<pre>"; print_r($getColors); die; */

        return $getProductColors;

    } 

    public static function getBrands($url){
        $categoryDetails = Category::categoryDetails($url);
        $getProductIds = Product::select('id')->whereIn('category_id',$categoryDetails['catIds'])->pluck('id')->toArray();
        $brandIds = Product::select('brand_id')->whereIn('id',$getProductIds)->groupBy('brand_id')->pluck('brand_id')->toArray();
        $brandDetails = Brand::select('id','nombre')->whereIn('id',$brandIds)->get()->toArray();
        /* echo "<pre>"; print_r($brandDetails); die; */

        return $brandDetails;

    }
}
