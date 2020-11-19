@extends('layout')

@section('title',"Vision 360")

@section('content')

<div class="container">

    {{-- <div class="cajaimagen1200 mt-2 ">
        <img class="img-fluid" src="{{asset('images/AdobeStock_340828216.jpeg') }}"  alt="Equipo 360">
    </div> --}}


    <div class="card mt-2 mb-2 vision360">

        <div class="card-header text-center titulo360">
            Modelo de Gestion Por Competencias TALENT 360&#176;<span><i class="material-icons">360</i></span></i>
        </div>
        <div class="card-body text-center ">
            <div class="d-flex justify-content-between">
                <p class="title-modelo">El modelo de gestión por competencias busca alinear los talentos y habilidades de los colaboradores con la visión y el objetivo de la empresa, partiendo de la idea de identificar el perfil perfecto del colaborador para un cargo específico y, en base a ello, crear una dinámica de reclutamiento y capacitación.
                    Sin duda, se trata un punto clave para el éxito de muchas empresas, pues es capaz de identificar las mejores habilidades de un colaborador para después potencializarlas para el beneficio de la organización.
                </p>
           </div>
            <div class="cajaimagen600">
                <img class="img-fluid" src="{{asset('images/candidatos.png') }}"  alt="Evaluacion 180 grados">
            </div>

        </div>
        <div class="d-flex justify-content-center">
            <a  href="{{ route('lanzar.index') }}" class="btn btn-dark">  Vamos a Lanzar una evaluacion </a>

        </div>

    </div>

    <section>
        <div class="row d-flex justify-content-between">
            <div class="col-sm-12 col-md-4 mt-3 p-2">
                <div class="card text-center">
                    <div class="card-header subtitulo90">
                    TALENT 90&#176;
                    </div>
                    <div class="card-body ">
                        <p class="title-modelo">El empleado es evaluado por su supervisor y el supervisor de su supervisor.</p>
                    </div>
                    <div class="cajaimagen300">
                        <img class="img-fluid" src="{{asset('images/comunicacion.png') }}"  alt="Evaluacion 180 grados">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 mt-3 p-2">
                <div class="card text-center">
                    <div class="card-header subtitulo180">
                    TALENT 180&#176;
                    </div>
                    <div class="card-body">
                    <p class="card-text modelo-180">El empleado es evaluado por su jefe, sus pares y clientes en ausencia de pares.</p>
                    </div>
                    {{-- <div class="card-footer text-muted">
                        <i class="material-icons">people_alt group_add </i>
                    </div> --}}
                    <div class="cajaimagen300">
                        <img class="img-fluid" src="{{asset('images/colaboracion.png') }}"  alt="Evaluacion 360 grados">
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 mt-3 p-2 ">
                <div class="card text-center">
                    <div class="card-header subtitulo360">
                    TALENT 360 &#176;
                    </div>
                    <div class="card-body modelo-360">
                    <p class="card-text">El empleado es evaluado por su entorno laboral; jefe, pares, subordinados y la autoevaluacion (yo).</p>
                    </div>
                    {{-- <div class="card-footer text-muted">
                        <i class="material-icons">people_alt  360</i>
                    </div> --}}
                    <div class="cajaimagen300">
                        <img class="img-fluid" src="{{asset('images/grupo.png') }}"  alt="Evaluacion 90 grados">
                    </div>
                </div>
            </div>
        </div>
</div>

@endsection
