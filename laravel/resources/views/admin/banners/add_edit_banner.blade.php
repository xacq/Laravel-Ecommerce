@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Pancartas</h3>
                       
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
                  
                  <form class="forms-sample" @if(empty($banner['id'])) action="{{ url('admin/add-edit-banner') }}" @else action="{{ url('admin/add-edit-banner/'.$banner['id']) }}" @endif method="post" enctype="multipart/form-data">@csrf                   
                    <div class="form-group">
                      <label for="link">Tipo de Pancarta</label>
                      <select class="form-control" id="tipo" name="tipo" required="">
                        <option value="">Seleccionar</option>
                        <option @if(!empty($banner['tipo'])&& $banner['tipo']=="Deslizante") selected="" @endif value="Deslizante">Deslizante</option>
                        <option @if(!empty($banner['tipo'])&& $banner['tipo']=="Anuncio") selected="" @endif value="Anuncio">Anuncio</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="admin_image">Imagen Pancarta</label>
                      <input type="file" class="form-control" id="image"  name="image">
                      @if(!empty($banner['image']))
                       <a href="{{ url('front/images/banner_images/'.$banner['image']) }}" target="_blank">Ver Imagen</a>
                      @endif
                    </div>  
                    <div class="form-group">
                      <label for="link">Link Pancarta</label>
                      <input type="text" class="form-control" id="link" placeholder="Ingrese el link de la pancarta" name="link" @if(!empty($banner['link'])) value="{{ $banner['link'] }}" @else value="{{ old('link') }}" @endif>
                    </div> 
                    <div class="form-group">
                      <label for="titulo">Título Pancarta</label>
                      <input type="text" class="form-control" id="titulo" placeholder="Ingrese el título de la pancarta" name="titulo" @if(!empty($banner['titulo'])) value="{{ $banner['titulo'] }}" @else value="{{ old('titulo') }}" @endif>
                    </div> 
                    <div class="form-group">
                      <label for="alt">Texto Alternativo del Pancarta</label>
                      <input type="text" class="form-control" id="alt" placeholder="Ingrese el texto alternativo de la pancarta" name="alt" @if(!empty($banner['alt'])) value="{{ $banner['alt'] }}" @else value="{{ old('alt') }}" @endif>
                    </div>          
                    <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                    <button type="button" class="btn btn-light" onclick="this.form.reset(); window.location.href='{{ url('admin/banners') }}';">
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