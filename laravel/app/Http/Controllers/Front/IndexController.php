<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Product;

class IndexController extends Controller
{
    public function index(){
        $sliderBanners = Banner::where('tipo','Deslizante')->where('status',1)->get()->toArray();
        $fixBanners = Banner::where('tipo','Anuncio')->where('status',1)->get()->toArray();
        $newProducts = Product::orderBY('id','Desc')->where('status',1)->limit(8)->get()->toArray();
        $bestSellers = Product::where(['is_bestseller'=>'Si','status'=>1])->inRandomOrder()->get()->toArray();
        $discountedProducts = Product::where('producto_descuento','>',0)->where('status',1)->limit(6)->inRandomOrder()->get()->toArray();
        $featuredProducts = Product::where(['es_destacada'=>'Si','status'=>1])->limit(4)->get()->toArray();

        $meta_titulo = "Ambato Shop";
        $meta_descripcion = "Ofertas de sitios web de compras en línea en Ropa, Electronicos & Arreglos";
        $meta_palabraclave = "sitio web de tienda online, compras en línea, comercio electrónico de múltiples proveedores";

        return view('front.index')->with(compact('sliderBanners','fixBanners','newProducts','bestSellers','discountedProducts','featuredProducts','meta_titulo','meta_descripcion','meta_palabraclave'));
    }
}
