
@extends('layout')

@section('title',"Upload Fila de Evaluacion")

@section('content')


<div class="container">

  <div class="row clearfix ">
    <div class="card">
        <div id="flash-message">
            @include('flash-message')


        </div>

        <div class="card-header text text-success">Subir archivo en el formato JSON con los datos basicos del Evaluado y sus evaluadores</div>
        <div class="card-header small text-muted">Formato:<br>
            <code>
            {<br>
                "Evaluado":"Pedro Perez",<br>
                "Evaluadores":<br>
                [
                    <br>{"name":"Juan  Martinez","relation":"Boss","email":"jm@example.com"},
                    <br>{"name":"Maria Rodriguez","relation":"Supervisor","email":"mr@example.com"},
                    <br>{"name":"Jonh Doe","relation":"Parner","email":"jd@example.com"},
                    <br>{"name":"Frank Aguilar","relation":"Parner","email":"faguilar@example.com"}
                    <br>{"name":"Pedro Perez","relation":"Auto","email":"pp@example.com"},
                    <br>
                ]<br>
            }<br>
            </code>
            <p>Descargue el formato del archivo JSON requerido para subir la informacion y lanzar la Evaluacion 360
                <a href="http://eva360.test.ve/uploads" target="_blank"><i class="material-icons">cloud_download</i></a>
            </p>

        </div>

         <div class="card-body">

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops ! </strong>Hemos encontrados un problema con su input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('json.fileupload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="file" class="form-control-file" name="fileName" id="fileName" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted">Por favor seleccion un archivo</small>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>

                </div>
            </form>
         </div>
     </div>
  </div>
</div>

@endsection
