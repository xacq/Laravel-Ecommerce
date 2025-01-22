@extends('front.layout.layout')
@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
    <div class="container">
        <div class="page-intro text-center">
            <h2>Mis Pedidos</h2>
            <ul class="bread-crumb d-inline-flex justify-content-center">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="is-marked">
                    <a href="#">Pedidos</a>
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
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Pedido Id</th>
                                <th>Producto(s)</th>
                                <th>Método de Pago</th>
                                <th>Total</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $order['id'] }}</td>
                                <td>
                                    @foreach($order['orders_products'] as $product)
                                        {{ $product['producto_nombre'] }} ({{ $product['producto_codigo'] }})<br>
                                    @endforeach
                                </td>
                                <td>{{ $order['payment_method'] }}</td>
                                <td>${{ number_format($order['total_general'], 2) }}</td>
                                <td>{{ date('Y-m-d h:i:s', strtotime($order['created_at'])) }}</td>
                                <td>
                                    <a href="{{ url('user/orders/'.$order['id']) }}" class="btn btn-info btn-sm">Ver Detalles</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart-Page /- -->
@endsection
