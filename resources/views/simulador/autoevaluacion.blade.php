@extends('mastersimulador')

@section('title',"Simulador de Autoevealuacion")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>

    <div class="mt-2 pb-2">
        <div class="text text-center">
            <h3 class="btn btn-lg" style="background-color:brown; color:white; font-size:1.2rem">Evaluacion Virtual de Desempeño por Competencias</h3>
        </div>
        <p>
            La <strong>Evaluacion Virtual</strong> es una facilidad disponible para que una persona experimente con nuestro sistema <strong class="text text-warning">HRFeedBack360</strong>,
            realizando una <strong class="text text-dark">Auto Evaluacion</strong> con un proceso sencillo, intuitivo y rápido.
            <br>Como funciona? <strong class="text text-warning">HRFeedBack360</strong>, creará Evaluadores Virtuales(EV) <strong>(Supervisor, Pares, Colaboradores y Clientes)</strong>
            , según el método de evaluación. El método 90(2 EV); El método 180(4 EV); El método 270(6 EV); El método 360(8 EV).
             Los EV responderán el cuestionario de competencias con un Robot <span class="material-icons bg-success" style="" >android</span>.
             La evaluaccion tiene un limite máximo de 10 minutos para culminarla. Si la prueba queda incompleta el Robot responderá
            la Auto Evaluacion y notificará la finalización via email para revisar los resultados.
            </p>
    </div>
    <div class="mt-2 pb-2">
        <div class="text text-center">
            <h3 class="btn btn-lg" style="background-color:brown; color:white; font-size:1.5rem">Auto Evaluacion Virtual</h3>
        </div>
        {{-- <p >
            LLena el formulario con los datos del correo, seleccione un cargo, una ubicacion,
            un método de evaluacion y un módelo de competencias</strong>.
        </p> --}}

    </div>

    @if ($modelos)

        <form action="{{ route('simulador.registrar') }}" method="POST">
            @csrf

            <div class="form-group">



                <div class="col">
                    <label for="email">Email</label>
                    <input
                    id="email" placeholder="Indica un correo" class="form-control"
                    @if ($email) readonly @endif name="email"  value="{{ old('email',$email)}}">
                </div>

                <div class="col">
                    <label for="name">Nombre Virtual</label>
                    <input id="name" class="form-control" type="text" name="name" value="{{old('name',$nombre)}}">
                </div>

                <div class="col">
                    <label >Cargo Virtual</label>
                    <select class="form-control" id="cargo" name="cargo">
                        @foreach ($cargos as $cargo)
                            <option  value="{{ $cargo->id }}">{{ $cargo->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col">
                    <label >Ubicacion Virtual</label>
                    <select class="form-control" id="departamento" name="departamento">
                        @foreach ($departamentos as $departamento)
                            <option  value="{{ $departamento->id }}">{{ $departamento->name}}</option>
                        @endforeach
                    </select>
                </div>

                {{-- <div class="col">

                    <label for="metodo">Metodo</label>
                    <select id="metodo" class="form-control" name="metodo" >
                        @foreach ($metodos as $metodo)
                                <option value="{{$metodo}}">{{ $metodo }}</option>
                        @endforeach

                    </select>
                </div> --}}

                <div class="col mt-2">
                    <div class="card-footer" style="background-color:darkgoldenrod;color:white">
                        <h5 class="card-title">Metodo</h5>
                        <div class="d-flex justify-content-between">
                            @foreach ($metodos as $metodo)
                            <label for="metodoradio" class="form-check-label">{{ $metodo}}</label>
                                <input type="radio"  id="{{"$metodo"}}"
                                value="{{"$metodo"}}"
                                name="metodoradio"
                                data-id="{{"$metodo"}}">
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-4 text text-center">
                    <h5 class="text text-danger">Modelos de competencias</h5>
                </div>

                <div class="table">
                    <table  class="table table-responsive table-condensed table-dark">

                    <thead>
                        <th >Modelo</th>
                        <th >Competencias</th>
                        <th >Seleccione</th>
                    </thead>
                    <tbody>
                    @foreach($modelos as $modelo)
                    <tr id="{{$modelo->id}}">
                        <td>{{$modelo->name}}</td>

                        <td style="font-size:0.6rem">
                            @foreach ($modelo->competencias as $modelocompetencia)
                                {{ $modelocompetencia->competencia->name}},
                            @endforeach
                        </td>
                        <td>
                            <div class="form-check">
                                <input type="radio" class="btnradio" value="{{"$modelo->id"}}" name="modeloradio[]">
                                <label class="form-check-label" for="{{"$modelo->name"}}">
                                </label>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                    </tbody>
                    </table>
                </div>

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



