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
  text: 'Statistics Division of United Nations'
},

series: [{
  type: 'organization',
  name: 'United Nations',
  keys: ['from', 'to'],
  data: [
    ['Director', 'SPDS'],
    ['Director', 'ESU'],
    ['Director', 'CDS'],
    ['Director', 'OTMS'],
    ['Director', 'ESB'],
    ['Director', 'DSSB'],
    ['Director', 'EESB'],
    ['Director', 'TSB'],
    ['Director', 'SSB'],
    ['ESB', 'NAS'],
    ['ESB', 'EEAS'],
    ['DSSB', 'DSS'],
    ['DSSB', 'SHSS'],
    ['EESB', 'ESS'],
    ['EESB', 'IESS'],
    ['TSB', 'IMTSS'],
    ['TSB', 'SITSS'],
    ['SSB', 'GDSU'],
    ['SSB', 'SDS'],
    ['SSB', 'SGCU'],
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
    title:'Pedro Perez',
    name: 'Director',
    color: "#419dc0",
    info: "Director"
  }, {
    className: 'title',
    id: 'ESU',
    title: 'Luis Marquez',
    name: 'Executive Support',
    layout: 'hanging',
    color: "#41c0a4",
    info: "Planning and coordination of the overall Division’s work program and operation, <br/>including program management finance/budget management, <br/>human resources management, and general office administration"
  }, {
    id: 'SPDS',
    title: null,
    name: 'Stats Planning & Development',
    image: null,
    layout: 'hanging',
    color: "#41c0a4",
    info: "Methodological work on MDG indicators, databases; <br/>coordination of inter-agency groups for MDG global indicators, <br/>responsible for MDG global monitoring. <br/>Coordination of global gender statistics program"
  }, {
    id: 'CDS',
    title: null,
    name: 'Capacity Development',
    layout: 'hanging',
    color: "#41c0a4",
    info: "Management and implementation of the Technical <br/>Co-operation and Statistical Capacity Building Program"
  }, {
    id: 'OTMS',
    title: null,
    name: 'Office & Tech Management',
    layout: 'hanging',
    color: "#41c0a4",
    info: "Application of information technologies for the collection, <br>processing and dissemination of international statistics<br> and metadata by all branches of the Statistics Division"
  }, {
    id: 'ESB',
    title: null,
    name: 'Economics Stats',
    column: 2,
    layout: 'hanging',
    color: "#abd734",
    info: "Economics Statistics Branch"
  }, {
    id: 'NAS',
    title: null,
    name: 'National Accounts',
    layout: 'hanging',
    color: "#beef3a",
    info: "National Accounts Section"

  }, {
    id: 'EEAS',
    title: null,
    name: 'Environmental Economic',
    layout: 'hanging',
    color: "#beef3a",
    info: "Environmental Economic Accounts Section"

  }, {
    id: 'DSSB',
    name: 'Demographic & Social Stats',
    column: 2,
    layout: 'hanging',
    color: "#34abd7",
    info: "Demographic and Social Statistics Branch"
  }, {
    id: 'DSS',
    name: 'Demographic Stats',
    layout: 'hanging',
    color: "#3abeef",
    info: "Demographic Statistics Section"
  }, {
    id: 'SHSS',
    name: 'Social & Housing Stats',
    layout: 'hanging',
    color: "#3abeef",
    info: "Social and Housing Statistics Section"
  }, {
    id: 'EESB',
    name: 'Environment & Energy Stats',
    column: 2,
    layout: 'hanging',
    color: "#d734ab",
    info: "Environment and Energy Statistics Branch"
  }, {
    id: 'ESS',
    name: 'Environment Stats',
    layout: 'hanging',
    color: "#ef3abe",
    info: "Environment Statistics Section"
  }, {
    id: 'IESS',
    name: 'Industrial & Energy Stats',
    layout: 'hanging',
    color: "#ef3abe",
    info: "Industrial and Energy Statistics Section"
  }, {
    id: 'TSB',
    name: 'Trade Stats',
    column: 2,
    layout: 'hanging',
    color: "#d76034",
    info: "Trade Statistics Branch"
  }, {
    id: 'IMTSS',
    name: 'Merchandise Trade Stats',
    layout: 'hanging',
    color: "#ef6b3a",
    info: "International Merchandise Trade Statistics Section"
  }, {
    id: 'SITSS',
    name: 'Stats of Trade',
    layout: 'hanging',
    color: "#ef6b3a",
    info: "Statistics of International Trade in Services Section"
  }, {
    id: 'SSB',
    name: 'Stats Services',
    column: 2,
    layout: 'hanging',
    color: "#d7b234",
    info: "Statistical Services Branch"
  }, {
    id: 'GDSU',
    name: 'Global Data Services',
    layout: 'hanging',
    color: "#efc63a",
    info: "Global Data Services Unit"
  }, {
    id: 'SDS',
    name: 'Stats Dissemination',
    layout: 'hanging',
    color: "#efc63a",
    info: "Statistical Dissemination Section"
  }, {
    id: 'SGCU',
    name: 'Geographic Conferences',
    layout: 'hanging',
    color: "#efc63a",
    info: "Statistical and Geographic Conferences Unit"
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



