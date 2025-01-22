@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Configuraciones</h3>
                        <!-- <h6 class="font-weight-normal mb-0">Actulizar la Contraseña</h6> -->
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
        @if($slug=="personal")
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Actualizar Datos Vendedor</h4>
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
                  
                  <form class="forms-sample" action="{{ url('admin/update-vendor-details/personal') }}"
                  method="post" enctype="multipart/form-data">@csrf
                    <div class="form-group">
                      <label>Vendedor: Nombre Usuario/Email</label>
                      <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="vendor_name">Nombre</label>
                      <input type="text" class="form-control" id="vendor_name" placeholder="Ingrese el nombre" name="vendor_name" value="{{ Auth::guard('admin')->user()->nombre }}">
                    </div>
                    <div class="form-group">
                      <label for="vendor_direccion">Dirección</label>
                      <input type="text" class="form-control" id="vendor_direccion" placeholder="Ingrese la dirección" name="vendor_direccion" value="{{ $vendorDetails['direccion'] }}" >
                    </div>
                    <div class="form-group">
                      <label for="vendor_ciudad">Ciudad</label>
                      <input type="text" class="form-control" id="vendor_ciudad" placeholder="Ingrese la ciudad" name="vendor_ciudad" value="{{ $vendorDetails['ciudad'] }}" >
                    </div>
                    <div class="form-group">
                      <label for="vendor_estado">Parroquia</label>
                      <input type="text" class="form-control" id="vendor_estado" placeholder="Ingrese el estado" name="vendor_estado" value="{{ $vendorDetails['estado'] }}" >
                    </div>
                    <div class="form-group">
                      <label for="vendor_pais">Pais</label>
                      <!-- <input type="text" class="form-control" id="vendor_pais" placeholder="Ingrese el pais" name="vendor_pais" value="{{ $vendorDetails['pais'] }}" > -->
                      <select class="form-control" id="vendor_pais" name="vendor_pais" style="color: #495057;">
                        <option value="">Seleccionar Pais</option>
                        @foreach($countries as $country)
                          <option value="{{ $country['country_name'] }}" @if($country['country_name']==$vendorDetails['pais']) selected @endif>{{ $country['country_name'] }}</option>
                        @endforeach
                      </select> 
                    </div>
                    <div class="form-group">
                      <label for="vendor_codigopin">Cédula</label>
                      <input type="text" class="form-control" id="vendor_codigopin" placeholder="Ingrese el codigo pin" name="vendor_codigopin" value="{{ $vendorDetails['codigopin'] }}" >
                    </div> 
                    <div class="form-group">
                      <label for="vendor_celular">Celular</label>
                      <input type="text" class="form-control" id="vendor_celular" placeholder="Ingrese 10 digitos" name="vendor_celular" value="{{  Auth::guard('admin')->user()->celular }}" required="" maxlength="10" minlength="10">
                    </div>
                    <div class="form-group">
                      <label for="vendor_image">Imagen</label>
                      <input type="file" class="form-control" id="vendor_image"  name="vendor_image">
                      @if(!empty(Auth::guard('admin')->user()->imagen))
                      <a target="_blank" href="{{ url('admin/images/photos/'.Auth::guard('admin')->user()->imagen) }}">Ver foto</a>
                      <input type="hidden" name="actual_vendor_image" value="{{ Auth::guard('admin')->user()->imagen }}">
                      @endif
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                    <button class="btn btn-light">Cancelar</button>
                  </form>
                </div>
              </div>
            </div>    
        </div>
        @elseif($slug=="business")
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Actualizar Datos Business Vendedor</h4>
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
                  
                  <form class="forms-sample" action="{{ url('admin/update-vendor-details/business') }}"
                  method="post" enctype="multipart/form-data">@csrf
                    <div class="form-group">
                      <label>Vendedor: Nombre Usuario/Email</label>
                      <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="nombre_tienda">Nombre Tienda</label>
                      <input type="text" class="form-control" id="nombre_tienda" placeholder="Ingrese el nombre de la tienda" name="nombre_tienda" @if(isset($vendorDetails['nombre_tienda'])) value="{{ $vendorDetails['nombre_tienda'] }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="direccion_tienda">Dirección Tienda</label>
                      <input type="text" class="form-control" id="direccion_tienda" placeholder="Ingrese la dirección de la tienda" name="direccion_tienda" @if(isset($vendorDetails['direccion_tienda'])) value=" {{ $vendorDetails['direccion_tienda'] }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="ciudad_tienda">Ciudad Tienda</label>
                      <input type="text" class="form-control" id="ciudad_tienda" placeholder="Ingrese la ciudad de la tienda" name="ciudad_tienda" @if(isset($vendorDetails['ciudad_tienda'])) value="{{ $vendorDetails['ciudad_tienda'] }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="estado_tienda">Parroquia Tienda</label>
                      <input type="text" class="form-control" id="estado_tienda" placeholder="Ingrese el estado donde se encuentra la tienda" name="estado_tienda" @if(isset($vendorDetails['estado_tienda'])) value="{{ $vendorDetails['estado_tienda'] }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="pais_tienda">Pais Tienda</label>
                      <select class="form-control" id="pais_tienda" name="pais_tienda" style="color: #495057;">
                        <option value="">Seleccionar Pais</option>
                        @foreach($countries as $country)
                          <option value="{{ $country['country_name'] }}" @if(isset($vendorDetails['pais_tienda']) && $country['country_name']==$vendorDetails['pais_tienda']) selected @endif>{{ $country['country_name'] }}</option>
                        @endforeach
                      </select> 
                    </div>
                    <div class="form-group">
                      <label for="codigopin_tienda">RUC</label>
                      <input type="text" class="form-control" id="codigopin_tienda" placeholder="Ingrese el codigo pin de la tienda" name="codigopin_tienda" @if(isset($vendorDetails['codigopin_tienda'])) value="{{ $vendorDetails['codigopin_tienda'] }}" @endif>
                    </div> 
                    <div class="form-group">
                      <label for="celular_tienda">Celular</label>
                      <input type="text" class="form-control" id="celular_tienda" placeholder="Ingrese 10 digitos" name="celular_tienda" @if(isset($vendorDetails['celular_tienda'])) value="{{ $vendorDetails['celular_tienda'] }}" @endif required="" maxlength="10" minlength="10">
                    </div>
                    <!-- <div class="form-group">
                      <label for="sitioweb_tienda">Sitio Web de la Tienda</label>
                      <input type="text" class="form-control" id="sitioweb_tienda" placeholder="Ingrese el sitio web de la tienda" name="sitioweb_tienda" @if(isset($vendorDetails['sitioweb_tienda'])) value="{{ $vendorDetails['sitioweb_tienda'] }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="email_tienda">Email de la Tienda</label>
                      <input type="text" class="form-control" id="email_tienda" placeholder="Ingrese el email de la tienda" name="email_tienda" @if(isset($vendorDetails['email_tienda'])) value="{{ $vendorDetails['email_tienda'] }}" @endif>
                    </div> -->
                    <!-- <div class="form-group">
                      <label for="business_licencia_numero">Número de licencia Comercial</label>
                      <input type="text" class="form-control" id="business_licencia_numero" placeholder="Ingrese el número de licencia comercial" name="business_licencia_numero" @if(isset($vendorDetails['business_licencia_numero'])) value="{{ $vendorDetails['business_licencia_numero'] }}" @endif>
                    </div> -->
                    <div class="form-group">
                      <label for="usd_moneda">Moneda</label>
                      <input type="text" class="form-control" id="usd_moneda" placeholder="Ingrese la moneda" name="usd_moneda" @if(isset($vendorDetails['usd_moneda'])) value="{{ $vendorDetails['usd_moneda'] }}" @endif>
                    </div>
                    <!-- <div class="form-group">
                      <label for="pan_number">Número Panorama</label>
                      <input type="text" class="form-control" id="pan_number" placeholder="Ingrese el número panorama" name="pan_number" @if(isset($vendorDetails['pan_number'])) value="{{ $vendorDetails['pan_number'] }}" @endif>
                    </div> -->
                    <div class="form-group">
                      <label for="address_proof">Selecionar Identidad</label>
                      <select class="form-control" name="address_proof" id="address_proof">
                        <option value="Cedula" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Cedula") selected @endif>Cedula</option>
                        <option value="Pasaporte" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Pasaporte") selected @endif>Pasaporte</option>
                        <option value="Papeleta de Votación" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Papeleta de Votación") selected @endif>Papeleta de Votación</option>
                        <option value="Licencia" @if(isset($vendorDetails['address_proof']) && $vendorDetails['address_proof']=="Licencia") selected @endif>Licencia</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="address_proof_image">Identidad Imagen</label>
                      <input type="file" class="form-control" id="address_proof_image"  name="address_proof_image">
                      @if(!empty($vendorDetails['address_proof_image']))
                      <a target="_blank" href="{{ url('admin/images/proofs/'.$vendorDetails['address_proof_image']) }}">Ver foto</a>
                      <input type="hidden" name="actual_address_proof" value="{{ $vendorDetails['address_proof_image'] }}">
                      @endif
                      
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                    <button class="btn btn-light">Cancelar</button>
                  </form>
                </div>
              </div>
            </div>    
        </div>
        @elseif($slug=="bank")
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Actualizar Datos Banco Vendedor</h4>
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
                  
                  <form class="forms-sample" action="{{ url('admin/update-vendor-details/bank') }}"
                  method="post" enctype="multipart/form-data">@csrf
                    <div class="form-group">
                      <label>Vendedor: Nombre Usuario/Email</label>
                      <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="cuenta_personal_name">Nombre Cuenta Personal</label>
                      <input type="text" class="form-control" id="cuenta_personal_name" placeholder="Ingrese el nombre de la tienda" name="cuenta_personal_name" @if(isset($vendorDetails['cuenta_personal_name'])) value="{{ $vendorDetails['cuenta_personal_name'] }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="banco_name">Nombre del Banco</label>
                      <input type="text" class="form-control" id="banco_name" placeholder="Ingrese la dirección de la tienda" name="banco_name" @if(isset($vendorDetails['banco_name'])) value=" {{ $vendorDetails['banco_name'] }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="cuenta_numero">Número de Cuenta</label>
                      <input type="text" class="form-control" id="cuenta_numero" placeholder="Ingrese la ciudad de la tienda" name="cuenta_numero" @if(isset($vendorDetails['cuenta_numero'])) value="{{ $vendorDetails['cuenta_numero'] }}" @endif>
                    </div>
                    <div class="form-group">
                      <label for="banco_ifsc_code">Tipo de cuenta(Ahorros/Corriente)</label>
                      <input type="text" class="form-control" id="banco_ifsc_code" placeholder="Ingrese el estado donde se encuentra la tienda" name="banco_ifsc_code" @if(isset($vendorDetails['banco_ifsc_code'])) value="{{ $vendorDetails['banco_ifsc_code'] }}" @endif>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                    <button class="btn btn-light">Cancelar</button>
                  </form>
                </div>
              </div>
            </div>    
        </div>
        @endif
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>

@endsection







