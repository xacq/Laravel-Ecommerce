@extends('front.layout.layout')
@section('content')
    <!-- Page Introduction Wrapper -->
    <div class="page-style-a">
        <div class="container">
            <div class="page-intro">
                <h2>Cuenta del Vendedor</h2>
                <ul class="bread-crumb">
                    <li class="has-separator">
                        <i class="ion ion-md-home"></i>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="is-marked">
                        <a href="{{ url('vendor/login-register') }}">Vendedor</a>
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
                <!-- Login -->
                <div class="col-lg-6">
                    <div class="login-wrapper">
                        <h2 class="account-h2 u-s-m-b-20">Login</h2>
                        <h6 class="account-h6 u-s-m-b-30">¡Bienvenido de nuevo! Inicia sesión en tu cuenta</h6>
                        <form action="{{ url('admin/login') }}" method='post'>@csrf
                            <div class="u-s-m-b-30">
                                <label for="vendor-email">Email
                                    <span class="astk">*</span>
                                </label>
                                <input type="email" name="email" id="vendor-email" class="text-field" placeholder="Ingrese el Email">
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="vendor-password">Contraseña
                                    <span class="astk">*</span>
                                </label>
                                <input type="password" name="password" id="vendor-password" class="text-field" placeholder="Ingrese la contraseña">
                            </div>
                            <div class="group-inline u-s-m-b-30">
                                <!-- <div class="group-1">
                                    <input type="checkbox" class="check-box" id="remember-me-token">
                                    <label class="label-text" for="remember-me-token">Remember me</label>
                                </div> -->
                                <div class="group-2 text-right">
                                    <div class="page-anchor">
                                        <a href="{{ url('vendor/forgot-password') }}">
                                            <i class="fas fa-circle-o-notch u-s-m-r-9"></i>¿Perdiste tu contraseña?</a>
                                    </div>
                                </div>
                            </div>
                            <div class="m-b-45">
                                <button class="button button-outline-secondary w-100">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Login /- -->
                <!-- Register -->
                <div class="col-lg-6">
                    <div class="reg-wrapper">
                        <h2 class="account-h2 u-s-m-b-20">Regístrate</h2>
                        <h6 class="account-h6 u-s-m-b-30">Regístrarte en este sitio te permite acceder al estado y al historial de tus ventas.</h6>
                        <form id="vendorForm" action="{{ url('/vendor/register') }}" method="post">@csrf
                            <div class="u-s-m-b-30">
                                <label for="vendorname">Nombre
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="vendorname" name="nombre" class="text-field" placeholder="Nombre del vendedor">
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="vendorcelular">Celular
                                    <span class="astk">*</span>
                                </label>
                                <input type="text" id="vendorcelular" name="celular" class="text-field" placeholder="Celular del vendedor">
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="vendoremail">Email
                                    <span class="astk">*</span>
                                </label>
                                <input type="email" id="vendoremail" class="text-field" name="email" placeholder="Email del vendedor">
                            </div>
                            <div class="u-s-m-b-30">
                                <label for="vendorpassword">Contraseña
                                    <span class="astk">*</span>
                                </label>
                                <div style="position: relative;">
                                    <input type="password" id="vendorpassword" name="password" class="text-field" placeholder="Ingrese la Contraseña" style="width: 100%;">
                                    <button type="button" id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                                        <i id="icon-eye" class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="u-s-m-b-30">
                                <input type="checkbox" class="check-box" id="accept" name="accept">
                                <label class="label-text no-color" for="accept">He leído y acepto la
                                    <a href="terms-and-conditions.html" class="u-c-brand">Términos & condiciones</a>
                                </label>
                            </div>
                            <div class="u-s-m-b-45">
                                <button class="button button-primary w-100">Registrar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Register /- -->
            </div>
        </div>
    </div>
    <!-- Account-Page /- -->
@endsection