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
    .thank-you-message {
        font-family: 'Arial', sans-serif;
        color: #333;
        margin-bottom: 20px;
        text-align: center;
    }

    .bank-details-table {
        width: 100%;
        max-width: 600px;
        margin: 20px auto;
        border-collapse: collapse;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        font-family: 'Arial', sans-serif;
    }

    .bank-details-table th,
    .bank-details-table td {
        padding: 12px 15px;
        text-align: left;
        border: 1px solid #ddd;
    }

    .bank-details-table th {
        background-color: #007BFF;
        color: #fff;
        font-weight: bold;
        text-transform: uppercase;
    }

    .bank-details-table td {
        background-color: #f9f9f9;
        color: #555;
    }

    .bank-details-caption {
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 10px;
        color: #007BFF;
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
                    <br>
                    <p class="thank-you-message">
    Realiza tu pago directamente en nuestra cuenta bancaria. El pedido no será enviado hasta que el comprobante del depósito o transferencia haya sido recibido en nuestra cuenta. Por favor confirma tu pago al email: <strong>kevinmasabanda2c@gmail.com</strong> o al número de WhatsApp: <strong>(+593) 0983004127</strong>. Será un gusto atenderte.
</p>

<div>
    <p class="bank-details-caption">Nuestros Datos Bancarios</p>
    <table class="bank-details-table">
        <thead>
            <tr>
                <th>A nombre de</th>
                <th>Banco</th>
                <th>Número de Cuenta</th>
                <th>Cédula</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Esmeraldita del Rocio Cordova Jaramillo</td>
                <td>Banco Pichincha (Ahorro)</td>
                <td>2205004831</td>
                <td>1802371169</td>
            </tr>
        </tbody>
    </table>
</div>

<p class="thank-you-message">
    Nos comunicaremos contigo de inmediato para confirmar tu pedido. Será un gusto atenderte.
</p>
                    <!-- <a href="{{ url('/') }}" class="btn u-s-m-t-30" style="background-color: #007BFF; color: white; border: 1px solid #ccc;">Volver a la Tienda</a> -->
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