<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resultado individual</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sticky-footer-navbar/">

    <link href="/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"  rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css" integrity="sha256-BJ/G+e+y7bQdrYkS2RBTyNfBHpA9IuGaPmf9htub5MQ=" crossorigin="anonymous" />
    <!-- Custom styles for this template -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
<style>

@import 'https://code.highcharts.com/css/highcharts.css';
#container {
  min-width: 300px;
  margin: 1em auto;
 /* border: 1px solid silver;*/
}

#container h4 {
  text-transform: none;
  font-size: 14px;
  font-weight: normal;
}

#container p {
  font-size: 13px;
  line-height: 16px;
}

h4 {
  font-size: 9.5px !important;
}

@media (min-width: 576px) {
  h4 {
    font-size: 12px !important;
  }
}

@media (min-width: 768px) {
  h4 {
    font-size: 12.5px !important;
  }
}

@media (min-width: 992px) {
  h4 {
    font-size: 15px !important;
  }
}

@media (min-width: 1200px) {
  h4 {
    font-size: 18px !important;
  }
}

</style>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>
<div class="container">
    <div id="container"></div>

    <div class="clearfix">
        <span class="float-left"><a href="{{url()->previous()}}" class="btn btn-dark btn-lg">Back</a></span>
    </div>
</div>
</body>

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
    title: 'Luis Mata',
    name: 'MANAGER',
    layout: 'hanging',
    color: "#41c0a4",
    info: "Responsable de llevar la direccion de las operaciones contable de la Empresa"
  }, {
    className: 'title',
    id: 'RC',
    title: 'Robinson Carrasquero',
    name: 'Control de Operaciones',
    column: 2,
    layout: 'hanging',
    color: "#abd734",
    info: "Persona responsable de llevar el Control de las operaciones contables"
  }, {
    id: 'RC1',
    title: 'Joe Doe',
    name: 'Operador',
    layout: 'hanging',
    color: "#beef3a",
    info: "Operador de Contabilidad"

  }, {
    id: 'RC2',
    title: 'Jane Doe',
    name: 'Operador',
    layout: 'hanging',
    color: "#beef3a",
    info: "Operador de Contabilidad"

  }, {
    id: 'RC3',
    title: 'Armando Mata',
    name: 'Cajero',
    layout: 'hanging',
    color: "#beef3a",
    info: "Cajero de Contabilidad"

  }, {
    id: 'MP',
    title: 'Maria Pia',
    name: 'Operaciones',
    column: 2,
    layout: 'hanging',
    color: "#34abd7",
    info: "Operaciones Financieras y control de movimientos contables"
  }, {
    id: 'MP1',
    title: 'Rebeca Carrasquero',
    name: 'Analista',
    layout: 'hanging',
    color: "#3abeef",
    info: "Analista de operaciones financieras revisa las operaciones contables"
  }, {
    id: 'MP2',
    title: 'Abraham Mendez',
    name: 'Analista',
    layout: 'hanging',
    color: "#3abeef",
    info: "Analista de operaciones financieras revisa las operaciones contables"
  }, {
    id: 'MP3',
    title: 'Jesus Marin',
    name: 'Contador',
    layout: 'hanging',
    color: "#3abeef",
    info: "Responsable de las operaciones financieras y asientos contables"
  }, {
    id: 'DM',
    title: 'Dilcia Moreno',
    name: 'Auditoria',
    column: 2,
    layout: 'hanging',
    color: "#d7b234",
    info: "Lleva a cabo la auditoria de las operaciones y movimientos financieros realizados en contabilidad"
  }, {
    id: 'DM1',
    title:'Durbelys Martinez',
    name: 'Auditor',
    layout: 'hanging',
    color: "#efc63a",
    info: "Responsable de auditar las operaciones financieras y contables "
  }, {
    id: 'DM2',
    title:'Zoraida Mendez',
    name: 'Auditor',
    layout: 'hanging',
    color: "#efc63a",
    info: "Responsable de auditar las operaciones financieras y contables "
  }, {
    id: 'DM3',
    title:'Pedro Rodriguez',
    name: 'Auditor',
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



