<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Notificacion de Evaluacion</title>
    <style>
        footer{
            padding: 10px;
            margin-top: 100px;
            background-color:black;
            color: white;
            text-align: center;
        }

    </style>
</head>
<body>
    <p>Estimado <b>{{ $dataEvaluador->nameEvaluador}}</b>! Le invitamos para que gestione ante esta plataforma la evaluacion de las competencias de:</p>
     de <strong>{{ $dataEvaluador->nameEvaluado }} </strong> en la cual usted cumple un rol de : {{ $dataEvaluador->relation}}
     <p>En el siguiente link podra acceder directamente al cuestionario para que evalue las competencias de su evaluado</p>
    <ul>
        <li>
            <a href="{{ $dataEvaluador->linkweb}}">
                Acceda directamente a la evaluacion pulsado en este enlace web
            </a>
        </li>

    </ul>
    <footer>
        Sistema de Evaluacion de Competencias del <strong>Talent 360</strong>
    </footer>
</body>
</html>
