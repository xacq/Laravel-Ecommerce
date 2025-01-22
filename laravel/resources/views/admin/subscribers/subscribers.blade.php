@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h3 class="font-weight-bold">Gestión Subscripciones</h3>
                        <h6 class="font-weight-normal mb-0">Subscripciones</h6>
                        <!-- <h6 class="font-weight-normal mb-0">Categorias</h6> -->
                        <!-- <p class="card-description">
                            Add class <code>.table-bordered</code>
                        </p> -->
                        <a href="{{ url('admin/export-subscribers') }}" style="max-width:150px; float:right" class="btn btn-block btn-primary">Export</a>
                        @if(Session::has('success_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success: </strong> {{ Session::get('success_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                        @endif
                        <div class="table-responsive pt-3">
                            <table id="subscribers" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            Subscripto en
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
                                    @foreach($subscribers as $subscriber)
                                    <tr>
                                        <td>
                                            {{ $subscriber['id'] }}
                                        </td>
                                        <td>
                                            {{ $subscriber['email'] }}
                                        </td>
                                        <td>
                                            {{ date ("F j, Y, g:i a", strtotime($subscriber['created_at'])); }}
                                        </td>
                                        <td>
                                            @if($subscriber['status']==1)
                                               <a class="updateSubscriberStatus" id="subscriber-{{ $subscriber['id'] }}" subscriber_id="{{ $subscriber['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-check" status="Active"></i></a>
                                            @else
                                            <a class="updateSubscriberStatus" id="subscriber-{{ $subscriber['id'] }}" subscriber_id="{{ $subscriber['id'] }}" href="javascript:void(0)"><i style="font-size:25px;" class="mdi mdi-bookmark-outline" status="Inactive"></i></a>  
                                            @endif
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="confirmDelete" module="subscriber" moduleid="{{ $subscriber['id'] }}"><i style="font-size:25px;" class="mdi mdi-file-excel-box"></i></a>
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