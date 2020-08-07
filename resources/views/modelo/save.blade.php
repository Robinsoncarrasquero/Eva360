@extends('lanzamiento.layout')

@section('title',"Salvar Modelo")

@section('content')

<div class="container">

    <div class="panel panel pb-3">
        <h4 class="text text-md-center text text-info">Competencias seleccionadas para crear el Modelo</h2>
    </div>

    <div id="flash-message">
        @include('flash-message')

    </div>

    @if ($competencias->isNotEmpty())
        <div class="col-md-12">
            <form action="{{ route('modelo.store') }}" method="POST">
            {{ csrf_field() }}
            <div class=" form-control">
                <label for="name">Nombre del Modelo</label>
                <input type="text" name="name" id="name" placeholder="Nombre del modelo">
            </div>
            <div class=" form-control">
                <label for="description">Descripcion del Modelo</label>
                <input type="text" name="description" id="description" placeholder="Descripcion del modelo">
            </div>
            <table class="table ">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Competencia</th>
                    <th scope="col">Check</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($competencias as $competencia)
                <tr>
                    <th scope="row">{{ $competencia->id }}</th>
                    <td>{{$competencia->name}}</td>
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
                <button type="submit" class="btn btn-dark btn-lg float-right" value="Next">Next</button>

            </div>

        </form>

        </div>
    @else
        <div class="alert alert-info">
            <p>No hay usuarios registrados</p>
        </div>
    @endif
    <div class="clearfix">

        {{-- {{ $competencias->links() }} --}}
    </div>

</div>

@endsection


<script>
$document.ready(function(){
    $(':checkbox[readonly=readonly]').click(function(){
         return false;
    });

});


</script>
