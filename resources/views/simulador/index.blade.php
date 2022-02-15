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
            <p class="card-body" style="color:darkgreen">Usted realiza una evaluacion simulada con el Evaluador virtual que es un robot que reponde el cuestionario automaticamente
                , hasta que el evaluador real(Usted) culmine la prueba. Luego podrá revisar los resultados en la Opcion Historico donde se puede
            observar tres resultados: Evaluadores, Resultados y Grafica. Recuerde que debe responder todas las competencias.
            Tambien recibirá un correo de finalizacion para indicarle que ha concluido la evaluacion.</p>
        </div>

        @if($evaluadores->count())

        <div class="table table-responsive">
            <table id="mytable" class="table  table-bordred table-striped">

            <thead>
                <th style="width: 20%">Nombre</th>
                <th style="width: 15%">Cuestionario</th>
                <th style="width: 15%">Historico</th>
                <th style="width: 15%">Fecha</th>
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
