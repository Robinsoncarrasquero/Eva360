@extends('layouts.layout')
@section('content')
<div class="row">
  <section class="content">
    <div class="col-md-8 ">
      <div class="panel panel-default">

        @if(Session::has('success'))
        <div class="alert alert-success">
            {{Session::get('success')}}
        </div>
        @endif

        <div class="panel-body">
          <div class="pull-left"><h3>Lista de Evaluados</h3></div>

          <div class="table-container">
            <table id="mytable" class="table table-bordred table-striped">
             <thead>
               <th>Nombre</th>
               <th>Status</th>
               <th>Editar</th>
               <th>Eliminar</th>
             </thead>
             <tbody>
              @if($evaluados->count())
              @foreach($evaluados as $evaluado)
              <tr>
                <td>{{$evaluado->name}}</td>
                <td>{{$evaluado->status}}</td>
                <td><a class="btn btn-primary btn-xs" href="{{route('evaluado.lanzar', $evaluado->id)}}" ><span class="glyphicon glyphicon-pencil"></span></a></td>
               </tr>
               @endforeach
               @else
               <tr>
                <td colspan="8">No hay registro !!</td>
              </tr>
              @endif
            </tbody>

          </table>
        </div>
      </div>
      {{ $evaluados->links() }}
    </div>
  </div>
</section>

@endsection
