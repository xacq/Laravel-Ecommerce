@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="font-weight-bold">Gestión Pedidos</h3>
                        <h6 class="font-weight-normal mb-0">Pedidos</h6>
                        <!-- <p class="card-description">
                            Add class <code>.table-bordered</code>
                        </p> -->
                        <div class="table-responsive pt-3">
                            <table id="orders" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            Pedido ID
                                        </th>
                                        <th>
                                            Fecha del Pedido
                                        </th>
                                        <th>
                                            Nombre del Cliente
                                        </th>
                                        <th>
                                            Email del Cliente
                                        </th>
                                        <th>
                                            Productos
                                        </th>
                                        <th>
                                            Monto del Pedido
                                        </th>
                                        <th>
                                            Pedido Status
                                        </th>
                                        <th>
                                            Metodo de Pago
                                        </th>
                                        <th>
                                            Acción
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    @if($order['orders_products'])
                                    <tr>
                                        <td>
                                            {{ $order['id'] }}
                                        </td>
                                        <td>
                                        {{ date('Y-m-d h:i:s', strtotime($order['created_at'])); }}
                                        </td>
                                        <td>
                                            {{ $order['nombre'] }}
                                        </td>
                                        <td>
                                            {{ $order['email'] }}
                                        </td>
                                        <td>
                                        @foreach($order['orders_products'] as $product)
                                            {{ $product['producto_nombre'] }} ({{ $product['producto_codigo'] }}) x {{ $product['producto_qty'] }}<br>
                                        @endforeach
                                        </td>
                                        <td>
                                            $ {{ $order['total_general'] }}
                                        </td>
                                        <td>
                                            {{ $order['order_status'] }}
                                        </td>
                                        <td>
                                            {{ $order['payment_method'] }}
                                        </td>
                                        <td>
                                            <a title="Ver los Detalles el Pedido" href="{{ url('admin/orders/'.$order['id']) }}"><i style="font-size:25px;" class="mdi mdi-file-document"></i></a>
                                            &nbsp;&nbsp;
                                            <a target="_blank" title="Ver la factura del Pedido" href="{{ url('admin/orders/invoice/'.$order['id']) }}"><i style="font-size:25px;" class="mdi mdi-printer"></i></a>
                                            &nbsp;&nbsp;
                                            <a target="_blank" title="Imprimir la factura del Pedido" href="{{ url('admin/orders/invoice/pdf/'.$order['id']) }}"><i style="font-size:25px;" class="mdi mdi-file-pdf"></i></a>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->
    <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright Â© 2021.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
        </div>
    </footer>
    <!-- partial -->
</div>
@endsection