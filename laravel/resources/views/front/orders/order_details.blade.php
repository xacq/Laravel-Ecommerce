<?php use App\Models\Product; ?>
@extends('front.layout.layout')
@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
    <div class="container">
        <div class="page-intro text-center">
            <h2>Detalles del Pedido #{{ $orderDetails['id'] }}</h2>
            <ul class="bread-crumb d-inline-flex justify-content-center">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="is-marked">
                    <a href="{{ url('user/orders') }}">Pedidos</a>
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
            <div class="col-lg-10">
                <!-- Detalles del Pedido -->
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                    <tr class="table-primary"><td colspan="2"><strong>Datos Bancarios de la Empresa</strong></td></tr>
                    <tr><td>Banco</td><td>Banco Pichincha (Ahorros)</td></tr>
                    <tr><td>Nombre del propietario</td><td>Esmeraldita del Rocio Cordova Jaramillo</td></tr>
                    <tr><td>Número de cuenta</td><td>2205004831</td></tr>
                    <tr><td>Cédula</td><td>1802371169</td></tr>
                    </table>
                    <table class="table table-hover table-striped table-bordered">
                        <tr class="table-primary"><td colspan="2"><strong>Detalles de Pedido</strong></td></tr>
                        <tr><td>Fecha</td><td>{{ date('Y-m-d h:i:s', strtotime($orderDetails['created_at'])) }}</td></tr>
                        <tr><td>Status del Pedido</td><td>{{ $orderDetails['order_status'] }}</td></tr>
                        <tr><td>Total del Pedido</td><td>${{ number_format($orderDetails['total_general'], 2) }}</td></tr>
                        <tr><td>Gastos del Envío</td><td>${{ number_format($orderDetails['shipping_charges'], 2) }}</td></tr>
                        @if($orderDetails['cupon_codigo']!="")
                        <tr><td>Código del Cupón</td><td>{{ $orderDetails['cupon_codigo'] }}</td></tr>
                        <tr><td>Monto del Cupón</td><td>${{ number_format($orderDetails['cupon_amount'], 2) }}</td></tr>
                        @endif
                        @if($orderDetails['nombre_mensajero']!="")
                        <tr><td>Nombre del Mensajero</td><td>{{ $orderDetails['nombre_mensajero'] }}</td></tr>
                        <tr><td>Celular</td><td>{{ ($orderDetails['numero_rastreo']) }}</td></tr>
                        @endif
                        <tr><td>Método de Pago</td><td>{{ $orderDetails['payment_method'] }}</td></tr>
                    </table>
                </div>

                <!-- Detalles del Producto -->
                <div class="table-responsive mt-4">
                    <table class="table table-hover table-striped table-bordered">
                        <tr  class="table-primary">
                            <th>Imagen del Producto</th>
                            <th>Código del Producto</th>
                            <th>Nombre del Producto</th>
                            <th>Tamaño del Producto</th>
                            <th>Color del Producto</th>
                            <th>Precio del Producto</th>
                            <th>Cantidad del Producto</th>
                        </tr>
                        @foreach($orderDetails['orders_products'] as $product)
                        <tr>
                            <td>
                                @php $getProductImage = Product::getProductImage($product['product_id']) @endphp
                                <a target="_blank" href="{{ url('product/'.$product['product_id']) }}"><img style="width:80px;" src="{{ asset('front/images/product_images/small/'.$getProductImage) }}" alt="Ambato Shop Imagen"></a>
                            </td>
                            <td>{{ $product['producto_codigo'] }}</td>
                            <td>{{ $product['producto_nombre'] }}</td>
                            <td>{{ $product['producto_tamano'] }}</td>
                            <td>{{ $product['producto_color'] }}</td>
                            <td>${{ number_format($product['producto_precio'], 2) }}</td>
                            <td>{{ $product['producto_qty'] }}</td>
                        </tr>
                        @if($product['nombre_mensajero']!="")
                            <tr><td colspan="7">Nombre del Mensajero: {{ $product['nombre_mensajero'] }}, Celular: {{ ($product['numero_rastreo']) }}</td></tr>
                        @endif
                        @endforeach
                    </table>
                </div>
                <br>
                <!-- Detalles del Pedido -->
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <tr class="table-primary"><td colspan="2"><strong>Dirección de Entrega</strong></td></tr>
                        <tr><td>Nombre</td><td>{{ $orderDetails['nombre'] }}</td></tr>
                        <tr><td>Dirección</td><td>{{ $orderDetails['direccion'] }}</td></tr>
                        <tr><td>Ciudad</td><td>{{ $orderDetails['ciudad'] }}</td></tr>
                        <tr><td>Parroquia</td><td>{{ $orderDetails['estado'] }}</td></tr>
                        <tr><td>Pais</td><td>{{ $orderDetails['pais'] }}</td></tr>
                        <tr><td>Cédula</td><td>{{ $orderDetails['pincodigo'] }}</td></tr>
                        <tr><td>Celular</td><td>{{ $orderDetails['celular'] }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart-Page /- -->
@endsection

