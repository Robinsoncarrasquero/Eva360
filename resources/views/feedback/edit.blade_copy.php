@extends('master')

@section('title',"FeedBack Edit")

@section('content')

<div class="container">

    <div id="flash-message">
        @include('flash-message')
    </div>

    <div class="mt-2 pb-2 text text-center col-lg-12">
        <h4 style="color:blue" >FEEDBACK</h4>
        <h4>{{ $evaluado->name }}</h4>
    </div>
    <div class="text text-center" style="color:silver">
        <h3>Resultados Logrados</h3>
    </div>
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

    <form  class="card-header" action="{{route('feedback.update',$evaluado)  }}" method="post">
        @csrf
        {{-- @method('PATCH') --}}
        <table class="table table-table" id={{ $feedback }}>
            <thead>
                <th class="text text-center">{{ $feedback->competencia }}</th>
            </thead>
            <tbody>

                <tr>
                    <td>
                        {{ $feedback->id }}
                        <input class="col-sm-12" hidden type="text" name="competencia[]" value="{{ $feedback->competencia }}">
                    </td>
                </tr>
                <tr>
                    <td>
                    <label for="feedback" style="font-size:1em">Escriba un FeedBack</label>
                    <textarea placeholder="Indique su feedback" type="text" id="feedback" class="form-control" rows="6"
                        maxlength="1000" name="feedback[]">{{ $feedback->feedback }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input class="col-sm-2" type="text" name="gradoName[]" value="{{ old('fb_finicio.'.$feedback->id, $feedback->fb_finicio) }}">
                    </td>
                </tr>
                <tr>

                    <td>
                        <textarea class="col-sm-12" cols="50" rows="4" name="gradoDescription[]">{{ old('fb_final.'.$feedback->id, $feedback->fb_ffinal)}}</textarea>
                    </td>
                </tr>
                <tr>

                    <td>
                        <input class="col-sm-4" type="text" name="gradoPonderacion[]" value="{{ old('gradoPonderacion.'.$feedback->id, $feedback->fb_nota)}}">
                    </td>
                </tr>

            </tbody>
        </table>
        @foreach ( $feedbacks as $feedback )


            <fieldset >
            <legend class="text text-center" style="color:rgb(248, 166, 12); font-size:2em">{{ $feedback->competencia }}</legend>
            <p>

            <div class="justify-content-start">

                <div class="col-lg-12 text text-center">
                    <label for="competencia" style="font-size:2em" >{{ $feedback->competencia }}</label>
                </div>

            </div>

            <div class="justify-content-between	">

                <div class="col-lg-12 d-flex p-2">
                    <label for="feedback" style="font-size:1em">Escriba un FeedBack</label>
                    <textarea placeholder="Indique su feedback" type="text" id="feedback" class="form-control" rows="6"
                        maxlength="1000" name="feedback[]">{{ $feedback->feedback }}</textarea>
                </div>

            </div>
            <div class="justify-content-start">
                <div class="col-lg-6">
                    <label for="fb_finicio">Fecha Inicio</label>
                    <input type="date" id="fb_finicio" class="form-control"  name="fb_finicio"  value="{{ $feedback->fb_finicio }}">
                </div>
            </div>
            <div class="justify-content-end">
            <div class="col-lg-6">
                    <label for="fb_ffinal">Fecha Final</label>
                    <input type="date" id="fb_ffinal" class="form-control"  name="fb_ffinal"  value="{{ $feedback->fb_ffinal }}">
                </div>
            </div>

            <div class="justify-content-start">
                <div class="col-sm-6">
                    <label >Estatus</label>
                    <select class="form-control" id="fb_status" name="fb_status">
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
                    <textarea placeholder="Observacion" type="text" id="fb_nota" class="form-control" rows="4"
                        maxlength="500" name="fb_nota">{{ $feedback->fb_nota }}</textarea>
                </div>

            </div>

            <hr class="text text-dark">

            </fieldset>

        @endforeach



        <div class="clearfix col-lg-12 ">
            <div class="col-lg-12">
                <a href="{{url()->previous()}}" class="btn btn-dark float-left">Back</a>
                <button type="submit" class="btn btn-dark float-right">Save</button>
            </div>
        </div>



    </form>


</div>

@endsection
