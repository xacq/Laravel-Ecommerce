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
<style>
    .thank-you-box {
        background-color: #f9f9f9;
        border: 2px solid #007BFF;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        margin-top: 20px;
    }

    .thank-you-title {
        font-family: 'Arial', sans-serif;
        color: #007BFF;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .thank-you-message {
        font-family: 'Arial', sans-serif;
        font-size: 16px;
        color: #555;
        margin-bottom: 15px;
    }

    .thank-you-message strong {
        color: #007BFF;
        font-weight: bold;
    }

    .btn {
        text-transform: uppercase;
        font-weight: bold;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn:hover {
        background-color: #0056b3;
        color: white;
        border-color: #0056b3;
    }
</style>
<!-- Cart-Page -->
<div class="page-cart u-s-p-t-80 u-s-p-b-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="thank-you-box">
                    <i class="ion ion-md-checkmark-circle-outline" style="font-size: 200px; color: #007BFF;"></i> <br><br>
                    <h3 class="thank-you-title">¡Su Pedido se ha Realizado con Éxito!</h3>
                    <p class="thank-you-message">Su número de Pedido es <strong>{{ Session::get('order_id') }}</strong> y su Total General es: <strong>$ {{ Session::get('grand_total') }} USD</strong>.</p>
                    <p class="thank-you-message">
                        Nos comunicaremos contigo de inmediato para confirmar tu pedido, Será un gusto atenderte.
                    </p>
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
