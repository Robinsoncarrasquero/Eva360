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
    <p>Estimado Administrador le informamos que la evaluacion de <strong>{{ $dataEvaluador->nameEvaluado }} </strong> ha finalizado.</p>
    <p>Loss resultados estan disponibles en el siguiente link.</p>
    <ul>
        <li>
            <a href="{{ $dataEvaluador->linkweb}}">
                Acceda directamente a la evaluacion pulsado en este enlace web.
            </a>
        </li>

    </ul>
    <footer>
        Sistema de Evaluacion de Desempe&ntilde;o por Competencias <strong>TALENT360</strong>
    </footer>

</body>
</html>
