<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Category;
use Session;
use Image;

class CategoryController extends Controller
{
    public function categories(){
        Session::put('page','categories');
        $categories = Category::with(['section','parentcategory'])->get()->toArray();
        /* dd($categories); */
        return view('admin.categories.categories')->with(compact('categories'));
    }

    public function updateCategoryStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Category::where('id',$data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'category_id'=>$data['category_id']]);
        
        }
    }

    public function addEditCategory(Request $request, $id=null){
        Session::put('page','categories');
        if($id==""){
            //Agregar categoria funcionalidad
            $title = "Agregar Categoría";
            $category = new Category;
            $getCategories = array();
            $message = "Categoría agregada correctamente";
        }else{
            //editar categoria funcionalidad
            $title = "Editar Categoría";
            $category = Category::find($id);
            $getCategories = Category::with('subcategories')->where(['parent_id'=>0,'section_id'=>$category['section_id']])->get();
            $message = "Categoría editada correctamente";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            $rules = [
                'categoria_nombre' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required',
                'url' => 'required',
            ];
            $customMessages = [
                'categoria_nombre.required' => 'Nombre categoría es obligatorio',
                'categoria_nombre.regex' => 'Nombre categoría no es válido',
                'section_id.required' => 'Sección es obligatorio',
                'url.required' => 'URL es obligatorio'
            ];
            $this->validate($request,$rules,$customMessages);

            if($data['categoria_descuento']==""){
                $data['categoria_descuento'] = 0;
            }

            //Upload Categoria Imagen
            if($request->hasFile('categoria_image')){
                $image = $request->file('categoria_image');
                if($image->isValid()){
                // Genera un nombre único para la imagen
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                // Define la ruta donde se guardará la imagen
                $imagePath = public_path('front/images/category_images');
                
                // Mueve la imagen a la ruta especificada
                $image->move($imagePath, $imageName);

                $category->categoria_image = $imageName;
                }
            }else{
                $category->categoria_image = "";
            }
            $category->section_id = $data['section_id'];
            $category->parent_id = $data['parent_id'];
            $category->categoria_nombre = $data['categoria_nombre'];
            $category->categoria_descuento = $data['categoria_descuento'];
            $category->descripcion = $data['descripcion'];
            $category->url = $data['url'];
            $category->meta_titulo = $data['meta_titulo'];
            $category->meta_descripcion = $data['meta_descripcion'];
            $category->meta_palabraclave = $data['meta_palabraclave'];
            $category->status = 1;
            $category->save();
            return redirect('admin/categories')->with('success_message',$message);
        }

        //optener todas la seciones
        $getSections = Section::get()->toArray();

        return view('admin.categories.add_edit_category')->with(compact('title','category','getSections','getCategories'));
    }   

    public function appendCategoryLevel(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $getCategories = Category::with('subcategories')->where(['parent_id'=>0,'section_id'=>$data['section_id']])->get()->toArray();
            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
        }
    }

    public function deleteCategory($id){
        //eliminar categoria
        Category::where('id',$id)->delete();
        $message = "Categoría eliminada correctamente";
        return redirect()->back()->with('success_message',$message);
    }

    public function deleteCategoryImage($id){
        //eliminar la imagen de categoria
        $categoryImage = Category::select('categoria_image')->where('id',$id)->first();
        
        //optener la imagen de la categoria
        $category_image_path = 'front/images/category_images/';

        //eliminar la imagen de la carpeta
        if(file_exists($category_image_path.$categoryImage->categoria_image)){
            unlink($category_image_path.$categoryImage->categoria_image);
        }

        //eliminar 
        Category::where('id',$id)->update(['categoria_image'=>'']);
        $message = "Imagen eliminada de categoría correctamente";

        return redirect()->back()->with('success_message',$message);
    }
}
