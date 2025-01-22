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
                    <a href="#">Proceder al Pago</a>
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
                    <h3 class="thank-you-title">POR FAVOR REALICE EL PAGO DE SU PEDIDO</h3>
                    <form action="{{ route('payment') }}" method="post">@csrf
                        <input type="hidden" name="amount" value="{{ '$' . number_format(round(Session::get('grand_total'), 2), 2) }}">
                        <input type="image" src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-200px.png" title="How PayPal Works" alt="Checkout with PayPal" width="200" height="50">

                    </form>
                    <a href="{{ url('/') }}" class="btn u-s-m-t-30" style="background-color: #007BFF; color: white; border: 1px solid #ccc;">Volver a la Tienda</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart-Page https://developer.paypal.com/dashboard/applications/sandbox/- -->
@endsection