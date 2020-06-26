<html lang="en" class="">
<head>
<meta charset="UTF-8">
<title>File Upload Evaluado y Evaluadores</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="card">
       <div class="card-header">Subir archivo de Evaluado</div>

         <div class="card-body">
            @if ($message = Session::get('success'))

                <div class="alert alert-success alert-block">

                    <button type="button" class="close" data-dismiss="alert">×</button>

                    <strong>{{ $message }}</strong>

                </div>
            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('evaluado.fileupload') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="file" class="form-control-file" name="fileName" id="fileName" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted">Please Choose file</small>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

         </div>
     </div>
  </div>
</div>
</html>
