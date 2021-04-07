@extends('master')

@section('title',"Editar Carga Masiva")

@section('content')

<div class="container">

        <div id="flash-message">
            @include('flash-message')
        </div>

        <div class="mt-1 text-center">
            <h5>Importacion de Plantilla de Personal</h5>
        </div>

        <div class="card-header">

            <form action="{{ route('plantillas.procesar',$carga_masiva)  }}" method="POST">
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

                <div class="col-lg-12">
                    <label for="metodo">Metodos</label>
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
                <div class="col-lg-12">
                    <h2>Seleccione un Modelo</h2>

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
                            <tbody  class="tbody-competencias-seleccionar">
                                @foreach($modelos as $modelo)
                                <tr id="{{$modelo->id}}">
                                    <td>{{$modelo->id}}</td>
                                    <td>{{$modelo->name}}</td>
                                    <td>{{$modelo->description}}</td>
                                    <td>
                                    <div class="form-check">
                                        <input type="radio" class="btnradio" value="{{"$modelo->id"}}" name="modeloradio[]">
                                        <label class="form-check-label" for="{{"$modelo->id"}}"></label>
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
