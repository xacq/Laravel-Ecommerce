<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsFilter;
use App\Models\ProductsAttribute;
use App\Models\Vendor;
use App\Models\Coupon;
use App\Models\User;
use App\Models\Cart;
use App\Models\DeliveryAddress;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrdersProduct;
use App\Models\ShippingCharge;
use App\Models\Rating;
use Session;
use DB;
use Auth;



class ProductsController extends Controller
{
    public function listing(Request $request){
        if($request->ajax()){
            $data = $request->all();


            $url = $data['url'];
            $_GET['sort'] = $data['sort'];
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if($categoryCount>0){
                //obtener los detalles de las categorias
                $categoryDetails = Category::categoryDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);

                //chequear dinamicamente los filtros
                $productFilters = ProductsFilter::productFilters();
                foreach($productFilters as $key => $filter){
                    //si el filtro se selecciona
                    if(isset($filter['filtro_columna']) && isset($data[$filter['filtro_columna']]) && !empty($filter['filtro_columna']) && !empty($data[$filter['filtro_columna']])){
                        $categoryProducts->whereIn($filter['filtro_columna'],$data[$filter['filtro_columna']]);
                    }
                }

                //chequear por ordernar
                if (isset($_GET['sort']) && !empty($_GET['sort'])) {
                    if ($_GET['sort'] == "product_latest") {
                        $categoryProducts->orderby('products.id', 'Desc');
                    }else if($_GET['sort'] == "price_lowest"){
                        $categoryProducts->orderby('products.producto_precio', 'Asc');
                    }else if($_GET['sort'] == "price_highest"){
                        $categoryProducts->orderby('products.producto_precio', 'Desc');
                    }else if($_GET['sort'] == "name_z_a"){
                        $categoryProducts->orderby('products.producto_nombre', 'Desc');
                    }else if($_GET['sort'] == "name_a_z"){
                        $categoryProducts->orderby('products.producto_nombre', 'Asc');
                    }
                }

                //chequear por tamano
                if (isset($data['size']) && !empty($data['size'])){
                    $productIds = ProductsAttribute::select('product_id')->whereIn('tamano',$data['size'])->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                //chequear por color
                if (isset($data['color']) && !empty($data['color'])){
                    $productIds = Product::select('id')->whereIn('producto_color',$data['color'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                //cheqear por precio
                /* if (isset($data['precio']) && !empty($data['precio'])){
                   foreach($data['precio'] as $key => $precio){
                        $priceArr = explode('-',$precio);
                        $productIds[] = Product::select('id')->whereBetween('producto_precio',[$priceArr[0],$priceArr[1]])->pluck('id')->toArray();
                   }
                   $productIds = call_user_func_array('array_merge',$productIds);
                   $categoryProducts->whereIn('products.id',$productIds);

                } */

                //cheqear por precio
                $productIds = array();
                if (isset($data['precio']) && !empty($data['precio'])){
                   foreach($data['precio'] as $key => $precio){
                        $priceArr = explode('-',$precio);
                        if(isset($priceArr[0]) && isset($priceArr[1])){
                            $productIds[] = Product::select('id')->whereBetween('producto_precio',[$priceArr[0],$priceArr[1]])->pluck('id')->toArray();
                        }
                   }
                   $productIds = array_unique(array_flatten($productIds));
                   $categoryProducts->whereIn('products.id',$productIds);

                }

                //chequear por marca
                if (isset($data['brand']) && !empty($data['brand'])){
                    $productIds = Product::select('id')->whereIn('brand_id',$data['brand'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('products.id',$productIds);
                }

                $categoryProducts = $categoryProducts->paginate(30);
                /* dd($categoryDetails); */
                /* echo "Categoria existe"; die; */
                $meta_titulo = $categoryDetails['categoryDetails']['meta_titulo'];
                $meta_palabraclave = $categoryDetails['categoryDetails']['meta_palabraclave'];
                $meta_descripcion = $categoryDetails['categoryDetails']['meta_descripcion'];

                return view('front.products.ajax_products_listing')->with(compact('categoryDetails','categoryProducts','url','meta_titulo','meta_palabraclave','meta_descripcion'));
            }else{
                abort(404);
            }

        }else{
            if(isset($_REQUEST['search']) && !empty($_REQUEST['search'])){
                if($_REQUEST['search']=="nuevas-llegadas"){
                    $search_product = $_REQUEST['search'];
                    $categoryDetails['breadcrumbs'] =  "Nuevas llegadas";
                    $categoryDetails['categoryDetails']['categoria_nombre'] =  "Nuevas llegadas";
                    $categoryDetails['categoryDetails']['descripcion'] =  "Productos Nuevos llegadas ";

                    $categoryProducts = Product::select('products.id','products.id','products.section_id','products.category_id','products.brand_id','products.vendor_id','products.producto_nombre','products.producto_codigo','products.producto_color','products.producto_precio','products.producto_descuento','products.producto_image','products.descripcion')->with('brand')
                    ->join('categories', 'categories.id', '=', 'products.category_id')
                    ->where('products.status', 1)->orderby('id','Desc');
                }else if($_REQUEST['search']=="mas-vendidos"){
                    $search_product = $_REQUEST['search'];
                    $categoryDetails['breadcrumbs'] =  "Mas Vendidos";
                    $categoryDetails['categoryDetails']['categoria_nombre'] =  "Mas Vendidos";
                    $categoryDetails['categoryDetails']['descripcion'] =  "Productos Mas Vendidos ";

                    $categoryProducts = Product::select('products.id','products.id','products.section_id','products.category_id','products.brand_id','products.vendor_id','products.producto_nombre','products.producto_codigo','products.producto_color','products.producto_precio','products.producto_descuento','products.producto_image','products.descripcion')->with('brand')
                    ->join('categories', 'categories.id', '=', 'products.category_id')
                    ->where('products.status', 1)->where('products.is_bestseller','Si');
                }else if($_REQUEST['search']=="destacados"){
                    $search_product = $_REQUEST['search'];
                    $categoryDetails['breadcrumbs'] =  "Productos Destacados";
                    $categoryDetails['categoryDetails']['categoria_nombre'] =  "Productos Destacados";
                    $categoryDetails['categoryDetails']['descripcion'] =  "Productos Destacados ";

                    $categoryProducts = Product::select('products.id','products.id','products.section_id','products.category_id','products.brand_id','products.vendor_id','products.producto_nombre','products.producto_codigo','products.producto_color','products.producto_precio','products.producto_descuento','products.producto_image','products.descripcion')->with('brand')
                    ->join('categories', 'categories.id', '=', 'products.category_id')
                    ->where('products.status', 1)->where('products.es_destacada','Si');
                }else if($_REQUEST['search']=="descuentos"){
                    $search_product = $_REQUEST['search'];
                    $categoryDetails['breadcrumbs'] =  "Productos con Descuentos";
                    $categoryDetails['categoryDetails']['categoria_nombre'] =  "Productos con Descuentos";
                    $categoryDetails['categoryDetails']['descripcion'] =  "Productos con Descuentos ";

                    $categoryProducts = Product::select('products.id','products.id','products.section_id','products.category_id','products.brand_id','products.vendor_id','products.producto_nombre','products.producto_codigo','products.producto_color','products.producto_precio','products.producto_descuento','products.producto_image','products.descripcion')->with('brand')
                    ->join('categories', 'categories.id', '=', 'products.category_id')
                    ->where('products.status', 1)->where('products.producto_descuento','>',0);
                }else{
                $search_product = $_REQUEST['search'];
                $categoryDetails['breadcrumbs'] =  $search_product;
                $categoryDetails['categoryDetails']['categoria_nombre'] =  $search_product;
                $categoryDetails['categoryDetails']['descripcion'] =  "Buscar Producto por ". $search_product;

                $categoryProducts = Product::select('products.id','products.id','products.section_id','products.category_id','products.brand_id','products.vendor_id','products.producto_nombre','products.producto_codigo','products.producto_color','products.producto_precio','products.producto_descuento','products.producto_image','products.descripcion')->with('brand')
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->where(function($query) use ($search_product) {
                    $query->where('products.producto_nombre', 'like', '%' . $search_product . '%')
                        ->orWhere('products.producto_codigo', 'like', '%' . $search_product . '%')
                        ->orWhere('products.producto_color', 'like', '%' . $search_product . '%')
                        ->orWhere('products.descripcion', 'like', '%' . $search_product . '%')
                        ->orWhere('categories.categoria_nombre', 'like', '%' . $search_product . '%');
                })->where('products.status', 1);
            }


                if(isset($_REQUEST['section_id']) && !empty($_REQUEST['section_id'])){
                    $categoryProducts =$categoryProducts->where('products.section_id',$_REQUEST['section_id']);
                }

                $categoryProducts =$categoryProducts->get();
                /* dd($categoryProducts); */
                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts'));
            }else{
                $url = Route::getFacadeRoot()->current()->uri();
                $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
                if($categoryCount>0){
                    //obtener los detalles de las categorias
                    $categoryDetails = Category::categoryDetails($url);
                    $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIds'])->where('status',1);

                    //chequear por ordernar
                    if (isset($_GET['sort']) && !empty($_GET['sort'])) {
                        if ($_GET['sort'] == "product_latest") {
                            $categoryProducts->orderby('products.id', 'Desc');
                        }else if($_GET['sort'] == "price_lowest"){
                            $categoryProducts->orderby('products.producto_precio', 'Asc');
                        }else if($_GET['sort'] == "price_highest"){
                            $categoryProducts->orderby('products.producto_precio', 'Desc');
                        }else if($_GET['sort'] == "name_z_a"){
                            $categoryProducts->orderby('products.producto_nombre', 'Desc');
                        }else if($_GET['sort'] == "name_a_z"){
                            $categoryProducts->orderby('products.producto_nombre', 'Asc');
                        }
                    }

                    $categoryProducts = $categoryProducts->paginate(30);
                    /* dd($categoryDetails); */
                    /* echo "Categoria existe"; die; */
                    $meta_titulo = $categoryDetails['categoryDetails']['meta_titulo'];
                    $meta_palabraclave = $categoryDetails['categoryDetails']['meta_palabraclave'];
                    $meta_descripcion = $categoryDetails['categoryDetails']['meta_descripcion'];
                    return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','url','meta_titulo','meta_palabraclave','meta_descripcion'));
                }else{
                    abort(404);
                }
            }

        }

    }

    public function vendorListing($vendorid){
        //obtener ls detalles del vendedor (nombre de la tienda)
        $getVendorShop = Vendor::getVendorShop($vendorid);
        //obtener el producto del vendedor
        $vendorProducts = Product::with('brand')->where('vendor_id',$vendorid)->where('status',1);
        $vendorProducts = $vendorProducts->paginate(30);
        /* dd($vendorProducts); */
        return view('front.products.vendor_listing')->with(compact('getVendorShop','vendorProducts'));
    }

    public function detail($id){
        $productDetails = Product::with(['section','category','brand','attributes'=>function($query){
            $query->where('stock','>',0)->where('status',1);
        },'images','vendor'])->find($id)->toArray();
        $categoryDetails = Category::categoryDetails($productDetails['category']['url']);
       /*  dd($productDetails); */

        //obtener producto similar
        $similarProducts = Product::with('brand')->where('category_id',$productDetails['category']['id'])->where('id','!=',$id)->limit(4)->inRandomOrder()->get()->toArray();
        /* dd($similarProducts); */

        //configuracion para los productos recien vistos
        if(empty(Session::get('session_id'))){
           $session_id = md5(uniqid(rand(), true));
        }else{
            $session_id = Session::get('session_id');
        }
        Session::put('session_id',$session_id);

        //Insertar el producto en la tabla si aun no existe
        $countRecentlyViewedProducts = DB::table('recently_viewed_products')->where(['product_id'=>$id,'session_id'=>$session_id])->count();
        if($countRecentlyViewedProducts==0){
            DB::table('recently_viewed_products')->insert(['product_id'=>$id,'session_id'=>$session_id]);
        }

        //Obtener los productos recien vistos (id)
        $recentProductsIds = DB::table('recently_viewed_products')->select('product_id')->where('product_id','!=',$id)->where('session_id',$session_id)->inRandomOrder()->get()->take(4)->pluck('product_id');
        /* dd($recentProductsIds); */

        //obtener producto recien visto
        $recentlyViewedProducts = Product::with('brand')->whereIn('id',$recentProductsIds)->get()->toArray();
        /* dd($recentlyViewedProducts); */

        //obtener el codigo de grupo (colores)
        $groupProducts = array();
        if(!empty($productDetails['grupo_codigo'])){
            $groupProducts = Product::select('id','producto_image')->where('id','!=',$id)->where(['grupo_codigo'=>$productDetails['grupo_codigo'],'status'=>1])->get()->toArray();
        }

        //obtener calificaciones
        $ratings = Rating::with('user')->where(['product_id'=>$id,'status'=>1])->get()->toArray();

        //obtener el porcentahe de las calificaciones
        $ratingSum = Rating::where(['product_id'=>$id,'status'=>1])->sum('clasificacion');
        $ratingCount = Rating::where(['product_id'=>$id,'status'=>1])->count();

        // Inicializar las variables con valores predeterminados
        $avgRating = 0;
        $avgStarRating = 0;

        //obtener las estrellas
        $ratingOneStarCount = Rating::where(['product_id'=>$id,'status'=>1,'clasificacion'=>1])->count();
        $ratingTwoStarCount = Rating::where(['product_id'=>$id,'status'=>1,'clasificacion'=>2])->count();
        $ratingThreeStarCount = Rating::where(['product_id'=>$id,'status'=>1,'clasificacion'=>3])->count();
        $ratingFourStarCount = Rating::where(['product_id'=>$id,'status'=>1,'clasificacion'=>4])->count();
        $ratingFiveStarCount = Rating::where(['product_id'=>$id,'status'=>1,'clasificacion'=>5])->count();

        if($ratingCount>0){
            $avgRating = round($ratingSum/$ratingCount,2);
            $avgStarRating = round($ratingSum/$ratingCount);
        }

        $totalStock = ProductsAttribute::where('product_id',$id)->sum('stock');
        $meta_titulo = $productDetails['meta_titulo'];
        $meta_palabraclave = $productDetails['meta_palabraclave'];
        $meta_descripcion = $productDetails['meta_descripcion'];

        return view('front.products.detail')->with(compact('productDetails','categoryDetails','totalStock','similarProducts','recentlyViewedProducts','groupProducts','meta_titulo','meta_palabraclave','meta_descripcion','ratings','avgRating','avgStarRating','ratingOneStarCount','ratingTwoStarCount','ratingThreeStarCount','ratingFourStarCount','ratingFiveStarCount'));
    }

    public function getProductPrice(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            $getDiscountAttributePrice = Product::getDiscountAttributePrice($data['product_id'],$data['tamano']);
            return $getDiscountAttributePrice;
        }
    }

    public function cartAdd(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */

            //debe iniciar session antes de ocupar el cupon
            Session::forget('couponAmount');
            Session::forget('couponCode');

            if($data['cantidad']<=0){
                $data['cantidad']=1;
            }

            // Chequear stock del producto disponible o no
            $getProductStock = ProductsAttribute::getProductStock($data['product_id'],$data['tamano']);
            if($getProductStock<$data['cantidad']){
                return redirect()->back()->with('error_message','Cantidad requerida no está disponible');
            }

            //Generar Id session si no existe
            $session_id = Session::get('session_id');
            if(empty($session_id)){
                $session_id = Session::getId();
                Session::put('session_id',$session_id);
            }

            // chequear si elproducto existe en el carro del usuario
            if(Auth::check()){
                //si el usuario esta loguedo
                $user_id = Auth::user()->id;
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'tamano'=>$data['tamano'],'user_id'=>$user_id])->count();
            }else{
                //si el usuario no esta loguedo
                $user_id = 0;
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'tamano'=>$data['tamano'],'session_id'=>$session_id])->count();
            }

            if($countProducts>0){
                return redirect()->back()->with('error_message','El producto ya existe en el carrito!');
            }

            //guardar el producto en la tabla carro
            $item = new Cart;
            $item->session_id = $session_id;
            $item->user_id = $user_id;
            $item->product_id = $data['product_id'];
            $item->tamano = $data['tamano'];
            $item->cantidad = $data['cantidad'];
            $item->save();

            return redirect()->back()->with('success_message','El producto se agregó en el carrito. <a style="text-decoration:underline !important" href="/cart">Ver Carrito</a>');

        }
    }

    public function cart(){
        $getCartItems = Cart::getCartItems();
       /*  dd($getCartItems); */
       $meta_titulo = "Carrito de compras - Comercio electrónico de múltiples proveedores";
       $meta_palabraclave = "carrito de compras, multi venta";

        return view('front.products.cart')->with(compact('getCartItems','meta_titulo','meta_palabraclave'));
    }

    public function cartUpdate(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */

            //debe iniciar session antes de ocupar el cupon
            Session::forget('couponAmount');
            Session::forget('couponCode');

            //obtener los detalles de carrito
            $cartDetails = Cart::find($data['cartid']);

            //obtener los productos disponibles
            $availableStock = ProductsAttribute::select('stock')->where(['product_id'=>$cartDetails['product_id'],'tamano'=>$cartDetails['tamano']])->first()->toArray();

            /* echo "<pre>"; print_r($availableStock); die; */

            //Verifica si el stock deseado del usuario está disponible
            if($data['qty']>$availableStock['stock']){
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status'=>false,
                    'message'=>"El stock del producto no está disponible",
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                    'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                ]);
            }

            //verificar si el tamano del producto esta disponible
            $avalibleTamano = ProductsAttribute::where(['product_id'=>$cartDetails['product_id'],'tamano'=>$cartDetails['tamano'],'status'=>1])->count();
            if($avalibleTamano==0){
                $getCartItems = Cart::getCartItems();
                return response()->json([
                    'status'=>false,
                    'message'=>"El tamaño de producto no está disponible. Por favor elimine y eliga otro producto!",
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                    'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                ]);
            }

            //actualizar la cantidad en el carrito
            Cart::where('id',$data['cartid'])->update(['cantidad'=>$data['qty']]);
            $getCartItems = Cart::getCartItems();
            $totalCartItems = totalCartItems();
            Session::forget('couponAmount');
            Session::forget('couponCode');
            return response()->json([
                'status'=>true,
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
            ]);
        }
    }

    public function cartDelete(Request $request){
        if($request->ajax()){
            Session::forget('couponAmount');
            Session::forget('couponCode');
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */

            //debe iniciar session antes de ocupar el cupon
            Session::forget('couponAmount');
            Session::forget('couponCode');

            Cart::where('id',$data['cartid'])->delete();
            $getCartItems = Cart::getCartItems();
            $totalCartItems = totalCartItems();
            return response()->json([
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
            ]);
        }
    }

    public function applyCoupon(Request $request){
        if($request->ajax()){
            $data = $request->all();
            Session::forget('couponAmount');
            Session::forget('couponCode');
            /* echo "<pre>"; print_r($data); die; */
            $getCartItems = Cart::getCartItems();
            $totalCartItems = totalCartItems();
            $couponCount = Coupon::where('cupon_codigo',$data['code'])->count();
            if($couponCount==0){
                return response()->json([
                    'status'=>false,
                    'totalCartItems'=>$totalCartItems,
                    'message'=>'El Cupón no es válido!',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                    'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                ]);
            }else{
                //"verificar para otro cupon" ; die;
                //obtener los detalles del cupo
                $couponDetails = Coupon::where('cupon_codigo',$data['code'])->first();

                //si el cupon no esta activo
                if($couponDetails->status==0){
                    $message = "El Cupón no esta activado!";
                }


                // Verificar la fecha de caducidad del cupón
                $expiry_date = $couponDetails->fecha_caducidad;
                $current_date = date('Y-m-d');

                // Si $expiry_date no es nulo o vacío y está en el formato correcto
                if (!empty($expiry_date) && $expiry_date < $current_date) {
                    $message = "¡El Cupón está expirado!";
                }

                //verificr si el cupon es de una vez
                if($couponDetails->cupon_tipo="Una Vez"){
                    // Verificar en la tabla de pedidos si el cupón ya fue utilizado por el usuario
                    $couponCount = Order::where(['cupon_codigo'=>$data['code'],'user_id'=>Auth::user()->id])->count();
                    if ($couponCount>=1){
                        $message = "¡Ya has utilizado este código de cupón!";
                    }
                }

                //verificr si el cupon pertenece al producto
                //obtener todo la seleccio de categorias para el cupon

                $carArr = explode(",",$couponDetails->categories);

                $total_amount = 0;
                foreach($getCartItems as $key => $item){
                    if(!in_array($item['product']['category_id'],$carArr)){
                        $message = "Este codigo de cupon no pertenece a este producto!";
                    }
                    $attrPrice = Product::getDiscountAttributePrice($item['product_id'],$item['tamano']);
                    /* echo "<pre>"; print_r($attrPrice); die; */
                    $total_amount = $total_amount + ($attrPrice['final_price']*$item['cantidad']);
                }

                if(isset($couponDetails->users)&&!empty($couponDetails->users)){
                    // Verificar si este cupón es seleccionado para el usuario
                    $userArr = explode(",", $couponDetails->users);

                    if (count($userArr)) {
                        foreach ($userArr as $key => $user) {
                            $getUserId = User::select('id')->where('email', $user)->first()->toArray();

                            $usersId[] = $getUserId['id'];

                        }

                        foreach ($getCartItems as $item) {
                            if (!in_array($item['user_id'], $usersId)) {
                                $message = "¡Este código de cupón no es para ti!";
                            }
                        }
                    }
                }

                if($couponDetails->vendor_id>0){
                    $productIds = Product::select('id')->where('vendor_id',$couponDetails->vendor_id)->pluck('id')->toArray();
                    /* echo "<pre>"; print_r($productIds); die; */
                    //verificar si el cupon pertenece al los productos del vendedr
                    foreach ($getCartItems as $item) {
                        if (!in_array($item['product']['id'], $productIds)) {
                            $message = "¡Este código de cupón no es para ti!. (validación del proveedor)";
                        }
                    }
                }

                //mensaje de error
                if(isset($message)){
                    return response()->json([
                        'status'=>false,
                        'totalCartItems'=>$totalCartItems,
                        'message'=>$message,
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                        'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                    ]);
                }else{
                    //codigo del cupon es incorrecto
                    //verificar si el cupon es porcentaje o valis fijo
                    if($couponDetails->amount_tipo=="Valor Fijo"){
                        $couponAmount = $couponDetails->amount;
                    }else{
                        $couponAmount = $total_amount * ($couponDetails->amount/100);
                    }

                    $grand_total = $total_amount - $couponAmount;

                    //aplicacion el codigo del cupon y
                    Session::put('couponAmount',$couponAmount);
                    Session::put('couponCode',$data['code']);

                    $message = "Código del Cupón aplicada correctamente";

                    return response()->json([
                        'status'=>true,
                        'totalCartItems'=>$totalCartItems,
                        'couponAmount'=>$couponAmount,
                        'grand_total'=>$grand_total,
                        'message'=>$message,
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('getCartItems')),
                        'headerview'=>(String)View::make('front.layout.header_cart_items')->with(compact('getCartItems'))
                    ]);
                }

            }
        }
    }

    public function checkout(Request $request){
        $deliveryAddresses = DeliveryAddress::deliveryAddresses();
        foreach($deliveryAddresses as $key => $value){
            $shippingCharges = ShippingCharge::getShippingCharges($value['pais']);
            $deliveryAddresses[$key]['shipping_charges'] = $shippingCharges;
        }
        /* dd($deliveryAddresses); */

        $countries = Country::where('status',1)->get()->toArray();
        $getCartItems = Cart::getCartItems();
        //dd($getCartItems);

        if(count($getCartItems)==0){
            $message = "Su carrito esta vacio. Por favor agregar productos para pagar";
            return redirect('cart')->with('error_message',$message);
        }

        if ($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            //website securuty
            foreach($getCartItems as $item){
                $product_status = Product::getProductStatus($item['product_id']);
                if($product_status==0){
                    //Product::deleteCartProduct($item['product_id']);
                    //$message = "¡Uno de los productos está deshabilitado! Inténtalo de nuevo.";
                    $message = $item['product']['producto_nombre']." con ".$item['tamano'].". No está disponible. Por favor elimínelo del carrito y elija otro producto.";
                    return redirect('/cart')->with('error_message',$message);
                }

                // Evitar que se agoten los productos al realizar pedidos
                $getProductStock = ProductsAttribute::getProductStock($item['product_id'],$item['tamano']);
                if($getProductStock==0){
                    //Product::deleteCartProduct($item['product_id']);
                    //$message = "¡El productos está agotado! Inténtalo mas tarde.";
                    $message = $item['product']['producto_nombre']." con ".$item['tamano'].". No está disponible. Por favor elimínelo del carrito y elija otro producto.";
                    return redirect('/cart')->with('error_message',$message);
                }

                // cuando esta desabilidado enlos atributos de los productos al realizar pedidos
                $getAttributeStatus = ProductsAttribute::getAttributeStatus($item['product_id'],$item['tamano']);
                if($getAttributeStatus==0){
                    //Product::deleteCartProduct($item['product_id']);
                    //$message = "¡Los atributos del producto está deshabilitado! Inténtalo mas tarde.";
                    $message = $item['product']['producto_nombre']." con ".$item['tamano'].". No está disponible. Por favor elimínelo del carrito y elija otro producto.";
                    return redirect('/cart')->with('error_message',$message);
                }

                //prevenir las categorias desabilidatas
                $getCategoryStatus = Category::getCategoryStatus($item['product']['category_id']);
                if($getCategoryStatus==0){
                    //Product::deleteCartProduct($item['product_id']);
                    //$message = "¡La categoria del producto está deshabilitado! Inténtalo mas tarde.";
                    $message = $item['product']['producto_nombre']." con ".$item['tamano'].". No está disponible. Por favor elimínelo del carrito y elija otro producto.";
                    return redirect('/cart')->with('error_message',$message);
                }
            }

            //selecinar la direccion de entrega validacion
            if(empty($data['address_id'])) {
                $message = "¡Por favor, seleccione la dirección de entrega!";
                return redirect()->back()->with('error_message',$message);
            }

            //selecione el metodo de pago validacion
            if(empty($data['payment_gateway'])) {
                $message = "¡Por favor, seleccione el metodo de pago!";
                return redirect()->back()->with('error_message',$message);
            }

            //selecione los terminos y condiciones validacion
            if(empty($data['accept'])) {
                $message = "¡Por favor, seleccione los términos y condiciones!";
                return redirect()->back()->with('error_message',$message);
            }

            //enviar metodo de pago COD si el cod esta selecciono por el usuario
            if($data['payment_gateway']=="COD"){
                $payment_method = "Pago Contra Entrega";
                $order_status = "Nuevo";
            }
            elseif($data['payment_gateway']=="TDB"){
                $payment_method = "Tranferencia/Deposito Bancario";
                $order_status = "Nuevo";
            }// Si se selecciona PayPhone
            elseif ($data['payment_gateway'] == 'TDC') {
                $payment_method = "Pago en linea";
                $order_status = "Nuevo";
            }
            else{
                $payment_method = "Pagado";
                $order_status = "Pendiente";
            }

            //obtener la direcion de entrega por address-id
            $deliveryAddress = DeliveryAddress::where('id',$data['address_id'])->first()->toArray();
            //dd($deliveryAddresses);

            DB::beginTransaction();

            // Obtener el precio total del pedido
            $total_price=0;
            foreach($getCartItems as $item){
                $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['tamano']);
                $total_price = $total_price + ($getDiscountAttributePrice['final_price'] * $item['cantidad']);
            }

            //calcular el gastos de envio
            $shipping_charges = 0;

            //obtener el cargo de envio
            $shipping_charges = ShippingCharge::getShippingCharges($deliveryAddress['pais']);

            //calcular el total general
            $grand_total = $total_price + $shipping_charges - Session::get('couponAmount');

            //insertar el total general in session variable
            Session::put('grand_total',$grand_total);

            //insertar los detalles de la orden
            $order = new Order;
            $order->user_id = Auth::user()->id;
            $order->nombre = $deliveryAddress['nombre'];
            $order->direccion = $deliveryAddress['direccion'];
            $order->ciudad = $deliveryAddress['ciudad'];
            $order->estado = $deliveryAddress['estado'];
            $order->pais = $deliveryAddress['pais'];
            $order->pincodigo = $deliveryAddress['pincodigo'];
            $order->celular = $deliveryAddress['celular'];
            $order->email = Auth::user()->email;
            $order->shipping_charges = $shipping_charges;
            $order->cupon_codigo = Session::get('couponCode');
            $order->cupon_amount = Session::get('couponAmount');
            $order->order_status = $order_status;
            $order->payment_method = $payment_method;
            $order->proceso_pago = $data['payment_gateway'];
            $order->total_general = $grand_total;
            $order->save();

            $order_id = DB::getPdo()->lastInsertId();

            foreach($getCartItems as $item){
                $cartItem = new OrdersProduct;
                $cartItem->order_id = $order_id;
                $cartItem->user_id = Auth::user()->id;
                $getProductDetails = Product::select('producto_codigo','producto_nombre','producto_color','admin_id','vendor_id')->where('id',$item['product_id'])->first()->toArray();
                //dd($getProductDetails);
                $cartItem->admin_id = $getProductDetails['admin_id'];
                $cartItem->vendor_id = $getProductDetails['vendor_id'];
                $cartItem->product_id = $item['product_id'];
                $cartItem->producto_codigo = $getProductDetails['producto_codigo'];
                $cartItem->producto_nombre = $getProductDetails['producto_nombre'];
                $cartItem->producto_color = $getProductDetails['producto_color'];
                $cartItem->producto_tamano = $item['tamano'];
                $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['tamano']);
                $cartItem->producto_precio = $getDiscountAttributePrice['final_price'];

                $getProductStock = ProductsAttribute::getProductStock($item['product_id'],$item['tamano']);
                if($item['cantidad']>$getProductStock){
                    $message = $getProductDetails['producto_nombre']." con ".$item['tamano'].". Stock no está disponible. Por favor reduzca su cantidad e intente de nuevo.";

                    return redirect('/cart')->with('error_message',$message);
                }

                $cartItem->producto_qty = $item['cantidad'];
                $cartItem->save();

                //reducir el stock
                $getProductStock = ProductsAttribute::getProductStock($item['product_id'],$item['tamano']);
                $newStock = $getProductStock - $item['cantidad'];
                ProductsAttribute::where(['product_id'=>$item['product_id'],'tamano'=>$item['tamano']])->update(['stock'=>$newStock]);

            }

            //Insertar el edido ID en la ssesion variable
            Session::put('order_id',$order_id);

            DB::commit();

            $orderDetails = Order::with('orders_products')->where('id',$order_id)->first()->toArray();

            if($data['payment_gateway']=="COD"){
                $email = Auth::user()->email;
                $messageData = [
                    'email' => $email,
                    'name' => Auth::user()->name,
                    'order_id' => $order_id,
                    'orderDetails' => $orderDetails
                ];
                Mail::send('emails.order',$messageData,function($message)use($email){
                    $message->to($email)->subject('Pedido Realizado..! Gracias por su compra, te esperamos pronto!');
                });

                return redirect('thanks');

            }elseif($data['payment_gateway']=="TDB"){
                $email = Auth::user()->email;
                $messageData = [
                    'email' => $email,
                    'name' => Auth::user()->name,
                    'order_id' => $order_id,
                    'orderDetails' => $orderDetails
                ];
                Mail::send('emails.order',$messageData,function($message)use($email){
                    $message->to($email)->subject('Pedido Realizado..! Gracias por su compra, te esperamos pronto!');
                });

                return redirect('thanks_tranferencia');

            }// Si se selecciona PayPhone
            elseif ($data['payment_gateway'] == 'TDC') {
                session(['order' => $order]);
                // Redirigir a una nueva página donde el cliente ingresará la información de la tarjeta
                return redirect('/payphone-checkout');
            }

            elseif($data['payment_gateway']=="Paypal"){
                // Paypal
                return redirect('/paypal');
            }else{
                echo "Próximamente otros métodos de pago";
            }

            /* return redirect('thanks'); */

        }

        $total_price = 0;
        foreach($getCartItems as $item){
            $attrPrice =  Product::getDiscountAttributePrice($item['product_id'],$item['tamano']);
            $total_price = $total_price + ($attrPrice['final_price']*$item['cantidad']);
        }
        /* echo $total_price; die; */

        return view('front.products.checkout')->with(compact('deliveryAddresses','countries','getCartItems','total_price'));
    }


    public function thanks(){
        if(Session::has('order_id')){
            //si el carro esta vacio
            Cart::where('user_id',Auth::user()->id)->delete();
            return view('front.products.thanks');
        }else{
            return redirect('cart');
        }

    }

    public function thanks_tranferencia(){
        if(Session::has('order_id')){
            //si el carro esta vacio
            Cart::where('user_id',Auth::user()->id)->delete();
            return view('front.products.thanks_tranferencia');
        }else{
            return redirect('cart');
        }

    }
}
