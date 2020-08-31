@extends('layout')

@section('title',"Vision 360")

@section('content')

<div class="container">

    <div class="card mb-2 vision360">

        <div class="card-header text-center titulo360">
            SISTEMA DE VISION 360&#176;<span><i class="material-icons">360</i></span></i>
        </div>
        <div class="card-body ">
            <h5 class="card-title text-center">GESTION POR COMPETENCIAS VISION 360&#176; </h5>
            <p class="card-text">Significa tomar en cuenta que los conocimientos, habilidades, experiencias y cualidades personales influyen en el rendimiento de las personas y aplicar esto, de manera sistemática y sistémica para conseguir los mejores resultados de la empresa y la mayor orientación profesional al empleado.</p>
            <p class="card-text">Una competencia es la capacidad desarrollada, demostrada y utilizada con el verdadero grado de dominio y responsabilidad para realizar las tareas o actividades requeridas para desempeñar un puesto de trabajo eficazmente.
                Para valorar el desempeño por competencias, la organización define cuales son las competencias relacionadas con los puestos de trabajo. Estas son fijadas por área o nivel de posición (Unidades de negocio) y técnicas o ocupacionales.
            </p>
            <div class="text-center">
                <a  href="{{ route('lanzar.index') }}" class="btn btn-dark">  Vamos a Lanzar una evaluacion </a>

            </div>

        </div>

    </div>

    <section>
        <div class="row">
            <div class="col-sm-4">
                <div class="card text-center">

                    <div class="card-header subtitulo90">
                    VISION 90&#176;
                    </div>
                    <div class="card-body">
                    <h5 class="card-title">Sistema de Vision 90&#176;</h5>
                    <p class="card-text">Es cuando el empleado es evaluado por su supervisor y el supervisor de su supervisor.</p>
                    </div>

                    <div class="card-footer text-muted">
                        <i class="material-icons">people_alt</i>
                    </div>
                </div>

            </div>
            <div class="col-sm-4">
                <div class="card text-center">
                    <div class="card-header subtitulo180">
                    VISION 180&#176;
                    </div>
                    <div class="card-body">
                    <h5 class="card-title">Sistema de Vision 180&#176;</h5>
                    <p class="card-text">Es cuando el empleado es evaluado por su jefe, los pares y eventualmente los clientes.</p>
                    </div>
                    <div class="card-footer text-muted">
                        <i class="material-icons">people_alt group_add </i>
                    </div>
                </div>

            </div>
            <div class="col-sm-4">
                <div class="card text-center">
                    <div class="card-header subtitulo360">
                    VISION 360 &#176;
                    </div>
                    <div class="card-body">
                    <h5 class="card-title">Sistema de Vision 360&#176</h5>
                    <p class="card-text">Es cuando el empleado es evaluado por todo el entorno laboral, su jefe, los pares, los subordinados y la autoevaluacion(yo).</p>
                    </div>
                    <div class="card-footer text-muted">
                        <i class="material-icons">people_alt  360</i>
                    </div>
                </div>

            </div>

        </div>
        <div class="row text text-center pt-5">

            <img src="logo/flujogeneral.png" style="width: 1ex;" alt="flujo">

        </div>

    </section>

</div>

@endsection
