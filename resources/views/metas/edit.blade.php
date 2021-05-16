@extends('master')

@section('title',"Editar Meta")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>

    <div class="text text-center">
        <h5>Actualizar meta</h5>
    </div>

    <form class="card-header" action="{{route('meta.update',$meta)  }}" method="post">
        @csrf
        @method('PATCH' )

        <div class="col-sm-6">
            <label for="name">Nombre</label>
            <input id="name" class="form-control" type="text" name="name" value="{{$meta->name }}">
        </div>

        <div class="col-sm-12">
            <label for="description">Descripcion</label>
            <textarea id="description" class="form-control"  name="description" rows="4" >{{$meta->description }}</textarea>
        </div>

        <div class="col-sm-6">
            <label for="nivelrequerido">Requerido</label>
            <input id="nivelrequerido" class="form-control" type="text" name="nivelrequerido" value="{{ $meta->nivelrequerido}}">
        </div>

        <div class="col-sm-6">
            <label for="tipo">Tipo</label>
            <select id="tipo" class="form-control" name="tipo">
               @foreach ($tipos as $tipo)
                    @if ($meta->tipo==$tipo)
                        <option selected value="{{$tipo->id}}">{{ $tipo->tipo }}</option>
                    @else
                        <option          value="{{$tipo->id}}">{{ $tipo->tipo }}</option>
                    @endif
                @endforeach
            </select>
        </div>

        <table class="table table-table">
            <thead class="table-thead">
                <th>#</th>
                <th>Meta</th>
                <th>Descripcion</th>
                <th>Requerido</th>
            </thead>
            <tbody>
                @foreach ($meta->submetas as $key=>$value)
                <tr>
                    <td>
                        {{ $key }}
                        <input class="col-sm-2" hidden type="text" name="submetaid[]" value="{{ $value->id }}">
                    </td>
                    <td>
                        <input class="col-sm-2" type="text" name="submetaName[]" value="{{ old('submetaName.'.$key, $value->submeta) }}">
                    </td>
                    <td>
                        <textarea class="col-sm-12" cols="50" rows="4" name="submetaDescription[]">{{ old('submetaDescription.'.$key, $value->description)}}</textarea>
                    </td>
                    <td>
                        <input class="col-sm-4" type="text" name="submetaRequerido[]" value="{{ old('submetaRequerido.'.$key, $value->requerido)}}">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="clearfix col-sm-12 mt-2">
            <a href="{{url()->previous()}}" class="btn btn-dark float-left">Back</a>
            <button type="submit" class="btn btn-dark float-right">Save</button>
        </div>

    </form>
</div>

@endsection
