@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Detalles Vendedor</h3>
                        
                        <h6 class="font-weight-normal mb-0"><a href="{{ url('admin/admins/vendedor') }}">Regresar</a></h6>
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
                  <h4 class="card-title">Datos Personales</h4>
                 
                    <div class="form-group">
                      <label>Email</label>
                      <input class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_name">Nombre</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['nombre'] }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_direccion">Dirección</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['direccion'] }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_ciudad">Ciudad</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['ciudad'] }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_estado">Estado</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['estado'] }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_pais">Pais</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['pais'] }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_codigopin">Código Pin</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['codigopin'] }}" readonly="">
                    </div> 
                    <div class="form-group">
                      <label for="vendor_celular">Celular</label>
                      <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['celular'] }}" readonly="">
                    </div>
                    @if(!empty($vendorDetails['imagen']))
                    <div class="form-group">
                      <label for="vendor_image">Imagen</label>
                      <br><img style="width: 200px;" src="{{ url('admin/images/photos/'.$vendorDetails['imagen']) }}">     
                    </div>
                    @endif
                  
                </div>
              </div>
            </div> 
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Datos Comerciales</h4>
                    
                    <div class="form-group">
                      <label for="vendor_name">Nombre de la Tienda</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['vendor_business']['nombre_tienda'])) value="{{ $vendorDetails['vendor_business']['nombre_tienda'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_direccion">Dirección de la Tienda</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['vendor_business']['direccion_tienda'])) value=" {{ $vendorDetails['vendor_business']['direccion_tienda'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_ciudad">Ciudad de la Tienda</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['vendor_business']['ciudad_tienda'])) value="{{ $vendorDetails['vendor_business']['ciudad_tienda'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_estado">Estado de la Tienda</label>
                      <input type="text" class="form-control"  @if(isset($vendorDetails['vendor_business']['estado_tienda'])) value="{{ $vendorDetails['vendor_business']['estado_tienda'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_pais">Pais de la Tienda</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['vendor_business']['pais_tienda'])) value="{{ $vendorDetails['vendor_business']['pais_tienda'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_codigopin">Código Pin de la Tienda</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['vendor_business']['codigopin_tienda'])) value="{{ $vendorDetails['vendor_business']['codigopin_tienda'] }}" @endif readonly="">
                    </div> 
                    <div class="form-group">
                      <label for="vendor_celular">Celular de la Tienda</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['vendor_business']['celular_tienda'])) value="{{ $vendorDetails['vendor_business']['celular_tienda'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label>Sitio Web de la Tienda</label>
                      <input class="form-control" @if(isset($vendorDetails['vendor_business']['sitioweb_tienda'])) value="{{ $vendorDetails['vendor_business']['sitioweb_tienda'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label>Email de la Tienda</label>
                      <input class="form-control" @if(isset($vendorDetails['vendor_business']['email_tienda'])) value="{{ $vendorDetails['vendor_business']['email_tienda'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label>Número de licencia comercial</label>
                      <input class="form-control" @if(isset($vendorDetails['vendor_business']['business_licencia_numero'])) value="{{ $vendorDetails['vendor_business']['business_licencia_numero'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label>Moneda</label>
                      <input class="form-control" @if(isset($vendorDetails['vendor_business']['usd_moneda'])) value="{{ $vendorDetails['vendor_business']['usd_moneda'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label>Número Pan</label>
                      <input class="form-control" @if(isset($vendorDetails['vendor_business']['pan_number'])) value="{{ $vendorDetails['vendor_business']['pan_number'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label>Prueba de Dirección</label>
                      <input class="form-control" @if(isset($vendorDetails['vendor_business']['address_proof'])) value="{{ $vendorDetails['vendor_business']['address_proof'] }}" @endif readonly="">
                    </div>
                    @if(!empty($vendorDetails['vendor_business']['address_proof_image']))
                    <div class="form-group">
                      <label for="vendor_image">Imagen</label>
                      <br><img style="width: 200px;" src="{{ url('admin/images/proofs/'.$vendorDetails['vendor_business']['address_proof_image']) }}">       
                    </div>
                    @endif
                  
                </div>
              </div>
            </div> 
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Datos Bancarios</h4>
                 
                    <div class="form-group">
                      <label>Nombre Cuenta Personal</label>
                      <input class="form-control" @if(isset($vendorDetails['vendor_bank']['cuenta_personal_name'])) value="{{ $vendorDetails['vendor_bank']['cuenta_personal_name'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_name">Nombre del Banco</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['vendor_bank']['banco_name'])) value=" {{ $vendorDetails['vendor_bank']['banco_name'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_name">Número de Cuenta</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['vendor_bank']['cuenta_numero'])) value="{{ $vendorDetails['vendor_bank']['cuenta_numero'] }}" @endif readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_direccion">Código Banco IFSC</label>
                      <input type="text" class="form-control" @if(isset($vendorDetails['vendor_bank']['banco_ifsc_code'])) value="{{ $vendorDetails['vendor_bank']['banco_ifsc_code'] }}" @endif readonly="">
                    </div>
                  
                </div>
              </div>
            </div>  
            
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Comisiones</h4>
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
                    <div class="form-group">
                      <label>Comisión por artículo(%)</label>
                      <form method="post" action="{{ url('admin/update-vendor-comision') }}">@csrf
                        <input type="hidden" name="vendor_id" value="{{ $vendorDetails['vendor_personal']['id'] }}">
                        <input name="comision" class="form-control" @if(isset($vendorDetails['vendor_personal']['comision'])) value="{{ $vendorDetails['vendor_personal']['comision'] }}" @endif required="">
                        <br>
                        <button type="submit">Actualizar</button>
                      </form>
                    </div>

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







