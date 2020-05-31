@extends('layout')

@section('title',"Lanzamiento de Prueba")

@section('content')

<div class="container">

    <div class="col-md-12">
        <h1 class="text text-center">{{$title}} : {{ $evaluado->name }}</h1>
    </div>

    @if(Session::has('success'))
    <div class="alert alert-success">
        {{Session::get('success')}}
    </div>
    @endif

    @if ($evaluadores->isNotEmpty())

        <table class="table table-dark">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Relation</th>
                <th scope="col">?</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($evaluadores as $user)
            <tr>
                <th scope="row">{{ $user->id }}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->relation}}</td>

                <td>
                    <form action="{{ route('evaluado.update',$user->id) }}" method="POST">
                        {{-- {{ method_field('PUT') }} --}}
                        {{ csrf_field() }}

                        {{-- <a href="{{ route('evaluado.lanzar', [$user])}}" class="btn-update-chk btn btn-link"><span class="oi oi-pencil"></span></a> --}}
                        <button type="submit" class="btn btn-link"><span class="oi oi-trash"></span></button>
                        <input type="checkbox" name="evaludorescheck[]" id="{{"chkevaluador$user->id"}}" class="btn-update-chk nv-check-box">
                    </form>

                </td>
            </tr>

            @endforeach

            </tbody>
        </table>


    @else
        <p>No hay usuarios registrados</p>
    @endif

</div>

@endsection

@section('sidebar')

<h2>Barra Evaluado</h2>
@endsection

<script src="{{ asset('js/lanzar.js') }}"></script>



