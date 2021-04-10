@extends('master')

@section('title',"FeedBack Edit")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>

    <div class="mt-2 pb-2 text text-center col-lg-12">
        <h3 style="color:blue" >FEEDBACK</h3>
        <h3>{{ $evaluado->name }}</h3>
    </div>

    @if ($feedbacks->count()>0)
        <div class="justify-content-start">
            <div class="col-lg-12 text text-center">
                <a href=" {{route('feedBack->exportfeedback',$evaluado)  }} "><h3 style="color:orange"> Exportar Feedback a Excel </h3></a>
            </div>
        </div>

    @endif

    <div class="table table-responsive">
        <table id="{{ 'tablex' }}" class="table  table-bordered table-striped table-table">
            <thead class="table-thead" style="text-align: center;background:rgb(2, 54, 2);color:rgba(247, 240, 240, 0.932)">
                <tr>
                    <th>Competencias</th>
                    @foreach ($dataCategoria as $key=>$value)
                    <th>
                        <strong>{{$value}}</strong>
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($dataSerie as $key=>$dataValue)
                <tr>
                    @if ($dataValue['data'][0]>($dataValue['data'][1]))
                        <td  class="text xtext-danger" style="font-size:1.5em; color:white;background:red">{{$dataValue['name']}}</td>
                    @else
                        <td >{{$dataValue['name']}}</td>
                    @endif
                    @foreach ($dataValue['data'] as $vdata)
                        @if ($dataValue['data'][0]>($dataValue['data'][1]))
                            <td style="font-size:1.5em; color:red" class="text text-center">{{ number_format($vdata,2)}}</td>
                        @else
                            <td class="text text-center">{{ number_format($vdata,2)}}</td>
                        @endif
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="table table-responsive">
        <table id="{{ 'table'.$evaluado->id }}" class="table  table-bordered table-striped table-table">
            <thead class="table-thead" style="text-align: center;background:rgb(68, 0, 255);color:white">

            <th>% <br>Cumpmto</th>
            <th>% <br> Brecha</th>
            <th>% <br> Potencial</th>
            <th>Oportunidad</th>
            <th>Fortaleza</th>
            </thead>
            <tbody>
                @foreach ($dataBrecha as $key=>$value)
                <tr style="text-align: center">

                <td>{{ number_format($value['cumplimiento'],2) }}</td>
                <td>
                @if ($value['cumplimiento']!=100)
                    {{ number_format($value['brecha'],2) }}
                @endif
                </td>
                <td style="font-size:1.5em; color:white;background:green">
                    @if ($value['potencial']>100)
                    {{ number_format($value['potencial'],2) }}
                    @endif
                </td>
                <td>
                    @foreach ($value['dataoportunidad'] as $vdata)
                        {{$vdata['competencia']}},
                    @endforeach
                </td>
                <td>
                    @foreach ($value['datafortaleza'] as $vdata)
                        {{$vdata['competencia']}},
                    @endforeach
                </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

        {{-- @method('PATCH') --}}


        @foreach ( $feedbacks as $feedback )
        <div class="clearfix">


        <form  class="card-header" action="{{route('feedback.update',$evaluado->id)  }}" method="post" name="frm{{ $feedback->id }}">
        @csrf


        <fieldset >
            <legend class="text text-center" style="color:#f3a10a; font-size:2em;">{{ $feedback->competencia }}</legend>

            <div class="justify-content-start">

                <div class="col-lg-12 text text-center">

                    <input type="text" hidden   class="form-control"  name="fb_competencia[]"  value="{{ $feedback->id }}">
                </div>

            </div>

            <div class="justify-content-between	">

                <div class="col-lg-12 d-flex p-2">
                    <label for="feedback" style="font-size:1em">Escriba un FeedBack</label>
                    <textarea placeholder="Indique su feedback" type="text" id="fb_feedback{{ $feedback->id }}" class="form-control" rows="6"
                        maxlength="1000" name="fb_feedback[]">{{ old('fb_feedback'.$feedback->id,  $feedback->feedback) }}</textarea>
                </div>

            </div>
            <div class="justify-content-start">
                <div class="col-lg-6">
                    <label for="fb_finicio">Fecha Inicio</label>
                    <input type="date" id="fb_finicio{{ $feedback->id }}" class="form-control"  name="fb_finicio[]"  value="{{ old('fb_finicio'.$feedback->id, $feedback->fb_finicio) }}">
                </div>
            </div>
            <div class="justify-content-end">
            <div class="col-lg-6">
                    <label for="fb_ffinal">Fecha Final</label>
                    <input type="date" id="fb_ffinal{{ $feedback->id }}" class="form-control"  name="fb_ffinal[]"  value="{{ old('fb_ffinal'.$feedback->id, $feedback->fb_ffinal) }}">
                </div>
            </div>

            <div class="justify-content-start">
                <div class="col-sm-6">
                    <label >Estatus</label>
                    <select class="form-control" id="fb_status{{ $feedback->id }}" name="fb_status[]">
                        @foreach ($fb_status as $status)
                            @if ($feedback->fb_status==$status)
                                <option  selected  value="{{ $status}}">{{ $status}}</option>
                            @else
                                <option   value="{{ $status}}">{{ $status}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="justify-content-start ">

                <div class="col-lg-12 d-flex p-2">
                    <label for="fb_nota">Nota de Observacion</label>
                    <textarea placeholder="Escriba alguna observacion" type="text" id="fb_nota{{ $feedback->id }}" class="form-control" rows="4"
                        maxlength="500" name="fb_nota[]">{{ old('fb_nota'.$feedback->id, $feedback->fb_nota) }}</textarea>
                </div>

            </div>

            <hr class="text text-dark">

            </fieldset>


            <div class="clearfix col-lg-12 ">
                <div class="col-lg-12">
                    @if (Auth::user()->is_manager))
                    <a href="{{ route('manager.staff',$evaluado->subproyecto_id)}}" class="btn btn-dark float-left">Back</a>
                    @else
                    <a href="{{ route('talent.historicoevaluaciones',$evaluado->user_id)}}" class="btn btn-dark float-left">Back</a>
                    @endif
                    <button type="submit" class="btn btn-dark float-right">Save</button>
                </div>
            </div>

            {{-- <td>
                <button class="btn btn-danger" onclick="deleteConfirmation({{$feedback->id}},'{{route('feedback.delete',$feedback->id)}}')">Delete</button>
            </td> --}}

    </fieldset>
    </form>
    </div>
    <br><br>
    @endforeach

</div>

{{-- @section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endsection --}}

@endsection
