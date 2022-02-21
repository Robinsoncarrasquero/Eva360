@extends('mastersimulador')

@section('title',"Resultado final")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')

    </div>

    <div class="card-header mt-1 mb-3">
        @if ($evaluado->status!==Helper::estatus('Finalizada'))
            <h5 class="text-center text-danger">Debe culminar la evaluacion de {{ $evaluado->user->name }} para ver los resultado finales.</h5>
        @else
            <div class="text text-center">
                <h5>Resultado final de <span class="text-danger">{{ $evaluado->user->name }}</span></h5>
                @if ($configuraciones->promediarautoevaluacion)
                    <p class="btn btn-dark">La Auto Evaluacion está incluida en los Resultados</p>
                @endif
            </div>
        @endif
    </div>

    @if ($competencias)

        <div class="row">

            <p>Resultados por cada competencia. Indica si el empleado Cumplió o No Cumplió. Tambien recibe una calificacion
                 cualitativa basada en un rango que indica su avance progresivo con respecto a la competencia.
                 Calificacion : No desarrollada(0-25) - Inicio(26-50) - En proceso(51-75) - Avanzada(76-99) - Desarrollada(100).
            </p>

            @foreach($competencias as $key=>$value)
            <div class="col-sm-12 col-md-3">
            <div class="table " >

                <table id="{{$key}}" class="table table-bordered table-table table-responsibe">
                    <thead>
                        <tr >
                            <th class="text text-center title-th-competencia-x" colspan="2" style="background:rgb(235, 229, 229)">
                            <strong >{{ $value['competencia']}}<br> (Nivel Requerido {{ $value['nivelRequerido'] }})
                            </strong>
                            </th>
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

                    {{-- <tr>
                        <td class="font-weight-bold">Brecha</td>
                        @if ($value['brecha'] >=0)
                        <td class="font-weight-bold alert-success">{{ $value['brecha']  }}</td>
                        @else
                        <td class="alert alert-danger font-weight-bold">{{ $value['brecha']  }}</td>
                        @endif
                    </tr> --}}
                    <tr>
                        <td class="text text-center font-weight-bold"><a href=""><i class="material-icons md-48" >bar_chart</i></a>Resultado</td>
                        <td class="text text-center" ><strong>{{ number_format($value['eva360'],2)}}</strong></td>
                    </tr>
                    <tr>
                        @if ($value['eva360'] >=$value['nivelRequerido'])
                            <td class="font-weight-bold text text-success">{{ $value['cumplido']  }}</td>
                        @else
                            <td class="text text-danger font-weight-bold">{{ $value['cumplido']  }}</td>
                        @endif

                        <td class="text-center" style="background:{{  $value['colorcalificacion']}}"><strong>{{ $value['calificacion']}}</strong></td>
                    </tr>

                    </tbody>
                </table>

            </div>
            </div>
            @endforeach


        </div>

        <div class="clearfix">
            <span class="float-left"><a href="{{route('simulador.historicoevaluaciones')}}" class="btn btn-dark btn-lg">Regresar</a></span>
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
