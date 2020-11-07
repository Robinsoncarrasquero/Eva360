<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Notificacion de Finalizacion de Evaluacion</title>
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
    <p>Estimado Administrador le informamos que la evaluacion de <strong>{{ $dataEvaluador->nameEvaluado }} </strong> ha finalizado, lo cual ya puede revisar los resultados
     de los evaluadores</p>
    <p>En el siguiente link podra acceder al formulario con los resultados finales de la respectiva Evaluacion.</p>
    <ul>
        <li>
            <a href="{{ $dataEvaluador->linkweb}}">
                Acceda directamente a la evaluacion pulsado en este enlace web.
            </a>
        </li>

    </ul>
    <footer>
        Sistema de Evaluacion de Competencias del <strong>Talent 360</strong>
    </footer>

</body>
</html>
