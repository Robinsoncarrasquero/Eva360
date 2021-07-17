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

                <div class="col-lg-4 form-check">
                    <label class="form-check-label " for="autoevaluacion[]" style="color: rgb(255, 165, 0);font-size:1em">Autoevaluacion</label>
                    <input type="checkbox" class="check-select "  name="autoevaluacion[]" @if($record->promediarautoevaluacion) checked @endif >
                </div>

                <div class="col-lg-4 form-check">
                    <label class="form-check-label " for="sendemail[]" style="color: orange;font-size:1em">Enviar Emails</label>
                    <input type="checkbox" class="check-select "   name="sendemail[]" @if($record->email) checked @endif>
                </div>

               <div class="col-lg-4 form-check">
                    <label class="form-check-label " for="sendsms[]" style="color: orange;font-size:1em">Enviar SMS</label>
                    <input type="checkbox" class="check-select "  name="sendsms[]" @if($record->sms) checked @endif>
                </div>

                <div class="col-sm-12 col-lg-3">
                    <label for="manager" style="color: rgb(53, 52, 50);font-size:1em">Manager</label>
                    <input type="text" class="form-control"  name="manager" value="{{ $record->manager }}">
                </div>

                <div class="col-sm-12 col-lg-3">
                    <label  for="supervisor" style="color: rgb(53, 52, 50);font-size:1em">Supervisor</label>
                    <input type="text" class="form-control"  name="supervisor" value="{{ $record->supervisor}}">
                </div>

                <div class="col-sm-12 col-lg-3">
                    <label  for="supervisor" style="color: rgb(53, 52, 50);font-size:1em">Supervisores</label>
                    <input type="text" class="form-control"  name="supervisores" value="{{ $record->supervisores}}">
                </div>

                <div class="col-sm-12 col-lg-3">
                    <label for="pares" style="color: rgb(53, 52, 50);font-size:1em">Pares</label>
                    <input type="text" class="form-control"  name="pares"value="{{ $record->pares }}" >
                </div>

                <div class="col-sm-12 col-lg-3">
                    <label for="subordinados" style="color: rgb(53, 52, 50);font-size:1em">Subordinados</label>
                    <input type="text" class="form-control"  name="subordinados" value="{{ $record->subordinados }}">
                </div>

                <div class="col-sm-12 col-lg-3">
                    <label for="autoevaluacion" style="color: rgb(53, 52, 50);font-size:1em">Autoevaluacion</label>
                    <input type="text" class="form-control"  name="autoevaluacion" value="{{ $record->autoevaluacion }}">
                </div>

                <div class="clearfix col-sm-12 mt-2">
                    <button type="submit" class="btn btn-dark float-right">Save</button>
                </div>
            </form>
        <div>

</div>

@endsection
