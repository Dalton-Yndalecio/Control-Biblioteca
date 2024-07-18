<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>REPORTES PDF PRESTAMOS</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Personas</th>
                <th>objetos</th>
                <th>fecha salida</th>
                <th>Estado Prestamo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reporte['prestamos'] as $prestamo)
            <tr>
                <td>{{ $reporte['personas']->where('id', $prestamo->idpersona)->first()->nombre }} {{ $reporte['personas']->where('id', $prestamo->idpersona)->first()->apellidos }}</td>
                <td>
                    <table>
                        <thead>
                            <tr>
                                <th>Objetos</th>
                                <th>signatura</th>
                                <th>cantidad</th>
                                <th>estado objeto</th>
                                <th>fecha retrono</th>
                                <th>fecha entrega</th>
                                <th>esatdo prestamo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reporte['detalles']->where('Id_prestamo', $prestamo->id) as $detalle)
                                <tr>
                                    <td>
                                        {{ $reporte['objetos']->where('id', $detalle->Id_objeto)->first()->Nombre }}
                                    </td>
                                    <td>
                                        {{ $reporte['objetos']->where('id', $detalle->Id_objeto)->first()->Signatura }}
                                    </td>
                                    <td>{{ $detalle->cantidad }}</td>
                                    <td>{{ $detalle->OEstado }}</td>
                                    <td>{{ $detalle->FRetorno }}</td>
                                    <td>{{ $detalle->FEntrega }}</td>
                                    <td>{{ $detalle->PEstado }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
                <td>
                    {{ $prestamo->FSalida }}
                </td>
                <td>
                    {{ $prestamo->EstadoP }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>