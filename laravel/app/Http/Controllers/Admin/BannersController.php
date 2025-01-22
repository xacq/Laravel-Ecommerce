<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Session;

class BannersController extends Controller
{
    public function banners(){
        Session::put('page','banners');
        $banners = Banner::get()->toArray();
        /* dd($banners); die; */
        return view('admin.banners.banners')->with(compact('banners'));
    }

    public function updateBannerStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Banner::where('id',$data['banner_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'banner_id'=>$data['banner_id']]);
        
        }
    }

    public function deleteBanner($id){
        //obtener imagen
        $bannerImage = Banner::where('id',$id)->first();

        //obtenrr el pth de la image
        $banner_image_path = 'front/images/banner_images/';

        //eliminar la imagen de la careta si existe
        if(file_exists($banner_image_path.$bannerImage->image)){
            unlink($banner_image_path.$bannerImage->image);
        }

        //Eliminar de la base de datos tabla
        Banner::where('id',$id)->delete();

        $message = "Pancarta eliminada correctamente";
        return redirect('admin/banners')->with('success_message',$message);

    }

    public function addEditBanner(Request $request, $id=null){
        Session::put('page','banners');
        if($id==""){
            //agregar banner
            $banner = new Banner;
            $title = "Agregar Pancarta Imagen";
            $message = "Pancarta agregada correctamente";
        }else{
            //actualiar baner
            $banner = Banner::find($id);
            $title = "Editar Pancarta Imagen";
            $message = "Pancarta actualizada correctamente";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            $rules = [
                'link' => 'required',
                'titulo' => 'required',
                'alt' => 'required',
            ];
            $customMessages = [
                'link.required' => 'Link es obligatorio',
                'titulo.required' => 'Título es obligatorio',
                'alt.required' => 'Texto Alternativo es obligatorio',
            ];
            $this->validate($request,$rules,$customMessages);

            $banner->tipo = $data['tipo'];
            $banner->link = $data['link'];
            $banner->titulo = $data['titulo'];
            $banner->alt = $data['alt'];
            $banner->status = 1;

            if($data['tipo']=="Deslizante"){
                $width = "1920";
                $height = "720";
            }else if($data['tipo']=="Anuncio"){
                $width = "1920";
                $height = "450";
            }

            //Upload Banner Imagen
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                if ($image->isValid()) {
                    // Genera un nombre único para la imagen
                    $imageName = time() . '.' . $image->getClientOriginalExtension();

                    // Define la ruta donde se guardará la imagen (fuera de laravel)
                    $imagePath = base_path('../front/images/banner_images');

                    // Crear la carpeta si no existe
                    if (!is_dir($imagePath)) {
                        mkdir($imagePath, 0755, true);
                    }

                    // Mueve la imagen a la ruta especificada
                    $image->move($imagePath, $imageName);

                    // Guarda el nombre de la imagen en la base de datos
                    $banner->image = $imageName;
                }
            }

            $banner->save();
            return redirect('admin/banners')->with('success_message',$message);
        }

        return view('admin.banners.add_edit_banner')->with(compact('title','banner'));
    }
}
