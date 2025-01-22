<?php 
use App\Models\ProductsFilter; 
$productFilters = ProductsFilter::productFilters();
/* dd($productFilters); */
?>
<div class="col-lg-3 col-md-3 col-sm-12">
    <!-- Fetch-Categories-from-Root-Category  -->
    <div class="fetch-categories">
                        <h3 class="title-name">Explorar Categorías</h3>
                        <!-- Level 1 -->
                        <!-- <h3 class="fetch-mark-category">
                            <a href="listing.html">T-Shirts
                                <span class="total-fetch-items">(5)</span>
                            </a>
                        </h3>
                        <ul>
                            <li>
                                <a href="shop-v3-sub-sub-category.html">Casual T-Shirts
                                    <span class="total-fetch-items">(3)</span>
                                </a>
                            </li>
                            <li>
                                <a href="listing.html">Formal T-Shirts
                                    <span class="total-fetch-items">(2)</span>
                                </a>
                            </li>
                        </ul> -->
                        <!-- //end Level 1 -->
                        <!-- Level 2 -->
                        <!-- <h3 class="fetch-mark-category">
                            <a href="listing.html">Shirts
                                <span class="total-fetch-items">(5)</span>
                            </a>
                        </h3>
                        <ul>
                            <li>
                                <a href="shop-v3-sub-sub-category.html">Casual Shirts
                                    <span class="total-fetch-items">(3)</span>
                                </a>
                            </li>
                            <li>
                                <a href="listing.html">Formal Shirts
                                    <span class="total-fetch-items">(2)</span>
                                </a>
                            </li>
                        </ul> -->
                        <!-- //end Level 2 -->
    </div>
    <!-- Fetch-Categories-from-Root-Category  /- -->
    @if(!isset($_REQUEST['search']))
        <!-- Filters -->
        <!-- Filter-Size -->
        <?php $getSizes = ProductsFilter::getSizes($url); ?>
        <div class="facet-filter-associates">
            <h3 class="title-name">Tamaño</h3>
            <form class="facet-form" action="#" method="post">
                <div class="associate-wrapper">
                    @foreach($getSizes as $key => $size)
                    <input type="checkbox" class="check-box size" name="size[]" id="size{{ $key }}" value="{{ $size }}">
                    <label class="label-text" for="size{{ $key }}">{{ $size }}
                    </label>
                    @endforeach
                </div>
            </form>
        </div>
        <!-- Filter-Size -->
        <!-- Filter-Color -->
        <?php $getColors = ProductsFilter::getColors($url); ?>
        <div class="facet-filter-associates">
            <h3 class="title-name">Color</h3>
            <form class="facet-form" action="#" method="post">
                <div class="associate-wrapper">
                    @foreach($getColors as $key => $color)
                    <input type="checkbox" class="check-box color" name=color[]"" id="color{{ $key }}" value="{{ $color }}">
                    <label class="label-text" for="color{{ $key }}">{{ $color }}<!-- Heather Grey
                        <span class="total-fetch-items">(1)</span> -->
                    </label>
                    @endforeach
                </div>
            </form>
        </div>
        <!-- Filter-Color /- -->
        <!-- Filter-Brand -->
        <?php $getBrands = ProductsFilter::getBrands($url); ?>
        <div class="facet-filter-associates">
                            <h3 class="title-name">Brand</h3>
                            <form class="facet-form" action="#" method="post">
                                <div class="associate-wrapper">
                                    @foreach($getBrands as $key =>$brand)
                                    <input type="checkbox" class="check-box brand" name="brand[]" id="brand{{ $key }}" value="{{ $brand['id'] }}">
                                    <label class="label-text" for="brand{{ $key }}">{{ $brand['nombre'] }}
                                        <!-- <span class="total-fetch-items">(0)</span> -->
                                    </label>
                                    @endforeach
                                </div>
                            </form>
        </div>
        <!-- Filter-Brand /- -->
        <!-- Filter-Precio -->
        <div class="facet-filter-associates">
                            <h3 class="title-name">Precio</h3>
                            <form class="facet-form" action="#" method="post">
                                <div class="associate-wrapper">
                                    <?php $prices = array('0-10','10-20','20-50','50-80','80-100'); ?>
                                    @foreach($prices as $key => $precio)
                                    <input type="checkbox" class="check-box precio" id="precio{{ $key }}" name="precio[]" value="{{ $precio }}">
                                    <label class="label-text" for="precio{{ $key }}">USD {{ $precio }}
                                        <!-- <span class="total-fetch-items">(0)</span> -->
                                    </label>
                                    @endforeach
                                </div>
                            </form>
        </div>
        <!-- Filter-Precio /- -->
        <!-- Filter -->
        @foreach($productFilters as $filter)
        <?php
            $filterAvailable = ProductsFilter::filterAvailable($filter['id'],$categoryDetails['categoryDetails']['id']);
        ?>
        @if($filterAvailable=="Si")
            @if(count($filter['filter_value'])>0)
            <div class="facet-filter-associates">
                <h3 class="title-name">{{ $filter['filtro_nombre'] }}</h3>
                <form class="facet-form" action="#" method="post">
                    <div class="associate-wrapper">
                        @foreach($filter['filter_value'] as $value)
                        <input type="checkbox" class="check-box {{ $filter['filtro_columna'] }}" id="{{ $value['filtro_value'] }}" name="{{ $filter['filtro_columna'] }}[]" value="{{ $value['filtro_value'] }}">
                        <label class="label-text" for="{{ $value['filtro_value'] }}">{{ ucwords($value['filtro_value']) }}
                            <!-- <span class="total-fetch-items">(0)</span> -->
                        </label>
                        @endforeach
                    </div>
                </form>
            </div>
            @endif
        @endif
        @endforeach
    @endif
    <?php
    /* <!-- Filter /- -->
    <!-- Filter-Price -->
    <div class="facet-filter-by-price">
                        <h3 class="title-name">Price</h3>
                        <form class="facet-form" action="#" method="post">
                            <!-- Final-Result -->
                            <div class="amount-result clearfix">
                                <div class="price-from">$0</div>
                                <div class="price-to">$3000</div>
                            </div>
                            <!-- Final-Result /- -->
                            <!-- Range-Slider  -->
                            <div class="price-filter"></div>
                            <!-- Range-Slider /- -->
                            <!-- Range-Manipulator -->
                            <div class="price-slider-range" data-min="0" data-max="5000" data-default-low="0" data-default-high="3000" data-currency="$"></div>
                            <!-- Range-Manipulator /- -->
                            <button type="submit" class="button button-primary">Filter</button>
                        </form>
    </div>
    <!-- Filter-Price /- -->
    <!-- Filter-Free-Shipping -->
    <div class="facet-filter-by-shipping">
                        <h3 class="title-name">Shipping</h3>
                        <form class="facet-form" action="#" method="post">
                            <input type="checkbox" class="check-box" id="cb-free-ship">
                            <label class="label-text" for="cb-free-ship">Free Shipping</label>
                        </form>
    </div>
    <!-- Filter-Free-Shipping /- -->
    <!-- Filter-Rating -->
    <div class="facet-filter-by-rating">
                        <h3 class="title-name">Rating</h3>
                        <div class="facet-form">
                            <!-- 5 Stars -->
                            <div class="facet-link">
                                <div class="item-stars">
                                    <div class='star'>
                                        <span style='width:76px'></span>
                                    </div>
                                </div>
                                <span class="total-fetch-items">(0)</span>
                            </div>
                            <!-- 5 Stars /- -->
                            <!-- 4 & Up Stars -->
                            <div class="facet-link">
                                <div class="item-stars">
                                    <div class='star'>
                                        <span style='width:60px'></span>
                                    </div>
                                </div>
                                <span class="total-fetch-items">& Up (5)</span>
                            </div>
                            <!-- 4 & Up Stars /- -->
                            <!-- 3 & Up Stars -->
                            <div class="facet-link">
                                <div class="item-stars">
                                    <div class='star'>
                                        <span style='width:45px'></span>
                                    </div>
                                </div>
                                <span class="total-fetch-items">& Up (0)</span>
                            </div>
                            <!-- 3 & Up Stars /- -->
                            <!-- 2 & Up Stars -->
                            <div class="facet-link">
                                <div class="item-stars">
                                    <div class='star'>
                                        <span style='width:30px'></span>
                                    </div>
                                </div>
                                <span class="total-fetch-items">& Up (0)</span>
                            </div>
                            <!-- 2 & Up Stars /- -->
                            <!-- 1 & Up Stars -->
                            <div class="facet-link">
                                <div class="item-stars">
                                    <div class='star'>
                                        <span style='width:15px'></span>
                                    </div>
                                </div>
                                <span class="total-fetch-items">& Up (0)</span>
                            </div>
                            <!-- 1 & Up Stars /- -->
                        </div>
    </div>
    <!-- Filter-Rating -->
    <!-- Filters /- --> */
    ?>
</div>