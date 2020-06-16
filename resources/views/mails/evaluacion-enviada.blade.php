<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Notificacion de Evaluacion</title>
</head>
<body>
    <p>Estimado <b>{{ $dataEvaluador->nameEvaluador}}</b>! Le enviamos la siguiente comunicacion,
     para que gestione ante esta plataforma la evaluacion de las competencias de:</p>
    <ul>
        <li>Nombre: <strong>{{ $dataEvaluador->nameEvaluado }} </strong></li>
        <li>Relation: {{ $dataEvaluador->relation}}</li>
    </ul>
    <p>En el siguiente link podra acceder al cuestionario para que evalue las competencias relacionadas</p>
    <ul>
        <li>
            <a href="{{ $dataEvaluador->linkweb}}">
                Acceda directamente a la evaluacion pulsado en este enlace web
            </a>
        </li>

    </ul>
</body>
</html>
