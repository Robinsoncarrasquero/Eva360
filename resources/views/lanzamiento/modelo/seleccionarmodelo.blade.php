@extends('layout')

@section('title',"Lanzamiento de Prueba por Modelo")

@section('content')

<div class="container">

    <div class="panel panel pb-3">
        <h4 class="text text-md-center">Seleccione un Modelo para lanzar la evaluacion de: {{ $evaluado->name }}</h4>
    </div>
    <div class="panel pb-3">
        <div class="clearfix">
            <form class="form-inline mt-2 mt-md-0 float-left" action="{{ route('lanzar.seleccionarmodelo',$evaluado) }}">
                <input class="form-control mr-sm-2" type="text" placeholder="Modelo" aria-label="Searh" name="buscarWordKey">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
            </form>

        </div>
    </div>
    @if ($modelos)

            <form action="{{ route('lanzar.procesarmodelo',$evaluado) }}" method="POST">
                @csrf
                <div class="row ">
                    <div class="col-sm-8">
                        <div class="table table-table">
                            <table id="table1" class="table table-bordered table-striped">
                            <thead class="table-competencias-seleccionar">
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Seleccione</th>
                            </thead>
                            <tbody  class="tbody-competencias-seleccionar">
                                @foreach($modelos as $modelo)
                                <tr id="{{$modelo->id}}">
                                    <td>{{$modelo->id}}</td>
                                    <td>{{$modelo->name}}</td>
                                    <td>{{$modelo->description}}</td>
                                    <td>
                                        <div class="form-check">
                                            <input type="radio" class="btnradio" value="{{"$modelo->id"}}" name="modeloradio[]">
                                            <label class="form-check-label" for="{{"$modelo->id"}}">
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                        <div class="clearfix">
                            <span class="float-left"><a href="{{ url()->previous() }}" class="btn btn-dark btn-lg">Back</a></span>
                            <button type="submit" class="btn btn-dark btn-lg float-right" value="Next">Lanzar</button>
                        </div>

                    </div>

                    <div class="col-sm-4 panel">
                        <form  >
                            <table class="table table-light table-table">
                                <thead class="table-thead-lanzarmodelo">
                                    <th>Competencias del Modelo</th>
                                </thead>
                                <tbody id="tbody-table-seleccionado" class="table-tbody-lanzarmodelo" >

                                </tbody>
                            </table>
                        </form>
                    </div>


                </div>

            </form>
    @else
            <div class="alert alert-info">
                <p>No hay modelos registrados</p>
            </div>

    @endif

    <div class="clearfix">
        {{ $modelos->links() }}
    </div>

</div>

@endsection

@section('scripts')
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script type="text/javascript">
    $(document).on('click','.btnradio',function(e){
        id=$(this).parents('tr').prop('id');
        td='<tr><td>No hay Informacion</td></tr>';
        $.ajax({
        type:'GET',
          url:"{{ route('modelo.ajaxcompetencias') }}",
          data:{id:id},
           success:function(data){
               if (data.success){
                   td='';
                   var datajson=data.dataJson;
                   datajson.forEach(logArrayElements);
               }
               $("#tbody-table-seleccionado").html(td);
            }

        });

    function logArrayElements(element, index, array) {
        td +="<tr><td>"+element+"</td></tr>";
        console.log("a[" + index + "] = " + element);
    }

	});

</script>
@endsection


@section('sidebar')


@endsection



