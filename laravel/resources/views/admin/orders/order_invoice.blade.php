<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2>Invoice</h2><h3 class="pull-right">Pedido # {{ $orderDetails['id'] }}
                    <?php echo DNS1D::getBarcodeHTML($orderDetails['id'], 'C39'); ?>
                </h3>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Facturado a:</strong><br>
    					{{ $userDetails['name'] }}<br>
                        @if(!empty($userDetails['direccion']))
    					    {{ $userDetails['direccion'] }}<br>
                        @endif
                        @if(!empty($userDetails['ciudad']))
    					    {{ $userDetails['ciudad'] }}<br>
                        @endif
                        @if(!empty($userDetails['estado']))
    					    {{ $userDetails['estado'] }}<br>
                        @endif
                        @if(!empty($userDetails['pais']))
    					    {{ $userDetails['pais'] }}<br>
                        @endif
                        @if(!empty($userDetails['pincodigo']))
    					    {{ $userDetails['pincodigo'] }}<br>
                        @endif
    					    {{ $userDetails['celular'] }}<br>
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			<strong>Facturado a:</strong><br>
                        {{ $orderDetails['nombre'] }}<br>
    					{{ $orderDetails['direccion'] }}<br>
    					{{ $orderDetails['ciudad'] }}, {{ $orderDetails['estado'] }}<br>
                        {{ $orderDetails['pais'] }}{{ - $orderDetails['pincodigo'] }}<br>
    					{{ $orderDetails['celular'] }}<br>
    				</address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Payment Method:</strong><br>
    					{{ $orderDetails['payment_method'] }}
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Order Date:</strong><br>
    					{{ date('Y-m-d h:i:s', strtotime($orderDetails['created_at'])); }} <br> <br>
    				</address>
    			</div>
    		</div>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Order summary</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Código del Producto</strong></td>
        							<td class="text-center"><strong>Tamaño</strong></td>
        							<td class="text-center"><strong>Color</strong></td>
        							<td class="text-center"><strong>Precio</strong></td>
        							<td class="text-center"><strong>Cantidad</strong></td>
        							<td class="text-right"><strong>Total</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
                                 @php $subTotal = 0 @endphp
    							@foreach($orderDetails['orders_products'] as $product)
                                <tr>
    								<td>{{ $product['producto_codigo'] }} <?php echo DNS1D::getBarcodeHTML($product['producto_codigo'], 'C39'); ?></td>
    								<td class="text-center">{{ $product['producto_tamano'] }}</td>
    								<td class="text-center">{{ $product['producto_color'] }}</td>
    								<td class="text-center">$ {{ $product['producto_precio'] }}</td>
    								<td class="text-center">{{ $product['producto_qty'] }}</td>
    								<td class="text-right">$ {{ $product['producto_precio'] * $product['producto_qty'] }}</td>
    							</tr>
                                @php $subTotal = $subTotal + ($product['producto_precio'] * $product['producto_qty']) @endphp
                                @endforeach
                                
    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-right"><strong>Subtotal</strong></td>
    								<td class="thick-line text-right">$ {{ $subTotal }}</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>Gastos de Envío</strong></td>
    								<td class="no-line text-right">$ {{ $orderDetails['shipping_charges'] }}</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-right"><strong>Total General</strong></td>
    								<td class="no-line text-right"><strong>$ {{ $orderDetails['total_general'] }}</strong><br>
                                        @if($orderDetails['payment_method']=="COD")
                                            <font color="red">(Ya pagado)</font> 
                                        @endif
                                    </td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>