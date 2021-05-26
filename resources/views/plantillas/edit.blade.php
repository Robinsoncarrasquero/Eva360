@extends('master')

@section('title',"Editar Carga Masiva")

@section('content')

<div class="container">

        <div id="flash-message">
            @include('flash-message')
        </div>


        <div class="mt-1 text-center">
            <h5>Importacion de Plantilla de Personal</h5>
        </div>

        <div id="container" ></div>

        <div class="card-header">

            <form action="{{ route('plantillas.procesar',$carga_masiva)  }}" method="POST">
                @csrf
                {{-- @method('PATCH') --}}

                <div class="col-lg-12">
                    <label for="name">Nombre de la importacion</label>
                    <input id="name" class="form-control" type="text" name="name" readonly value="{{$carga_masiva->name}}">
                </div>

                <div class="col-lg-12">
                    <label for="description">Descripcion</label>
                    <textarea placeholder="Descripcion" type="text" id="description" class="form-control" rows="4"
                        maxlength="250" name="description">{{ $carga_masiva->description }}</textarea>
                </div>

                {{-- <div class="col-lg-12">
                    <label for="metodo">Metodos</label>
                    <select id="metodo" class="form-control" name="metodo" >
                        @foreach ($metodos as $metodo)
                            @if ($carga_masiva->metodo==$metodo)
                                <option selected value="{{$metodo}}">{{ $metodo }}</option>
                            @else
                                <option value="{{$metodo}}">{{ $metodo }}</option>
                            @endif
                        @endforeach
                    </select>
                </div> --}}

                {{-- <div class="col-lg-12 text-center">
                    <h2>Seleccione un Modelo</h2>
                </div>

                <div class="row ">
                    <div class="col-lg-12">
                        <div class="table " >
                            <table  class="table table-condensed table-responsive ">
                            <thead style="background-color: green;color:white">
                                <th >#</th>
                                <th >Nombre</th>
                                <th >Objetivo</th>
                                <th >Seleccionar</th>
                            </thead>
                            <tbody  class="tbody-competencias-seleccionar">
                                @foreach($modelos as $modelo)
                                <tr id="{{$modelo->id}}">
                                    <td>{{$modelo->id}}</td>
                                    <td>{{$modelo->name}}</td>
                                    <td>{{$modelo->description}}</td>
                                    <td>
                                    <div class="form-check">
                                        <input type="radio" class="btnradio" value="{{"$modelo->id"}}" name="modeloradio[]">
                                        <label class="form-check-label" for="{{"$modelo->id"}}"></label>
                                    </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>

                    </div>
                </div> --}}

                <div class="clearfix col-lg-12 mt-2">
                    <a href="{{route('plantillas.index')}}" class="btn btn-dark float-left">Regresar</a>

                    <button type="submit" class="btn btn-dark float-right">Procesar</button>

                </div>

            </form>
        <div>

</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/sankey.js"></script>
<script src="https://code.highcharts.com/modules/organization.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>

