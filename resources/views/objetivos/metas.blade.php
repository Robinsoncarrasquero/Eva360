@extends('master')

@section('title',"Respondiendo la Prueba")

@section('content')

<div class="container">


        <div id="flash-message">
            @include('flash-message')

        </div>

        <div class="pb-1 mt-2">

            <div class="text text-center">
                <h5>Actualice cada meta de acuerdo a sus logros e intrucciones dadas por su supervisor
            </div>

            {{-- <div class="text-center mt-3">
                <h4>Competencias a evaluar</h4>
            </div> --}}

        </div>

        @if($objetivos)

                <form method="POST" action="{{ route('objetivo.finalizar',$evaluador->id) }}">
                @csrf


                    @foreach($objetivos as $objetivo)
                    <div class="xcard mt-4">

                    <div class="card-header mb-2">
                        <div class="d-flex justify-content-center">
                            <a href="{{route('objetivo.responder', $objetivo->id)}}" style="color: rgb(16, 17, 17)" >
                            <h3 >{{$objetivo->meta->name}}</h3></a>
                        </div>

                        <div class="d-flex justify-content-center">
                            @if($objetivo->submeta)
                                <a href="{{route('objetivo.responder', $objetivo->id)}}" >
                                    <span ><i class="material-icons text-success">thumb_up_alt check_box</i></span></a>
                            @else
                                <a href="{{route('objetivo.responder', $objetivo->id)}}" >
                                <span class="spinner-grow spinner-grow-sm text-danger align-center" role="status"><i class="material-icons spellcheck"></i></span></a>
                            @endif
                        </div>
                    </div>
                   </div>

                    @endforeach


                <div class="clearfix mt-3">
                    @if (!Auth::user()->admin())

                        <span class="float-left"><a href="{{route('objetivo.index')}}" class="btn btn-dark btn-lg">Regresar</a></span>
                        @if($evaluador->status!=2)
                            <button type="submit" class="btn btn-dark btn-lg float-right" value="Finalizar">Finalicé</button>
                        @endif
                    @endif

                </div>

                </form>


        @else

            <div class="alert-info">
                <p>No hay informacion disponibles para responder</p>
            <div>

        @endif

        {{-- {{ $competencias->links() }} --}}

</div>


@endsection
