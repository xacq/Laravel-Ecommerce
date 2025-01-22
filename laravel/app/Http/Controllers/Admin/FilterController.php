<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductsFilter;
use App\Models\ProductsFiltersValue;
use Session;
use App\Models\Section;
use DB;

class FilterController extends Controller
{
    public function filters(){
        Session::put('page','filters');
        $filters = ProductsFilter::get()->toArray();
        /* dd($filters); */ 
        return view('admin.filters.filters')->with(compact('filters'));
    }

    public function filtersValues(){
        Session::put('page','filters');
        $filters_values = ProductsFiltersValue::get()->toArray();
        /* dd($filters); */ 
        return view('admin.filters.filters_values')->with(compact('filters_values'));
    }

    public function updateFilterStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsFilter::where('id',$data['filter_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'filter_id'=>$data['filter_id']]);
        
        }
    }

    public function updateFilterValueStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductsFiltersValue::where('id',$data['filter_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'filter_id'=>$data['filter_id']]);
        
        }
    }

    public function addEditFilter(Request $request, $id=null){
        Session::put('page','filters');
        if($id==""){
            $title = "Agregar un Filtro";
            $filter = new ProductsFilter;
            $message = "Filtro agregado corectamente";
        }else{
            $title = "Editar un Filtro";
            $filter = ProductsFilter::find($id);
            $message = "Filtro editado corectamente";
        }

    
        if ($request->isMethod ('post')){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            $cat_ids = implode(',',$data['cat_ids']);
            // Save Filter column details in products_filters table
            $filter->cat_ids = $cat_ids;
            $filter->filtro_nombre = $data['filtro_nombre'];
            $filter->filtro_columna = $data['filtro_columna'];
            $filter->status = 1;
            $filter->save();
            // Add filter column in products table
            DB::statement('ALTER TABLE products ADD ' . $data['filtro_columna'] . ' VARCHAR(255) AFTER descripcion');
            return redirect('admin/filters')->with('success_message', $message);        
        }

        // Obtener la sección con la categoría y subcategoría
        $categories = Section::with('categories')->get()->toArray();

        return view('admin.filters.add_edit_filter')->with(compact('title','categories','filter'));
    }

    public function addEditFilterValue(Request $request, $id=null){
        Session::put('page','filters');
        if($id==""){
            $title = "Agregar el Valor del Filtro";
            $filter = new ProductsFiltersValue;
            $message = "Valor del Filtro agregado corectamente";
        }else{
            $title = "Editar el Valor del Filtro";
            $filter = ProductsFiltersValue::find($id);
            $message = "Valor del Filtro editado corectamente";
        }

    
        if ($request->isMethod ('post')){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            
            // Save Filter Values column details in products_filters table
            
            $filter->filtro_id = $data['filtro_id'];
            $filter->filtro_value = $data['filtro_value'];
            $filter->status = 1;
            $filter->save();

            return redirect('admin/filters-values')->with('success_message', $message);        
        }

        //Obtenr filtros
        $filters = ProductsFilter::where('status',1)->get()->toArray();

        return view('admin.filters.add_edit_filter_value')->with(compact('title','filter','filters'));
    }

    public function categoryFilters(Request $request){
        if($request->ajax()){
            $data = $request->all();
            /* echo "<pre>"; print_r($data); die; */
            $category_id = $data['category_id'];
            return response()->json([
                'view'=>(String)View::make('admin.filters.category_filters')->with(compact('category_id'))
            ]);
        }
    }

}
