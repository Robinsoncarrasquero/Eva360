@extends('lanzamiento.layout')

@section('title',"Lanzamiento de Prueba")

@section('content')

<div class="container">

    <div class="panel pb-1">
        <h4 class="text text-center">Lanzar la prueba de: {{ $evaluado->name }}</h2>
    </div>

    <div id="flash-message">
        @include('flash-message')

    </div>

    @if ($evaluadores->isNotEmpty())
        <div class="col-sm-12">
            <form action="{{ route('lanzar.procesar',$evaluado) }}" method="POST">
                {{ csrf_field() }}

            <table class="table table-table ">
                <thead class="table-thead">
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
                <span class="float-left"><a href="{{route('lanzar.index')}}" class="btn btn-dark btn-lg">Back</a></span>
                <button type="submit" class="btn btn-dark btn-lg float-right" value="Next">Next</button>

            </div>

        </form>

        </div>

    @else
        <div class="clearfix">
            <p>No competencias seleccionadas</p>
        </div>
    @endif
    <div class="clearfix">

        {{-- {{ $competencias->links() }} --}}
    </div>

</div>

@endsection

@section('sidebar')
<div class="col-sm-12">
    <form >
    {{ csrf_field() }}

    <table class="table ">
        <thead>
        <tr>
            <th scope="col">Evaluador</th>
            <th scope="col">Email</th>
            <th scope="col">Notificar</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($evaluadores as $evaluador)
        <tr>
            <td scope= "row">{{$evaluador->name}}</td>
            <td>{{$evaluador->email}}</td>
            <td>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="{{"$evaluador->id"}}"
                    value="{{"$evaluador->id"}}" name="evaluador[]" checked  hidden>
                    <label class="form-check-label" for="{{"$evaluador->id"}}"></label>
                    <span><i class="material-icons">contact_mail</i></span>
                </div>
            </td>
        </tr>

        @endforeach

        </tbody>
    </table>

    </form>

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
