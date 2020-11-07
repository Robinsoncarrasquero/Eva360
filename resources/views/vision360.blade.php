@extends('layout')

@section('title',"Vision 360")

@section('content')

<div class="container">

    <div class="card mb-2 vision360">

        <div class="card-header text-center titulo360">
            GESTION POR COMPETENCIAS TALENT 360&#176;<span><i class="material-icons">360</i></span></i>
        </div>
        <div class="card-body ">
            {{-- <p class="card-text">Significa tomar en cuenta que los conocimientos, habilidades, experiencias y cualidades personales influyen en el rendimiento de las personas y aplicar esto, de manera sistemática y sistémica para conseguir los mejores resultados de la empresa y la mayor orientación profesional al empleado.</p>
            <p class="card-text">Una competencia es la capacidad desarrollada, demostrada y utilizada con el verdadero grado de dominio y responsabilidad para realizar las tareas o actividades requeridas para desempeñar un puesto de trabajo eficazmente.
                Para valorar el desempeño por competencias, la organización define cuales son las competencias relacionadas con los puestos de trabajo. Estas son fijadas por área o nivel de posición (Unidades de negocio) y técnicas o ocupacionales.
            </p> --}}
            <p class="title-modelo">El modelo de gestión por competencias busca alinear los talentos y habilidades de los colaboradores con la visión y el objetivo de la empresa, partiendo de la idea de identificar el perfil perfecto del colaborador para un cargo específico y, en base a ello, crear una dinámica de reclutamiento y capacitación.
                Sin duda, se trata un punto clave para el éxito de muchas empresas, pues es capaz de identificar las mejores habilidades de un colaborador para después potencializarlas para el beneficio de la organización.
                </p>
            <div class="text-center">
                <a  href="{{ route('lanzar.index') }}" class="btn btn-dark">  Vamos a Lanzar una evaluacion </a>

            </div>

        </div>

    </div>

    <section>
        <div class="row">
            <div class="col-sm-4 mt-1">
                <div class="card text-center">

                    <div class="card-header subtitulo90">
                    TALENT 90&#176;
                    </div>
                    <div class="card-body ">
                    <p class="card-text modelo-90">Es cuando el empleado es evaluado por su supervisor y el supervisor de su supervisor.</p>
                    </div>

                    <div class="card-footer text-muted">
                        <i class="material-icons">people_alt</i>
                    </div>
                </div>

            </div>
            <div class="col-sm-4 mt-1">
                <div class="card text-center">
                    <div class="card-header subtitulo180">
                    TALENT 180&#176;
                    </div>
                    <div class="card-body">
                    <p class="card-text modelo-180">Es cuando el empleado es evaluado por su jefe, los pares y eventualmente los clientes.</p>
                    </div>
                    <div class="card-footer text-muted">
                        <i class="material-icons">people_alt group_add </i>
                    </div>
                </div>

            </div>
            <div class="col-sm-4 mt-1">
                <div class="card text-center">
                    <div class="card-header subtitulo360">
                    TALENT 360 &#176;
                    </div>
                    <div class="card-body modelo-360">
                    <p class="card-text">Es cuando el empleado es evaluado por todo el entorno laboral, jefe, pares, subordinados y autoevaluacion(yo).</p>
                    </div>
                    <div class="card-footer text-muted">
                        <i class="material-icons">people_alt  360</i>
                    </div>
                </div>

            </div>

        </div>

    </section>

</div>

@endsection
