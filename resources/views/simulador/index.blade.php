@extends('mastersimulador')

@section('title',"Lista de Evaluados")

@section('content')

<div class="container">


        <div id="flash-message">
            @include('flash-message')

        </div>

        <div class="card-header pb-2 mt-2">

            <div class="text text-center">

                <h5 style="color:blue;">AUTO EVALUACION</h5>

            </div>
            <p class="card-body" style="color:darkgreen">Se presenta la lista Evaluaciones que usted ha creado. Puede acceder al cuestionario de competencias
                para responderlo. Tambien puede acceder al historico para revisar los resultados logrados de la Evaluacion simulada.
                El Evaluador virtual es un robot que actuará por cada evaluador simulado y responderá
                automáticamente cada vez que usted responda su autoevaluacion. El estatus de la Evaluacion
                es indicada mediante un circulo que parpadea parecido a un semáforo para indicar
                que cuando es Verde= Finalizada, Amarillo = Respondiendo,  Rojo = Creada.</p>
        </div>

        @if($evaluadores->count())

        <div class="table table-responsive">
            <table id="mytable" class="table  table-bordred table-striped">

            <thead>
                <th >Nombre</th>
                <th >Cuestionario</th>
                <th >Historico</th>
                <th >Fecha</th>
            </thead>
            <tbody>
            @foreach($evaluadores as $evaluador)
            <tr>
                <td>{{$evaluador->evaluado->name}} </td>

                <td class="status-progress" >
                    @if($evaluador->evaluado->word_key=='Objetivos')

                        @if(Helper::estatus($evaluador->status)=='Finalizada')
                            <a href="{{route('objetivo.metas',$evaluador->id)}}" >
                            <i class="spinner-grow spinner-grow-sm text-success" role="status"></i></a>
                        @endif

                        @if(Helper::estatus($evaluador->status)=='Inicio')
                            <a href="{{route('objetivo.metas',$evaluador->id)}}"><i class="spinner-grow spinner-grow-sm text-warning " role="status"></i></a><span class="badge badge-alert">{{ $evaluador->evaluaciones->count()}} </span>
                        @endif

                        @if(Helper::estatus($evaluador->status)=='Lanzada')
                            <a href="{{route('objetivo.metas',$evaluador->id)}}" >
                            <i class="spinner-grow spinner-grow-sm text-danger" role="status"></i></a>
                        @endif

                    @else
                        @if(Helper::estatus($evaluador->status)=='Finalizada')
                            <a href="{{route('simulador.competencias',$evaluador->id)}}" >
                            <i class="spinner-grow spinner-grow-sm text-success" role="status"></i></a>
                        @endif

                        @if(Helper::estatus($evaluador->status)=='Inicio')
                            <a href="{{route('simulador.competencias',$evaluador->id)}}">
                            <i class="spinner-grow spinner-grow-sm text-warning " role="status"></i></a>
                            <span class="badge badge-alert">{{ $evaluador->evaluaciones->count()}} </span>
                        @endif

                        @if(Helper::estatus($evaluador->status)=='Lanzada')
                            <a href="{{route('simulador.competencias',$evaluador->id)}}" >
                            <i class="spinner-grow spinner-grow-sm text-danger" role="status"></i></a>
                        @endif
                    @endif

                </td>

                <td>
                    @if($evaluador->status==0)
                        <a href="{{route('simulador.historicoevaluaciones')}}" >
                        <span><i class="material-icons ">send</i></span></a>
                    @else
                        <a href="{{route('simulador.historicoevaluaciones')}}" >
                        <span><i class="material-icons">visibility</i></span></a>
                    @endif

                </td>

                <td>{{ $evaluador->created_at }}</td>
            </tr>
            @endforeach
            </tbody>
            </table>
        </div>

        @else

        <div class="alert alert-info no-hay-registros">
            <p>No hay registros de evaluados</p>
        <div>

        @endif

        <div class=" d-flex justify-content-center">
            {{ $evaluadores->links() }}
        </div>


</div>


@endsection
