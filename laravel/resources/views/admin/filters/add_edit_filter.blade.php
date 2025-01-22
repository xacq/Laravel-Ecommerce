@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Filtros</h3>
                       
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
                  
                  <form class="forms-sample" @if(empty($filter['id'])) action="{{ url('admin/add-edit-filter') }}" @else action="{{ url('admin/add-edit-filter/'.$filter['id']) }}" @endif method="post" enctype="multipart/form-data">@csrf
                    <div class="form-group">
                        <label for="cat_ids">Seleccionar una o más Categorías</label>
                        <select name="cat_ids[]" id="cat_ids" class="form-control text-dark" multiple="" style="height: 250px;">
                            <option value="">Seleccionar</option>
                                @foreach($categories as $section)
                                        <optgroup label="{{ $section['nombre'] }}"></optgroup>
                                        @foreach($section['categories'] as $category)                            
                                                <option @if(!empty($filter['category_id']) == $category['id']) selected="" @endif value="{{ $category['id'] }}">&nbsp;&nbsp;&nbsp;-->&nbsp;{{ $category['categoria_nombre'] }}</option>
                                                @foreach($category['subcategories'] as $subcategory)
                                                        <option @if(!empty($filter['category_id']) == $subcategory['id']) selected="" @endif value="{{ $subcategory['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->&nbsp;{{ $subcategory['categoria_nombre'] }}</option>
                                                @endforeach                         
                                        @endforeach                                    
                                @endforeach                           
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="filtro_nombre">Nombre del Filtro</label>
                      <input type="text" class="form-control" id="filtro_nombre" placeholder="Ingrese el nombre del Filtro" name="filtro_nombre" @if(!empty($filter['filtro_nombre'])) value="{{ $filter['filtro_nombre'] }}" @else value="{{ old('filtro_nombre') }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="filtro_columna">Columna del Filtro</label>
                      <input type="text" class="form-control" id="filtro_columna" placeholder="Ingrese el columna del Filtro" name="filtro_columna" @if(!empty($filter['filtro_columna'])) value="{{ $filter['filtro_columna'] }}" @else value="{{ old('filtro_columna') }}" @endif>
                    </div>       
                    <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                    <button type="button" class="btn btn-light" onclick="this.form.reset(); window.location.href='{{ url('admin/filters') }}';">
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