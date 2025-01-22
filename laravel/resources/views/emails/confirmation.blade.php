<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <table>
        <tr><td>Hola {{ $name }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Por favor haga clic en el enlace para activar tu cuenta: </td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td><a href="{{ url('/user/confirm/'.$code) }}">Confirmar la Cuenta</a></td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Gracias & Saludos</td></tr>
    </table>
</body>
</html>