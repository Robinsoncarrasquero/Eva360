@extends('master')

@section('title',"Prueba por evaluador")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>

    <div class="card card-header mt-2 mb-4">
        <div class="text text-center">
            <h5>Evaluadores de <span class="text-danger">{{ $evaluado->name }}</span></h5>
        </div>
    </div>

    @if($evaluadores)

    <div class="row">

        @foreach($evaluadores as $evaluador)
        <div class="table table-responsive col-sm-12 col-md-6 mt-1">
            <table id="table{{ $evaluador->id }}" class="table table-striped table-table">
                <thead>
                <tr id="{{ $evaluador->id }}">
                    <th class="chk-enviar-prueba" colspan="4">
                        <input type="checkbox" class="btncheck">Reenviar email
                    </th>
                    <th>
                        <span><a class="btn btn-success btn-sm" href="{{ route('evaluacion.competencias',$evaluador) }}">Ver</a></span>
                    </th>
                </tr>

                {{-- <tr id="send{{ $evaluador->id }}">
                    <th colspan="5">
                        <button class="btn btn-warning" onclick="sendEmail({{$evaluador->id}})">Reenviar Email</button>
                    </th>
                </tr> --}}
                <tr>
                    <th class="text text-left  title-th-evaluador" colspan="5">
                    {{$evaluador->name}}({{ $evaluador->relation }}) <span id="dataemail{{$evaluador->id}}">{{$evaluador->email}}</span>
                    <input type="email" required class="editemail" id="email{{$evaluador->id}}" value="{{$evaluador->email}}">
                    <button type="button" data-id="{{$evaluador->id}}" class="btn btn-info btn-save-email">Guardar Email
                    </th>
                </tr>
                <tr>
                <th>Competencia</th>
                <th>Descripcion</th>
                <th>Requerido</th>
                <th>Resultado</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($evaluador->evaluaciones as $evaluacion)
                <tr>
                    <td>{{$evaluacion->competencia->name}}</td>
                    <td>{{substr($evaluacion->competencia->description,0,200)}}</td>
                    <td class="text text-center">{{$evaluacion->competencia->nivelrequerido}}</td>
                    <td class="text text-center"><span class="badge badge-dark">{{ $evaluacion->resultado}}</span></td>
                </tr>
                @endforeach
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
            <p>No hay preguntas disponibles para responder</p>
        <div>
    @endif

</div>
@endsection

@section('scripts')
{{-- <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> --}}
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function sendEmail(id) {

        //id=$(this).parents('tr').prop('id');
        //var row= $(this).parents('tr').children('th');
        $.ajax({
            type:'post',
            url:"{{ route('ajaxsendemailevaluador',"+id+") }}",
            data:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),id:id},
            dataType: 'JSON',
            success:  function (response) {
                if (response.success){
                    //alert(response.message);
                    row.removeClass('btn-warning').append('<i class="text text-success material-icons">email</i>');
                }else{
                    //alert(response.message);
                }

            },
            statusCode: {
                404: function() {
                    alert('web not found');
                }
            },
            error:function(x,xs,xt){
                //window.open(JSON.stringify(x));
                //alert('error: ' + JSON.stringify(x) +"\n error string: "+ xs + "\n error throwed: " + xt);
            }
        });
    }

    $('.btncheck').click(function(e){

        id=0;
        if($(this).is(':checked',true)){
            id=$(this).parents('tr').prop('id');
            var row= $(this).parents('tr').children('th');
            //row.removeClass('btn-warning').append('<i class="text text-success material-icons">email</i>');
            // var f=null;
            // f=$(this).closest('tr').clone(false);
            // $('#table' + id +' tbody').append(f);
            // $(this).parents("tr").remove();
            $.ajax({
                url:"{{ route('ajaxsendemailevaluador') }}",
                data:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),id:id},
                type:'post',
                success:  function (response) {
                    if (response.success){
                       row.removeClass('btn-warning').append('<i class="text text-success material-icons">email</i>');
                       //alert(response.message);
                    //    swal({
                    //         title: "Exito, bien hecho!",
                    //         text: response.message,
                    //         type: "success",
                    //         reverseButtons: !0
                    //     });

                    }else{
                        // swal({
                        //     title: "Error, algo no esta bien!",
                        //     text: response.message,
                        //     type: "warning",
                        //     reverseButtons: !0
                        // });
                        //alert(response.message);
                    }

                },
                statusCode: {
                    404: function() {
                        alert('web not found');
                    }
                },
                error:function(x,xs,xt){
                    //window.open(JSON.stringify(x));
                    //alert('error: ' + JSON.stringify(x) +"\n error string: "+ xs + "\n error throwed: " + xt);
                }
            });
        }
    });

    //Save email
    $('.btn-save-email').click(function(e){
        //e.preventDefault();
        id=0;
        {
            id=$(this).attr('data-id');
            var row= $(this).parents('tr').children('th');
            var email= $("#email"+id).val();
            var eemail= $("#dataemail"+id).text();
            $.ajax({
                type:'post',
                url:"{{ route('ajaxchangeemailevaluador') }}",
                data:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),id:id,email:email},
                dataType: 'JSON',
                success:  function (response) {
                    if (!response.success){
                        $("#email"+id).val(eemail).addClass('alert-danger');
                        // swal({
                        //     title: "Error, algo no esta bien!",
                        //     text: response.message,
                        //     type: "warning",
                        //     reverseButtons: !0
                        // });

                        // alert(response.message);
                    }else{
                        $("#email"+id).addClass('alert-success').removeClass('alert-danger');
                        $("#dataemail"+id).text(email).addClass('alert-success');
                        // swal({
                        //     title: "Exito, bien hecho!",
                        //     text: response.message,
                        //     type: "success",
                        //     reverseButtons: !0
                        // });
                    }

                },
                statusCode: {
                    404: function() {
                        alert('web not found');
                    }
                },
                error:function(x,xs,xt){
                    //window.open(JSON.stringify(x));
                    //alert('error: ' + JSON.stringify(x) +"\n error string: "+ xs + "\n error throwed: " + xt);
                }
            });
        }
    });
</script>
@endsection
