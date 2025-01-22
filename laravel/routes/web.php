<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Http\Controllers\Front\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/test-email', function() {
    try {
        \Mail::raw('Este es un correo de prueba desde Laravel', function ($message) {
            $message->to('dep.sistemas.caap@gmail.com') // Cambia al correo deseado
                    ->subject('Correo de Prueba desde Laravel')
                    ->from('info@ambatoshop.com', 'AmbatoShop');
        });
        return "Correo enviado exitosamente!";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});

Route::get('/clear-cache', function() {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    return "Caché de configuración limpiada";
});

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){
    //ruta de logeo con el administradir
    Route::match(['get','post'],'login','AdminController@login');
    //controla la ruta de dasboard para que se logee obligatoriamente
    Route::group(['middleware'=>['admin']],function(){
    //Ruta del administrador dashboard
    Route::get('dashboard','AdminController@dashboard');

    //actulizar contraseña del admin
    Route::match(['get','post'],'update-admin-password','AdminController@updateAdminPassword');

    //actulizar contraseña del vendedor
    Route::match(['get','post'],'update-vendor-password','AdminController@updateVendorPassword');

    //verificar contraseña del admin
    Route::post('check-admin-password','AdminController@checkAdminPassword');

    // actuliar los detalles de admin
    Route::match(['get','post'],'update-admin-details','AdminController@updateAdminDetails');

    // actualizar los detalles del vendedor
    Route::match(['get','post'],'update-vendor-details/{slug}','AdminController@updateVendorDetails');

    //actualizar las comisiones del vendedor
    Route::post('update-vendor-comision','AdminController@updateVendorComision');

    //ver adminitradores / subadministradores/ vendedores
    Route::get('admins/{tipo?}','AdminController@admins');

    //ver los detalles del vendedor
    Route::get('view-vendor-details/{id}','AdminController@viewVendorDetails');

    //actualizar el status de admin
    Route::post('update-admin-status','AdminController@updateAdminStatus');

    //cerras sesion admin
    Route::get('logout','AdminController@logout');

    //seciones
    Route::get('sections','SectionController@sections');

    //actualizar/eliminar/agregar el status de secciones
    Route::post('update-section-status','SectionController@updateSectionStatus');

    Route::get('delete-section/{id}','SectionController@deleteSection');

    Route::match(['get','post'],'add-edit-section/{id?}','SectionController@addEditSection');

    //Marcas "Brands"
    Route::get('brands','BrandController@brands');

    //actualizar/eliminar/agregar el status de las marcas
    Route::post('update-brand-status','BrandController@updateBrandStatus');

    Route::get('delete-brand/{id}','BrandController@deleteBrand');

    Route::match(['get','post'],'add-edit-brand/{id?}','BrandController@addEditBrand');

    //categorias
    Route::get('categories','CategoryController@categories');

    Route::post('update-category-status','CategoryController@updateCategoryStatus');

    Route::match(['get','post'],'add-edit-category/{id?}','CategoryController@addEditCategory');

    Route::get('append-categories-level','CategoryController@appendCategoryLevel');

    Route::get('delete-category/{id}','CategoryController@deleteCategory');
    Route::get('delete-category-image/{id}','CategoryController@deleteCategoryImage');

    //Productos
    Route::get('products','ProductsController@products');
    Route::post('update-product-status','ProductsController@updateProductStatus');
    Route::get('delete-product/{id}','ProductsController@deleteProduct');

    Route::match(['get','post'],'add-edit-product/{id?}','ProductsController@addEditProduct');
    Route::get('delete-product-image/{id}','ProductsController@deleteProductImage');
    Route::get('delete-product-video/{id}','ProductsController@deleteProductVideo');

    //Atributos
    Route::match(['get','post'],'add-edit-attributes/{id}','ProductsController@addAttributes');
    Route::post('update-attribute-status','ProductsController@updateAttributeStatus');
    Route::get('delete-attribute/{id}','ProductsController@deleteAttribute');
    Route::match(['get','post'],'edit-attributes/{id}','ProductsController@editAttribute');

    //Filtro
    Route::get('filters','FilterController@filters');
    Route::get('filters-values','FilterController@filtersValues');
    Route::post('update-filter-status','FilterController@updateFilterStatus');
    Route::post('update-filter-value-status','FilterController@updateFilterValueStatus');

    Route::match(['get','post'],'add-edit-filter/{id?}','FilterController@addEditFilter');
    Route::match(['get','post'],'add-edit-filter-value/{id?}','FilterController@addEditFilterValue');
    Route::post('category-filters','FilterController@categoryFilters');

    //Imagenes
    Route::match(['get','post'],'add-images/{id}','ProductsController@addImages');
    Route::post('update-image-status','ProductsController@updateImageStatus');
    Route::get('delete-image/{id}','ProductsController@deleteImage');

    //Banners
    Route::get('banners','BannersController@banners');
    Route::post('update-banner-status','BannersController@updateBannerStatus');
    Route::get('delete-banner/{id}','BannersController@deleteBanner');
    Route::match(['get','post'],'add-edit-banner/{id?}','BannersController@addEditBanner');

    //Cupones
    Route::get('coupons','CouponsController@coupons');
    Route::post('update-coupon-status','CouponsController@updateCouponStatus');
    Route::get('delete-coupon/{id}','CouponsController@deleteCoupon');
    Route::match(['get','post'],'add-edit-coupon/{id?}','CouponsController@addEditCoupon');

    //usuarios
    Route::get('users','UserController@users');
    Route::post('update-user-status','UserController@updateUserStatus');

    //Pedidos
    Route::get('orders','OrderController@orders');
    Route::get('orders/{id}','OrderController@orderDetails');
    Route::post('update-order-status','OrderController@updateOrderStatus');
    Route::post('update-order-item-status','OrderController@updateOrderItemStatus');

    //facura del pedido
    Route::get('orders/invoice/{id}','OrderController@viewOrderInvoice');
    Route::get('orders/invoice/pdf/{id}','OrderController@viewPDFInvoice');

    //CARGOD DE ENVIO
    Route::get('shipping-charges','ShippingController@shippingCharges');
    Route::post('update-shipping-status','ShippingController@updateShippingStatus');
    Route::match(['get','post'],'edit-shipping-charges/{id}','ShippingController@editShippingCharges');

    //suscripciones
    Route::get('subscribers','NewsletterController@subscribers');
    Route::post('update-subscriber-status','NewsletterController@updateSubscriberStatus');
    Route::get('delete-subscriber/{id}','NewsletterController@deleteSubscriber');
    Route::get('export-subscribers','NewsletterController@exportSubscribers');

    //Calificaciones
    Route::get('ratings','RatingController@ratings');
    Route::post('update-rating-status','RatingController@updateRatingStatus');
    Route::get('delete-rating/{id}','RatingController@deleteRating');
    });
});

