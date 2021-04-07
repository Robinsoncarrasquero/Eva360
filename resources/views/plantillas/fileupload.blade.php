
@extends('master')

@section('title',"Upload Plantilla de Personal")

@section('content')


<div class="container">

  <div class="row clearfix ">
    <div class="card">
        <div id="flash-message">
            @include('flash-message')

        </div>

        <div class=" card-header titulo">
            <h5 >Subir un archivo en el formato EXCEL con la plantilla del Personal</h5>
        </div>

        <div class="card-header small text-muted" >Formato EXCEL XLXS:

            <table class="table table-responsive">
                <th>ubicacion</th>
                <th>name</th>
                <th>dni</th>
                <th>email</th>
                <th>email_super</th>
                <th>celular</th>
                <th>manager</th>
                <th>cargo</th>
                <th>nivel_cargo</th>
                <body>
                    <tr>
                        <td>Contabilidad</td>
                        <td>Joe Doe</td>
                        <td>999888777</td>
                        <td>joe.doe@example.com</td>
                        <td>joe.doe@example.com</td>
                        <td>057337999432</td>
                        <td>yes</td>
                        <td>Manager</td>
                        <td>Gerencial</td>
                    </tr>
                    <tr>
                        <td>Contabilidad</td>
                        <td>Jane Doe</td>
                        <td>888999777</td>
                        <td>jane.doe@example.com</td>
                        <td>joe.doe@example.com</td>
                        <td>058337999999</td>
                        <td>no</td>
                        <td>Jefe Control</td>
                        <td>Supervisorio</td>
                    </tr>
                    <tr>
                        <td>Contabilidad</td>
                        <td>Robinson Smith</td>
                        <td>775999123</td>
                        <td>robinson.smith@example.com</td>
                        <td>joe.doe@example.com</td>
                        <td>058414999470</td>
                        <td>no</td>
                        <td>Jefe Contable</td>
                        <td>Supervisorio</td>
                    </tr>

                    <tr>
                        <td>Contabilidad</td>
                        <td>Mary Perry</td>
                        <td>777888999</td>
                        <td>mary.perry@example.com</td>
                        <td>jane.doe@example.com</td>
                        <td>057212999555</td>
                        <td>no</td>
                        <td>Analista</td>
                        <td>No Supervisorio</td>
                    </tr>

                    <tr>
                        <td>Contabilidad</td>
                        <td>Darwin Perez</td>
                        <td>105034499</td>
                        <td>d.perez@example.com</td>
                        <td>jane.doe@example.com</td>
                        <td>057332456090</td>
                        <td>no</td>
                        <td>Analista</td>
                        <td>No Supervisorio</td>
                    </tr>

                    <tr>
                        <td>Contabilidad</td>
                        <td>Tony Toby</td>
                        <td>456888999</td>
                        <td>tony.toby@example.com</td>
                        <td>robinson.smith@example.com</td>
                        <td>351978696380</td>
                        <td>no</td>
                        <td>Contador</td>
                        <td>No Supervisorio</td>
                    </tr>

                    <tr>
                        <td>Contabilidad</td>
                        <td>Treena Tommy</td>
                        <td>10791306</td>
                        <td>treena.tommy@example.com</td>
                        <td>robinson.smith@example.com</td>
                        <td>351941999322</td>
                        <td>no</td>
                        <td>Contador</td>
                        <td>No Supervisorio</td>
                    </tr>
                </body>
            </table>

            <p>Descargue el formato del archivo EXCEL requerido para subir la plantilla
             <a href="{{route('plantillas.downloads') }}" target="_blank"><i class="material-icons">cloud_download</i></a>
            </p>

        </div>

         <div class="card-body">

            <form action="{{ route('plantillas.upload') }}" method="POST" enctype="multipart/form-data" id='myform'>
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


