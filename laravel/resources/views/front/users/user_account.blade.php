@extends('front.layout.layout')
@section('content')
    <!-- Page Introduction Wrapper -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Mi Cuenta</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="index.html">Home</a>
                    </li>
                    <li class="is-marked">
                        <a href="account.html">Cuenta</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Page Introduction Wrapper /- -->
    <!-- Account-Page -->
    <div class="page-account u-s-p-t-80">
        <div class="container">
        @if(Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success: </strong> {{ Session::get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                @endif
                @if(Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error: </strong> {{ Session::get('error_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error: </strong> <?php echo implode('', $errors->all('<div>:message</div>')); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                @endif
            <div class="row">
                <!-- Actualizar datos del usuario -->
                <div class="col-lg-6">
                    <div class="login-wrapper">
                        <h2 class="account-h2 u-s-m-b-20" style="font-size: 18px;">Actualizar Datos de Contacto </h2>
                        <p id="account-error"></p>
                        <p id="account-success"></p>
                        <form id="accountForm" action="javascript:;" method='post'>@csrf
                            <div class="u-s-m-b-30">
                                <label for="user-email">Email
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field" value="{{ Auth::user()->email }}" readonly="" disabled="" style="background-color: #e9e9e9;">
                                <p id="account-email"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="user-name">Nombre
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field" type="text" id="user-name" name="name" value="{{ Auth::user()->name }}">
                                <p id="account-name"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="user-direccion">Dirección
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field" type="text" id="user-direccion" name="direccion" value="{{ Auth::user()->direccion }}">
                                <p id="account-direccion"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="user-ciudad">Ciudad
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field" type="text" id="user-ciudad" name="ciudad" value="{{ Auth::user()->ciudad }}">
                                <p id="account-ciudad"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="user-estado">Estado
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field" type="text" id="user-estado" name="estado" value="{{ Auth::user()->estado }}">
                                <p id="account-estado"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="user-pais">Pais
                                    <span class="astk">*</span>
                                </label>
                                <select class="text-field" id="user-pais" name="pais" style="color: #495057;">
                                        <option value="">Seleccionar Pais</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country['country_name'] }}" @if($country['country_name']==Auth::user()->pais) selected @endif>{{ $country['country_name'] }}</option>
                                    @endforeach
                                </select>
                                <p id="account-pais"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="user-pincodigo">Cédula
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field" type="text" id="user-pincodigo" name="pincodigo" value="{{ Auth::user()->pincodigo }}">
                                <p id="account-pincodigo"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="user-celular">Celular
                                    <span class="astk">*</span>
                                </label>
                                <input class="text-field" type="text" id="user-celular" name="celular" value="{{ Auth::user()->celular }}">
                                <p id="account-celular"></p>
                            </div>
                            <div class="m-b-45">
                                <button class="button button-outline-secondary w-100">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Actualizar datos del usuario /- -->
                <!-- Password Actualizar -->
                <div class="col-lg-6">
                    <div class="reg-wrapper"> <br>
                        <h2 class="account-h2 u-s-m-b-20" style="font-size: 18px;">Actualizar Contraseña</h2>
                        <p id="password-error"></p>
                        <p id="password-success"></p>
                        <form id="passwordForm" action="javascript:;" method="post">@csrf
                            <div class="u-s-m-b-30">
                                <label for="current-password">Contraseña Actual
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" id="current-password" name="current_password" class="text-field" placeholder="Ingrese la contraseña actual">
                                <p id="password-current_password"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="new-password">Nueva Contraseña
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" id="new-password" name="new_password" class="text-field" placeholder="Ingrese la nueva contraseña">
                                <p id="password-new_password"></p>
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="confirm-password">Confirmar Contraseña
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" id="confirm-password" name="confirm_password" class="text-field" placeholder="Confirmar la contraseña">
                                <p id="password-confirm_password"></p>
                            </div>
                            <div class="u-s-m-b-45">
                                <button class="button button-primary w-100">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Password Actualizar /- -->
            </div>
        </div>
    </div>
    <!-- Account-Page /- -->
@endsection