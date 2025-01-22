<?php use App\Models\Product; ?>
<!-- Products-List-Wrapper -->
<div class="table-wrapper u-s-m-b-60">
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Accion</th>
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
                        <div class="cart-anchor-image">
                            <a href="{{ url('product/'.$item['product_id']) }}">
                                <img src="{{ asset('front/images/product_images/small/'.$item['product']['producto_image']) }}" alt="Ambato Shop Producto">
                                <h6>
                                    {{ $item['product']['producto_nombre'] }} ({{ $item['product']['producto_codigo'] }}) <br>
                                    Tamaño: {{ $item['tamano'] }} <br>
                                    Color: {{ $item['product']['producto_color'] }}
                                </h6>
                            </a>
                        </div>
                    </td>
                    <td>
                        <div class="cart-price">
                            @if($getDiscountAttributePrice['discount']>0)
                            <div class="price-template">
                                <div class="item-new-price">
                                    $ {{ $getDiscountAttributePrice['final_price'] }}
                                </div>
                                <div class="item-old-price" style="margin-right:5%;">
                                    $ {{ $getDiscountAttributePrice['producto_precio'] }}
                                </div>
                            </div>
                            @else
                            <div class="price-template">
                                <div class="item-new-price">
                                    ${{ $getDiscountAttributePrice['final_price'] }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="cart-quantity">
                            <div class="quantity">
                                <input type="text" class="quantity-text-field" value="{{ $item['cantidad'] }}">
                                <a class="plus-a updateCartItem" data-cartid="{{ $item['id'] }}" data-qty="{{ $item['cantidad'] }}" data-max="1000">&#43;</a>
                                <a class="minus-a updateCartItem" data-cartid="{{ $item['id'] }}" data-qty="{{ $item['cantidad'] }}" data-min="1">&#45;</a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="cart-price">
                            $ {{ $getDiscountAttributePrice['final_price'] * $item['cantidad'] }}
                        </div>
                    </td>
                    <td>
                        <div class="action-wrapper">
                                <button class="button button-outline-secondary fas fa-trash deleteCartItem" data-cartid="{{ $item['id'] }}"></button>
                        </div>
                    </td>
                </tr>
                @php $total_price =$total_price + ($getDiscountAttributePrice['final_price'] * $item['cantidad'])  @endphp
                @endforeach
            </tbody>
        </table>
</div>
<!-- Products-List-Wrapper /- -->

<!-- Billing -->
<div class="calculation u-s-m-b-60">
    <div class="table-wrapper-2">
        <table>
            <thead>
                <tr>
                    <th colspan="2">Totales del carrito</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <h3 class="calc-h3 u-s-m-b-0">SubTotal</h3>
                    </td>
                    <td>
                        <span class="calc-text">$ {{ $total_price }}</span>
                    </td>
                </tr>
                <!-- <tr>
                    <td>
                        <h3 class="calc-h3 u-s-m-b-0">Cupón de Descuento</h3>
                    </td>
                    <td>
                        <span class="calc-text couponAmount">
                            @if(Session::has('couponAmount'))
                                $ {{ Session::get('couponAmount') }}
                            @else
                                $ 0
                            @endif
                        </span>
                    </td>
                </tr> -->
                <tr>
                    <td>
                        <h3 class="calc-h3 u-s-m-b-0">Total General</h3>
                    </td>
                    <td>
                        <span class="calc-text grand_total">$ {{ $total_price - Session::get('couponAmount') }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Billing /- -->
