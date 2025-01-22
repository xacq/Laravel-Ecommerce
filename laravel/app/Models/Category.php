<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function section(){
        return $this->belongsTo('App\Models\Section','section_id')->select('id','nombre');
    }

    public function parentcategory(){
        return $this->belongsTo('App\Models\Category','parent_id')->select('id','categoria_nombre');
    }

    public function subcategories(){
        return $this->hasMany('App\Models\Category','parent_id')->where('status',1);
    }

    public static function categoryDetails($url){
        $categoryDetails = Category::select('id','parent_id','categoria_nombre','url','descripcion','meta_titulo','meta_descripcion','meta_palabraclave')->with(['subcategories'=>function($query){
            $query->select('id','parent_id','categoria_nombre','url','descripcion','meta_titulo','meta_palabraclave','meta_descripcion');
        }])->where('url', $url)->first()->toArray();
        /* dd($categoryDetails); */
        $catIds = array();
        $catIds[] = $categoryDetails['id'];

        if($categoryDetails['parent_id']==0){
            //Only Show Main Category in Breadcrumb
            $breadcrumbs = '<li class="is-marked">
            <a href="'.url($categoryDetails['url']).'">'.$categoryDetails['categoria_nombre'].'</a>
            </li>';
        }else{
            //how Main and Sub Category in Breadcrumb
            $parentCategory = Category::select('categoria_nombre','url')->where('id',$categoryDetails['parent_id'])->first()->toArray();
            $breadcrumbs = '<li class="has-separator">
            <a href="'.url($parentCategory['url']).'">'.$parentCategory['categoria_nombre'].'</a>
            </li><li class="is-marked">
            <a href="'.url($categoryDetails['url']).'">'.$categoryDetails['categoria_nombre'].'</a>
            </li>';
        }

        foreach($categoryDetails['subcategories'] as $key => $subcat){
            $catIds[] = $subcat['id'];
        }
        /* dd($catIds); */
        $resp = array('catIds'=>$catIds,'categoryDetails'=>$categoryDetails,'breadcrumbs'=>$breadcrumbs);
        return $resp;
    }

    public static function getCategoryName($category_id){
        $getCategoryName = Category::select('categoria_nombre')->where('id',$category_id)->first();
        return $getCategoryName->categoria_nombre;
    }

    public static function getCategoryStatus($category_id){
        $getCategoryStatus =  Category::select('status')->where('id',$category_id)->first();
        return $getCategoryStatus->status;
    }
}