Highcharts.chart('container', {

chart: {
  height: 600,
  inverted: true
},

title: {
  useHTML: true,
  text: 'Plantilla de Personal'
},

series: [{
  type: 'organization',
  name: 'Plantilla de Puestos',
  keys: ['from', 'to'],
  data: [

    ['Director', 'MANAGER'],
    ['Director', 'RC'],
    ['Director', 'MP'],
    ['Director', 'DM'],
    ['RC', 'RC1'],
    ['RC', 'RC2'],
    ['RC', 'RC3'],
    ['MP', 'MP1'],
    ['MP', 'MP2'],
    ['MP', 'MP3'],
    ['DM', 'DM1'],
    ['DM', 'DM2'],
    ['DM', 'DM3'],
  ],
  levels: [{
    level: 0,
    color: 'silver',
    dataLabels: {
      color: 'black'
    },
    height: 25
  }, {
    level: 1,
    color: 'silver',
    dataLabels: {
      color: 'black'
    },
    height: 25
  }, {
    level: 2,
    dataLabels: {
      color: 'black'
    },
    height: 25
  }, {
    level: 4,
    dataLabels: {
      color: 'black'
    },
    height: 25
  }],
  nodes: [{
    id: 'Director',
    title:null,
    name: 'CONTABILIDAD',
    color: "#419dc0",
  //  info: "Control de las operaciones contables de la organizacion<br>procesando y llevando los libros contables<br>y coordina las operaciones con el area de finanzas y administracion."
  }, {
    id: 'MANAGER',
    name: 'Luis Mata',
    title: 'MANAGER',
    layout: 'hanging',
    color: "#41c0a4",
    info: "Responsable de llevar la direccion de las operaciones contable de la Empresa"
  }, {
    className: 'title',
    id: 'RC',
    name: 'Robinson Carrasquero',
    title: 'Control de Operaciones',
    column: 2,
    layout: 'hanging',
    color: "#abd734",
    info: "Persona responsable de llevar el Control de las operaciones contables"
  }, {
    id: 'RC1',
    name: 'Joe Doe',
    title: 'Operador',
    layout: 'hanging',
    color: "#beef3a",
    info: "Operador de Contabilidad"

  }, {
    id: 'RC2',
    name: 'Jane Doe',
    title: 'Operador',
    layout: 'hanging',
    color: "#beef3a",
    info: "Operador de Contabilidad"

  }, {
    id: 'RC3',
    name: 'Armando Mata',
    title: 'Cajero',
    layout: 'hanging',
    color: "#beef3a",
    info: "Cajero de Contabilidad"

  }, {
    id: 'MP',
    name: 'Maria Pia',
    title: 'Operaciones',
    column: 2,
    layout: 'hanging',
    color: "#34abd7",
    info: "Operaciones Financieras y control de movimientos contables"
  }, {
    id: 'MP1',
    name: 'Rebeca Carrasquero',
    title: 'Analista',
    layout: 'hanging',
    color: "#3abeef",
    info: "Analista de operaciones financieras revisa las operaciones contables"
  }, {
    id: 'MP2',
    name: 'Abraham Mendez',
    title: 'Analista',
    layout: 'hanging',
    color: "#3abeef",
    info: "Analista de operaciones financieras revisa las operaciones contables"
  }, {
    id: 'MP3',
    name: 'Jesus Marin',
    title: 'Contador',
    layout: 'hanging',
    color: "#3abeef",
    info: "Responsable de las operaciones financieras y asientos contables"
  }, {
    id: 'DM',
    name: 'Dilcia Moreno',
    title: 'Auditoria',
    column: 2,
    layout: 'hanging',
    color: "#d7b234",
    info: "Lleva a cabo la auditoria de las operaciones y movimientos financieros realizados en contabilidad"
  }, {
    id: 'DM1',
    name:'Durbelys Martinez',
    title: 'Auditor',
    layout: 'hanging',
    color: "#efc63a",
    info: "Responsable de auditar las operaciones financieras y contables "
  }, {
    id: 'DM2',
    name:'Zoraida Mendez',
    title: 'Auditor',
    layout: 'hanging',
    color: "#efc63a",
    info: "Responsable de auditar las operaciones financieras y contables "
  }, {
    id: 'DM3',
    name:'Pedro Rodriguez',
    title: 'Auditor',
    layout: 'hanging',
    color: "#efc63a",
    info: "Responsable de auditar las operaciones financieras y contables "
  }],
  colorByPoint: false,
  color: '#007ad0',
  dataLabels: {
    color: 'white',
  },
  borderColor: 'white',
  nodeWidth: 45,
  nodePadding: 2
}],

tooltip: {
  outside: true,
  formatter: function() {
    return this.point.info;
  }
},

exporting: {
  allowHTML: true,
  sourceWidth: 800,
  sourceHeight: 600
}
});

</script>




@endsection
