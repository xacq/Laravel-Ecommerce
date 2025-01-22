<?php
use App\Models\Product;
use App\Models\ProductsFilter;
$productFilters = ProductsFilter::productFilters();
/* dd($productFilters); */
?>
@extends('front.layout.layout')
@section('content')
<style>
    *{
    margin: 0;
    padding: 0;
    }
    .rate {
        float: left;
        height: 46px;
        padding: 0 10px;
    }
    .rate:not(:checked) > input {
        position:inherit;
        top:-9999px;
    }
    .rate:not(:checked) > label {
        float:right;
        width:1em;
        overflow:hidden;
        white-space:nowrap;
        cursor:pointer;
        font-size:30px;
        color:#ccc;
    }
    .rate:not(:checked) > label:before {
        content: '★ ';
    }
    .rate > input:checked ~ label {
        color: #ffc700;
    }
    .rate:not(:checked) > label:hover,
    .rate:not(:checked) > label:hover ~ label {
        color: #deb217;
    }
    .rate > input:checked + label:hover,
    .rate > input:checked + label:hover ~ label,
    .rate > input:checked ~ label:hover,
    .rate > input:checked ~ label:hover ~ label,
    .rate > label:hover ~ input:checked ~ label {
        color: #c59b08;
    }
</style>
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Detalles</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="is-marked">
                    <a href="javascript:;">Detalles</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- Single-Product-Full-Width-Page -->
