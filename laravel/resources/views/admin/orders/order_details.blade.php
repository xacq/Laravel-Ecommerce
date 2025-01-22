<?php
use App\Models\Product;
use App\Models\OrdersLog;
use App\Models\Vendor;
use App\Models\Coupon;
/* if(Auth::guard('admin')->user()->tipo=="vendedor"){
  $getVendorComision = Vendor::getVendorComision(Auth::guard('admin')->user()->vendor_id);
} */
?>
@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
    @if(Session::has('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success: </strong> {{ Session::get('success_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
    @endif
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Gestión del Pedidos</h3>
                        <h6 class="font-weight-normal mb-0"><a href="{{ url('admin/orders') }}">Regresar</a></h6>
                    </div>
                    <!-- <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                    <a class="dropdown-item" href="#">January - March</a>
                                    <a class="dropdown-item" href="#">March - June</a>
                                    <a class="dropdown-item" href="#">June - August</a>
                                    <a class="dropdown-item" href="#">August - November</a>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Detalles del Pedido</h4>

                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Pedido ID: </label>
                      <label>{{ $orderDetails['id'] }}</label>
                    </div>

                    <div class="form-group">
                      <label style="font-weight:550;">Fecha: </label>
                      <label>{{ date('Y-m-d h:i:s', strtotime($orderDetails['created_at'])); }}</label>
                    </div>
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Pedido Status: </label>
                      <label>{{ $orderDetails['order_status'] }}</label>
                    </div>
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Total General: </label>
                      <label>$ {{ $orderDetails['total_general'] }}</label>
                    </div>
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Gastos de Envío: </label>
                      <label>$ {{ $orderDetails['shipping_charges'] }}</label>
                    </div>
                    @if(!empty($orderDetails['cupon_codigo']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Codigo del Cupon: </label>
                      <label>{{ $orderDetails['cupon_codigo'] }}</label>
                    </div>
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Monto del Cupon: </label>
                      <label>$ {{ $orderDetails['cupon_amount'] }}</label>
                    </div>
                    @endif
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Metodo de Pago: </label>
                      <label>{{ $orderDetails['payment_method'] }}</label>
                    </div>


                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Detalles del Cliente</h4>

                  <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Nombre: </label>
                      <label>{{ $userDetails['name'] }}</label>
                    </div>
                    @if(!empty($userDetails['direccion']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Dirección: </label>
                      <label>{{ $userDetails['direccion'] }}</label>
                    </div>
                    @endif
                    @if(!empty($userDetails['ciudad']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Ciudad: </label>
                      <label>{{ $userDetails['ciudad'] }}</label>
                    </div>
                    @endif
                    @if(!empty($userDetails['estado']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Estado: </label>
                      <label>{{ $userDetails['estado'] }}</label>
                    </div>
                    @endif
                    @if(!empty($userDetails['pais']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Pais: </label>
                      <label>{{ $userDetails['pais'] }}</label>
                    </div>
                    @endif
                    @if(!empty($userDetails['pincodigo']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Cédula: </label>
                      <label>{{ $userDetails['pincodigo'] }}</label>
                    </div>
                    @endif
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Celular: </label>
                      <label>{{ $userDetails['celular'] }}</label>
                    </div>
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Email: </label>
                      <label>{{ $userDetails['email'] }}</label>
                    </div>

                </div>
              </div>
       </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Dirección de Entrega</h4>

                  <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Nombre: </label>
                      <label>{{ $orderDetails['nombre'] }}</label>
                    </div>
                    @if(!empty($orderDetails['direccion']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Dirección: </label>
                      <label>{{ $orderDetails['direccion'] }}</label>
                    </div>
                    @endif
                    @if(!empty($orderDetails['ciudad']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Ciudad: </label>
                      <label>{{ $orderDetails['ciudad'] }}</label>
                    </div>
                    @endif
                    @if(!empty($orderDetails['estado']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Parroquia: </label>
                      <label>{{ $orderDetails['estado'] }}</label>
                    </div>
                    @endif
                    @if(!empty($orderDetails['pais']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Pais: </label>
                      <label>{{ $orderDetails['pais'] }}</label>
                    </div>
                    @endif
                    @if(!empty($orderDetails['pincodigo']))
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Cédula: </label>
                      <label>{{ $orderDetails['pincodigo'] }}</label>
                    </div>
                    @endif
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Celular: </label>
                      <label>{{ $orderDetails['celular'] }}</label>
                    </div>
                    <div class="form-group" style="height:15px;">
                      <label style="font-weight:550;">Email: </label>
                      <label>{{ $orderDetails['email'] }}</label>
                    </div>

                </div>
              </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Actualizar el Status del Pedido</h4>
                    @if(Auth::guard('admin')->user()->tipo!=="vendedor")
                    <form action="{{ url('admin/update-order-status') }}" method="post">@csrf
                      <input type="hidden" name="order_id" value="{{ $orderDetails['id'] }}">
                      <select name="order_status" id="order_status" required="">
                        <option value="" selected="">Selecionar</option>
                        @foreach($orderStatuses as $status)
                          <option value="{{ $status['nombre'] }}" @if(!empty($orderDetails['order_status']) && $orderDetails['order_status']==$status['nombre']) selected="" @endif>{{ $status['nombre'] }}</option>
                        @endforeach
                      </select>&nbsp;&nbsp;&nbsp;<button type="submit">Actualizar</button> <br><br>
                      <input type="text" name="nombre_mensajero" id="nombre_mensajero" placeholder="Nombre de Mensajero"><br><br>
                      <input type="text" name="numero_rastreo" id="numero_rastreo" placeholder="Número de rastreo">

                    </form>
                    @foreach($orderLog as $key => $log)
                    <?php /* echo "<pre>"; print_r($log['orders_products'][$key]['producto_codigo']); die; */ ?>
                      <strong>{{ $log['order_status'] }}</strong>

                        @if(isset($log['order_item_id'])&&$log['order_item_id']>0)
                        @php $getItemDetails = OrdersLog::getItemDetails($log['order_item_id']) @endphp
                          - Articulo {{ $getItemDetails['producto_codigo'] }}
                            @if(!empty($getItemDetails['nombre_mensajero']))
                              <br><span>Nombre de Mensajero: {{ $getItemDetails['nombre_mensajero']}}</span>
                            @endif
                            @if(!empty($getItemDetails['numero_rastreo']))
                              <br><span>Número de rastreo: {{ $getItemDetails['numero_rastreo'] }}</span>
                            @endif

                        @endif

                      <br> {{ date('Y-m-d h:i:s', strtotime($log['created_at'])); }} <br>
                      <hr>
                    @endforeach
                    @else
                    Esta función está restringida

                    @endif
                </div>
              </div>
            </div>
            <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Productos del Pedido</h4>
            <div class="table-responsive"> <!-- Añadido para la responsividad -->
                <table class="table table-hover table-striped table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>Imagen</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Tamaño</th>
                            <th>Color</th>
                            <th>Precio Unitario</th>
                            <th>Cantidad</th>
                            <th>Precio Total</th>
                            @if(Auth::guard('admin')->user()->tipo!="vendedor")
                              <th>Producto de</th>
                            @endif
                            <th>Comisión</th>
                            <th>Monto a Cobrar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderDetails['orders_products'] as $product)
                        <tr>
                            <td>
                                @php $getProductImage = Product::getProductImage($product['product_id']) @endphp
                                <a target="_blank" href="{{ url('product/'.$product['product_id']) }}">
                                    <img style="width:60px;" src="{{ asset('front/images/product_images/small/'.$getProductImage) }}" alt="Ambato Shop Producto">
                                </a>
                            </td>
                            <td>{{ $product['producto_codigo'] }}</td>
                            <td>{{ $product['producto_nombre'] }}</td>
                            <td>{{ $product['producto_tamano'] }}</td>
                            <td>{{ $product['producto_color'] }}</td>
                            <td>$ {{ number_format($product['producto_precio'], 2) }}</td>
                            <td>{{ $product['producto_qty'] }}</td>
                            <td>
                              @if($product['vendor_id']>0)
                                @if($orderDetails['cupon_amount']>0)
                                    @php $couponDetails = Coupon::couponDetails($orderDetails['cupon_codigo']) @endphp
                                    @if($couponDetails['vendor_id']>0)
                                      $ {{ number_format($total_price = $product['producto_precio']*$product['producto_qty']+$orderDetails['shipping_charges']-$item_discount, 2) }}
                                    @else
                                    $ {{ number_format($total_price = $product['producto_precio']*$product['producto_qty']+$orderDetails['shipping_charges'], 2) }}
                                    @endif
                                @else
                                  $ {{ number_format($total_price = $product['producto_precio']*$product['producto_qty']+$orderDetails['shipping_charges'], 2) }}
                                @endif
                              @else
                                $ {{ number_format($total_price = $product['producto_precio']*$product['producto_qty']+$orderDetails['shipping_charges'], 2) }}
                              @endif
                            </td>
                            @if(Auth::guard('admin')->user()->tipo!="vendedor")
                              @if($product['vendor_id']>0)
                                <td>
                                  <a target="_blank" href="/admin/view-vendor-details/{{ $product['admin_id'] }}">Vendedor</a>
                                </td>
                              @else
                                <td>Admin</td>
                              @endif
                            @endif

                            @if($product['vendor_id']>0)
                              @php $getVendorComision = Vendor::getVendorComision($product['vendor_id']);  @endphp
                              <td>$ {{ number_format($comision = round($total_price * $getVendorComision/100,2), 2)  }}</td>
                              <td>$ {{ number_format($product['producto_precio'] - $comision, 2) }}</td>
                            @else
                              <td>$ 0</td>
                              <td>$ {{ number_format($product['producto_precio'],2) }}</td>
                            @endif


                            <td>
                              <form action="{{ url('admin/update-order-item-status') }}" method="post">@csrf
                                  <input type="hidden" name="order_item_id" value="{{ $product['id'] }}">
                                  <select name="order_item_status" id="order_item_status" required="">
                                      <option value="">Seleccionar</option>
                                      @foreach($orderItemStatuses as $status)
                                          <option value="{{ $status['nombre'] }}"
                                              @if(!empty($product['item_status']) && $product['item_status']==$status['nombre'])
                                                  selected
                                              @endif>
                                              {{ $status['nombre'] }}
                                          </option>
                                      @endforeach
                                  </select>
                                  <input style="width:150px;" type="text" name="item_nombre_mensajero" id="item_nombre_mensajero" placeholder="Nombre de Mensajero" @if(!empty($product['nombre_mensajero'])) value="{{ $product['nombre_mensajero'] }}" @endif><br><br>
                                  <input style="width:150px;" type="text" name="item_numero_rastreo" id="item_numero_rastreo" placeholder="Número de rastreo" @if(!empty($product['numero_rastreo'])) value="{{ $product['numero_rastreo'] }}" @endif>
                                  <button type="submit">Actualizar</button>
                              </form>
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

    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>
@endsection
