<!DOCTYPE html>
<html>
<head>
    <title>Laravel 7 Ajax Request example</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>

    <div class="container">
        <h1>Laravel 7 Ajax Request example</h1>

        <form >

            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" class="form-control" placeholder="Name" required="">
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required="">
            </div>

            <div class="form-group">
                <strong>Email:</strong>
                <input type="email" name="email" class="form-control" placeholder="Email" required="">
            </div>
            <div class="form-group">
                <strong>Quiero:</strong>
                <input type="checkbox" name="checkok" class="form-control btn-submit"  required="">
            </div>

            <div class="form-group">
                <button class="btn btn-success btn-submit">Submit</button>
            </div>

        </form>
    </div>

</body>
<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".btn-submit").click(function(e){

        e.preventDefault();

        var name = $("input[name=name]").val();
        var password = $("input[name=password]").val();
        var email = $("input[name=email]").val();
        // var form = form->serialize();
        $.ajax({
           type:'POST',
           url:"{{ route('ajaxRequest.post') }}",
           data:{ name:name, password:password, email:email},
           success:function(data){
              alert(data.success);
           }
        });

	});
</script>

</html>
