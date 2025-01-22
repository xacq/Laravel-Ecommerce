<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table style="width:700px;">
        <tr><td>&nbsp;</td></tr>
        <tr><td><img src="{{ asset('front/images/main-logo/stack-developers-logo.png') }}" alt="Ambato Shop Imagen"></td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Hola {{ $nombre }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>El estado de su pedido #{{ $order_id }} se ha actualizado a {{ $order_status }}:</td></tr>
        <tr><td>&nbsp;</td></tr>
        @if(!empty($nombre_mensajero) && !empty($numero_rastreo))
        <tr><td>
            Nombre del Mensajero es: {{ $nombre_mensajero }} y su celular es: {{ $numero_rastreo }}
        </td></tr>
        <tr><td>&nbsp;</td></tr>
        @endif
        <tr><td>&nbsp;</td></tr>
        <tr><td>Detalles de su Pedido: </td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>
            <table style="width:95%;" cellpadding="5" cellspacing="5" bgcolor="#f7f4f4">
                <tr bgcolor="#ccc">
                    <td>Nombre del Producto</td>
                    <td>Código del Producto</td>
                    <td>Tamaño del Producto</td>
                    <td>Color del Producto</td>
                    <td>Cantidad</td>
                    <td>Precio del Producto</td>
                </tr>
                @foreach($orderDetails['orders_products'] as $order)
                <tr bgcolor="#f9f9f9">
                    <td>{{ $order['producto_nombre'] }}</td>
                    <td>{{ $order['producto_codigo'] }}</td>
                    <td>{{ $order['producto_tamano'] }}</td>
                    <td>{{ $order['producto_color'] }}</td>
                    <td>{{ $order['producto_qty'] }}</td>
                    <td>$ {{ $order['producto_precio'] }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5" align="right">Gastos de envio</td>
                    <td>$ {{ $orderDetails['shipping_charges'] }}</td>
                </tr>
                <tr>
                    <td colspan="5" align="right">Cupón de descuento</td>
                    <td>$
                        @if($orderDetails['cupon_amount']>0)
                            {{ $orderDetails['cupon_amount'] }}
                        @else
                            0
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="5" align="right">Total General</td>
                    <td>$ {{ $orderDetails['total_general'] }}</td>
                </tr>
            </table>
        </td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>
                <table>
                    <tr>
                        <td><strong>Dirección de entrega</strong></td>
                    </tr>
                    <tr>
                        <td>{{ $orderDetails['nombre'] }}</td>
                    </tr>
                    <tr>
                        <td>{{ $orderDetails['direccion'] }}</td>
                    </tr>
                    <tr>
                        <td>{{ $orderDetails['ciudad'] }}</td>
                    </tr>
                    <tr>
                        <td>{{ $orderDetails['estado'] }}</td>
                    </tr>
                    <tr>
                        <td>{{ $orderDetails['pais'] }}</td>
                    </tr>
                    <tr>
                        <td>{{ $orderDetails['pincodigo'] }}</td>
                    </tr>
                    <tr>
                        <td>{{ $orderDetails['celular'] }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Para cualquier consulta, puede ponerse en contacto con nosotros en <a href="mailto:kevinmasabanda2c@gmail.com">kevinmasabanda2c@gmail.com</a></td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>SALUDOS....!</td></tr>
        <tr><td>&nbsp;</td></tr>
    </table>
</body>
</html>
