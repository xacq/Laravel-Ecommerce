@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Productos</h3>
                       
                    </div>
                    <!-- <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                    <a class="dropdown-item" href="#">January - March</a>
                                    <a class="dropdown-item" href="#">March - June</a>
                                    <a class="dropdown-item" href="#">June - August</a>
                                    <a class="dropdown-item" href="#">August - November</a>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">{{ $title }}</h4>
                  @if(Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Error: </strong> {{ Session::get('error_message') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  @endif

                  @if(Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Success: </strong> {{ Session::get('success_message') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  @endif

                  @if ($errors->any())
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                  @endif
                  
                  <form class="forms-sample" @if(empty($product['id'])) action="{{ url('admin/add-edit-product') }}" @else action="{{ url('admin/add-edit-product/'.$product['id']) }}" @endif method="post" enctype="multipart/form-data">@csrf
                    <div class="form-group">
                      <label for="category_id">Selecionar la Categoría</label>
                      <select name="category_id" id="category_id" class="form-control text-dark">
                        <option value="">Seleccionar</option>
                        @foreach($categories as $section)
                            <optgroup label="{{ $section['nombre'] }}"></optgroup>
                            @foreach($section['categories'] as $category)
                            <option @if(!empty($product['category_id']==$category['id'])) selected="" @endif value="{{ $category['id'] }}">&nbsp;&nbsp;&nbsp;-->&nbsp;{{ $category['categoria_nombre'] }}</option>
                                @foreach($category['subcategories'] as $subcategory)
                                <option @if(!empty($product['category_id']==$subcategory['id'])) selected="" @endif value="{{ $subcategory['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->&nbsp;{{ $subcategory['categoria_nombre'] }}</option>
                                @endforeach
                            @endforeach
                        @endforeach
                      </select>
                    <div>
                      <br>
                    <div class="loadFilters">
                        @include('admin.filters.category_filters')
                    </div>
                    <div class="form-group">
                      <label for="brand_id">Selecionar la Marca</label>
                      <select name="brand_id" id="brand_id" class="form-control text-dark">
                        <option value="">Seleccionar</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand['id'] }}" @if(!empty($product['brand_id']==$brand['id'])) selected="" @endif>{{ $brand['nombre'] }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="producto_nombre">Nombre Producto</label>
                      <input type="text" class="form-control" id="producto_nombre" placeholder="Ingrese el nombre del producto" name="producto_nombre" @if(!empty($product['producto_nombre'])) value="{{ $product['producto_nombre'] }}" @else value="{{ old('producto_nombre') }}" @endif>
                    </div> 
                    <div class="form-group">
                      <label for="producto_codigo">Código del Producto</label>
                      <input type="text" class="form-control" id="producto_codigo" placeholder="Ingrese el código del producto" name="producto_codigo" @if(!empty($product['producto_codigo'])) value="{{ $product['producto_codigo'] }}" @else value="{{ old('producto_codigo') }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="producto_color">Color del Producto</label>
                      <input type="text" class="form-control" id="producto_color" placeholder="Ingrese el color del producto" name="producto_color" @if(!empty($product['producto_color'])) value="{{ $product['producto_color'] }}" @else value="{{ old('producto_color') }}" @endif>
                    </div> 
                    <div class="form-group">
                      <label for="producto_precio">Precio del Producto</label>
                      <input type="text" class="form-control" id="producto_precio" placeholder="Ingrese el precio del producto" name="producto_precio" @if(!empty($product['producto_precio'])) value="{{ $product['producto_precio'] }}" @else value="{{ old('producto_precio') }}" @endif>
                    </div>   
                    <div class="form-group">
                      <label for="producto_descuento">Producto Descuento (%)</label>
                      <input type="text" class="form-control" id="producto_descuento" placeholder="Ingrese el descuento" name="producto_descuento" @if(!empty($product['producto_descuento'])) value="{{ $product['producto_descuento'] }}" @else value="{{ old('producto_descuento') }}" @endif>
                    </div> 
                    <div class="form-group">
                      <label for="producto_peso">Peso del Producto</label>
                      <input type="text" class="form-control" id="producto_peso" placeholder="Ingrese el peso" name="producto_peso" @if(!empty($product['producto_peso'])) value="{{ $product['producto_peso'] }}" @else value="{{ old('producto_peso') }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="grupo_codigo">Grupo Código</label>
                      <input type="text" class="form-control" id="grupo_codigo" placeholder="Ingrese código del grupo" name="grupo_codigo" @if(!empty($product['grupo_codigo'])) value="{{ $product['grupo_codigo'] }}" @else value="{{ old('grupo_codigo') }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="producto_image">Imagen Producto (Tamaño recomendado:1000x1000)</label>
                      <input type="file" class="form-control" id="producto_image"  name="producto_image">
                      @if(!empty($product['producto_image']))
                       <a href="{{ url('front/images/product_images/large/'.$product['producto_image']) }}" target="_blank">Ver Imagen</a>&nbsp; |&nbsp;
                       <a href="javascript:void(0)" class="confirmDelete" module="product-image" moduleid="{{ $product['id'] }}">Eliminar Imagen</a>
                      @endif
                    </div>
                    <div class="form-group">
                      <label for="producto_video">Video Producto (Tamaño recomendado:2MB)</label>
                      <input type="file" class="form-control" id="producto_video"  name="producto_video">
                      <a href="{{ url('front/videos/product_videos/'.$product['producto_video']) }}" target="_blank">Ver Video</a>&nbsp; |&nbsp;
                       <a href="javascript:void(0)" class="confirmDelete" module="product-video" moduleid="{{ $product['id'] }}">Eliminar Video</a> -->
                    </div>
                    <div class="form-group">
                      <label for="descripcion">Descripción</label>
                      <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{ $product['descripcion'] }}</textarea>
                    </div>
                    <!-- <div class="form-group">
                      <label for="meta_titulo">Meta Título</label>
                      <input type="text" class="form-control" id="meta_titulo" placeholder="Ingrese el Meta Título" name="meta_titulo" @if(!empty($product['meta_titulo'])) value="{{ $product['meta_titulo'] }}" @else value="{{ old('meta_titulo') }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="meta_descripcion">Meta Descripción</label>
                      <input type="text" class="form-control" id="meta_descripcion" placeholder="Ingrese Meta Descripción" name="meta_descripcion" @if(!empty($product['meta_descripcion'])) value="{{ $product['meta_descripcion'] }}" @else value="{{ old('meta_descripcion') }}" @endif>
                    </div>   
                    <div class="form-group">
                      <label for="meta_palabraclave">Palabra Clave</label>
                      <input type="text" class="form-control" id="meta_palabraclave" placeholder="Ingrese la Palabra Clave" name="meta_palabraclave" @if(!empty($product['meta_palabraclave'])) value="{{ $product['meta_palabraclave'] }}" @else value="{{ old('meta_palabraclave') }}" @endif>
                    </div>  --> 
                    <div class="form-group">
                      <label for="es_destacada">Artículo Destacado?</label>
                      <input type="checkbox" name="es_destacada" id="es_destacada" value="Si" @if(!empty($product['es_destacada']) && $product['es_destacada']=="Si") checked="" @endif></input>
                    </div>  
                    <div class="form-group">
                      <label for="is_bestseller">Artículo mas Vendido</label>
                      <input type="checkbox" name="is_bestseller" id="is_bestseller" value="Si" @if(!empty($product['is_bestseller']) && $product['is_bestseller']=="Si") checked="" @endif></input>
                    </div>            
                    <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                    <button type="button" class="btn btn-light" onclick="this.form.reset(); window.location.href='{{ url('admin/products') }}';">
                        Cancelar
                    </button>
                  </form>
                </div>
              </div>
            </div>
            
        </div>
        

    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>
@endsection