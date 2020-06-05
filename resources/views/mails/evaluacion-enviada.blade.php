<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Notificacion de Evaluacion</title>
</head>
<body>
    <p>Estimado Evaluador {{ $dataEvaluador->evaluadorName }}! Le enviamos la siguiente comunicacion en fecha {{ $dataEvaluador->created_at }}.</p>
    <p>Para que gestione ante esta plataforma la evaluacion de las competencias de:</p>
    <ul>
        <li>Nombre: {{ $dataEvaluador->name }}</li>
        <li>Relation: {{ $dataEvaluador->relation}}</li>
    </ul>
    <p>En el siguiente link podra acceder al cuestionario para responder el cuestionario web sobre las competencias a evaluar></p>
    <ul>
        <li>
            <a href="{{ $dataEvaluador->siteweb }}">
                Direccion web directamente al sitio con este token : {{ $dataEvaluador->token }}
            </a>
        </li>
    </ul>
</body>
</html>
