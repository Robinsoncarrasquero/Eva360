@extends('master')

@section('title',"Lista de Evaluaciones")

@section('content')

<div class="container">


        <div id="flash-message">
            @include('flash-message')

        </div>

        <div class="card pb-2 mt-2">

            <div class="text text-center">
                <h4 style="color:rgb(4, 44, 165); font-size:1.5rem">MIS EVALUACIONES POR OBJETIVOS</h4>

            </div>

        </div>

        @if($evaluadores->count())

        <div class="table table-responsive">
            <table id="mytable" class="table  table-bordred table-striped">

                <thead>
                    <th style="width: 30%">Nombre</th>
                    <th style="width: 15%">Progreso</th>
                    <th style="width: 15%">Status</th>
                    <th style="width: 15%">Ver</th>
                    <th style="width: 15%">Fecha</th>
                </thead>
            <tbody>
            @foreach($evaluadores as $evaluador)
            <tr>
                <td>{{$evaluador->evaluado->user->name}}</td>

                <td class="status-progress" >
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
                </td>
                <td>
                    {{-- <div class="status-progress">
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
                    </div> --}}
                    <span>{{ Helper::estatus($evaluador->status) }}</span>
                </td>
                <td>
                    @if($evaluador->status==0)
                        <a href="{{route('objetivo.metas',$evaluador->id)}}" >
                        <span><i class="material-icons ">send</i></span></a>
                    @else
                        <a href="{{route('objetivo.metas',$evaluador->id)}}" >
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
            <p>No hay registros de evaluaciones</p>
        <div>

        @endif

        <div class=" d-flex justify-content-center">
            {{ $evaluadores->links() }}
        </div>


</div>


@endsection
