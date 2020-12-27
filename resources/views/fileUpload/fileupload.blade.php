
@extends('master')

@section('title',"Upload Fila de Evaluacion")

@section('content')


<div class="container">

  <div class="row clearfix ">
    <div class="card">
        <div id="flash-message">
            @include('flash-message')

        </div>

        <div class=" card-header titulo">
            <h5 >Subir un archivo en el formato JSON con los datos de un Evaluado y sus Evaluadores</h5>
        </div>

        <div class="card-header small text-muted" >Formato:<br>
            <code  class="formatojson">
            {<br>
                &nbsp"Evaluado":"Joe Doe",<br>
                &nbsp"Cargo":"Developer",<br>
                &nbsp"Evaluadores":<br>
                &nbsp[
                    <br>&nbsp&nbsp{"name":"Jonh Martinez","relation":"Super","email":"jm@example.com"},
                    <br>&nbsp&nbsp{"name":"Mary Rodriguez","relation":"Super","email":"mr@example.com"},
                    <br>&nbsp&nbsp{"name":"Jane Doe","relation":"Par","email":"jd@example.com"},
                    <br>&nbsp&nbsp{"name":"Frank Aguilar","relation":"Sub","email":"faguilar@example.com"}
                    <br>&nbsp&nbsp{"name":"Joe Doe","relation":"Auto","email":"pp@example.com"},
                    <br>
                &nbsp]<br>
            }<br>
            </code>
            <p>Descargue el formato del archivo JSON requerido para subir la informacion y lanzar la Evaluacion 360
                <a href="{{url('uploads') }}" target="_blank"><i class="material-icons">cloud_download</i></a>
            </p>

        </div>

         <div class="card-body">

            <form action="{{ route('json.fileupload') }}" method="POST" enctype="multipart/form-data" id='myform'>
                @csrf
                <div class="form-group">
                    <input type="file" class="form-control-file" name="fileName" id="fileName" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted">Por favor seleccion un archivo</small>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-dark btn-lg float-right btnsubmit" value="Next">Subir</button>
                </div>
            </form>
         </div>
     </div>
  </div>
</div>


@section('scripts')
<script>
$(document).ready(function () {

    $("form").submit(function(e){
        filename=$("#fileName").val().length;
        if ($("#fileName").val().length==0){
        e.preventDefault();
        e.stopPropagation();
        alert("Por favor seleccione un archivo");
        }
    });

});
</script>
@endsection

@endsection


