@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Categorías</h3>
                       
                    </div>
                    <div class="col-12 col-xl-4">
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
                    </div>
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
                  
                  <form class="forms-sample" @if(empty($category['id'])) action="{{ url('admin/add-edit-category') }}" @else action="{{ url('admin/add-edit-category/'.$category['id']) }}" @endif method="post" enctype="multipart/form-data">@csrf
                    <div class="form-group">
                      <label for="categoria_nombre">Nombre Categoría</label>
                      <input type="text" class="form-control" id="categoria_nombre" placeholder="Ingrese el nombre de la categoría" name="categoria_nombre" @if(!empty($category['categoria_nombre'])) value="{{ $category['categoria_nombre'] }}" @else value="{{ old('categoria_nombre') }}" @endif>
                    </div> 
                    <div class="form-group">
                      <label for="section_id">Selecionar la Sección</label>
                      <select name="section_id" id="section_id" class="form-control" style="color: #495057;">
                        <option value="">Seleccionar</option>
                        @foreach($getSections as $section)
                        <option value="{{ $section['id'] }}" @if(!empty($category['section_id']) && $category['section_id']==$section['id']) selected="" @endif>{{ $section['nombre'] }}</option>
                        @endforeach
                      </select>
                    </div>
                    
                    <div id="appendCategoriesLevel">
                      @include('admin.categories.append_categories_level')
                    </div> 
                    <div class="form-group">
                      <label for="categoria_image">Imagen Categoría</label>
                      <input type="file" class="form-control" id="categoria_image"  name="categoria_image">
                      @if(!empty($category['categoria_image']))
                       <a href="{{ url('front/images/category_images/'.$category['categoria_image']) }}" target="_blank">Ver Imagen</a>&nbsp; |&nbsp;
                       <a href="javascript:void(0)" class="confirmDelete" module="category-image" moduleid="{{ $category['id'] }}">Eliminar Imagen</a>
                      @endif
                    </div>    
                    <div class="form-group">
                      <label for="categoria_descuento">Categoría Descuento</label>
                      <input type="text" class="form-control" id="categoria_descuento" placeholder="Ingrese el descuento" name="categoria_descuento" @if(!empty($category['categoria_descuento'])) value="{{ $category['categoria_descuento'] }}" @else value="{{ old('categoria_descuento') }}" @endif>
                    </div> 
                    <div class="form-group">
                      <label for="descripcion">Descripción</label>
                      <textarea name="descripcion" id="descripcion" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="url">Categoría URL</label>
                      <input type="text" class="form-control" id="url" placeholder="Ingrese el url de la categoría" name="url" @if(!empty($category['url'])) value="{{ $category['url'] }}" @else value="{{ old('url') }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="meta_titulo">Meta Título</label>
                      <input type="text" class="form-control" id="meta_titulo" placeholder="Ingrese el Meta Título" name="meta_titulo" @if(!empty($category['meta_titulo'])) value="{{ $category['meta_titulo'] }}" @else value="{{ old('meta_titulo') }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="meta_descripcion">Meta Descripción</label>
                      <input type="text" class="form-control" id="meta_descripcion" placeholder="Ingrese Meta Descripción" name="meta_descripcion" @if(!empty($category['meta_descripcion'])) value="{{ $category['meta_descripcion'] }}" @else value="{{ old('meta_descripcion') }}" @endif>
                    </div>   
                    <div class="form-group">
                      <label for="meta_palabraclave">Palabra Clave</label>
                      <input type="text" class="form-control" id="meta_palabraclave" placeholder="Ingrese la Palabra Clave" name="meta_palabraclave" @if(!empty($category['meta_palabraclave'])) value="{{ $category['meta_palabraclave'] }}" @else value="{{ old('meta_palabraclave') }}" @endif>
                    </div>              
                    <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                    <button type="button" class="btn btn-light" onclick="this.form.reset(); window.location.href='{{ url('admin/categories') }}';">
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