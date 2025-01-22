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
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Actualizar la Contraseña</h4>
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
                  
                  <form class="forms-sample" action="{{ url('admin/update-vendor-password') }}" method="post" >@csrf
                    <div class="form-group">
                      <label>Admin: Nombre Usuario/Email</label>
                      <input class="form-control" value="{{ $adminDetails['email'] }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label>Tipo Admin</label>
                      <input  class="form-control" value="{{ $adminDetails['tipo'] }}" readonly="">
                    </div>
                    <div class="form-group">
                      <label for="contrasena_actual">Contraseña Actual</label>
                      <input type="password" class="form-control" id="contrasena_actual" placeholder="Ingrese la Contraseña Actual" name="contrasena_actual" required="">
                      <span id="check_password"></span>
                    </div>
                    <div class="form-group">
                      <label for="nueva_contrasena">Nueva Contraseña</label>
                      <input type="password" class="form-control" id="nueva_contrasena" placeholder="Ingrese la Nueva Contraseña" name="nueva_contrasena" required="">
                    </div>
                    <div class="form-group">
                      <label for="confirmar_contrasena">Confirmar Contraseña</label>
                      <input type="password" class="form-control" id="confirmar_contrasena" placeholder="Confirmar Contraseña" name="confirmar_contrasena" required="">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                    <button type="button" class="btn btn-light" onclick="this.form.reset(); window.location.href='{{ url('admin/dashboard') }}';">
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