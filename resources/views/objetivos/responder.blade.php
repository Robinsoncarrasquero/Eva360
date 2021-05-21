@extends('master')

@section('title',"Responder la Prueba")

@section('content')

<div class="container">
    <div id="flash-message">
        @include('flash-message')
    </div>

    <div class="card-header mb-3">
        <h5 class="text text-center"> <span class="text text-danger">{{  $objetivo->evaluador->evaluado->user->name }} </span>, Actualice la meta de acuerdo a sus logros e intrucciones dadas por su supervisor
        <span class="text text-danger"><br></span> relacionada con</h5>
    </div>

    <div class="mb-2">
        <h4 class="text text-center mt-2 border-primary "><strong> {{ $objetivo->meta->name }}</strong></h4>
        <h6 class="card card-header description" >{{ $objetivo->meta->description}}</h6>
    </div>


    @if ($objetivo->meta->submetas->isNotEmpty())
        <form action="{{ route('objetivo.store',$objetivo) }}" method="POST" id="form-select">
        @csrf
            <div class="table table-responsive">
                <table class="table  table-striped table-table">
                    <thead class="table-preguntas border-warning">
                        <th scope="col">#</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">% Meta Minima</th>
                        <th scope="col">Cantidad de la Meta 100%</th>
                        <th scope="col">Cantidad de la Meta Cumplida</th>
                        <th scope="col">Medida</th>
                    </thead>
                    <tbody>

                    @foreach ($objetivo->meta->submetas as $submeta)
                        <tr data-id="{{"$submeta->id"}}" class="filas" >
                            <td>
                                <input type="text"  id="submeta" value="{{ "$submeta->submeta" }}" name="submeta" hidden>
                            </td>
                            <td>{{$submeta->description}}</td>
                            <td>
                                <input type="text" readonly class="form-control" id="nivelrequerido" value= "{{ $objetivo->meta->nivelrequerido }} " name="nivelrequerido"
                                @if ($objetivo->evaluador->status==2)
                                    disabled
                                @endif>

                            </td>
                            <td>
                                <input type="text" class="form-control" id="montoasignado" value= "{{ $objetivo->montoasignado }} " name="montoasignado"
                                @if ($objetivo->evaluador->status==2)
                                    disabled
                                @endif>

                            </td>
                            <td>
                                <input type="text" class="form-control" id="montocumplido" value="{{ $objetivo->montocumplido }}" name="montocumplido"
                                @if ($objetivo->evaluador->status==2)
                                    disabled
                                @endif>
                            </td>

                            <td>
                                @foreach ($mediciones  as $medida)
                                <div class="xform-check ">
                                    <label for="medidacheck[]" class="form-check-label">{{ $medida->name}}</label>
                                    @if($objetivo->medida_id===$medida->id && $objetivo->submeta===$submeta->submeta)
                                        <input type="radio" class="radiofrecuencia" id="{{"radiofrecuencia$submeta->id"}}"
                                        value="{{$medida->id}}" name="medidacheck[]" checked
                                        @if ($objetivo->evaluador->status==2)
                                            disabled
                                        @endif>
                                    @else
                                        <input type="radio" class="radiofrecuencia" id="{{"radiofrecuencia$submeta->id"}}"
                                        value="{{ $medida->id }}" name="medidacheck[]"
                                        @if ($objetivo->evaluador->status==2)
                                            disabled
                                        @endif>
                                    @endif
                                </div>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

            </div>

            <div class="col-md-4 ">
                <div id="divtodo">

                </div>
            </div>


        <div class="clearfix">
           @if (!Auth::user()->admin())
                <span class="float-left"><a href="{{ url()->previous() }}" class="btn btn-dark btn-lg">Back</a></span>
                @if ($objetivo->evaluador->status!=2)
                    <button type="submit" class="btn btn-dark btn-lg float-right" value="Next" >Next</button>
                @endif
            @endif


        </div>

    </form>

    @else
        <div class="col-md-12">
            <p>No hay datos disponible para objetivo</p>
        </div>
    @endif


</div>

@endsection


@section('scripts')
    <script src="{{ asset('js/responder.js') }}"></script>
@endsection


