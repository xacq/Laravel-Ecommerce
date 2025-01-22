@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Cupones</h3>
                       
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                    <a class="dropdown-item" href="#">January - March</a>
                                    <a class="dropdown-item" href="#">March - June</a>
                                    <a class="dropdown-item" href="#">June - August</a>
                                    <a class="dropdown-item" href="#">August - November</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">{{ $title }}</h4>
                  @if(Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Error: </strong> {{ Session::get('error_message') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  @endif

                  @if(Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Success: </strong> {{ Session::get('success_message') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  @endif

                  @if ($errors->any())
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                  @endif
                  
                <form class="forms-sample" @if(empty($coupon['id'])) action="{{ url('admin/add-edit-coupon') }}" @else action="{{ url('admin/add-edit-coupon/'.$coupon['id']) }}" @endif method="post" enctype="multipart/form-data">@csrf
                    @if(empty($coupon['cupon_codigo']))
                    <div class="form-group">
                        <label for="cupon_opcion">Opción de Cupón: </label><br>
                        <span><input id="AutomaticCoupon" type="radio" name="cupon_opcion" value="Automatic" checked="">&nbsp;Antomático&nbsp;&nbsp;</span>
                        <span><input id="ManualCoupon" type="radio" name="cupon_opcion" value="Manual">&nbsp;Manual&nbsp;&nbsp;</span>
                    </div>
                    <div class="form-group" style="display: none;" id="couponField">
                        <label for="cupon_codigo">Cupón Código</label>
                        <input type="text" class="form-control" id="cupon_codigo" placeholder="Ingrese el codigo del cupon" name="cupon_codigo">                    
                    </div>
                    @else
                        <input type="hidden" name="cupon_opcion" value="{{ $coupon['cupon_opcion'] }}">
                        <input type="hidden" name="cupon_codigo" value="{{ $coupon['cupon_codigo'] }}">
                        <div class="form-group">
                            <label for="cupon_codigo">Cupón Código: </label>
                            <span>{{ $coupon['cupon_codigo'] }}</span>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="cupon_tipo">Tipo de Cupón: </label><br>
                        <span><input type="radio" name="cupon_tipo" value="Varias Veces" checked="" @if(isset($coupon['cupon_tipo'])&&$coupon['cupon_tipo']=="Varias Veces") checked="" @endif>&nbsp;Varias Veces&nbsp;&nbsp;</span>
                        <span><input type="radio" name="cupon_tipo" value="Una Vez" @if(isset($coupon['cupon_tipo'])&&$coupon['cupon_tipo']=="Una Vez") checked="" @endif>&nbsp;Una Vez&nbsp;&nbsp;</span>
                    </div>
                    <div class="form-group">
                        <label for="amount_tipo">Monto de Cupón: </label><br>
                        <span><input type="radio" name="amount_tipo" value="Porcentaje" checked="" @if(isset($coupon['amount_tipo'])&&$coupon['amount_tipo']=="Porcentaje") checked="" @endif>&nbsp;Porcentaje&nbsp;(en %)&nbsp;</span>
                        <span><input type="radio" name="amount_tipo" value="Valor Fijo" @if(isset($coupon['amount_tipo'])&&$coupon['amount_tipo']=="Valor Fijo") checked="" @endif>&nbsp;Valor Fijo&nbsp;&nbsp;(en $USD)</span>      
                    </div>
                    <div class="form-group">
                      <label for="amount">Monto</label>
                      <input type="text" class="form-control" id="amount" placeholder="Ingrese el monto del coupon" name="amount"  @if(isset($coupon['amount'])) value="{{ $coupon['amount'] }}" @else value="{{ old('amount') }}"  @endif>
                    </div> 
                    <div class="form-group">
                      <label for="categories">Selecionar la Categoría</label>
                      <select name="categories[]" class="form-control text-dark" multiple="">
                        @foreach($categories as $section)
                            <optgroup label="{{ $section['nombre'] }}"></optgroup>
                            @foreach($section['categories'] as $category)
                            <option value="{{ $category['id'] }}" @if(in_array($category['id'],$selCats)) selected="" @endif>&nbsp;&nbsp;&nbsp;-->&nbsp;{{ $category['categoria_nombre'] }}</option>
                                @foreach($category['subcategories'] as $subcategory)
                                <option value="{{ $subcategory['id'] }}" @if(in_array($subcategory['id'],$selCats)) selected="" @endif>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->&nbsp;{{ $subcategory['categoria_nombre'] }}</option>
                                @endforeach
                            @endforeach
                        @endforeach
                      </select>
                    <div>
                    <div class="form-group">
                      <label for="brands">Selecionar la Marca</label>
                      <select name="brands[]" class="form-control text-dark" multiple="">
                        @foreach($brands as $brand)
                            <option value="{{ $brand['id'] }}" @if(in_array($brand['id'],$selBrands)) selected="" @endif>{{ $brand['nombre'] }}</option>
                        @endforeach
                      </select>
                    </div>     
                    <div class="form-group">
                      <label for="users">Selecionar la Usuario</label>
                      <select name="users[]" class="form-control text-dark" multiple="">
                        @foreach($users as $user)
                            <option value="{{ $user['email'] }}" @if(in_array($user['email'],$selUsers)) selected="" @endif>{{ $user['email'] }}</option>
                        @endforeach
                      </select>
                    </div>   
                    <div class="form-group">
                      <label for="fecha_caducidad">Fecha de Vencimiento</label>
                      <input type="date" class="form-control" id="fecha_caducidad" placeholder="Ingrese la fecha del vencimiento" name="fecha_caducidad" @if(isset($coupon['fecha_caducidad'])) value="{{ $coupon['fecha_caducidad'] }}" @else value="{{ old('fecha_caducidad') }}"  @endif>
                    </div>   
                    <button type="submit" class="btn btn-primary mr-2">Guardar</button>
                    <button type="button" class="btn btn-light" onclick="this.form.reset(); window.location.href='{{ url('admin/coupons') }}';">
                        Cancelar
                    </button>
                  </form>
                </div>
              </div>
            </div>
            
        </div>
        

    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>
@endsection