@extends('master')

@section('title',"Resultado final")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')

    </div>

    <div class="card-header mt-2 mb-4">
        @if ($evaluado->status!==Helper::estatus('Finalizada'))
            <h5 class="text-center text-danger">La Prueba de {{ $evaluado->name }} aun no ha finalizado</h5>
        @else
        <div class="text text-center">
            <h5>Resultado final de <span class="text-danger">{{ $evaluado->name }}</span></h5>
        </div>
        @endif
    </div>

    @if($competencias)

    <div class="row">

        @foreach($competencias as $key=>$value)
        <div class="table table-responsive col-sm-12 col-md-6">
            <table id="{{$key}}" class="table table-bordered table-table">
                <thead>
                <tr>
                    <th class="text text-center title-th-competencia" colspan="2">
                    <strong >{{ $value['competencia']}} (Margen Requerido {{ $value['nivelRequerido'] }})
                    </strong> </th>
                </tr>
                <th>Evaluador</th>
                <th>Ponderado</th>
                </thead>
                <tbody>
                @foreach ($value['data'] as $item)
                <tr>
                    <td >{{ $item['name']}}</td>
                    <td>{{ number_format($item['average'],2)}}</td>
                </tr>
                @endforeach
                <tr>
                    <td class="text text-center"><strong>Obtenido</strong></td>
                    <td class="text text-dark" ><a href=""><i class="material-icons">bar_chart</i></a>{{ number_format($value['eva360'],2)}}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        @endforeach
    </div>

    <div class="clearfix">
        <span class="float-left"><a href="{{url()->previous()}}" class="btn btn-dark btn-lg">Back</a></span>
    </div>

    @else

    <div class="alert-info">
        <p>No hay informacion disponibles</p>
    <div>

    @endif

</div>

@section('scripts')
<script>
$(document).ready(function(){

    function generarLetra(){
        var letras = ["a","b","c","d","e","f","0","1","2","3","4","5","6","7","8","9"];
        var numero = (Math.random()*15).toFixed(0);
        return letras[numero];
    }

    function colorHEX(){
        var coolor = "";
        for(var i=0;i<6;i++){
            coolor = coolor + generarLetra() ;
        }
        return "#" + coolor;
    }

    function generarNumero(numero){
        return (Math.random()*numero).toFixed(0);
    }

    function colorRGB(){
        var coolor = "("+generarNumero(255)+"," + generarNumero(255) + "," + generarNumero(255) +")";
        return "rgb" + coolor;
    }
});

</script>
@endsection

@endsection
