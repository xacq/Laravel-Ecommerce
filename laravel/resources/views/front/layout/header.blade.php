<?php
use App\Models\Section;
$sections = Section::sections();
/* echo "<pre>"; print_r($sections); die; */
$totalCartItems = totalCartItems();
?>
<!-- Header -->
<header>
        <!-- Top-Header -->
        <div class="full-layer-outer-header">
            <div class="container clearfix">
                <nav>
                    <ul class="primary-nav g-nav">
                        <li>
                            <a href="tel:+111222333">
                                <i class="fas fa-phone u-c-brand u-s-m-r-9"></i>
                                Teléfono: +593 983004127</a>
                        </li>
                        <li>
                            <a href="mailto:info@sitemakers.in">
                                <i class="fas fa-envelope u-c-brand u-s-m-r-9"></i>
                                E-mail: kevinmasabanda2c@gmail.com
                            </a>
                        </li>
                    </ul>
                </nav>
                <nav>
                    <ul class="secondary-nav g-nav">
                        <li>
                            @if(Auth::check())
                                <a href="{{ url('user/account') }}">Mi Cuenta</a>
                            @else
                                <a href="{{ url('user/login-register') }}">Login/Registro</a>
                            @endif
                            <ul class="g-dropdown" style="width:200px">
                                <li>
                                    <a href="{{ url('/cart') }}">
                                        <i class="fas fa-cog u-s-m-r-9"></i>
                                        Mi carrito</a>
                                </li>
                                <li>
                                    <a href="{{ url('user/orders') }}">
                                        <i class="far fa-heart u-s-m-r-9"></i>
                                        Mis Pedidos</a>
                                </li>
                                <!-- <li>
                                    <a href="checkout.html">
                                        <i class="far fa-check-circle u-s-m-r-9"></i>
                                        Proceso de pago</a>
                                </li> -->
                                @if(Auth::check())
                                    <li>
                                        <a href="{{ url('user/account') }}">
                                            <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                                            Mi Cuenta</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('user/logout') }}">
                                            <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                                            Cerrar Sesión</a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ url('user/login-register') }}">
                                            <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                                            Login Usuario</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('vendor/login-register') }}">
                                            <i class="fas fa-sign-in-alt u-s-m-r-9"></i>
                                            Login Vendedor</a>
                                    </li>

                                @endif
                            </ul>
                        </li>
                        <!-- <li>
                            <a>USD
                                <i class="fas fa-chevron-down u-s-m-l-9"></i>
                            </a>
                            <ul class="g-dropdown" style="width:90px">
                                <li>
                                    <a href="#" class="u-c-brand">($) USD</a>
                                </li>
                                <li>
                                    <a href="#">(£) GBP</a>
                                </li>
                            </ul>
                        </li> -->
                        <!-- <li>
                            <a>ENG
                                <i class="fas fa-chevron-down u-s-m-l-9"></i>
                            </a>
                            <ul class="g-dropdown" style="width:70px">
                                <li>
                                    <a href="#" class="u-c-brand">ENG</a>
                                </li>
                                <li>
                                    <a href="#">ARB</a>
                                </li>
                            </ul> -->
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Top-Header /- -->
        <!-- Mid-Header -->
        <div class="full-layer-mid-header">
            <div class="container">
                <div class="row clearfix align-items-center">
                    <div class="col-lg-3 col-md-9 col-sm-6">
                        <div class="brand-logo text-lg-center">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('front/images/main-logo/AmbatoShop.png') }}" alt="Ambato Shop Developers" class="app-brand-logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 u-d-none-lg">
                        <form class="form-searchbox" action="{{ url('/search-products') }}" method="get">
                            <label class="sr-only" for="search-landscape">Buscar</label>
                            <input name="search" id="search-landscape" type="text" class="text-field" placeholder="Busca todo" @if(isset($_REQUEST['search']) && !empty($_REQUEST['search'])) value="{{ $_REQUEST['search'] }}" @endif>
                            <div class="select-box-position">
                                <div class="select-box-wrapper select-hide">
                                    <label class="sr-only" for="select-category">Elija una categoría para buscar</label>
                                    <select class="select-box" id="select-category" name="section_id">
                                        <option selected="selected" value="">
                                            Todos
                                        </option>
                                        @foreach($sections as $section)
                                            <option
                                                value="{{ $section['id'] }}"
                                                @if(isset($_REQUEST['section_id']) && $_REQUEST['section_id'] == $section['id'])
                                                    selected
                                                @endif
                                            >
                                                {{ $section['nombre'] }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <button id="btn-search" type="submit" class="button button-primary fas fa-search"></button>
                        </form>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <nav>
                            <ul class="mid-nav g-nav">
                                <li class="u-d-none-lg">
                                    <a href="{{ url('/') }}">
                                        <i class="ion ion-md-home u-c-brand"></i>
                                    </a>
                                </li>
                                <!-- <li class="u-d-none-lg">
                                    <a href="wishlist.html">
                                        <i class="far fa-heart"></i>
                                    </a>
                                </li> -->
                                <li>
                                    <a id="mini-cart-trigger">
                                        <i class="ion ion-md-basket"></i>
                                        <span class="item-counter totalCartItems">{{ $totalCartItems }}</span>
                                        <!-- <span class="item-price">$220.00</span> -->
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mid-Header /- -->
        <!-- Responsive-Buttons -->
        <div class="fixed-responsive-container">
            <div class="fixed-responsive-wrapper">
                <button type="button" class="button fas fa-search" id="responsive-search"></button>
            </div>
            <!-- <div class="fixed-responsive-wrapper">
                <a href="wishlist.html">
                    <i class="far fa-heart"></i>
                    <span class="fixed-item-counter">4</span>
                </a>
            </div> -->
        </div>
        <!-- Responsive-Buttons /- -->
        <!-- Mini Cart -->
        <div id="appendHeaderCartItems">
            @include ('front.layout.header_cart_items')
        </div>
        <!-- Mini Cart /- -->
        <!-- Bottom-Header -->
        <div class="full-layer-bottom-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3">
                        <div class="v-menu v-close">
                            <span class="v-title">
                                <i class="ion ion-md-menu"></i>
                                Todas las categorías
                                <i class="fas fa-angle-down"></i>
                            </span>
                            <nav>
                                <div class="v-wrapper">
                                    <ul class="v-list animated fadeIn">
                                        @foreach($sections as $section)
                                        @if(count($section['categories'])>0)
                                        <li class="js-backdrop">
                                            <a href="javascript:;">
                                                <i class="ion-ios-add-circle"></i>
                                                {{ $section['nombre'] }}
                                                <i class="ion ion-ios-arrow-forward"></i>
                                            </a>
                                            <button class="v-button ion ion-md-add"></button>
                                            <div class="v-drop-right" style="width: 700px;">
                                                <div class="row">
                                                    @foreach($section['categories'] as $category)
                                                    <div class="col-lg-4">
                                                        <ul class="v-level-2">
                                                            <li>
                                                                <a href="{{ url($category['url']) }}">{{ $category['categoria_nombre'] }}</a>
                                                                <ul>
                                                                    @foreach($category['subcategories'] as $subcategory)
                                                                    <li>
                                                                        <a href="{{ url($subcategory['url']) }}">{{ $subcategory['categoria_nombre'] }}</a>
                                                                    </li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </li>
                                        @endif
                                        @endforeach
                                        <!-- <li>
                                            <a class="v-more">
                                                <i class="ion ion-md-add"></i>
                                                <span>View More</span>
                                            </a>
                                        </li> -->
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <ul class="bottom-nav g-nav u-d-none-lg">
                            <li>
                                <a href="{{ url('search-products?search=nuevas-llegadas') }}">Nuevas llegadas
                                    <span class="superscript-label-new">Nuevos</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('search-products?search=mas-vendidos') }}">Más Vendidos
                                    <span class="superscript-label-hot">HOT</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('search-products?search=destacados') }}">Destacados
                                    <span style="
                                        background-color: #f39c12;
                                        color: #fff;
                                        font-size: 10px;
                                        padding: 2px 5px;
                                        border-radius: 5px;
                                        position: absolute;
                                        top: 2px;
                                        left: 40px;
                                        transform: translateY(-50%);">
                                        Top
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('search-products?search=descuentos') }}">Descuentos
                                        <span class="superscript-label-discount">%</span>
                                </a>
                            </li>
                            <li class="mega-position">
                                <a>Más
                                    <i class="fas fa-chevron-down u-s-m-l-9"></i>
                                </a>
                                <div class="mega-menu mega-3-colm" style="display: grid; grid-template-columns: repeat(4, 1fr); ">
                                    <ul>
                                        <li class="menu-title">Ropa</li>
                                        <li>
                                            <a href="{{ url('hombre') }}">Hombre</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('mujer') }}">Mujer</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('niños') }}">Niños</a>
                                        </li>
                                    </ul>
                                    <ul>
                                        <li class="menu-title">Electrónicos</li>
                                        <li>
                                            <a href="{{ url('celulares') }}">Celulares</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('tablet') }}">Tablet</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('audífonos') }}">Audífonos</a>
                                        </li>
                                    </ul>
                                    <ul>
                                        <li class="menu-title">Arreglos</li>
                                        <li>
                                            <a href="{{ url('ramos') }}">Ramos</a>
                                        </li>
                                    </ul>
                                    <ul>
                                        <li class="menu-title">CUENTA</li>
                                        <li>
                                            <a href="{{ url('user/account') }}">Mi Cuenta</a>
                                        </li>
                                        <!-- <li>
                                            <a href="shop-v1-root-category.html">Mi perfil</a>
                                        </li> -->
                                        <li>
                                            <a href="{{ url('user/orders') }}">Mis pedidos</a>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bottom-Header /- -->
</header>
<!-- Header /- -->
