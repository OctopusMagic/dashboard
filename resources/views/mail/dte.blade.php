<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Documento Tributario Electrónico</title>
</head>

<body>
    <p>Estimado(a) {{$receptor}},</p>
    <p>
        Adjunto encontrará su documento tributario electrónico:<br><br>
        <strong>Código de Generación:</strong> {{$codGeneracion}}<br>
        <strong>Número de Control:</strong> {{$numeroControl}}<br>
        <strong>Sello de Recepción:</strong> {{$selloRecibido}}<br>
        <strong>Fecha de Procesamiento:</strong> {{\Carbon\Carbon::parse($fhProcesamiento)->format('d-m-Y H:i:s')}}<br>
        <strong>Estado:</strong> {{$estado}}<br>
    </p>
</body>

</html>