<div class="page-detail u-s-p-t-80">
        <div class="container">
            <!-- Product-Detail -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <!-- Product-zoom-area -->
                    <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                        <a href="{{ asset('front/images/product_images/large/'.$productDetails['producto_image']) }}">
                            <img src="{{ asset('front/images/product_images/large/'.$productDetails['producto_image']) }}" alt="Ambato Shop Imagen" width="385" height="385" />
                        </a>
                    </div>
                    <div class="thumbnails" style="margin-top:30px;">
                        <a href="{{ asset('front/images/product_images/large/'.$productDetails['producto_image']) }}" data-standard="{{ asset('front/images/product_images/small/'.$productDetails['producto_image']) }}">
                            <img with="120" height="120" src="{{ asset('front/images/product_images/small/'.$productDetails['producto_image']) }}" alt="Ambato Shop Imagen" />
                        </a>
                        @foreach($productDetails['images'] as $image)
                            <a href="{{ asset('front/images/product_images/large/'.$image['image']) }}" data-standard="{{ asset('front/images/product_images/small/'.$image['image']) }}">
                                <img with="120" height="120" src="{{ asset('front/images/product_images/small/'.$image['image']) }}" alt="Ambato Shop Imagen" />
                            </a>
                        @endforeach
                        </div>
                    <!-- Product-zoom-area /- -->
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <!-- Product-details -->
                    <div class="all-information-wrapper">
                    @if(Session::has('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error: </strong> <?php echo Session::get('error_message'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    @endif

                    @if(Session::has('success_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success: </strong> <?php echo Session::get('success_message'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                    @endif
                        <div class="section-1-title-breadcrumb-rating">
                            <div class="product-title">
                                <h1>
                                    <a href="javascript:;">{{ $productDetails['producto_nombre'] }}</a>
                                </h1>
                            </div>
                            <ul class="bread-crumb">
                                <li class="has-separator">
                                    <a href="{{ url('/') }}">Home</a>
                                </li>
                                <li class="has-separator">
                                    <a href="avascript:;">{{ $productDetails['section']['nombre'] }}</a>
                                </li>
                                <?php echo $categoryDetails['breadcrumbs']; ?>
                            </ul>
                            <div class="product-rating">
                                <div title="{{ $avgRating }} fuera de 5 - basado en {{ count($ratings) }} Reseñas">
                                    @if($avgStarRating>0)
                                        <?php
                                            $star=1;
                                            while($star<=$avgStarRating){
                                        ?>
                                            <span style="color: gold; font-size: 17px;">&#9733;</span>
                                        <?php $star++; } ?>({{ $avgRating }})
                                    @endif
                                </div>
                                <span></span>
                            </div>
                        </div>
                        <div class="section-2-short-description u-s-p-y-14">
                            <h6 class="information-heading u-s-m-b-8">Descripción:</h6>
                            <p>
                                {{ $productDetails['descripcion'] }}
                            </p>
                        </div>
                        <div class="section-3-price-original-discount u-s-p-y-14">
                            <?php $getDiscountPrice = Product::getDiscountPrice($productDetails['id']); ?>
                            <span class="getAttributePrice">
                            @if($getDiscountPrice>0)
                                <div class="price">
                                    <h4>$ {{ $getDiscountPrice }}</h4>
                                </div>
                                <div class="original-price">
                                    <span>Precio Original:</span>
                                    <span>$ {{ $productDetails['producto_precio'] }}</span>
                                </div>
                            @else
                                <div class="price">
                                    <h4>$ {{ $productDetails['producto_precio'] }}</h4>
                                </div>
                            @endif
                            </span>
                            <!-- <div class="discount-price">
                                <span>Discount:</span>
                                <span>15%</span>
                            </div>
                            <div class="total-save">
                                <span>Save:</span>
                                <span>$20</span>
                            </div> -->
                        </div>
                        <div class="section-4-sku-information u-s-p-y-14">
                            <h6 class="information-heading u-s-m-b-8">Información:</h6>
                            <div class="left">
                                <span>Código del Producto:</span>
                                <span>{{ $productDetails['producto_codigo'] }}</span>
                            </div>
                            <div class="left">
                                <span>Color del producto:</span>
                                <span>{{ $productDetails['producto_color'] }}</span>
                            </div>
                            <div class="availability">
                                <span>Disponibilidad:</span>
                                @if($totalStock>0)
                                    <span>En Stock</span>
                                @else
                                    <span style="color:red;">Fuera de Stock</span>
                                @endif
                            </div>
                            @if($totalStock>0)
                            <div class="left">
                                <span>Solo:</span>
                                <span>quedan {{$totalStock}}</span>
                            </div>
                            @endif
                        </div>
                        @if(isset($productDetails['vendor']))
                        <div>
                            Tienda: <a href="/products/{{ $productDetails['vendor']['id'] }}"> {{ $productDetails['vendor']['vendorbusinessdetails']['nombre_tienda'] }} </a>
                        </div>
                        @endif
                        <form action="{{ url('cart/add') }}" class="post-form" method="Post">@csrf
                            <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}">
                            <div class="section-5-product-variants u-s-p-y-14">

                                @if(count($groupProducts) > 0)
                                    <div>
                                        <div><strong>Más Colores</strong></div>
                                        <div style="margin-top:10px;">
                                            @foreach($groupProducts as $product)
                                                <a href="{{ url('product/'.$product['id']) }}"><img style="width: 100px;" src="{{ asset('front/images/product_images/small/'.$product['producto_image']) }}"></a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <div class="sizes u-s-m-b-11" style="margin-top:20px;">
                                    <span>Tamaño disponible:</span>
                                    <div class="size-variant select-box-wrapper">
                                        <select name="tamano" id="getPrice" product-id="{{ $productDetails['id'] }}" class="select-box product-size" required="">
                                        <option value="">Seleccionar Tamaño</option>
                                            @foreach($productDetails['attributes'] as $attribute)
                                            <option value="{{ $attribute['tamano'] }}">{{ $attribute['tamano'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="section-6-social-media-quantity-actions u-s-p-y-14">
                                <?php /* <div class="quick-social-media-wrapper u-s-m-b-22">
                                        <span>Share:</span>
                                        <ul class="social-media-list">
                                            <li>
                                                <a href="#">
                                                    <i class="fab fa-facebook-f"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fab fa-twitter"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fab fa-google-plus-g"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fas fa-rss"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <i class="fab fa-pinterest"></i>
                                                </a>
                                            </li>
                                        </ul>
                                </div> */ ?>
                                <div class="quantity-wrapper u-s-m-b-22">
                                    <span>Cantidad:</span>
                                    <div class="quantity">
                                        <input type="number" class="quantity-text-field" name="cantidad" value="1" min="1" oninput="this.value = this.value < 1 ? 1 : this.value;">
                                    </div>
                                </div>
                                <div>
                                        <button class="button button-outline-secondary" type="submit">Añadir al carrito</button>
                                        <button class="button button-outline-secondary far fa-heart u-s-m-l-6"></button>
                                        <button class="button button-outline-secondary far fa-envelope u-s-m-l-6"></button>
                                </div>

                            </div>
                        </form>
                    </div>
                    <!-- Product-details /- -->
                </div>
            </div>
            <!-- Product-Detail /- -->
            <!-- Detail-Tabs -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="detail-tabs-wrapper u-s-p-t-80">
                        <div class="detail-nav-wrapper u-s-m-b-30">
                            <ul class="nav single-product-nav justify-content-center">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#video">Video del Producto</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#detail">Detalles del Producto</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#review">Calificaciones {{ count($ratings) }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <!-- Description-Tab -->
                            <div class="tab-pane fade active show" id="video">
                                <div>
                                    @if($productDetails['producto_video'])
                                    <video width="500" height="300" controls>
                                        <source src="{{ url('front/videos/product_videos/'.$productDetails['producto_video']) }}" type="video/mp4">
                                    </video>
                                    @else
                                        El video del producto no existe
                                    @endif
                                </div>
                            </div>
                            <!-- Description-Tab /- -->
                            <!-- Details-Tab -->
                            <div class="tab-pane fade" id="detail">
                                <div class="specification-whole-container">
                                    <div class="spec-table u-s-m-b-50">
                                        <h4 class="spec-heading">Detalles del Producto</h4>
                                        <table>
                                        @foreach($productFilters as $filter)
                                            @if(isset($productDetails['category_id']))
                                            <?php
                                                $filterAvailable = ProductsFilter::filterAvailable($filter['id'],$productDetails['category_id']);
                                            ?>
                                                @if($filterAvailable=="Si")
                                                <tr>
                                                    <td>{{ $filter['filtro_nombre'] }}</td>
                                                    <td>
                                                        @foreach($filter['filter_value'] as $value)
                                                            @if(!empty($productDetails[$filter['filtro_columna']]) && $value['filtro_value']==$productDetails[$filter['filtro_columna']]) {{ ucwords($value['filtro_value']) }} @endif
                                                        @endforeach
                                                    </td>
                                                </tr>
                                                @endif
                                            @endif
                                        @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Specifications-Tab /- -->
                            <!-- Reviews-Tab -->
                            <div class="tab-pane fade" id="review">
                                <div class="review-whole-container">
                                    <div class="row r-1 u-s-m-b-26 u-s-p-b-22">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="total-score-wrapper">
                                                <h6 class="review-h6">Calificación promedio</h6>
                                                <div class="circle-wrapper">
                                                    <h1>{{ $avgRating }}</h1>
                                                </div>
                                                <h6 class="review-h6">Basado en {{ count($ratings) }} reseñas</h6>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="total-star-meter">
                                                <div class="star-wrapper">
                                                    <span>5 Estrellas</span>
                                                    <div class="star">
                                                        <span style='width:0'></span>
                                                    </div>
                                                    <span>({{ $ratingFiveStarCount }})</span>
                                                </div>
                                                <div class="star-wrapper">
                                                    <span>4 Estrellas</span>
                                                    <div class="star">
                                                        <span style='width:0'></span>
                                                    </div>
                                                    <span>({{ $ratingFourStarCount }})</span>
                                                </div>
                                                <div class="star-wrapper">
                                                    <span>3 Estrellas</span>
                                                    <div class="star">
                                                        <span style='width:0'></span>
                                                    </div>
                                                    <span>({{ $ratingThreeStarCount }})</span>
                                                </div>
                                                <div class="star-wrapper">
                                                    <span>2 Estrellas</span>
                                                    <div class="star">
                                                        <span style='width:0'></span>
                                                    </div>
                                                    <span>({{ $ratingTwoStarCount }})</span>
                                                </div>
                                                <div class="star-wrapper">
                                                    <span>1 Estrella</span>
                                                    <div class="star">
                                                        <span style='width:0'></span>
                                                    </div>
                                                    <span>({{ $ratingOneStarCount }})</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row r-2 u-s-m-b-26 u-s-p-b-22">
                                        <div class="col-lg-12">
                                            <form method="POST" action="{{ url('add-rating') }}" name="formRating" id="formRating">@csrf()
                                                <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}">
                                                <div class="your-rating-wrapper">
                                                    <h6 class="review-h6">Tu calificación es importante.</h6>
                                                    <h6 class="review-h6">¿Has usado este producto antes?</h6>
                                                    <div class="star-wrapper u-s-m-b-8">
                                                        <div class="rate">
                                                            <input style="display: none;" type="radio" id="star5" name="clasificacion" value="5" />
                                                            <label for="star5" title="text">5 stars</label>
                                                            <input style="display: none;" type="radio" id="star4" name="clasificacion" value="4" />
                                                            <label for="star4" title="text">4 stars</label>
                                                            <input style="display: none;" type="radio" id="star3" name="clasificacion" value="3" />
                                                            <label for="star3" title="text">3 stars</label>
                                                            <input style="display: none;" type="radio" id="star2" name="clasificacion" value="2" />
                                                            <label for="star2" title="text">2 stars</label>
                                                            <input style="display: none;" type="radio" id="star1" name="clasificacion" value="1" />
                                                            <label for="star1" title="text">1 star</label>
                                                        </div>
                                                    </div>
                                                    <textarea name="opiniones" class="text-area u-s-m-b-8" id="review-text-area" placeholder="Tu Comentario" required=""></textarea>
                                                    <button type="submit" class="button button-outline-secondary">Enviar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Get-Reviews -->
                                    <div class="get-reviews u-s-p-b-22">
                                        <!-- Review-Options -->
                                        <div class="review-options u-s-m-b-16">
                                            <div class="review-option-heading">
                                                <h6>Calificaciones
                                                    <span> {{ count($ratings) }} </span>
                                                </h6>
                                            </div>
                                            <!-- <div class="review-option-box">
                                                <div class="select-box-wrapper">
                                                    <label class="sr-only" for="review-sort">Review Sorter</label>
                                                    <select class="select-box" id="review-sort">
                                                        <option value="">Sort by: Best Rating</option>
                                                        <option value="">Sort by: Worst Rating</option>
                                                    </select>
                                                </div>
                                            </div> -->
                                        </div>
                                        <!-- Review-Options /- -->
                                        <!-- All-Reviews -->
                                        <div class="reviewers">
                                            @if(count($ratings)>0)
                                                @foreach($ratings as $rating)
                                                    <div class="review-data">
                                                        <div class="reviewer-name-and-date">
                                                            <h6 class="reviewer-name">{{ $rating['user']['name'] }}</h6>
                                                            <h6 class="review-posted-date">{{ date("d-m-Y H:i:s",strtotime($rating['created_at'])); }}</h6>
                                                        </div>
                                                        <div class="reviewer-stars-title-body">
                                                            <div class="reviewer-stars">
                                                                <?php
                                                                    $count=0;
                                                                    while($count<$rating['clasificacion']){
                                                                ?>
                                                                <span style="color: gold;">&#9733;</span>
                                                                <?php $count++; } ?>
                                                            </div>
                                                            <p class="review-body">
                                                                {{ $rating['opiniones'] }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <!-- All-Reviews /- -->
                                    </div>
                                    <!-- Get-Reviews /- -->
                                </div>
                            </div>
                            <!-- Reviews-Tab /- -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Detail-Tabs /- -->
            <!-- Different-Product-Section -->
            <div class="detail-different-product-section u-s-p-t-80">
                <!-- Similar-Products -->
                <section class="section-maker">
                    <div class="container">
                        <div class="sec-maker-header text-center">
                            <h3 class="sec-maker-h3">Productos Similares</h3>
                        </div>
                        <div class="slider-fouc">
                            <div class="products-slider owl-carousel" data-item="4">
                                @foreach($similarProducts as $product)
                                <div class="item">
                                    <div class="image-container">
                                        <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                            <?php $product_image_path = 'front/images/product_images/small/'.$product['producto_image']; ?>
                                            @if(!empty($product['producto_image']) && file_exists($product_image_path))
                                                <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Ambato Shop Producto" style="width: 400px; height: 300px;">
                                            @else
                                                <img class="img-fluid" src="{{ asset('front/images/product_images/small/no_image.png') }}" alt="Ambato Shop Producto" style="width: 400px; height: 300px;">
                                            @endif
                                        </a>
                                        <div class="item-action-behaviors">
                                            <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look</a>
                                            <a class="item-mail" href="javascript:void(0)">Mail</a>
                                            <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                            <a class="item-addCart" href="/cart">Add to Cart</a>
                                        </div>
                                    </div>
                                    <div class="item-content">
                                        <div class="what-product-is">
                                            <ul class="bread-crumb">
                                                <li class="has-separator">
                                                    <a href="shop-v1-root-category.html">{{ $product['producto_codigo'] }}</a>
                                                </li>
                                                <li class="has-separator">
                                                    <a href="listing.html">{{ $product['producto_color'] }}</a>
                                                </li>
                                                <li>
                                                    <a href="listing.html">{{ $product['brand']['nombre']  }}</a>
                                                </li>
                                            </ul>
                                            <h6 class="item-title">
                                                <a href="{{ url('product/'.$product['id']) }}">{{ $product['producto_nombre'] }}</a>
                                            </h6>
                                            <!-- <div class="item-stars">
                                                <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                    <span style='width:0'></span>
                                                </div>
                                                <span>(0)</span>
                                            </div> -->
                                        </div>
                                        <?php $getDiscountPrice = Product::getDiscountPrice($product['id']); ?>
                                        @if($getDiscountPrice>0)
                                        <div class="price-template">
                                            <div class="item-new-price">
                                                ${{ $getDiscountPrice }}
                                            </div>
                                            <div class="item-old-price">
                                                ${{ $product['producto_precio'] }}
                                            </div>
                                        </div>
                                        @else
                                        <div class="price-template">
                                            <div class="item-new-price">
                                                ${{ $product['producto_precio'] }}
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="tag new">
                                        <span>NEW</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Similar-Products /- -->
                <!-- Recently-View-Products  -->
                <section class="section-maker">
                    <div class="container">
                        <div class="sec-maker-header text-center">
                            <h3 class="sec-maker-h3">Productos Recien Vistos</h3>
                        </div>
                        <div class="slider-fouc">
                            <div class="products-slider owl-carousel" data-item="4">
                            @foreach($recentlyViewedProducts as $product)
                                <div class="item">
                                    <div class="image-container">
                                        <a class="item-img-wrapper-link" href="{{ url('product/'.$product['id']) }}">
                                            <?php $product_image_path = 'front/images/product_images/small/'.$product['producto_image']; ?>
                                            @if(!empty($product['producto_image']) && file_exists($product_image_path))
                                                <img class="img-fluid" src="{{ asset($product_image_path) }}" alt="Ambato Shop Producto" style="width: 400px; height: 300px;">
                                            @else
                                                <img class="img-fluid" src="{{ asset('front/images/product_images/small/no_image.png') }}" alt="Ambato Shop Producto" style="width: 400px; height: 300px;">
                                            @endif
                                        </a>
                                        <div class="item-action-behaviors">
                                            <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look</a>
                                            <a class="item-mail" href="javascript:void(0)">Mail</a>
                                            <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                            <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                                        </div>
                                    </div>
                                    <div class="item-content">
                                        <div class="what-product-is">
                                            <ul class="bread-crumb">
                                                <li class="has-separator">
                                                    <a href="shop-v1-root-category.html">{{ $product['producto_codigo'] }}</a>
                                                </li>
                                                <li class="has-separator">
                                                    <a href="listing.html">{{ $product['producto_color'] }}</a>
                                                </li>
                                                <li>
                                                    <a href="listing.html">{{ $product['brand']['nombre']  }}</a>
                                                </li>
                                            </ul>
                                            <h6 class="item-title">
                                                <a href="{{ url('product/'.$product['id']) }}">{{ $product['producto_nombre'] }}</a>
                                            </h6>
                                            <!-- <div class="item-stars">
                                                <div class='star' title="0 out of 5 - based on 0 Reviews">
                                                    <span style='width:0'></span>
                                                </div>
                                                <span>(0)</span>
                                            </div> -->
                                        </div>
                                        <?php $getDiscountPrice = Product::getDiscountPrice($product['id']); ?>
                                        @if($getDiscountPrice>0)
                                        <div class="price-template">
                                            <div class="item-new-price">
                                                ${{ $getDiscountPrice }}
                                            </div>
                                            <div class="item-old-price">
                                                ${{ $product['producto_precio'] }}
                                            </div>
                                        </div>
                                        @else
                                        <div class="price-template">
                                            <div class="item-new-price">
                                                ${{ $product['producto_precio'] }}
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="tag new">
                                        <span>NEW</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Recently-View-Products /- -->
            </div>
            <!-- Different-Product-Section /- -->
        </div>
</div>
<!-- Single-Product-Full-Width-Page /- -->
@endsection
