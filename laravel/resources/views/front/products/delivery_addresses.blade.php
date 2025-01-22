<!-- Form-Fields /- -->
<h4 class="section-h4 deliveryText">Agregar nueva dirección de entrega</h4>
<div class="u-s-m-b-24">
    <input type="checkbox" class="check-box" id="ship-to-different-address" data-toggle="collapse" data-target="#showdifferent">
    @if(count($deliveryAddresses)>0)
        <label class="label-text newAddress" for="ship-to-different-address">Ship to a different address?</label>
    
    @else
        <label class="label-text newAddress" for="ship-to-different-address">Marque para agregar la dirección de entrega</label>
    
    @endif
    </div>
<div class="collapse" id="showdifferent">
    <!-- Form-Fields -->
    <form id="addressEditForm" action="javascript:;"  method="post">@csrf
        <input type="hidden" name="delivery_id">
        <div class="group-inline u-s-m-b-13">
            <div class="group-1 u-s-p-r-16">
                <label for="first-name-extra">Nombre
                    <span class="astk">*</span>
                </label>
                <input type="text" name="delivery_nombre" id="delivery_nombre" class="text-field">
                <p id="delivery-delivery_nombre"></p>
            </div>
            <div class="group-2">
                <label for="last-name-extra">Dirección
                    <span class="astk">*</span>
                </label>
                <input type="text" name="delivery_direccion" id="delivery_direccion" class="text-field">
                <p id="delivery-delivery_direccion"></p>
            </div>
        </div>
        <div class="group-inline u-s-m-b-13">
            <div class="group-1 u-s-p-r-16">
                <label for="first-name-extra">Ciudad
                    <span class="astk">*</span>
                </label>
                <input type="text" name="delivery_ciudad" id="delivery_ciudad" class="text-field">
                <p id="delivery-delivery_ciudad"></p>
            </div>
            <div class="group-2">
                <label for="last-name-extra">Parroquia
                    <span class="astk">*</span>
                </label>
                <input type="text" name="delivery_estado" id="delivery_estado" class="text-field">
                <p id="delivery-delivery_estado"></p>
            </div>
        </div>
        <div class="u-s-m-b-13">
            <label for="select-country-extra">Pais
                <span class="astk">*</span>
            </label>
            <div class="select-box-wrapper">
                <select class="select-box" id="delivery_pais" name="delivery_pais">
                        <option value="">Seleccionar Pais</option>
                    @foreach($countries as $country)
                        <option value="{{ $country['country_name'] }}" @if($country['country_name']==Auth::user()->pais) selected @endif>{{ $country['country_name'] }}</option>
                    @endforeach
                </select>
                <p id="delivery-delivery_pais"></p>
            </div>
        </div>
        <div class="street-address u-s-m-b-13">
            <label for="delivery_pincodigo">Cédula
                <span class="astk">*</span>
            </label>
            <input type="text" id="delivery_pincodigo" name="delivery_pincodigo" class="text-field"  maxlength="10"> 
            <p id="delivery-delivery_pincodigo"></p>
        </div>
        <div class="u-s-m-b-13">
            <label for="delivery_celular">Celular
                <span class="astk">*</span>
            </label>
            <input type="text" id="delivery_celular" name="delivery_celular" class="text-field"  maxlength="10">
            <p id="delivery-delivery_celular"></p>
        </div>
        <div class="u-s-m-b-13">
            <button style="width:100%;" type="submit" class="button button-outline-secondary">Guardar</button>
        </div>
    </form>
    <!-- Form-Fields /- -->
</div>
<!-- <div>
    <label for="order-notes">Order Notes</label>
    <textarea class="text-area" id="order-notes" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
</div> -->