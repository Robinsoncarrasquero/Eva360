<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="favicon.ico">    <!-- Iconos para bootstrap -->
    <link href="/open-iconic/font/css/open-iconic-bootstrap.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"  rel="stylesheet">
    <title>@yield('title') - Vision360</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sticky-footer-navbar/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css" integrity="sha256-BJ/G+e+y7bQdrYkS2RBTyNfBHpA9IuGaPmf9htub5MQ=" crossorigin="anonymous" />

    {{-- <link rel="stylesheet" href="{{asset('bs40/core/css/bootstrap.min.css')  }}" >
    <script src = {{asset('bs40/core/css/jq/2.1.3/jquery.min.js')  }}></script>
    <link rel="stylesheet" href="{{ asset('bs40/core/css/open-iconic/1.1.1/font/open-iconic-bootstrap.min.css')  }}"/> --}}

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Custom styles for this template -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <style>
        .titulo-proyecto{
            color:brown; font-family: 'Times New Roman', Times, serif;font-size: 2ex;
        }
        .titulo-subproyecto{
            color:black;
            background-color:lightsteelblue;
        }

        #grid {
            display: grid;
            grid-template-columns: 150px 1fr;
            grid-template-rows: 50px 1fr 50px;
        }

        #item1 {
            grid-column: 2;
            grid-row-start: 1; grid-row-end: 4;
        }

    </style>
  </head>

  <body>


    <header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="{{ route('home') }}"><img src="{{('/logo/vision360.jpg') }}" style=" width: 10ex; height:3ex" alt="Vision 360"></a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">

            <ul class="navbar-nav mr-auto ">

                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('vision360') }}">Home <span class="sr-only">(current)</span></a>
                </li>


                @if (Auth::check() && Auth::user()->admin())
                    {{-- <li class="nav-item ">
                        <a class="nav-link" href="{{ route('lanzar.index') }}">Panel<span class="sr-only">(current)</span></a>
                    </li> --}}

                    <li class="dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Panel<span class="caret"></span>
                        </a>
                        <ul class=" dropdown-menu">
                            <li><a class="dropdown-item"  href="{{ route('proyectoevaluado.index') }}">Control de Proyecto</a></li>
                            <li  class=" dropdown-divider"></li>
                            <li><a class="dropdown-item"  href="{{ route('lanzar.index') }}">Control de Evaluado</a></li>
                        </ul>

                    </li>
                    <li class="dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Proyectos<span class="caret"></span>
                        </a>
                        <ul class=" dropdown-menu">
                            <li><a class="dropdown-item"  href="{{ route('proyecto.index') }}">Proyecto</a></li>
                            <li  class=" dropdown-divider"></li>
                            <li><a class="dropdown-item"  href="{{ route('subproyecto.index') }}">Sub proyecto</a></li>
                        </ul>

                    </li>
                    <li class="dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Cargos<span class="caret"></span>
                        </a>
                        <ul class=" dropdown-menu">
                            <li><a class="dropdown-item"  href="{{ route('nivelCargo.index') }}">Nivel</a></li>
                            <li  class=" dropdown-divider"></li>
                            <li><a class="dropdown-item"  href="{{ route('cargo.index') }}">Cargo</a></li>
                        </ul>

                    </li>
                    <li class="dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Competencias<span class="caret"></span>
                        </a>
                        <ul class=" dropdown-menu">
                            <li><a class="dropdown-item"  href="{{ route('tipo.index') }}">Tipo</a></li>
                            <li  class=" dropdown-divider"></li>
                            <li><a class="dropdown-item"  href="{{ route('competencia.index') }}">Competencias</a></li>
                            <li  class=" dropdown-divider"></li>
                            <li><a class="dropdown-item"  href="{{ route('modelo.index') }}">Modelo</a></li>
                        </ul>
                    </li>

                    <li class="nav-item ">
                        <a  class="nav-link" href="{{ route('frecuencia.index') }}">Frecuencia</a>
                    </li>
                    <li class="nav-item ">
                        <a  class="nav-link" href="{{ route('user.index') }}">Usuarios</a>
                    </li>
                @endif

                @if (Auth::check())
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ route('evaluacion.index') }}">Mis Evaluados<span class="sr-only">(current)</span></a>
                    </li>
                @endif

            </ul>


            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}  </a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="material-icons " style="font-size:1rem; color: green">person</i> <span   class="caret username">{{ Auth::user()->name }}</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="material-icons" style="color:red">logout</i>
                                {{-- {{ __('Logout') }} --}}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>

          {{-- <form class="form-inline mt-2 mt-md-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form> --}}

        </div>
      </nav>
    </header>

    <!-- Begin page content -->
    <main role="main" class="container">
        <div class="row ">
            <div class="col-md-12">

                @yield('content')

            </div>

            <div class="col-md-12">
                @section('sidebar')
                @show
            </div>

        </div>

    </main>

    <footer id="footer" class="footer">
        <div class="container">
            <span class="text text-center text-white ">Sistema de Gestion por Competencias Talent360</span>
         </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <script src={{ asset('bs40/core/js/jquery-3.2.1.slim.min.js') }}> </script>
    <script src={{ asset('bs40/core/js/popper.min.js') }}> </script>
    <script src={{ asset('bs40/core/js/bootstrap.min.js') }}> </script>
    @yield('scripts')

  </body>

</html>
