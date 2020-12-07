<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
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
