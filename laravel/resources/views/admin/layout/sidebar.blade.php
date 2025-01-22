<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a @if(Session::get('page')=="dashboard") style="background:#4B49AC !important; color: #fff !important;" @endif class="nav-link" href="{{ url('admin/dashboard') }}">
            <i class="icon-grid menu-icon"></i>
            <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @if(Auth::guard('admin')->user()->tipo=="vendedor")
        <li class="nav-item">
            <a @if(Session::get('page')=="update_vendor_password") style="background: #4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-settings" aria-expanded="false" aria-controls="ui-settings">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Configuración</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-settings">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="update_vendor_password") style="background:#4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url ('admin/update-vendor-password') }}">Cambiar Contraseña</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="update_personal_details" || Session::get('page')=="update_business_details" || Session::get('page')=="update_bank_details") style="background: #4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-vendors" aria-expanded="false" aria-controls="ui-vendors">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Datos Vendedor</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-vendors">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="update_personal_details") style="background:#4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url ('admin/update-vendor-details/personal') }}">Datos Personales</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="update_business_details") style="background:#4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url ('admin/update-vendor-details/business') }}">Datos Comercial</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="update_bank_details") style="background:#4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url ('admin/update-vendor-details/bank') }}">Datos Bancarios</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="sections" || Session::get('page')=="categories" || Session::get('page')=="brands" || Session::get('page')=="products"|| Session::get('page')=="filters") style="background: #4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-catalogue" aria-expanded="false" aria-controls="ui-catalogue">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Catálogo</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-catalogue">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="products") style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/products') }}">Productos</a></li>
                    <!-- <li class="nav-item"> <a @if(Session::get('page')=="coupons") style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/coupons') }}">Cupones</a></li> -->
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="orders") style="background: #4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-orders" aria-expanded="false" aria-controls="ui-orders">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Gestión Pedidos</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-orders">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="orders") style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/orders') }}">Pedidos</a></li>
                </ul>
            </div>
        </li>
        @else
        <li class="nav-item">
            <a @if(Session::get('page')=="update_admin_password" || Session::get('page')=="update_admin_details") style="background: #4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-settings" aria-expanded="false" aria-controls="ui-settings">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Configuración</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-settings">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="update_admin_password") style="background:#4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url ('admin/update-admin-password') }}">Cambiar Contraseña</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="update_admin_details") style="background:#4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url ('admin/update-admin-details') }}">Cambiar Detalles</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="view_admins" || Session::get('page')=="view_subadmins" || Session::get('page')=="view_vendors" || Session::get('page')=="view_all") style="background: #4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-admins" aria-expanded="false" aria-controls="ui-admins">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Gestión Admin</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-admins">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="view_admins") style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/admins/superadmin') }}">Administradores</a></li>
                    <!-- <li class="nav-item"> <a @if(Session::get('page')=="view_subadmins") style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/admins/subadministrador') }}">Sub Adminitrador</a></li> -->
                    <li class="nav-item"> <a @if(Session::get('page')=="view_vendors") style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/admins/vendedor') }}">Vendedores</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="view_all") style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/admins') }}">Todos</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="sections" || Session::get('page')=="categories" || Session::get('page')=="brands" || Session::get('page')=="products"|| Session::get('page')=="filters" || Session::get('page')=="coupons") style="background: #4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-catalogue" aria-expanded="false" aria-controls="ui-catalogue">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Catálogo</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-catalogue">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="sections") style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/sections') }}">Sección</a></li>                   
                    <li class="nav-item"> <a @if(Session::get('page')=="categories") style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/categories') }}">Categorías</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="brands") style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/brands') }}">Marcas</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="products") style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/products') }}">Productos</a></li>
                    <!-- <li class="nav-item"> <a @if(Session::get('page')=="coupons") style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/coupons') }}">Cupones</a></li> -->
                    <li class="nav-item"> <a @if(Session::get('page')=="filters") style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/filters') }}">Filtros</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="orders") style="background: #4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-orders" aria-expanded="false" aria-controls="ui-orders">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Gestión Pedidos</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-orders">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="orders") style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/orders') }}">Pedidos</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="ratings") style="background: #4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-ratings" aria-expanded="false" aria-controls="ui-ratings">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Clasificaciones</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-ratings">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="ratings") style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/ratings') }}">Clasificación</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="users" || Session::get('page')=="subscribers") style="background: #4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-users" aria-expanded="false" aria-controls="ui-users">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Usuarios</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-users">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="users") style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/users') }}">Usuarios</a></li>
                    <li class="nav-item"> <a @if(Session::get('page')=="subscribers") style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/subscribers') }}">Suscripciones</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="banners") style="background: #4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-banners" aria-expanded="false" aria-controls="ui-banners">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Gestión Banners</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-banners">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="banners") style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/banners') }}">Pancartas</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a @if(Session::get('page')=="shipping") style="background: #4B49AC !important; color: #fff !important;" @endif class="nav-link" data-toggle="collapse" href="#ui-shipping" aria-expanded="false" aria-controls="ui-shipping">
            <i class="icon-layout menu-icon"></i>
            <span class="menu-title">Gestión Envios</span>
            <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-shipping">
                <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                    <li class="nav-item"> <a @if(Session::get('page')=="shipping") style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC !important;" @endif class="nav-link" href="{{ url('admin/shipping-charges') }}">Cargos de Envío</a></li>
                </ul>
            </div>
        </li>
        @endif
    </ul>
</nav>