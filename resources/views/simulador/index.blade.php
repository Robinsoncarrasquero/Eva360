@extends('mastersimulador')

@section('title',"Lista de Evaluados")

@section('content')

<div class="container">

        <div id="flash-message">
            @include('flash-message')

        </div>

        <div class="mt-2">

             <div class="text text-center mt-3" style="color:dodgerblue">
                <h4 >AUTO EVALUACION VIRTUAL</h4>
            </div>
            <p class="card-footer "><strong>Lista de Auto Evaluaciones. Cada icono accede opciones relacionadas.
                El histórico presenta los resultados de la Evaluaciones realizadas. El estatus indica el progreso de la Evaluacion como un semáforo:</strong>
                <ul class="d-flex justify-content-between">
                    <li >Finalizada<i class="spinner-grow spinner-grow-sm text-success"  ></i></li>
                    <li>Activa<i class="spinner-grow spinner-grow-sm text-warning" ></i></li>
                    <li>Detenida<i class="spinner-grow spinner-grow-sm text-danger" ></i></li>
                </ul>
            </p>


        </div>
        <div class="d-flex justify-content-end">
            <a href="{{ route('simulador.autoevaluacion') }}" class="btn btn-dark"><i class="material-icons">library_add</library-add></i> </a>
        </div>
        @if($evaluadores->count())

            <div class="table table-light table-responsive">
                <table class="table  table-bordered table-striped">
                    <thead>
                        <th >Nombre</th>
                        <th >Evaluacion</th>
                        <th >Historico</th>
                        <th >Fecha</th>
                    </thead>
                    <tbody>
                    @foreach($evaluadores as $evaluador)
                    <tr >
                        <td>{{$evaluador->evaluado->name}}<br>Metodo: {{ $evaluador->evaluado->word_key }} </td>

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
