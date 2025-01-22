@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="font-weight-bold">Gestión Pancartas</h3>
                        <h6 class="font-weight-normal mb-0">Pancartas</h6>
                        <!-- <h6 class="font-weight-normal mb-0">Categorias</h6> -->
                        <!-- <p class="card-description">
                            Add class <code>.table-bordered</code>
                        </p> -->
                        <a style="max-width: 160px; float: right; display: inline-block;" href="{{ url('admin/add-edit-banner') }}" class="btn btn-block btn-primary">Agregar Pancarta</a>
                        @if(Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success: </strong> {{ Session::get('success_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                        @endif
                        <div class="table-responsive pt-3">
                            <table id="banners" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Imagen
                                        </th>
                                        <th>
                                            Tipo Pancarta
                                        </th>
                                        <th>
                                            Link
                                        </th>
                                        <th>
                                            Titulo
                                        </th>
                                        <th>
                                            Alt
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Acción
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($banners as $banner)
                                    <tr>
                                        <td>
                                            {{ $banner['id'] }}
                                        </td>
                                        <td>
                                            <img style="width: 60px; height: 60px;" src="{{ asset('front/images/banner_images/'.$banner['image']) }}">
                                        </td>
                                        <td>
                                            {{ $banner['tipo'] }}
                                        </td>
                                        <td>
                                            {{ $banner['link'] }}
                                        </td>
                                        <td>
                                            {{ $banner['titulo'] }}
                                        </td>
                                        <td>
                                            {{ $banner['alt'] }}
                                        </td>
                                        <td>
                                            @if($banner['status']==1)
                                               <a class="updateBannerStatus" id="banner-{{ $banner['id'] }}" banner_id="{{ $banner['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-check" status="Active"></i></a>
                                            @else
                                            <a class="updateBannerStatus" id="banner-{{ $banner['id'] }}" banner_id="{{ $banner['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-outline" status="Inactive"></i></a>  
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/add-edit-banner/'.$banner['id']) }}"><i style="font-size:25px;" class="mdi mdi-pencil-box"></i></a>
                                            <?php /* <a title="Banner" class="confirmDelete" href="{{ url('admin/delete-banner/'.$banner['id']) }}"><i style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a> */?>
                                            <a href="javascript:void(0)" class="confirmDelete" module="banner" moduleid="{{ $banner['id'] }}"><i style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a>
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