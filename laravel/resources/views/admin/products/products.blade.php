@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="font-weight-bold">Gestión Productos</h3>
                        <h6 class="font-weight-normal mb-0">Productos</h6>
                        <!-- <h6 class="font-weight-normal mb-0">Categorias</h6> -->
                        <!-- <p class="card-description">
                            Add class <code>.table-bordered</code>
                        </p> -->
                        <a style="max-width: 160px; float: right; display: inline-block;" href="{{ url('admin/add-edit-product') }}" class="btn btn-block btn-primary">Agregar Producto</a>
                        @if(Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success: </strong> {{ Session::get('success_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                        @endif
                        <div class="table-responsive pt-3">
                            <table id="products" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Producto Nombre
                                        </th>
                                        <th>
                                            Producto Código
                                        </th>
                                        <th>
                                            Producto Color
                                        </th>
                                        <th>
                                            Producto Imagen
                                        </th>
                                        <th>
                                            Categoría
                                        </th>
                                        <th>
                                            Sección
                                        </th>
                                        @if(Auth::guard('admin')->user()->tipo!="vendedor")
                                            <th>
                                                Añadido por
                                            </th>
                                        @endif
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Acción
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                    <tr>
                                        <td>
                                            {{ $product['id'] }}
                                        </td>
                                        <td>
                                            {{ $product['producto_nombre'] }}
                                        </td>
                                        <td>
                                            {{ $product['producto_codigo'] }}
                                        </td>
                                        <td>
                                            {{ $product['producto_color'] }}
                                        </td>
                                        <td>
                                        @if(!empty($product['producto_image']))
                                                <img style="width: 120px; height: 120px;" src="{{ asset('front/images/product_images/small/'.$product['producto_image']) }}">
                                        @else
                                                <img style="width: 120px; height: 120px;" src="{{ asset('front/images/product_images/small/no_image.png') }}">
                                        @endif 
                                        </td>
                                        <td>
                                            {{ $product['category']['categoria_nombre'] }}
                                        </td>
                                        <td>
                                            {{ $product['section']['nombre'] }}
                                        </td>
                                        @if(Auth::guard('admin')->user()->tipo!="vendedor")
                                            <td>
                                                @if($product['admin_tipo']=="vendedor")
                                                    <a target="_blank" href="{{ url('admin/view-vendor-details/'.$product['admin_id']) }}">{{ ucfirst($product['admin_tipo']) }}</a>
                                                @else
                                                    {{ ucfirst($product['admin_tipo']) }}
                                                @endif
                                            </td>
                                        @endif
                                        <td>
                                            @if($product['status']==1)
                                               <a class="updateProductStatus" id="product-{{ $product['id'] }}" product_id="{{ $product['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-check" status="Active"></i></a>
                                            @else
                                            <a class="updateProductStatus" id="product-{{ $product['id'] }}" product_id="{{ $product['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-outline" status="Inactive"></i></a>  
                                            @endif
                                        </td>
                                        <td>
                                            <a title="Editar Productos" href="{{ url('admin/add-edit-product/'.$product['id']) }}"><i style="font-size:25px;" class="mdi mdi-pencil-box"></i></a>
                                            <a title="Agregar Atributos" href="{{ url('admin/add-edit-attributes/'.$product['id']) }}"><i style="font-size:25px;" class="mdi mdi-plus-box"></i></a>
                                            <a title="Agregar Imagenes" href="{{ url('admin/add-images/'.$product['id']) }}"><i style="font-size:25px;" class="mdi mdi-library-plus"></i></a>
                                            <?php /* <a title="Product" class="confirmDelete" href="{{ url('admin/delete-product/'.$product['id']) }}"><i style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a> */?>
                                            <a href="javascript:void(0)" class="confirmDelete" module="product" moduleid="{{ $product['id'] }}"><i style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a>
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