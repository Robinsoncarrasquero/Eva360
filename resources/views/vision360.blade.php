@extends('master')

@section('title','Talent 360')

@section('content')

<div class="container">

    {{-- <div class="cajaimagen1200 mt-2 ">
        <img class="img-fluid" src="{{asset('images/AdobeStock_340828216.jpeg') }}"  alt="Equipo 360">
    </div> --}}

    <div class="mt-2 pb-2">
        {{-- <div class="text text-center">
            <h3 class="btn btn-lg" style="background-color:brown; color:white; font-size:1.2rem">Evaluacion Virtual de Desempeño por Competencias</h3>
        </div> --}}
        {{-- <p>
            La <strong>Evaluacion Virtual</strong> es una facilidad disponible para que una persona experimente mediante la <strong class="text text-dark">Auto Evaluacion</strong>,
            en nuestro sistema <strong class="text text-warning">HRFeedBack360</strong>, con un proceso sencillo, intuitivo y rápido.
            Como funciona? <strong class="text text-warning">HRFeedBack360</strong> creará Evaluadores Virtuales(EV) <strong>(Supervisor, Pares, Colaboradores y Clientes)</strong>
            , segun un método de evaluación. El método 90(2 EV); El método 180(4 EV); El método 270(6 EV); El método 360(8 EV).
            Los EV responderan el cuestionario mediante un robot <span class="material-icons bg-success" style="" >android</span>
            que reaccionará automáticamente.
            Si la prueba no es finalizada durante 10 minutos el Robot responderá la Auto Evaluacion y notificará la finalización.
        </p> --}}

        <div class="d-flex justify-content-center">
            <span><a href=" {{url("https://hr.fb360.cf/simulador/autoevaluacion")}}" class="btn btn-dark btn-lg">Probar Auto Evaluacion Virtual</a></span>
        </div>


    </div>
    <div class="card-header text-center xtitulo360 " style="background-color:brown; color:white; font-size:1.2rem">
        Diccionario de Evaluacion de Desempeño Por Competencias<span><i class="material-icons">360</i></span></i>
    </div>

    <div class="card-columns ">
        @foreach($competencias as $competencia)
        <div class="card mt-4 pb-2  @if($competencia->seleccionmultiple) border-success @else border-danger @endif">

            <div class="card-body">

                <div class="circle" style="background-color:{{ Color::getBGColor()}};color:white;fontsize:1rem;font-weight: bold;">
                    <span class="text-capitalize ">{{substr($competencia->name,0,1)}}</span>
                </div>
                <h5 class="card-title">{{$competencia->name}}</h5>
                <p class="card-text">{{ substr($competencia->description,0,40) }}...</p>
                <a href="{{route('verdiccionariodecompetencia', $competencia->id)}}" style="color: rgb(16, 17, 17)" >
                @if($competencia->seleccionmultiple)
                    {{-- <span ><i class="material-icons text-success">thumb_up_alt</i></span></a> --}}
                    <a href="{{route('verdiccionariodecompetencia', $competencia->id)}}" class="btn btn-success">Ver</a>
                @else
                    {{-- <span class="spinner-grow spinner-grow-sm text-danger align-center" role="status"><i class="material-icons spellcheck"></i></span></a> --}}
                    <a href="{{route('verdiccionariodecompetencia', $competencia->id)}}" class="btn btn-danger">Ver</a>
                @endif

            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-2 text text-center" style="color:orangered">
        <h3> Metodos de Evaluacion</h3>

    </div>
    <section>
        <div class="row d-flex justify-content-between">

            <div class="col-sm-12 col-md-3 mt-3 p-2">
                <div class="card text-center">
                    <div class="card-header subtitulo90" style="background-color:blueviolet;color:white">
                    METODO 90&#176;
                    </div>
                    <div class="card-body ">
                        <p class="card-text modelo-90">El empleado es evaluado por su supervisor y la autoevaluacion.</p>
                    </div>
                    <div class="cajaimagen300">
                        <img class="img-fluid" src="{{asset('images/comunicacion.png') }}"  alt="Evaluacion 180 grados">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 mt-3 p-2" >
                <div class="card text-center">
                    <div class="card-header subtitulo180" style="background-color:rgb(18, 224, 204); color:white;">
                    METODO 180&#176;
                    </div>
                    <div class="card-body">
                    <p class="card-text modelo-180">El empleado es evaluado por su supervisor,
                        sus pares y la autoevaluacion.</p>
                    </div>
                    {{-- <div class="card-footer text-muted">
                        <i class="material-icons">people_alt group_add </i>
                    </div> --}}
                    <div class="cajaimagen300">
                        <img class="img-fluid" src="{{asset('images/colaboracion.png') }}"  alt="Evaluacion 360 grados">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 mt-3 p-2" >
                <div class="card text-center">
                    <div class="card-header subtitulo180" style="background-color:darkgoldenrod; color:white;">
                    METODO 270&#176;
                    </div>
                    <div class="card-body modelo-360">
                        <p class="card-text">El empleado es evaluado por su supervisor, pares, colaboradores y
                        la autoevaluacion.</p>
                    </div>
                    {{-- <div class="card-footer text-muted">
                        <i class="material-icons">people_alt group_add </i>
                    </div> --}}
                    <div class="cajaimagen300">
                        <img class="img-fluid" src="{{asset('images/grupo.png') }}"  alt="Evaluacion 360 grados">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-3 mt-3 p-2 ">
                <div class="card text-center">
                    <div class="card-header subtitulo360" style="background-color: seagreen;color:white">
                    METODO 360 &#176;
                    </div>
                    <div class="card-body modelo-360">
                    <p class="card-text">Es una evaluacion integral abarca supervisor, pares, colaboradores
                        , clientes internos o externos y la autoevaluacion.</p>
                    </div>
                    {{-- <div class="card-footer text-muted">
                        <i class="material-icons">people_alt  360</i>
                    </div> --}}
                    <div class="cajaimagen300">
                        <img class="img-fluid" src="{{asset('images/grupo-de-trabajo.png') }}"  alt="Evaluacion 90 grados">
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
