<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formunica-Solicitudes</title>
</head>
<body>
    Formunica Solicitud de Pago

    <table class="table table-sm">
    <thead>
        <tr>
            <th>Statistics</th>
            <th>#1</th>
            <th>#2</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td># Solicitud</td>
            @foreach($solicitudes as $solicitud)
            <td>{{ $solicitud->IdSolicitud }}</td>
            @endforeach
        </tr>
        <tr>
            <td>Centro de Costo</td>
            @foreach($solicitudes as $solicitud)
            <td>{{ $solicitud->CENTRO_COSTO }}</td>
            @endforeach
        </tr>
    </tbody>
</table>

</body>
</html>
