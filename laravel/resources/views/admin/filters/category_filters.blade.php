<?php 
use App\Models\ProductsFilter; 
$productFilters = ProductsFilter::productFilters();
/* dd($productFilters); */
if(isset($product['category_id'])){
    $category_id = $product['category_id'];
}
?>
@foreach($productFilters as $filter)
    @if(isset($category_id))
    <?php
        $filterAvailable = ProductsFilter::filterAvailable($filter['id'],$category_id);
    ?>
        @if($filterAvailable=="Si")
        <div class="form-group">
        <label for="{{ $filter['filtro_columna'] }}">Seleccionar {{ $filter['filtro_nombre'] }}</label>
        <select name="{{ $filter['filtro_columna'] }}" id="{{ $filter['filtro_columna'] }}" class="form-control text-dark">
            <option value="">Seleccionar</option>
            @foreach($filter['filter_value'] as $value)
                <option value="{{ $value['filtro_value'] }}" @if(!empty($product[$filter['filtro_columna']]) && $value['filtro_value']==$product[$filter['filtro_columna']]) selected="" @endif>{{ ucwords($value['filtro_value']) }}</option>
            @endforeach
        </select>
        </div>
        @endif
    @endif
@endforeach