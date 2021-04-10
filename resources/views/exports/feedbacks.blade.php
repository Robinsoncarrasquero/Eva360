        <table>
            <thead>
            <tr class="text text-center">
                <th colspan="8">REPORTE DE FEEDBACK</th>
            </tr>
            <tr>
                <th colspan="8">{{ Str::upper($evaluado->name) }}</th>
            </tr>
            <tr>
                <th colspan="8">METODO: {{ $evaluado->word_key }}</th>
            </tr>
            {{-- <tr>
                <th >COMPETENCIA</th>
                <th >REQUISITO</th>
                <th >RESULTADO</th>
            </tr> --}}

            {{-- @foreach ($dataSerie as $key=>$dataValue)
            <tr>
                <th>{{$dataValue['name']}}</th>
                @foreach ($dataValue['data'] as $vdata)
                <th>{{ number_format($vdata,2)}}</th>
                @endforeach
            </tr>
            @endforeach --}}
            <tr>
                <th>Competencias</th>
                <th>Requisito</th>
                <th>Resultado</th>
                <th colspan="2">Feedback</th>
                <th>Fecha Inicio</th>
                <th>Fecha Final</th>
                <th>Estatus</th>
                <th colspan="2">Nota de Observacion</th>
            </tr>

            @foreach ($datafbs as $datafb)
            <tr>
                <th>{{$datafb['name']}}</th>
                @foreach ($datafb['data'] as $vdata)
                <th>{{ number_format($vdata,2)}}</th>
                @endforeach
                <th colspan="2">{{ $datafb['feedback'] }}</th>
                <th>{{ $datafb['fb_finicio'] }}</th>
                <th>{{ $datafb['fb_ffinal'] }}</th>
                <th>{{ $datafb['fb_status'] }}</th>
                <th colspan="2">{{ $datafb['fb_nota'] }}</th>

            </tr>
            @endforeach
            </thead>
            <tbody>
            {{-- @foreach ( $feedbacks as $feedback )
                <tr>
                    <td>{{ $feedback->competencia }}</td>
                    <td colspan="2">{{ $feedback->feedback }}</td>
                    <td >{{ $feedback->fb_finicio }}</td>
                    <td>{{ $feedback->fb_ffinal }}</td>

                    <td>{{ $feedback->fb_status }}</td>
                    <td colspan="2">{{ $feedback->fb_nota }}</td>
                </tr>
            @endforeach --}}
            </tbody>
        </table>

