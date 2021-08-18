@extends('master')

@section('title',"Editar status de Feedback")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>

    <div class="text text-center">
        <h5>Actualizar status de Feedback</h5>
    </div>

    <form class="card-header" action="{{route('fbstatu.update',$fbstatu)  }}" method="post">
        @csrf
        @method('PATCH' )

        <div class="col-lg-12">
            <label for="name">Status</label>
            <input id="name" maxlength="50" class="form-control" type="text" name="name" value="{{ $fbstatu->name }}">
        </div>

        <div class="col-lg-12">
            <label for="description">Descripcion</label>
            <textarea id="description" maxlength="100" class="form-control"  name="description" rows="4" >{{ $fbstatu->description }}</textarea>
        </div>

        <div class="clearfix col-lg-12 mt-2">
            <a href="{{url()->previous()}}" class="btn btn-dark float-left">Back</a>
            <button type="submit" class="btn btn-dark float-right">Save</button>
        </div>

    </form>

</div>

@endsection
