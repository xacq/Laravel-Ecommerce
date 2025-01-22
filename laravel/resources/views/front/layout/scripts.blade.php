<?php 
use App\Models\ProductsFilter; 
$productFilters = ProductsFilter::productFilters();
/* dd($productFilters); */
?>
<script>
    $(document).ready(function(){

        //clasificar por filtro
        $("#sort").on("change", function(){
            var sort = $("#sort").val();
            var url = $("#url").val();
            var color = get_filter('color');
            var size = get_filter('size'); 
            var precio = get_filter('precio');
            var brand = get_filter('brand');
            @foreach($productFilters as $filters)
                var {{ $filters['filtro_columna'] }} = get_filter('{{ $filters['filtro_columna'] }}');
            @endforeach
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                method: 'POST',
                data:{
                @foreach($productFilters as $filters)
                    {{ $filters['filtro_columna'] }}:{{ $filters['filtro_columna'] }},
                @endforeach
                url:url,sort:sort,size: size,color: color,precio: precio, brand: brand},
                success: function(data){
                    $('.filter_products').html(data);
                },
                error: function(){
                    alert('aqui');
                }
            });
        });

        //filtrar por tamaño
        $(".size").on("change", function(){
            var color = get_filter('color');
            var size = get_filter('size'); 
            var precio = get_filter('precio');
            var brand = get_filter('brand');
            var sort = $("#sort").val();
            var url = $("#url").val();
            @foreach($productFilters as $filters)
                var {{ $filters['filtro_columna'] }} = get_filter('{{ $filters['filtro_columna'] }}');
            @endforeach
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                method: 'POST',
                data: {
                    @foreach($productFilters as $filters)
                        {{ $filters['filtro_columna'] }}:{{ $filters['filtro_columna'] }},
                    @endforeach
                    url: url,
                    sort: sort,
                    size: size,
                    color: color,
                    precio: precio,
                    brand: brand
                },
                success: function(data){
                    $('.filter_products').html(data);
                },
                error: function(){
                    alert('aqui');
                }
            });
        });

        //filtrar por color
        $(".color").on("change", function(){
            var color = get_filter('color');
            var size = get_filter('size');
            var precio = get_filter('precio');
            var brand = get_filter('brand');
            var sort = $("#sort").val();
            var url = $("#url").val();
            @foreach($productFilters as $filters)
                var {{ $filters['filtro_columna'] }} = get_filter('{{ $filters['filtro_columna'] }}');
            @endforeach
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                method: 'POST',
                data: {
                    @foreach($productFilters as $filters)
                        {{ $filters['filtro_columna'] }}:{{ $filters['filtro_columna'] }},
                    @endforeach
                    url: url,
                    sort: sort,
                    size: size,
                    color: color,
                    precio: precio,
                    brand: brand
                },
                success: function(data){
                    $('.filter_products').html(data);
                },
                error: function(){
                    alert('aqui');
                }
            });
        });

        //filtrar por precio
        $(".precio").on("change", function(){
            var color = get_filter('color');
            var size = get_filter('size');
            var precio = get_filter('precio');
            var brand = get_filter('brand');
            var sort = $("#sort").val();
            var url = $("#url").val();
            @foreach($productFilters as $filters)
                var {{ $filters['filtro_columna'] }} = get_filter('{{ $filters['filtro_columna'] }}');
            @endforeach
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                method: 'POST',
                data: {
                    @foreach($productFilters as $filters)
                        {{ $filters['filtro_columna'] }}:{{ $filters['filtro_columna'] }},
                    @endforeach
                    url: url,
                    sort: sort,
                    size: size,
                    color: color,
                    precio: precio,
                    brand: brand
                },
                success: function(data){
                    $('.filter_products').html(data);
                },
                error: function(){
                    alert('aqui');
                }
            });
        });

        //filtrar por marca(brand)
        $(".brand").on("change", function(){
            var brand = get_filter('brand');
            var color = get_filter('color');
            var size = get_filter('size');
            var precio = get_filter('precio');
            var sort = $("#sort").val();
            var url = $("#url").val();
            @foreach($productFilters as $filters)
                var {{ $filters['filtro_columna'] }} = get_filter('{{ $filters['filtro_columna'] }}');
            @endforeach
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                method: 'POST',
                data: {
                    @foreach($productFilters as $filters)
                        {{ $filters['filtro_columna'] }}:{{ $filters['filtro_columna'] }},
                    @endforeach
                    url: url,
                    sort: sort,
                    size: size,
                    color: color,
                    precio: precio,
                    brand: brand
                },
                success: function(data){
                    $('.filter_products').html(data);
                },
                error: function(){
                    alert('aqui');
                }
            });
        });

        //filtro dinamico
        @foreach($productFilters as $filter)
            $('.{{ $filter['filtro_columna'] }}').on('click',function(){
                var url = $("#url").val();
                var color = get_filter('color');
                var size = get_filter('size');
                var precio = get_filter('precio');
                var brand = get_filter('brand');
                var sort = $("#sort option:selected").val();
                @foreach($productFilters as $filters)
                    var {{ $filters['filtro_columna'] }} = get_filter('{{ $filters['filtro_columna'] }}');
                @endforeach
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:url,
                    method:"Post",
                    data:{
                        @foreach($productFilters as $filters)
                            {{ $filters['filtro_columna'] }}:{{ $filters['filtro_columna'] }},
                        @endforeach
                        url:url,sort:sort,size: size,color: color,precio: precio, brand:brand},
                    success: function(data){
                        $('.filter_products').html(data);
                    },
                    error: function(){
                        alert('aqui');
                    }
                });
            });
        @endforeach
    });
</script>