@extends('layout')

@section('title',"Responder la Prueba")

@section('content')

<div class="container">
    <div class="mb3">
        <div class="panel">
            <b class="text text-center">Estimado {{  $evaluacion->evaluador->name }}, analice con criterio y determinacion las siguientes conductas de
            <span class="text text-danger">{{ $evaluacion->evaluador->evaluado->name }}</span>.</b>
        </div>
    </div>

    <div class="panel">
        <h4 class="text text-center"><br><strong> {{ $evaluacion->competencia->name }} {{$evaluacion->grado }}</strong></h4>
        <h5 class="alert alert-success">{{ $evaluacion->competencia->description}}</h5>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <p>Errores encontrados que debe corregir:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach

            </ul>

        </div>

    @endif

    @if ($evaluacion->competencia->grados->isNotEmpty())
            <form action="{{ route('evaluacion.store',$evaluacion) }}" method="POST" id="form-select">
                {{-- {{ method_field('PUT') }} --}}
                {{ csrf_field() }}
    <div class="form-row">
        <div class="form-group col-md-8">
            <table class="table ">
                <thead>
                <tr>
                    <th scope="col">Grado</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Seleccione</th>
                    <th scope="col">Frecuencia</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($evaluacion->competencia->grados as $grado)

                     <tr data-id="{{" $grado->id "}}" class="filas" >
                        <th scope="row">{{ $grado->grado }}</th>
                        <td>{{$grado->description}}</td>
                        <td>
                            @if($evaluacion->grado===$grado->grado)
                                <div class="form-check">
                                    <input type="radio" class="check-select radiogrado" id="{{"radiogrado$grado->id"}}"
                                    value="{{"$grado->id"}}" name="gradocheck[]" checked >
                                </div>
                            @else
                                <div class="form-check">
                                    <input type="radio" class="check-select" id="{{"radiogrado$grado->id"}}"
                                    value="{{"$grado->id"}}" name="gradocheck[]">
                                </div>

                            @endif

                        </td>
                        <td>


                            @foreach ($frecuencias  as $frecuencia)

                                <div class="form-check checkbox-inline ">
                                    <label for="frecuencia[]" class="form-check-label">{{ $frecuencia->name}}</label>
                                    @if($evaluacion->frecuencia===$frecuencia->valor && $evaluacion->grado===$grado->grado)
                                        <input type="radio" class="form-check radiofrecuencia" id="{{"radiofrecuencia$grado->id"}}"
                                        value="{{"$frecuencia->id"}}" name="frecuenciacheck[]" checked >
                                    @else
                                        <input type="radio" class="form-check radiofrecuencia" id="{{"radiofrecuencia$grado->id"}}"
                                        value="{{"$frecuencia->id"}}" name="frecuenciacheck[]" >
                                    @endif
                                </div>

                            @endforeach




                        </td>

                    </tr>
                @endforeach

                </tbody>
            </table>

        </div>

        <div class="form-group col-md-4 ">

            <div id="divtodo">

            </div>


        </div>

    </div>
    <div class="clearfix">
        <span class="float-left"><a href="{{url()->previous()}}" class="btn btn-dark btn-lg">Back</a></span>
        <button type="submit" class="btn btn-dark btn-lg float-right" value="Next">Next</button>

        </div>

       </form>


    @else
        <div class="col-md-12">
            <p>No datos disponible para evaluaciones</p>
        </div>
    @endif


</div>

@endsection


@section('sidebar')


@endsection


@section('scripts')
<script >
$(document).ready(function() {



    $('.check-select').click(function(e){

        //e.preventDefault();

        var row = $(this).parents('tr');
        var id=row.data('id');
        var divtodo= document.getElementById('divtodo');
        // for(i=0;i<row.length;i++)
        //     // if(chkAsientos[i].checked)
        //     //     asientos.push(chkAsientos[i].value);
        //     divtodo.innerHTML = "<b>Tus tr:</b> ";

        // }

        $(".filas").each(function(){
            var xrow = $(this).attr('data-id');
            if (id!=xrow){
               $(this).remove();
            }

        });


        // var form = $('#form-select');
        // var attrAccion =form.attr('action');
        // var url = attrAccion.replace(':ID-COMPETENCIA',id)

        // var data = form.serialize();


        // $.post(url,data,function(result){
        //     alert(result);
        // });
        // $.ajax({
        //     type: "POST",
        //     url:url,
        //     data:data,
        //     success: function (data) {
        //         alert(data);
        //     },
        //     error: function (data) {
        //         console.log('Error:', data);
        //     }
        // });


    });

});


</script>
@endsection
