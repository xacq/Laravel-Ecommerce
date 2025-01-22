<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <table>
        <tr><td>Hola {{ $nombre }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Se le solicita que cambie su contraseña. La nueva contraseña es la siguiente: </td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Email: {{ $email }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Contraseña: {{ $password }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Gracias & Saludos</td></tr>
    </table>
</body>
</html>