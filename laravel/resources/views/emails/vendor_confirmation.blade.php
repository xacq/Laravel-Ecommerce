<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <tr><td>Hola {{ $nombre }}! </td></tr>
    <tr><td>&nbsp;<br></td></tr>
    <tr><td>Por favor haga clic en el enlace para confirmar su cuenta de vendedor</td></tr>
    <tr><td><a href="{{ url('vendor/confirm/'.$code) }}">{{ url('vendor/confirm/'.$code) }}</a></td></tr>
    <tr><td>&nbsp;<br></td></tr>
    <tr><td>Gracias & Saludos,</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>UTA</td></tr>
</body>
</html>