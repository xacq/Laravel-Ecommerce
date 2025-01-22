<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Product;
use App\Models\Section;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductsAttribute;
use App\Models\ProductsImage;
use App\Models\ProductsFilter;

use Auth;
use Session;

class ProductsController extends Controller
{
    public function products(){
        Session::put('page','products');
        $adminTipo = Auth::guard('admin')->user()->tipo;
        $vendor_id = Auth::guard('admin')->user()->vendor_id;
        if($adminTipo == "vendedor"){
            $vendorStatus = Auth::guard('admin')->user()->status;
            if($vendorStatus==0){
                return redirect("admin/update-vendor-details/personal")->with('error_message','Su cuenta de proveedor aún no está aprobada. Por favor asegúrese de llenar su formulario válido: datos personales, comerciales y bancarios');
            }
        }
        $products = Product::with(['section'=>function($query){
            $query->select('id','nombre');
        },'category'=>function($query){
            $query->select('id','categoria_nombre');
        }]);
        if($adminTipo=="vendedor"){
            $products = $products->where('vendor_id',$vendor_id);
        }
        $products = $products->get()->toArray();
        /* dd($products); */
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Product::where('id',$data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'product_id'=>$data['product_id']]);
        
        }
    }

    public function deleteProduct($id){
        //eliminar categoria
        Product::where('id',$id)->delete();
        $message = "Producto eliminado correctamente";
        return redirect()->back()->with('success_message',$message);
    }

    public function addEditProduct(Request $request, $id=null){
        Session::put('page','products');
        if($id==""){
            $title = "Agregar Producto";
            $product = new Product;
            $message = "Producto agregado correctamente";
        }else{
            $title = "Editar Producto";
            $product = Product::find($id);
            /* dd($product); */
            $message = "Producto actualizado correctamente";
        }
    
        if($request->isMethod('post')){
            $data = $request->all();
    
            $rules = [
                'category_id' => 'required',
                'producto_nombre' => 'required|regex:/^[\pL\s\-\d]+$/u',
                'producto_codigo' => 'required|regex:/^\w+$/',
                'producto_precio' => 'required|numeric',
                'producto_color' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessages = [
                'category_id.required' => 'Categoría es obligatorio',
                'producto_nombre.required' => 'Nombre del producto es obligatorio',
                'producto_nombre.regex' => 'Nombre del producto no es válido',
                'producto_codigo.required' => 'Código del producto es obligatorio',
                'producto_codigo.regex' => 'Código del producto no es válido',
                'producto_precio.required' => 'Precio del producto es obligatorio',
                'producto_precio.numeric' => 'Precio del producto no es válido',
                'producto_color.required' => 'Color del producto es obligatorio',
                'producto_color.regex' => 'Color del producto no es válido'
            ];
            $this->validate($request,$rules,$customMessages);

            //Cargar Producto Imagen
            //samll:250x250
            //mediano:500x500
            //grande 1000x1000

           if ($request->hasFile('producto_image')) {
    $image = $request->file('producto_image');
    if ($image->isValid()) {
            // Genera un nombre único para la imagen
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Define las rutas donde se guardará la imagen
            $originalPath = base_path('../front/images/product_images/original/' . $imageName);
            $largeImagePath = base_path('../front/images/product_images/large/' . $imageName);
            $mediumImagePath = base_path('../front/images/product_images/medium/' . $imageName);
            $smallImagePath = base_path('../front/images/product_images/small/' . $imageName);

            // Mueve la imagen a la carpeta "original"
            $image->move(dirname($originalPath), $imageName);

            // Copia la imagen a las otras carpetas
            copy($originalPath, $largeImagePath);
            copy($originalPath, $mediumImagePath);
            copy($originalPath, $smallImagePath);

            // Guarda el nombre de la imagen en la base de datos
            $product->producto_image = $imageName;
        }
    }
 
            
            // Upload Product Video
        if($request->hasFile('producto_video')){
            $video_tmp = $request->file('producto_video');
            if($video_tmp->isValid()){
            //Upload Video in videos folder
            $extension = $video_tmp->getClientOriginalExtension();
            $videoName = rand(111,99999).'.'.$extension;
            $videoPath = 'front/videos/product_videos/';
            $video_tmp->move($videoPath,$videoName);
            //Insert Video name in products table
            $product->producto_video = $videoName;
            }
        }
    
            // guardar los detalles del producto en la tabla
            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails->section_id;
            $product->category_id = $data['category_id'];
            $product->brand_id = $data['brand_id'];
            $product->grupo_codigo = $data['grupo_codigo'];

            $productFilters = ProductsFilter::productFilters();
            foreach($productFilters as $filter){
                /* echo $data[$filter['filtro_columna']]; die; */
                $filterAvailable = ProductsFilter::filterAvailable($filter['id'],$data['category_id']);
                if($filterAvailable=="Si"){
                    if (isset($filter['filtro_columna']) && isset($data[$filter['filtro_columna']])) {
                        $product->{$filter['filtro_columna']} = $data[$filter['filtro_columna']];
                    }
                } 
            }
    
            if($id==""){
                $adminType = Auth::guard('admin')->user()->tipo;
                $vendor_id = Auth::guard('admin')->user()->vendor_id;
                $admin_id = Auth::guard('admin')->user()->id;
        
                $product->admin_tipo = $adminType;
                $product->admin_id = $admin_id;
                if($adminType == "vendedor"){
                    $product->vendor_id = $vendor_id;
                }else{
                    $product->vendor_id = 0;
                }
            }
    
            if(empty($data['producto_descuento'])){
                $data['producto_descuento'] = 0;
            }
            if(empty($data['producto_peso'])){
                $data['producto_peso'] = 0;
            }

            $product->producto_nombre = $data['producto_nombre'];
            $product->producto_codigo = $data['producto_codigo'];
            $product->producto_color = $data['producto_color'];
            $product->producto_precio = $data['producto_precio'];
            $product->producto_descuento = $data['producto_descuento'] ?? 0;
            $product->producto_peso = $data['producto_peso'] ?? 0;
            $product->descripcion = $data['descripcion'];
            $product->meta_titulo = $data['meta_titulo'] ?? '';
            $product->meta_descripcion = $data['meta_descripcion'] ?? '';
            $product->meta_palabraclave = $data['meta_palabraclave'] ?? '';
            $product->es_destacada = $data['es_destacada'] ?? "No";
            if(!empty($data['is_bestseller'])){
                $product->is_bestseller = $data['is_bestseller'];
            }else{
                $product->is_bestseller = "No";
            }
            $product->status = 1;
            $product->save();
    
            return redirect('admin/products')->with('success_message', $message);
        }
    
        // Obtener la sección con la categoría y subcategoría
        $categories = Section::with('categories')->get()->toArray();
        // Obtener las marcas
        $brands = Brand::where('status',1)->get()->toArray();
    
        return view('admin.products.add_edit_product')->with(compact('title','categories','brands','product'));
    }
    
    public function deleteProductImage($id){
        //optener la imagen delproducto
        $productImage = Product::select('producto_image')->where('id',$id)->first();

        //optener producto imagen path
        $small_image_path = 'front/images/product_images/small/';
        $medium_image_path = 'front/images/product_images/medium/';
        $large_image_path = 'front/images/product_images/large/';

        //eliminar la imagen del producto
        if(file_exists($small_image_path.$productImage->producto_image)){
            unlink($small_image_path.$productImage->producto_image);
        }

        if(file_exists($medium_image_path.$productImage->producto_image)){
            unlink($medium_image_path.$productImage->producto_image);
        }

        if(file_exists($large_image_path.$productImage->producto_image)){
            unlink($large_image_path.$productImage->producto_image);
        }

        //eliminar la imagen de l atabla
        Product::where('id',$id)->update(['producto_image'=>'']);

        $message = "Imagen eliminado correctamente";
        return redirect()->back()->with('success_message',$message);
    }

    public function deleteProductVideo($id){
        //tooptener video product
        $productVideo = Product::select('producto_video')->where('id',$id)->first();
        
        $product_video_path = 'front/videos/product_videos/';

        //eliminar la video del producto
        if(file_exists($product_video_path.$productVideo->producto_video)){
            unlink($product_video_path.$productVideo->producto_video);
        }

        //eliminar la video de la tabla
        Product::where('id',$id)->update(['producto_video'=>'']);

        $message = "Video eliminado correctamente";
        return redirect()->back()->with('success_message',$message);
    }

    public function addAttributes(Request $request, $id){
        Session::put('page','products');
        $product = Product::select('id','producto_nombre','producto_codigo','producto_color','producto_precio','producto_image')->with('attributes')->find($id);
        if($request->isMethod('post')){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */

            foreach($data['referencia'] as $key => $value){
                if(!empty($value)){

                    // ver si las refeencias  se duplican
                    $referenciaCount = ProductsAttribute::where('referencia',$value)->count();
                    if($referenciaCount>0){
                        return redirect()->back()->with('error_message','Esta referencia ya existe');
                    }
                    // ver si las refeencias  se duplican
                    $tamanoCount = ProductsAttribute::where([
                        'product_id' => $id,
                        'tamano' => $data['tamano'][$key]
                    ])->count();
                    
                    if($tamanoCount > 0){
                        return redirect()->back()->with('error_message', 'Este tamaño ya existe');
                    }
                    

                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->referencia = $value;
                    $attribute->tamano = $data['tamano'][$key];
                    $attribute->precio = $data['precio'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }
            return redirect()->back()->with('success_message','Atributos de productos agregados correctamente');
        }
        return view('admin.attributes.add_edit_attributes')->with(compact('product'));
    }

    public function updateAttributeStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsAttribute::where('id',$data['attribute_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'attribute_id'=>$data['attribute_id']]);
        
        }
    } 

    public function editAttribute(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            foreach($data['attributeId'] as $key => $attribute){
                if(!empty($attribute)){
                    ProductsAttribute::where(['id'=>$data['attributeId'][$key]])->update(['precio'=>$data['precio'][$key],'stock'=>$data['stock'][$key]]);
                }
            }
            return redirect()->back()->with('success_message','Atributo actualizado correctamente');
        }
    }

    public function addImages($id, Request $request){
        Session::put('page', 'products');
        $product = Product::select('id', 'producto_nombre', 'producto_codigo', 'producto_color', 'producto_precio', 'producto_image')->with('images')->find($id);
        
        if($request->isMethod('post')){
            $data = $request->all();
            if($request->hasFile('images')){
                $images = $request->file('images');
                foreach($images as $key => $image) {
                    if ($image->isValid()) {
                        $extension = $image->getClientOriginalExtension();
                        $imageName = rand(111, 99999) . '.' . $extension;
    
                        // Define las rutas donde se guardará la imagen
                        $originalImagePath = public_path('front/images/product_images/original/' . $imageName);
                        $largeImagePath = public_path('front/images/product_images/large/' . $imageName);
                        $mediumImagePath = public_path('front/images/product_images/medium/' . $imageName);
                        $smallImagePath = public_path('front/images/product_images/small/' . $imageName);
    
                        // Mueve la imagen a la ruta original
                        $image->move(public_path('front/images/product_images/original'), $imageName);
    
                        // Copia la imagen a las otras rutas
                        copy($originalImagePath, $largeImagePath);
                        copy($originalImagePath, $mediumImagePath);
                        copy($originalImagePath, $smallImagePath);
    
                        // Guarda la imagen en la base de datos
                        $productImage = new ProductsImage;
                        $productImage->image = $imageName;
                        $productImage->product_id = $id;
                        $productImage->status = 1;
                        $productImage->save();
                    }
                }
            }
    
            return redirect()->back()->with('success_message', 'Atributo actualizado correctamente');
        }
    
        return view('admin.images.add_images')->with(compact('product'));
    }    

    public function updateImageStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsImage::where('id',$data['image_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'image_id'=>$data['image_id']]);
        
        }
    }

    public function deleteImage($id){
        //optener la imagen delproducto
        $productImage = ProductsImage::select('image')->where('id',$id)->first();

        //optener producto imagen path
        $small_image_path = 'front/images/product_images/small/';
        $medium_image_path = 'front/images/product_images/medium/';
        $large_image_path = 'front/images/product_images/large/';

        //eliminar la imagen del producto
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }

        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }

        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }

        //eliminar la imagen de l atabla
        ProductsImage::where('id',$id)->delete();

        $message = "Imagen eliminado correctamente";
        return redirect()->back()->with('success_message',$message);
    }

}
