@extends('layout')

@section('title',"Resultados Resumido")

@section('content')

<div class="container">

    <div class="panel panel-default">

        <div class="col-sm-12">

            <div id="flash-message">
                @include('flash-message')

            </div>

            <div class="panel panel pb-3">

                <div class="clearfix">
                    @if ($evaluado->status!==Helper::estatus('Finalizada'))
                        <h4 class="alert alert-danger text text-center"><strong class=" text text-dark">La Prueba de {{ $evaluado->name }} aun no ha finalizado</strong></h4>
                    @else
                        <div class="alert alert-info text-center">
                            <h5>Resultados Finales Ponderados de la Evaluacion de <span class="text-danger">{{ $evaluado->name }}</span></h5>
                        </div>
                    @endif

                    <div class="text text-center">
                        <h4>Competencias evaluadas y resultados finales</span></h4>
                    </div>

                </div>

            </div>

            @if($competencias)

            <div class="panel-body">

                @foreach($competencias as $key=>$value)
                    <div class="table ">
                        <table id="{{$key}}" class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="text text-center title-th-competencia" colspan="2">
                            <strong >{{ $value['competencia']}} (Margen Requerido {{ $value['nivelRequerido'] }})
                            </strong> </th>
                        </tr>
                        <th>Grupo</th>
                        <th>Ponderacion</th>

                        </thead>
                        <tbody>
                        @foreach ($value['data'] as $item)

                        <tr>
                            <td >{{ $item['name']}}</td>
                            <td>{{ number_format($item['average'],2)}}</td>
                        </tr>

                       @endforeach
                       <tr>
                        <td class="text text-center"><strong>Resultado Final( sobre {{ count($value['data']) }} Grupos)</strong></td>
                        <td class="text text-dark" ><a href=""><i class="material-icons">bar_chart</i></a>{{ number_format($value['eva360'],2)}}
                        </td>
                       </tr>

                      </tbody>

                    </table>

                @endforeach

            </div>
            <div class="clearfix">
                <span class="float-left"><a href="{{url()->previous()}}" class="btn btn-dark btn-lg">Back</a></span>
            </div>


            </div>

            @else

            <div class="alert-info">
                <p>No hay informacion disponibles</p>
            <div>

            @endif

            {{-- {{ $competencias->links() }} --}}

        </div>

    </div>

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
