@extends('master')

@section('title',"Simulador de Autoevealuacion")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>
    <div class="mt-2 pb-2">
        <div class="text text-center">
            <h3 class="btn btn-lg" style="background-color:brown; color:white; font-size:1.5rem">Registro de usuario para Auto Evaluacion Virtual</h3>
        </div>
        <p>
           LLena el formulario con los datos de tu correo, selecciona un Cargo, una Ubicacion ,
            y un Método de Evaluacion <strong>90, 180, 270 o 360 grados</strong>.
           Al finalizar obtendrás los resultados en un minuto.
        </p>
        <p class="text text-center text-success"><strong >Exitos con tu AutoEvaluacion Virtual</strong>.</p>

    </div>

    @if ($modelos)

            <form action="{{ route('simulador.registrar') }}" method="POST">
                @csrf
                <div class="form-group">
                    <div class="col">
                        <label for="name">Nombre</label>
                        <input readonly id="name" class="form-control" type="text" name="name" value="{{old('name',$nombre)}}">
                    </div>

                    <div class="col">
                        <label for="email">Email</label>
                        <input
                        id="email" placeholder="Indique un correo" class="form-control"
                        @if ($email) readonly @endif name="email"  value="{{ old('email',$email)}}">
                    </div>

                    <div class="col">
                        <label >Cargo</label>
                        <select class="form-control" id="cargo" name="cargo">
                            @foreach ($cargos as $cargo)
                                <option  value="{{ $cargo->id }}">{{ $cargo->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col">
                        <label >Ubicacion</label>
                        <select class="form-control" id="departamento" name="departamento">
                            @foreach ($departamentos as $departamento)
                                <option  value="{{ $departamento->id }}">{{ $departamento->name}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col">
                        <label for="metodo">Metodo de evaluacion</label>
                        <select id="metodo" class="form-control" name="metodo" >
                            @foreach ($metodos as $metodo)
                                    <option value="{{$metodo}}">{{ $metodo }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="form-group">


                    <div class="panel pb-3 text-center">
                        <h5 class="text text-danger">Modelo de competencias</h5>
                    </div>

                    <table id="table1" class="table table-condensed table-dark">
                        <thead>
                            <th >Nombre</th>
                            <th >Competencias</th>
                            <th >Seleccione</th>
                        </thead>
                        <tbody>
                            @foreach($modelos as $modelo)
                            <tr id="{{$modelo->id}}">
                                <td>{{$modelo->name}}</td>

                                <td>
                                    @foreach ($modelo->competencias as $modelocompetencia)
                                        {{ $modelocompetencia->competencia->name}},
                                    @endforeach
                                </td>
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
                    <div class="clearfix">
                        <span><a href="{{ route('vision360') }}" class="btn btn-dark btn-lg">Regresar</a></span>
                        <button type="submit" class="btn btn-dark btn-lg " value="Next">Registrar</button>
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
            //$("#tbody-table-seleccionado").html(td);
            $("#lista-de-competencias").html(td);
        }

    });

    function logArrayElements(item, index, array) {
        td +="<li>"+item+"</li>";

        //console.log("a[" + index + "] = " + item);
    }

});
</script>
@endsection


@section('sidebar')


@endsection



