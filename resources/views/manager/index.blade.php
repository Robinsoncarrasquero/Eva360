@extends('master')

@section('title',"Evaluacion de Personal")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>
    <div class="card pb-0 ">

        <div class="text text-center">
            <h5 style="color:rgb(131, 132, 136); font-size:1.5rem">PROYECTOS DE EVALUACIONES DEL EQUIPO</h5>
        </div>
    </div>

    @if ($subproyectos)


        <div class="table table-table table-responsive">

            <table class="table">
                <table id="tb1" class="table  table-bordered table-striped table-table">
                <thead class="table-thead" style="text-align: center;background:rgb(2, 54, 2);color:rgba(247, 240, 240, 0.932)">
                {{-- <thead> --}}
                    <th class="alert-success">Evaluacion</th>
                    <th class="alert-warning text-center">Fecha Inicio</th>
                    <th class="alert-warning text-center">Fecha Update</th>
                    <th class="alert-dark text-center">Ver</th>

                </thead>
                <tbody>
                @foreach ($subproyectos as $key=>$subproyecto )

                <tr >
                    {{-- <td>{{ substr($empleado->name,0,50) }}<span style="background:rgb(179, 248, 179);  color:rgb(15, 16, 24)"><br>{{ $empleado->cargo->name}}</span></td> --}}

                    <td>{{ ($subproyecto['name']) }} </td>

                    <td class="text-center">{{ ($subproyecto['created_at']) }} </td>
                    <td class="text-center">{{ ($subproyecto['updated_at']) }} </td>
                    <td class="text text-center">

                        <a href="{{ route('manager.staff', $subproyecto) }}"><span><i class="material-icons">question_answer</i></span></a>

                    </td>

                    {{-- <td class="text text-center">
                        <form action="{{ route('plantillas.crearevaluaciones',$cargamasiva->id) }}" method="POST">
                            @csrf

                            <button type="submit" class="btn btn-success"> <i class="material-icons">library_add</i></button>
                        </form>
                    </td> --}}


                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{-- <div class=" d-flex justify-content-center">
            {{ $proyectos->links() }}

        </div> --}}
    @else
        <div class="d-flex alert alert-info">
            <p>No hay informacion disponible</p>
        <div>
    @endif

</div>

@endsection
