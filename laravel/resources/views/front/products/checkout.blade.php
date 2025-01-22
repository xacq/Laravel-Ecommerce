<?php use App\Models\Product; ?>
@extends('front.layout.layout')
@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Finalizar Compra</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="is-marked">
                    <a href="{{ url('/checkout') }}">Pagar</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- Checkout-Page -->
<div class="page-checkout u-s-p-t-80">
    <div class="container">
    @if(Session::has('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error: </strong> <?php echo Session::get('error_message'); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
    @endif

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="row">
                        <!-- Billing-&-Shipping-Details -->
                        <div class="col-lg-6" id="deliveryAddresses">
                            @include('front.products.delivery_addresses')
                        </div>
                        <!-- Billing-&-Shipping-Details /- -->
                        <!-- Checkout -->
                        <div class="col-lg-6">
                        <form name="checkoutForm" id="checkoutForm" action="{{ url('/checkout') }}" method="post">@csrf

                            @if(count($deliveryAddresses)>0)
                                <h4 class="section-h4">Direcciones de entrega</h4>
                                    @foreach($deliveryAddresses as $address)
                                        <div class="control-group" style="float:left; margin-right:5px;"><input type="radio" id="address{{ $address['id'] }}" name="address_id" value="{{ $address['id'] }}" shipping_charges="{{ $address['shipping_charges'] }}" total_price="{{ $total_price }}" cupon_amount="{{ Session::get('couponAmount') }}"></div>
                                        <div><label class="control-label" for="">
                                            Nombre: {{ $address['nombre'] }}, <br>
                                            Dirección: {{ $address['direccion'] }}, <br>
                                            Ciudad: {{ $address['ciudad'] }}, <br>
                                            Estado: {{ $address['estado'] }}, <br>
                                            Pais: {{ $address['pais'] }}, <br>
                                            Celular: {{ $address['celular'] }}</label>
                                            <a style="float: right; margin-left: 10px;" href="javascript:;" data-addressid="{{ $address['id'] }}" class="eliminarAddress">Eliminar</a>
                                            <a style="float: right;" href="javascript:;" data-addressid="{{ $address['id'] }}" class="editAddress">Editar</a>
                                        </div>
                                    @endforeach <br>
                            @endif

                                <h4 class="section-h4">Su Pedido</h4>
                                <div class="order-table">
                                    <table class="u-s-m-b-13">
                                        <thead>
                                            <tr>
                                                <th>Productos</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $total_price = 0 @endphp
                                            @foreach($getCartItems as $item)
                                            <?php
                                                $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['tamano']);
                                                /* "<pre>"; print_r($getDiscountAttributePrice);  */
                                            ?>
                                            <tr>
                                                <td>
                                                    <a href="{{ url('product/'.$item['product_id']) }}">
                                                        <img width="80" src="{{ asset('front/images/product_images/small/'.$item['product']['producto_image']) }}" alt="Ambato Shop Producto">
                                                        <h6 class="order-h6">{{ $item['product']['producto_nombre'] }} <br> Tamaño: {{ $item['tamano'] }} <br>
                                                        Color: {{ $item['product']['producto_color'] }}</h6>
                                                    </a>
                                                    <span class="order-span-quantity">x {{ $item['cantidad'] }}</span>
                                                </td>
                                                <td>
                                                    <h6 class="order-h6">${{ $getDiscountAttributePrice['final_price'] * $item['cantidad'] }}</h6>
                                                </td>
                                            </tr>
                                            @php $total_price =$total_price + ($getDiscountAttributePrice['final_price'] * $item['cantidad'])  @endphp
                                            @endforeach

                                            <tr>
                                                <td>
                                                    <h3 class="order-h3">Subtotal</h3>
                                                </td>
                                                <td>
                                                    <h3 class="order-h3">$ {{ $total_price }}</h3>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <h6 class="order-h6">Gastos de envío</h6>
                                                </td>
                                                <td>
                                                    <h6 class="order-h6"><span class="shipping_charges">$ 0.00</span></h6>
                                                </td>
                                            </tr>
                                            <!-- <tr>
                                                <td>
                                                    <h6 class="order-h6">Cupón de Descuento</h6>
                                                </td>
                                                <td>
                                                    <h6 class="order-h6">   @if(Session::has('couponAmount'))
                                                                            <span class="couponAmount">   $ {{ Session::get('couponAmount') }} </span>
                                                                            @else
                                                                                $ 0
                                                                            @endif</h6>
                                                </td>
                                            </tr> -->
                                            <tr>
                                                <td>
                                                    <h3 class="order-h3">Total General</h3>
                                                </td>
                                                <td>
                                                    <h3 class="order-h3"><strong class="grand_total">$ {{ $total_price - Session::get('couponAmount') }}</strong></h3>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                        <div class="u-s-m-b-13">
                                            <input type="radio" class="radio-box" name="payment_gateway" id="cash-on-delivery" value="COD">
                                            <label class="label-text" for="cash-on-delivery">Pago contra entrega</label>
                                        </div>
                                        <!-- <div class="u-s-m-b-13">
                                            <input type="radio" class="radio-box" name="payment_gateway" id="paypal" value="Paypal">
                                            <label class="label-text" for="paypal">Paypal</label>
                                        </div> -->
                                        <div class="u-s-m-b-13">
                                            <input type="radio" class="radio-box" name="payment_gateway" id="cash-on-transferencia" value="TDB">
                                            <label class="label-text" for="cash-on-transferencia">Tranferencia o deposito bancario</label>
                                        </div>

                                        <div class="u-s-m-b-13">
                                            <input type="radio" class="radio-box" name="payment_gateway" id="cash-on-linea" value="TDC">
                                            <label class="label-text" for="cash-on-linea">Pagos en línea</label>
                                        </div>

                                        <div class="u-s-m-b-13">
                                            <input type="checkbox" class="check-box" id="accept" name="accept" value="Si" title="Por favor acepte los terminos y condiciones">
                                            <label class="label-text no-color" for="accept">He leído y acepto los
                                                <a href="javascript:;" class="u-c-brand">términos y condiciones</a>
                                            </label>
                                        </div>
                                        <button type="submit" id="placeOrder" class="button button-outline-secondary">Realizar pedido</button>

                                    </div>
                            </form>
                        </div>
                        <!-- Checkout /- -->
                    </div>
                </div>
            </div>

    </div>
</div>
<!-- Checkout-Page /- -->
@endsection
