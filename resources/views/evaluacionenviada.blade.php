<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Notificacion de Evaluacion</title>
</head>
<body>
    <p>Estimado evaluador <span>{{ $evaluadorName }}!</span> Le enviamos la siguiente comunicacion,
    para que gestione ante esta plataforma la evaluacion de las competencias de:</p>
    <ul>
        <li>Nombre: {{ $evaluadoName }}</li>
        <li>Relation: {{ $relation}}</li>
    </ul>
    <p>En el siguiente link podra acceder al cuestionario para responder el cuestionario web sobre las competencias a evaluar></p>
    <ul>
        <li>
            <a href="{{ $siteweb }}">
                Direccion web directamente al sitio con este token : {{ $token }}
            </a>
        </li>
    </ul>
</body>
</html>
