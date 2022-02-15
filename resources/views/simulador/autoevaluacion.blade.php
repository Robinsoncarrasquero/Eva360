@extends('master')

@section('title',"Simulador de Autoevealuacion")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>


    @if ($modelos)

            <form action="{{ route('simulador.registrar') }}" method="POST">
                @csrf

                <div class="card-header">

                    <div class="justify-content-start">
                        <div class="col-6">
                            <label for="name">Nombre</label>
                            <input readonly id="name" class="form-control" type="text" name="name" value="{{old('name',$nombre)}}">
                        </div>
                    </div>

                    <div class="justify-content-start">
                        <div class="col-6">
                            <label for="email">Email</label>
                            <input
                            id="email" placeholder="Indique su correo" class="form-control"
                            @if ($email) readonly @endif name="email"  value="{{ old('email',$email)}}">
                        </div>
                    </div>

                    <div class="justify-content-start">
                        <div class="col-6">
                            <label >Cargo</label>
                            <select class="form-control" id="cargo" name="cargo">
                                @foreach ($cargos as $cargo)
                                    <option  value="{{ $cargo->id }}">{{ $cargo->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="justify-content-start">
                        <div class="col-6">
                            <label >Ubicacion</label>
                            <select class="form-control" id="departamento" name="departamento">
                                @foreach ($departamentos as $departamento)
                                    <option  value="{{ $departamento->id }}">{{ $departamento->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <label for="metodo">Metodos de evaluacion</label>
                        <select id="metodo" class="form-control" name="metodo" >
                            @foreach ($metodos as $metodo)
                                    <option value="{{$metodo}}">{{ $metodo }}</option>
                            @endforeach
                        </select>
                    </div>
               </div>

               <div class="panel pb-3">
                    <h5 class="text text-danger">Modelo de competencias</h5>
                </div>

               <div class="row ">
                    <div class="col-sm-8">
                        <div class="table table-table">
                            <table id="table1" class="table table-condensed table-responsive ">
                            <thead class="table-modelos">
                                <th >#</th>
                                <th >Nombre</th>
                                <th >Objetivo</th>

                                <th >Accion</th>
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
                            <span class="float-left"><a href="{{ route('vision360') }}" class="btn btn-dark btn-lg">Back</a></span>
                            <button type="submit" class="btn btn-dark btn-lg float-right" value="Next">Simular</button>
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

    {{-- <div class="clearfix">
        {{ $modelos->links() }}
    </div> --}}

</div>

@endsection

@section('scripts')
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type = "text/javascript">
$(document).on('click','.btnradio',function(e){
    id=$(this).parents('tr').prop('id');
    td='<tr><td>No hay Informacion</td></tr>';
    $.ajax({
        type:'GET',
        url:"{{ route('simulador.ajaxcompetencias') }}",
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

    function logArrayElements(item, index, array) {
        td +="<tr><td>"+item+"</td></tr>";

        //console.log("a[" + index + "] = " + item);
    }

});
</script>
@endsection


@section('sidebar')


@endsection



