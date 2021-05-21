@extends('master')

@section('title',"Lanzamiento de evaluacion por objetivos")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')

    </div>

    <div class="panel panel pb-1">
        <h4 class="text text-md-center">Seleccione las metas para la evaluacion de : {{ $user->name }}</h4>
    </div>

    @if ($user)
        <div class="col-sm-12">
            <form action="{{ route('lanzarobjetivo.procesar',$user) }}" method="POST" id="form-select">
                @csrf

                <div class="card-header">
                    <label  for="proyecto">Proyectos</label>
                    <select id="subproyecto"  class="form-control" name="subproyecto" >
                        @foreach ($proyectos as $proyectodata)
                            @foreach ( $proyectodata->subproyectos as $subpro )
                                @if (old('subproyecto')==$proyectodata->id)
                                    <option selected value="{{ $subpro->id }}">{{ $proyectodata->name }} ({{ $subpro->name }})</option>
                                @else
                                    <option value="{{ $subpro->id }}">{{ $proyectodata->name }} ({{ $subpro->name }})</option>
                                @endif
                            @endforeach
                        @endforeach
                    </select>
                </div>

                <div class="row ">
                    <div class="col-sm-8">
                        <table class="table table-table" id="table1">
                            <thead class="table-thead">
                                <th scope="col">#</th>
                                <th scope="col">Meta</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Seleccione</th>
                            </thead>
                            <tbody>
                            @foreach ($metas as $meta)
                            <tr data-id="{{" $meta->id "}}">
                                <th scope="row">{{ $meta->id }}</th>
                                <td>{{$meta->name}}</td>
                                <td>{{ substr($meta->description,0,150)}}....</td>
                                <td>{{$meta->tipo->tipo}}</td>
                                {{-- <td>{{$meta->grupometa->name}}</td> --}}
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="btncheck" id="{{"$meta->id"}}"
                                        value="{{"$meta->id"}}" name="metascheck[]">
                                        <label class="form-check-label" for="{{"$meta->id"}}">
                                        </label>
                                    </div>
                                </td>


                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-sm-4 panel ">

                        <table class="table " id="table2">
                            <thead>
                                <th colspan="4" scope="col">Metas Seleccionadas</th>
                            </thead>

                            <tbody class="tbody-modelo-seleccionado">

                            </tbody>
                        </table>

                    </div>

                    <div class="col-sm-8 clearfix">
                        @if (Auth::user()->is_manager)
                            <span class="float-left"><a href="{{ route('manager.personal') }}" class="btn btn-dark btn-lg">Back</a></span>
                        @else
                            <span class="float-left"><a href="{{ route('lanzarobjetivo.index') }}" class="btn btn-dark btn-lg">Back</a></span>
                        @endif
                        <button type="submit" class="btn btn-dark btn-lg float-right" value="Next">Next</button>

                    </div>

                </div>


            </form>

        </div>

    @else
        <p>No hay datos registrados</p>
    @endif

    <div class="clearfix">

        {{-- {{ $metas->links() }} --}}
    </div>

</div>

@endsection


@section('scripts')

    <script src="{{ asset('js/seleccionar.js') }}"></script>

@endsection

@section('sidebar')

@endsection
