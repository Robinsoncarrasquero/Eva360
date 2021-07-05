@extends('master')

@section('title',"Configuracion")

@section('content')

<div class="container">

        <div id="flash-message">
            @include('flash-message')
        </div>

        <div class="mt-1 text-center">
            <h5>Configuracion</h5>
        </div>

        <div class="card-header">

            <form action="{{route('configuracion.update',$record)  }}" method="post">
                @csrf

                <div class="col-lg-12 form-check">
                    <label class="form-check-label " for="autoevaluacion[]" style="color: rgb(255, 165, 0);font-size:1.5em">Autoevaluacion</label>
                    <input type="checkbox" class="check-select "  name="autoevaluacion[]" @if($record->promediarautoevaluacion) checked @endif >
                </div>

                <div class="col-lg-12 form-check">
                    <label class="form-check-label " for="sendemail[]" style="color: orange;font-size:1.5em">Enviar Emails</label>
                    <input type="checkbox" class="check-select "   name="sendemail[]" @if($record->email) checked @endif>
                </div>

                <div class="col-lg-12 form-check">
                    <label class="form-check-label " for="sendsms[]" style="color: orange;font-size:1.5em">Enviar SMS</label>
                    <input type="checkbox" class="check-select "  name="sendsms[]" @if($record->sms) checked @endif>
                </div>

                <div class="clearfix col-sm-12 mt-2">
                    <button type="submit" class="btn btn-dark float-right">Save</button>
                </div>
            </form>
        <div>

</div>

@endsection
