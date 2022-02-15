@extends('mastersimulador')

@section('title',"Lista de Evaluados")

@section('content')

<div class="container">

        <div id="flash-message">
            @include('flash-message')

        </div>

        <div class="mt-2">

             <div class="text text-center mt-3" style="color:dodgerblue">
                <h4 >AUTO EVALUACION</h4>
            </div>
            <p class="card-body">Se presenta la lista de Evaluaciones que usted ha creado y en donde podrá acceder al cuestionario de competencias.
                Tambien puede acceder al histórico para revisar los resultados de la Evaluacion simulada.
                El estatus de la Evaluacion es indicado mediante un circulo parpadeante parecido a un semáforo:
                <span><i class="spinner-grow spinner-grow-sm text-success" role="status"></i>Finalizada</span>
                <span><i class="spinner-grow spinner-grow-sm text-warning" role="status"></i>Proceso</span>
                <span><i class="spinner-grow spinner-grow-sm text-danger" role="status"></i>Detenida</span>
                </p>
        </div>

        @if($evaluadores->count())

            <div class="table table-light">
                <table id="mytable" class="table  table-bordered table-striped">
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