Route::get('orders/invoice/download/{id}','App\Http\Controllers\Admin\OrderController@viewPDFInvoice');

Route::namespace('App\Http\Controllers\Front')->group(function(){
    Route::get('/','IndexController@index');

    //Listas rutas de categorias
    $catUrls = Category::select('url')->where('status',1)->get()->pluck('url')->toArray();
    /* dd($catUrls); die; */
    foreach($catUrls as $key => $url){
        Route::match(['get','post'],'/'.$url,'ProductsController@listing');
    }

    //Productos del vendedor
    Route::get('/products/{vendorid}','ProductsController@vendorListing');

    //Detalles del productos(en la pagina)
    Route::get('/product/{id}','ProductsController@detail');

    //Obtener el atributo del producto precio
    Route::post('get-product-price','ProductsController@getProductPrice');

    //Login/Registro del Vendedor
    Route::get('vendor/login-register','VendorController@loginRegister');

    //Registro del vendedor
    Route::post('vendor/register','VendorController@vendorRegister');

    //Confirmacion de la cuenta vendedor
    Route::get('vendor/confirm/{code}','VendorController@confirmVendor');

    //Agregar la ruta del carrito
    Route::post('cart/add','ProductsController@cartAdd');

    //ruta para el carro
    Route::get('cart','ProductsController@cart');

    //actualizar la cantidad del carrito
    Route::post('cart/update','ProductsController@cartUpdate');

    //eliminar el item del carrito
    Route::post('cart/delete','ProductsController@cartDelete');

    //Login/Registro del Usuario
    Route::get('user/login-register',['as'=>'login','uses'=>'UserController@loginRegister']);

    //registro del usuario
    Route::post('user/register','UserController@userRegister');

    //buscar producto
    Route::get('search-products','ProductsController@listing');

    //editar suscribiones
    Route::post('add-subscriber-email','NewsletterController@addSubscriber');

    //para los comentario
    Route::post('add-rating','RatingController@addRating');

    Route::group( ['middleware'=> ['auth']], function(){
    //cuenta del usuario
    Route::match(['get','post'],'user/account','UserController@userAccount');

    //actualizar la contrasena del usuario
    Route::post('user/update-password','UserController@userUpdatePassword');

    //Aplicar el cupon
    Route::post('/apply-coupon','ProductsController@applyCoupon');

    //ruta para pagar
    Route::match(['GET','POST'],'/checkout','ProductsController@checkout');

    // Página para PayPhone
    Route::get('/payphone-checkout', function () {
        return view('front.products.payphone_checkout');
    });


    Route::get('/thanks_online', [OrderController::class, 'thanksOnline'])->name('thanks.online');
    
    //obtner direccion de delivery
    Route::post('get-delivery-address','AddressController@getDeliveryAddress');

    //guardar direccion de delivery
    Route::post('save-delivery-address','AddressController@saveDeliveryAddress');

    //eliminar direccion de delivery
    Route::post('remove-delivery-address','AddressController@removeDeliveryAddress');

    //gracias por la compra con delivery
    Route::get('thanks','ProductsController@thanks');

    //gracias por la compra con delivery
    Route::get('thanks_tranferencia','ProductsController@thanks_tranferencia');

    //pedidos del usuario
    Route::get('user/orders/{id?}','OrderController@orders');

    //Paypal
    Route::get('paypal','PaypalController@paypal');
    Route::post('pay','PaypalController@pay')->name('payment');
    Route::get('success','PaypalController@success');
    Route::get('error','PaypalController@error');
});

    //login del usuario
    Route::post('user/login','UserController@userLogin');

    //usuario olvido la contrasena del usuario
    Route::match(['get','post'],'user/forgot-password','UserController@forgotPassword');

    //usuario olvido la contrasena del vendedor
    Route::match(['get','post'],'vendor/forgot-password','VendorController@forgotPasswordVendor');

    //registro del usuario
    Route::get('user/logout','UserController@userLogout');

    //Confirmacion de la cuenta del usuario
    Route::get('user/confirm/{code}','UserController@confirmAccount');

});


