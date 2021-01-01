@extends('master')

@section('title',"Lista de Evaluados")

@section('content')

<div class="container">


        <div id="flash-message">
            @include('flash-message')

        </div>

        <div class="panel panel mt-4">
            <div class="text text-center">
                <h5>Mis Evaluados</h5>
            </div>
        </div>

        @if($evaluadores->count())


            <div class="table table-responsive">
                <table id="mytable" class="table  table-bordred table-striped">
                <thead>
                <th>Nombre</th>
                <th>Status</th>
                <th>Progreso</th>
                <th>Accion</th>
                </thead>
                <tbody>
                @foreach($evaluadores as $evaluador)
                <tr>
                    <td>{{$evaluador->evaluado->name}}</td>

                    <td class="status-progress" >
                        @if(Helper::estatus($evaluador->status)=='Finalizada')
                            <a href="{{route('evaluacion.competencias',$evaluador->id)}}" >
                            <i class="spinner-grow spinner-grow-sm text-success" role="status"></i></a>

                        @endif

                        @if(Helper::estatus($evaluador->status)=='Inicio')
                            <a href="{{route('evaluacion.competencias',$evaluador->id)}}"><i class="spinner-grow spinner-grow-sm text-danger " role="status"></i></a><span class="badge badge-alert">{{ $evaluador->evaluaciones->count()}} </span>
                        @endif

                        @if(Helper::estatus($evaluador->status)=='Lanzada')
                            <a href="{{route('evaluacion.competencias',$evaluador->id)}}" >
                            <i class="spinner-grow spinner-grow-sm text-warning role="status"></i></a>
                        @endif
                    </td>
                    <td>
                        <div class="status-progress">
                            @if(Helper::estatus($evaluador->status)=='Finalizada')
                                <span id="inicio" class="radio-checkeado" ></span>
                                <span id="medio" class="radio-checkeado" ></span>
                                <span id="final" class="radio-checkeado" ></span>
                            @endif

                            @if(Helper::estatus($evaluador->status)=='Inicio')
                                <span id="inicio" class="radio-checkeado" ></span>
                                <span id="medio" class="radio-no-checkeado" ></span>
                                <span id="final" class="radio-no-checkeado"></span>
                            @endif

                            @if(Helper::estatus($evaluador->status)=='Lanzada')
                                <span id="inicio" class="radio-checkeado"></span>
                                <span id="medio" class="radio-checkeado"></span>
                                <span id="final" class="radio-no-checkeado"></span>
                            @endif
                        </div>
                        <span>{{ Helper::estatus($evaluador->status) }}</span>
                    </td>
                    <td>
                        @if($evaluador->status==0)
                            <a href="{{route('evaluacion.competencias',$evaluador->id)}}" >
                            <span><i class="material-icons ">send</i></span></a>
                        @else
                            <a href="{{route('evaluacion.competencias',$evaluador->id)}}" >
                            <span><i class="material-icons">visibility</i></span></a>
                        @endif

                    </td>
                </tr>
                @endforeach
                </tbody>
                </table>
            </div>

        @else

        <div class="alert alert-info no-hay-registros">
            <p>No hay usuarios registrados</p>
        <div>

        @endif

        <div class=" d-flex justify-content-center">
            {{ $evaluadores->links() }}
        </div>


</div>


@endsection
