<?php use App\Models\Product; ?>
@extends('front.layout.layout')
@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Agradecimiento</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="is-marked">
                    <a href="#">Gracias</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- Cart-Page -->
<div class="page-cart u-s-p-t-80 u-s-p-b-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="thank-you-box">
                    <i class="ion ion-md-checkmark-circle-outline" style="font-size: 200px; color: #007BFF;"></i> <br><br>
                    <h3 class="thank-you-title">TU PAGO HA SIDO CONFIRMADO</h3>
                    <p>Gracias por el pago. Procesaremos tu pedido muy pronto.</p>
                    <p class="thank-you-message">Su número de Pedido es <strong>{{ Session::get('order_id') }}</strong> y su monto Total pagado es: <strong>$ {{ Session::get('grand_total') }} USD</strong>.</p>
                    <a href="{{ url('/') }}" class="btn u-s-m-t-30" style="background-color: #007BFF; color: white; border: 1px solid #ccc;">Volver a la Tienda</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart-Page /- -->
@endsection

<?php
    Session::forget('grand_total');
    Session::forget('order_id');
    Session::forget('couponCode');
    Session::forget('couponAmount');
?>
