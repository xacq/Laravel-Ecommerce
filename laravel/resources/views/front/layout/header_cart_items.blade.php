<?php
use App\Models\Product;
$getCartItems = getCartItems();
?>
<!-- Mini Cart -->
<div class="mini-cart-wrapper">
            <div class="mini-cart">
                <div class="mini-cart-header">
                    Tu Carro
                    <button type="button" class="button ion ion-md-close" id="mini-cart-close"></button>
                </div>
                <ul class="mini-cart-list">
                    @php $total_price = 0 @endphp
                    @foreach($getCartItems as $item)
                    <?php
                        $getDiscountAttributePrice = Product::getDiscountAttributePrice($item['product_id'],$item['tamano']);
                        /* "<pre>"; print_r($getDiscountAttributePrice);  */
                    ?>
                    <li class="clearfix">
                        <a href="{{ url('product/'.$item['product_id']) }}">
                            <img src="{{ asset('front/images/product_images/small/'.$item['product']['producto_image']) }}" alt="Ambato Shop Producto">
                            <span class="mini-item-name">{{ $item['product']['producto_nombre'] }}</span>
                            <span class="mini-item-price">${{ $getDiscountAttributePrice['final_price'] }}</span>
                            <span class="mini-item-quantity"> x {{ $item['cantidad'] }} </span>
                        </a>
                    </li>
                    @php $total_price =$total_price + ($getDiscountAttributePrice['final_price'] * $item['cantidad'])  @endphp
                    @endforeach
                </ul>
                <div class="mini-shop-total clearfix">
                    <span class="mini-total-heading float-left">Total:</span>
                    <span class="mini-total-price float-right">$ {{ $total_price }}</span>
                </div>
                <div class="mini-action-anchors">
                    <a href="{{ url('cart') }}" class="cart-anchor">Ver Carrito</a>
                    <a href="{{ url('checkout') }}" class="checkout-anchor">Pagar</a>
                </div>
            </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#mini-cart-close').on('click', function () {
        $('.mini-cart-wrapper').removeClass('mini-cart-open');
    });
</script>
<!-- Mini Cart /- -->
