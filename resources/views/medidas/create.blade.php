@extends('master')

@section('title',"Creacion de la medicion")

@section('content')


<div class="container">

    <div class="panel panel-default">

        <div id="flash-message">
            @include('flash-message')
        </div>

        <div class="mt-1 text-center">
            <h5>Nueva Medicion</h5>
        </div>

        <form action="{{ route('medida.store') }}" method="POST">
            @csrf
            <div class="row">

                <div class="col-lg-12">
                    <label for="name">Nombre</label>
                    <input type="text" id="name" maxlength="50" placeholder="Indique un nombre" class="form-control"  name="name" value="{{old('name')  }}" autofocus>
                </div>
                <div class="col-lg-12">
                    <label for="medida">Medicion</label>
                    <input type="text" id="medida" maxlength="20" placeholder="kilogramos, metros, toneladas, meses, horas..." class="form-control"  name="medida" value="{{old('medida')  }}" autofocus>
                </div>

                <div class="col-lg-12">
                    <label for="description">Descripcion</label>
                    <textarea placeholder="Describa sobre la medicion" type="text" id="description" class="form-control" rows="4"
                        maxlength="100" name="description">{{ old('description') }}</textarea>
                </div>

            </div>


            <div class="clearfix">
                <a href="{{route('medida.index')}}" class="btn btn-dark float-left">Back</a>
                <button type="submit" class="btn btn-dark float-right">Crear</button>
            </div>

        </form>


    </div>

</div>
@section('scripts')
    <script src="{{ asset('js/preguntacreate.js') }}"></script>
@endsection

@endsection
