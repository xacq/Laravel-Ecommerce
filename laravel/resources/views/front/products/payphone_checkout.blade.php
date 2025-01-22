@extends('front.layout.layout')

@section('content')

    @php
        $order = session('order'); // Recupera la variable 'order' de la sesión

        if ($order) {
            $totalGeneral = $order->total_general * 100; // Asegúrate de que es un entero (centavos)
            $ivaRate = 0.15; // Tasa de IVA (15%)

            // Cálculo del valor sin IVA
            $valorSinIva = round($totalGeneral / (1 + $ivaRate)); // Redondeamos a centavos

            // Cálculo del IVA
            $iva = $totalGeneral - $valorSinIva;

           //Valor con impuesto
            $valorConIva = $valorSinIva;

            //Datos para la vista
            $totalGeneral_vista = $totalGeneral;
            $valorSinIva_vista = 100;
            $iva_vista = $iva;
            $valorConIva_vista = $valorConIva-100;

            echo "Total General: {$totalGeneral_vista}<br>";
            echo "Valor sin IVA: {$valorSinIva_vista}<br>";
            echo "IVA: {$iva_vista}<br>";
            echo "Valor con IVA: {$valorConIva_vista}<br>";
            echo "Pedido: ". $order->id;

             // Datos para Payphone
            $payphoneData = [
                'amount' => (int) $totalGeneral,
                'amountWithoutTax' => 100,
                'amountWithTax' => (int) $valorConIva-100,
                'tax' => (int) $iva,
                'currency' => "USD",
                'storeId' => "eff42b4b-2056-4812-a0be-96d29a426bee",
                'reference' => "Pago por venta Fact#{$order->id}",
                'clientTransactionId' => $order->id
            ];


        } else {
            echo "No se encontró el pedido. Por favor, intente nuevamente.";

        }
    @endphp

    <head>
        <script src="https://cdn.payphonetodoesposible.com/box/v1.1/payphone-payment-box.js" type="module"></script>
        <link href="https://cdn.payphonetodoesposible.com/box/v1.1/payphone-payment-box.css" rel="stylesheet">
    </head>

    <div class="container text-center">

        <img class="img-fluid mb-4" src="{{ asset('front/images/main-logo/pay_logo.png') }}" alt="Banner" width="300px">
        <br>

        <h4 style="color:orange;">Formulario de Pago en Línea</h4>

        <br>
         <script>
            window.addEventListener('DOMContentLoaded', () => {
                ppb = new PPaymentButtonBox({
                    token: 'LaIx2c5PU-QB124tmh5NJ8k1Y-BHR4WhdKHtFclOL_k0RBHjeCKEKUkYWeikFFp5ImzsJaP_UjC2ii_12LcopDY5G8Gv4MFlcG5M3yuRoVqkXlk087U5XlkXBouaxOjKVFLP3S93007xXZxLBCvZQJFCyArGAPYAm0yUMpTBZ5CH1Uop1upD2jE7bDxRA_y_YGAw0R7XqWVaaXbaztTg33nxipN_18bo3jz4L5MKdQLHvubc8rXhqFUWi3qIZopS4y_PBGrNW5y8Zq4GgrurQgG-uzfJPFFcDTjyOAggEFNNeDbu6mYFE3_olyoHKyBJd6jz_4Yq_ZqeRl1WFbKDOx9TnGU',
                   ... @json($payphoneData),
                    service: 0,	//Monto asociado al servicio proporcionado.
                    tip:0,	//Monto de la propina otorgada por el cliente
                }).render('pp-button');
            })
        </script>

        <div id="pp-button"></div>

    </div>
@endsection