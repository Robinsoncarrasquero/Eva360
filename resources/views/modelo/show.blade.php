@extends('master')

@section('title',"Consultar Modelo")

@section('content')

<div class="container">

    <div class="panel panel pb-3">
        <h5 class="text text-center">Modelo de Evaluacion</h5>
    </div>

    <div id="flash-message">
        @include('flash-message')

    </div>


    @if ($modelo)
        <div class=" row col-md-12">
            <form action="{{ route('modelo.index') }}" method="get">
            @csrf
            <div class="card">

            <div class="card-header">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <label for="name">Modelo</label>
                        <input class="form-control" type="text" name="name" id="name" placeholder="Nombre" value="{{ $modelo->name }}">
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <label for="description">Descripcion</label>
                        <textarea class="form-control" rows="2"  type="text" name="description" id="description" placeholder="Objetivo del modelo">{{ $modelo->description}}</textarea>
                    </div>
                </div>

            </div>
            </div>
            <table class="table ">
                <thead>

                    <th scope="col">#</th>
                    <th scope="col">Competencia</th>
                    <th scope="col">Nivel Gen.</th>
                    <th scope="col">Nivel Req.</th>
                    <th scope="col">?</th>

                </thead>
                <tbody>
                @foreach ($modelo->competencias as $competencia)
                <tr>
                    <td>{{ $competencia->id }} </th>
                    <td>{{ $competencia->competencia->name }} </td>
                    <td>{{ $competencia->competencia->nivelrequerido }} </td>
                    <td>{{ $competencia->nivelrequerido }} </td>
                    <td>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="{{"$competencia->id"}}"
                            value="{{"$competencia->id"}}" name="competenciascheck[]" checked hidden>
                            <span><i class=" radio-checkeado material-icons">done</i></span>
                        </div>
                    </td>
                </tr>

                @endforeach

                </tbody>
            </table>
            <div class="clearfix">
                <span class="float-left"><a href="{{route('modelo.index')}}" class="btn btn-dark btn-lg">Back</a></span>
            </div>

        </form>

        </div>
    @else
        <div class="alert alert-info">
            <p>No hay registros de modelos</p>
        </div>
    @endif
    <div class="clearfix">

        {{-- {{ $competencias->links() }} --}}
    </div>

</div>

@endsection


<script src="{{ asset('js/lanzar.js') }}"></script>
<script>
$document.ready(function(){
    $(':checkbox[readonly=readonly]').click(function(){
         return false;
    });

});


</script>
