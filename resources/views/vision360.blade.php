@extends('layout')

@section('title',"Vision 360")

@section('content')

<div class="container">

    <div class="card text-center mb-5">

        <div class="card-header">
            SISTEMA DE VISION 360
        </div>
        <div class="card-body">
             <h5 class="card-title">GESTION POR COMPETENCIAS VISION 360</h5>
            <p class="card-text">Significa tomar en cuenta que los conocimientos, habilidades, experiencias y cualidades personales influyen en el rendimiento de las personas y aplicar esto, de manera sistemática y sistémica para conseguir los mejores resultados de la empresa y la mayor orientación profesional al empleado.</p>
            <p class="card-text">Una competencia es la capacidad desarrollada, demostrada y utilizada con el verdadero grado de dominio y responsabilidad para realizar las tareas o actividades requeridas para desempeñar un puesto de trabajo eficazmente.
                Para valorar el desempeño por competencias, la organización define cuales son las competencias relacionadas con los puestos de trabajo. Estas son fijadas por área o nivel de posición (Unidades de negocio) y técnicas o ocupacionales)
            </p>
            <a href="{{ route('lanzar.index') }}" class="btn btn-success">Vamos a Lanzar una evaluacion</a>
        </div>

    </div>

    <section>
        <div class="row">
            <div class="col-sm-4">
                <div class="card text-center">
                    <div class="card-header">
                    VISION 90
                    </div>
                    <div class="card-body">
                    <h5 class="card-title">Sistema de Vision 90</h5>
                    <p class="card-text">Es cuando la persona es evaluada por su supervisor y el supervisor de su supervisor.</p>
                    </div>
                    <div class="card-footer text-muted">
                    </div>
                </div>

            </div>
            <div class="col-sm-4">
                <div class="card text-center">
                    <div class="card-header">
                    VISION 180
                    </div>
                    <div class="card-body">
                    <h5 class="card-title">Sistema de Vision 180</h5>
                    <p class="card-text">Es cuando el empleado es evaluado por su jefe, los pares y eventualmente los clientes internos.</p>
                    </div>
                    <div class="card-footer text-muted">
                    </div>
                </div>

            </div>
            <div class="col-sm-4">
                <div class="card text-center">
                    <div class="card-header">
                    VISION 360
                    </div>
                    <div class="card-body">
                    <h5 class="card-title">Sistema de Vision 360</h5>
                    <p class="card-text">Es cuando el empleado es evaluado por todo el entorno; jefes, pares, subordinados, autoevaluacion.</p>
                    </div>
                    <div class="card-footer text-muted">
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
