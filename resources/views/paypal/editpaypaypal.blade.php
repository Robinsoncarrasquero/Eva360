@extends('master')

@section('title',"Pagar")

@section('content')

<div class="container">

        <div id="flash-message">
            @include('flash-message')
        </div>

        <div class="mt-1 d-flex justify-content-start">
            <h5>Hacer un abono a la cuenta </h5>
        </div>

        <div class="card-headerx">

            <form action="{{route('paypal.makepay')  }}" method="post">
                @csrf


                <div class="col-lg-4 mt-2">
                    <label for="precio">Precio por unitario</label>
                    <input id="precio" class="form-control" type="number" name="precio" value="{{ $precio }}" readonly>
                </div>

                <div class="col-lg-4 mt-2">
                    <label for="name">Unidades</label>
                    <input id="unidades" class="form-control" type="number" name="unidades" placeholder="Unidades"  onchange="return calculo(event)" onpaste="return false">
                </div>
                <div class="col-lg-4 mt-2">
                    <label for="name">Monto a abonar</label>
                    <input id="monto" class="form-control" type="text" name="monto" placeholder="Monto a abonar"  onkeypress="return validaSoloNumero(event)" onpaste="return false" readonly>
                </div>

                <div class="clearfix col-lg-4 mt-2">
                    <a href="{{route('paypal.transactions') }}" class="btn btn-dark float-left">Regresar</a>
                    <button type="submit" class="btn btn-dark float-right">Procesar</button>
                </div>

            </form>
        <div>

</div>

@section('scripts')
    {{-- <script src="{{ asset('js/deleteConfirmation.js') }}"></script> --}}

    <script>

        function validaSoloNumero(e){


            key=e.Key.Code || e.which;
            teclado = String.fromCharCode(key);

            numeros ="0123456789";
            especiales=["8-37-38-46"];
            teclado_especial=false;

            for (var i in especiales){

                if (key==especiales[i]){
                    teclado_especial=true;
                }

            }

            if (numeros.indexOf(teclado)==-1 && !teclado_especial){
                return false;
            }

        }

        function calculo(e){
            var unidades= parseInt(document.getElementById("unidades").value);
            var precio= parseFloat(document.getElementById("precio").value);
            var totalapagar= unidades*precio;
            document.getElementById("monto").value= totalapagar;
            if (totalapagar<0){
                document.getElementById("monto").value=0;
            }
        }
    </script>
@endsection

@endsection

