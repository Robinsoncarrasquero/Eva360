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
                <div class="form-row">
                    <div class="col-sm-4 form-check">
                        <input type="checkbox" class="check-select "   name="sendemail[]" @if($record->email) checked @endif>
                        <label class="form-check-label " for="sendemail[]" style="color: orange;font-size:1em">Enviar Emails</label>
                    </div>

                    <div class="col-sm-4 form-check">
                        <input type="checkbox" class="check-select "  name="sendsms[]" @if($record->sms) checked @endif>
                        <label class="form-check-label " for="sendsms[]" style="color: orange;font-size:1em">Enviar SMS</label>
                    </div>

                    <div class="col-sm-4 form-check">
                        <input type="checkbox" class="check-select "  name="promediarautoevaluacion[]" @if($record->promediarautoevaluacion) checked @endif >
                        <label class="form-check-label " for="promediarautoevaluacion[]" style="color: rgb(255, 165, 0);font-size:1em">Promediar autoevaluacion</label>
                    </div>
                </div>

                <div class="card-header">
                    <h5 class="card-title text-center">Titulos de Relaciones Individuales</h5>

                    <div class="form-row">
                        <div class="form-group col-sm-4">
                            <label for="manager" style="color: rgb(53, 52, 50);font-size:1em">Manager</label>
                            <input type="text" class="form-control"  name="manager" value="{{ $record->manager }}" maxlength="15">
                        </div>

                        <div class="form-group col-sm-4">
                            <label  for="supervisor" style="color: rgb(53, 52, 50);font-size:1em">Supervisor</label>
                            <input type="text" class="form-control"  name="supervisor" value="{{ $record->supervisor}}" maxlength="15">
                        </div>
                        <div class="col-sm-4">
                            <label for="autoevaluacion" style="color: rgb(53, 52, 50);font-size:1em">Autoevaluacion</label>
                            <input type="text" class="form-control"  name="autoevaluacion" value="{{ $record->autoevaluacion }}" maxlength="15">
                        </div>
                    </div>
                </div>
                <div class="card-header">
                    <h5 class="card-title text-center">Titulos de Relaciones Grupales</h5>
                    <div class="form-row">
                        <div class="col-sm-4">
                            <label  for="supervisor" style="color: rgb(53, 52, 50);font-size:1em">Supervisores</label>
                            <input type="text" class="form-control"  name="supervisores" value="{{ $record->supervisores}}" maxlength="15">
                        </div>

                        <div class="col-sm-4">
                            <label for="pares" style="color: rgb(53, 52, 50);font-size:1em">Pares</label>
                            <input type="text" class="form-control"  name="pares"value="{{ $record->pares }}" maxlength="15">
                        </div>

                        <div class="col-sm-4">
                            <label for="subordinados" style="color: rgb(53, 52, 50);font-size:1em">Subordinados</label>
                            <input type="text" class="form-control"  name="subordinados" value="{{ $record->subordinados }}" maxlength="15">
                        </div>


                    </div>
                </div>
                <div class="clearfix col-sm-12 mt-2">
                    <button type="submit" class="btn btn-dark float-right">Guardar</button>
                </div>
            </form>
        <div>

</div>

@endsection
