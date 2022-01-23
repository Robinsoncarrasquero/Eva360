@extends('master')

@section('title',"FeedBack Edit")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>

    <div class="text text-center col">
        <h3 style="color:blue" >FEEDBACK</h3>
        <h3>{{ $evaluado->user->name }}</h3>
    </div>

    @if ($feedbacks->count()>0)
        <div class="d-flex justify-content-start">
            <div class="col text text-center">
                <a href=" {{route('feedBack->exportfeedback',$evaluado)  }} "><h3 style="color:orange"> Exportar Feedback a Excel </h3></a>
            </div>
        </div>

    @endif

    <div class="table table-responsive">
        <table id="{{ 'tablex' }}" class="table table-bordered table-striped table-table">
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
                        <td  class="btn btn-danger" xstyle="font-size:1em; color:white;background:red">{{$dataValue['name']}}</td>
                    @else
                        <td >{{$dataValue['name']}}</td>
                    @endif
                    @foreach ($dataValue['data'] as $vdata)
                        @if ($dataValue['data'][0]>($dataValue['data'][1]))
                            <td style="font-size:1em; color:red" class="text text-center">{{ number_format($vdata,2)}}</td>
                        @else
                            <td class="text text-center">{{ number_format($vdata,2)}}</td>
                        @endif
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="table table-responsive mt-4">
        <table id="{{ 'table'.$evaluado->id }}" class="table  table-bordered table-striped table-table">
            <thead class="table-thead" style="text-align: center;background:rgb(68, 0, 255);color:white">

            <th>% <br>Cumplido</th>
            <th>% <br> Brecha</th>
            <th>% <br> Potencial</th>
            <th>Debilidad</th>
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
                <td>
                    @if ($value['potencial']>100)
                    <span style="font-size:1em; color:white;background:green">{{ number_format($value['potencial']-100,2) }}</span>
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


    <div class="clearfix mt-2">


        <form  class="card-header" action="{{route('feedback.update',$evaluado->id)  }}" method="post" name="frmfb">
        @csrf

        @foreach ( $feedbacks as $feedback )
        <div class="xd-flex justify-content-start xrow ">

            @if ($feedback->fb_status=='Cumplida')
                <legend class="text text-center" style="background-color:green ;color:white; font-size:1.2em;">{{ $feedback->competencia }}</legend>
            @else
                <legend class="text text-center text text-danger" >{{ $feedback->competencia }}</legend>
            @endif

            <div class="justify-content-start">

                <div class="col-lg-12 text text-center">

                    <input type="text" hidden   class="form-control"  name="fb_competencia[]"  value="{{ $feedback->id }}">
                </div>

            </div>

            <div class="d-flex justify-content-start col">

                <div class="col-6 p-2">
                    <label for="fb_feedback[]" style="font-size:1em">Feedback</label>
                    <textarea placeholder="Feedback"  id="fb_feedback{{ $feedback->id }}" class="form-control" rows="2"
                        maxlength="1000" name="fb_feedback[]">{{ old('fb_feedback'.$feedback->id,  $feedback->feedback) }}
                    </textarea>
                </div>

                <div class="col-6 p-2">
                    <label for="fb_development[]" style="font-size:1em">Desarrollo</label>
                    <textarea placeholder="Desarrollo" type="text" id="fb_development{{ $feedback->id }}" class="form-control" rows="2"
                        maxlength="1000" name="fb_development[]">{{ old('fb_development'.$feedback->id,  $feedback->development) }}</textarea>
                </div>

            </div>

            <div class="d-flex justify-content-start col">
                <div class="col-6">
                    <label for="fb_finicio">Fecha Inicio</label>
                    <input type="date" id="fb_finicio{{ $feedback->id }}" class="form-control"  name="fb_finicio[]"  value="{{ old('fb_finicio'.$feedback->id, $feedback->fb_finicio) }}">
                </div>

                <div class="col-6">
                    <label for="fb_ffinal">Fecha Final</label>
                    <input type="date" id="fb_ffinal{{ $feedback->id }}" class="form-control"  name="fb_ffinal[]"  value="{{ old('fb_ffinal'.$feedback->id, $feedback->fb_ffinal) }}">
                </div>
            </div>

            <div class="d-flex justify-content-start col">
                <div class="col-6">
                <label >Frecuencia</label>
                <select class="form-control" id="fb_periodo{{ $feedback->id }}" name="fb_periodo[]">
                    @foreach ($periodos as $periodo)
                        @if ($feedback->periodo==$periodo)
                            <option  selected  value="{{ $periodo->id }}">{{ $periodo->name }} </option>
                        @else
                            <option   value="{{ $periodo->id }}">{{ $periodo->name }}</option>
                        @endif
                    @endforeach
                </select>
                </div>


                <div class="col-6">
                    <label >Status</label>
                    <select class="form-control" id="fb_status{{ $feedback->id }}" name="fb_status[]">
                        @foreach ($fb_status as $status)
                            @if ($feedback->fbstatu_id==$status->id)
                                <option  selected  value="{{ $status->id }}">{{ $status->name }}</option>
                            @else
                                <option   value="{{ $status->id }}">{{ $status->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

            </div>
            {{-- <div class="d-flex justify-content-start ">

                <div class="col-lg-12 p-2">
                    <label for="fb_nota">Nota</label>
                    <textarea placeholder="Escriba alguna observacion" type="text" id="fb_nota{{ $feedback->id }}" class="form-control" rows="4"
                        maxlength="500" name="fb_nota[]">{{ old('fb_nota'.$feedback->id, $feedback->fb_nota) }}</textarea>
                </div>

            </div> --}}

            <hr style="color:green;background-color:green" >



            {{-- <td>
                <button class="btn btn-danger" onclick="deleteConfirmation({{$feedback->id}},'{{route('feedback.delete',$feedback->id)}}')">Delete</button>
            </td> --}}


        </div>
    @endforeach
    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('talent.historicoevaluaciones',$evaluado->user_id)}}" class="btn btn-dark float-left">Back</a>
            <button type="submit" class="btn btn-dark float-right">Save</button>
        </div>
    </div>
    </form>
    </div>
    <br><br>


</div>

{{-- @section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script src="{{ asset('js/deleteConfirmation.js') }}"></script>
@endsection --}}

@endsection
