@extends('master')

@section('title',"Manager Evaluaciones")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>

    <div class="card pb-0 mb-3">

        <div class="text text-center">
            <h5 style="color:royalblue; font-size:1.5rem">EVALUACION DE PERSONAL CARGA MASIVA</h5>
        </div>
    </div>

    @if ($carga_masiva->count())


        <div class="table table-table table-responsive">

            <table class="table">
                <thead>

                    <th style="width:10%" class="alert-dark text-center">Fecha</th>
                    <th style="width:30%" class="alert-success text-center">Descripcion</th>
                    <th style="width:20%" class="alert-dark text-center">Nombre</th>
                    <th style="width:10%" class="alert-warning text-center">Metodo</th>
                    <th style="width:10%" class="alert-warning text-center">Modelo</th>
                    <th style="width:10%" class="alert-dark text-center">Plantilla</th>
                    <th style="width:10%" class="alert-warning text-center">ver</th>
                    <th style="width:10%" class="alert-dark text-center">Lanzar</th>
                </thead>
                <tbody>
                @foreach ($carga_masiva as $cargamasiva )

                <tr >
                    {{-- <td>{{ substr($empleado->name,0,50) }}<span style="background:rgb(179, 248, 179);  color:rgb(15, 16, 24)"><br>{{ $empleado->cargo->name}}</span></td> --}}
                    <td class="text text-center">{{ $cargamasiva->updated_at }} </td>
                    <td>{{ ($cargamasiva->description) }} </td>
                    <td>{{ ($cargamasiva->name) }} </td>

                    <td class="text text-center" >{{ ($cargamasiva->metodo) }}</td>
                    <td class="text text-center">
                        @if($cargamasiva->modelo_id)
                            {{ $cargamasiva->modelo->name }}
                         @endif
                    </td>
                    <td class="text text-center">
                        <a><span class="badge badge-warning">{{ $cargamasiva->plantillas->count() }}</span></a>
                    </td>

                    <td class="text text-center">
                        @if($cargamasiva->procesado)
                            <a href="{{route('plantillas.verproyecto', $cargamasiva->id)}}"><span><i class="material-icons">question_answer</i></span></a>
                        @else
                            <a ><span><i class="material-icons text-dark">question_answer</i></span></a>
                        @endif
                    </td>

                    {{-- <td class="text text-center">
                        <form action="{{ route('plantillas.crearevaluaciones',$cargamasiva->id) }}" method="POST">
                            @csrf

                            <button type="submit" class="btn btn-success"> <i class="material-icons">library_add</i></button>
                        </form>
                    </td> --}}

                    <td class="text text-center">
                        @if($cargamasiva->file)
                            <a href="{{route('plantillas.lanzar', $cargamasiva->id)}}"><span><i class="material-icons text-success" >library_add</i></span></a>
                        @else
                            <a ><span><i class="material-icons text-dark">library_add</i></span></a>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class=" d-flex justify-content-center">
            {{ $carga_masiva->links() }}

        </div>
    @else
        <div class="d-flex alert alert-info">
            <p>No hay informacion disponible</p>
        <div>
    @endif

</div>

@endsection
