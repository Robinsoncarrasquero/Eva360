@extends('master')

@section('title',"Lanzar Carga Masiva")

@section('content')

<div class="container">

        <div id="flash-message">
            @include('flash-message')
        </div>

        <div class="mt-1 text-center">
            <h4>Lanzar una Evaluacion Masiva desde la Plantilla Importada</h4>
        </div>

        <div class="card-header">

            <form action="{{ route('plantillas.crearevaluaciones',$carga_masiva)  }}" method="POST">
                @csrf
                {{-- @method('PATCH') --}}

                <div class="col-lg-12">
                    <label for="name">Nombre de la importacion</label>
                    <input id="name" class="form-control" type="text" name="name" readonly value="{{$carga_masiva->name}}">
                </div>

                <div class="col-lg-12">
                    <label for="description">Descripcion</label>
                    <textarea placeholder="Descripcion" type="text" id="description" class="form-control" rows="4"
                        maxlength="250" name="description">{{ $carga_masiva->description }}</textarea>
                </div>

                <div class="col-lg-6">
                    <label for="metodo">Metodos disponibles en la data importada</label>
                    <select id="metodo" class="form-control" name="metodo" >
                        @foreach ($metodos as $metodo)
                            @if ($carga_masiva->metodo==$metodo)
                                <option selected value="{{$metodo}}">{{ $metodo }}</option>
                            @else
                                <option value="{{$metodo}}">{{ $metodo }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <br>

                <div class="col-lg-12 form-check">
                    <label class="form-check-label " for="autoevaluacion[]" style="color: rgb(255, 165, 0);font-size:1.5em"> Autoevaluacion</label>
                    <input type="checkbox" class="check-select "  name="autoevaluacion[]" >
                </div>

                <div class="col-lg-12 form-check">
                    <label class="form-check-label " for="sendmail[]" style="color: orange;font-size:1.5em"> Enviar Emails</label>
                    <input type="checkbox" class="check-select "   name="sendmail[]">
                </div>

                <div class="col-lg-12 form-check">
                    <label class="form-check-label " for="sendsms[]" style="color: orange;font-size:1.5em"> Enviar SMS</label>
                    <input type="checkbox" class="check-select "  name="sendsms[]" >
                </div>

                <div class="col-lg-12 form-check">
                    <label class="form-check-label " for="soloestaplantilla" style="color: orange;font-size:1.5em"> Exclusivamente esta plantilla</label>
                    <input type="checkbox" class="check-select " checked  name="soloestaplantilla">
                </div>
                <div class="col-lg-12 form-check">
                    <label class="form-check-label " for="supervisordirecto" style="color: orange;font-size:1.5em"> Unicamente Supervisor directo</label>
                    <input type="checkbox" class="check-select " checked  name="supervisordirecto">
                </div>

                <br>
                <div class="col-lg-12 text-center">
                    <h4>Seleccione un Modelo de Competencias</h4>
                </div>

                <div class="row ">
                    <div class="col-lg-12">
                        <div class="table " >
                            <table  class="table table-condensed table-responsive ">
                            <thead style="background-color: green;color:white">
                                <th >#</th>
                                <th >Nombre</th>
                                <th >Objetivo</th>
                                <th >Seleccionar</th>
                            </thead>
                            <tbody>
                                @foreach($modelos as $modelo)
                                <tr id="{{$modelo->id}}" style="color:black">
                                    <td>{{$modelo->id}}</td>
                                    <td>{{$modelo->name}}</td>
                                    <td>{{$modelo->description}}</td>
                                    <td>
                                        <div class="form-check">
                                            <input type="radio" class="btnradio" value="{{"$modelo->id"}}" name="modeloradio[]"
                                            @if ($modelo->id==$carga_masiva->modelo_id) checked  @endif>
                                            <label class="form-check-label" for="modelo_{{"$modelo->id"}}"></label>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="clearfix col-lg-12 mt-2">
                    <a href="{{route('plantillas.index')}}" class="btn btn-dark float-left">Regresar</a>
                    <button type="submit" class="btn btn-dark float-right">Procesar</button>
                </div>

            </form>
        <div>

</div>

@endsection
