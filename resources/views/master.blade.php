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
    <title>@yield('title')</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sticky-footer-navbar/">

    <!-- Bootstrap core CSS -->
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css" integrity="sha256-BJ/G+e+y7bQdrYkS2RBTyNfBHpA9IuGaPmf9htub5MQ=" crossorigin="anonymous" /> --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    {{-- <link rel="stylesheet" href="{{asset('bs40/core/css/bootstrap.min.css')  }}" >
    <script src = {{asset('bs40/core/css/jq/2.1.3/jquery.min.js')  }}></script>
    <link rel="stylesheet" href="{{ asset('bs40/core/css/open-iconic/1.1.1/font/open-iconic-bootstrap.min.css')  }}"/> --}}


    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">

    {{-- <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script> --}}

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

    {{-- <nav class="navbar navbar-expand-lg navbar-light bg-lightxx" style="background-color: #e3f2fd;""> --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <a class="navbar-brand" href="{{ route('home') }}"><img id="logo" style="width:2em" src="{{asset('logo/logo170x60.png') }}"  alt="Talent 360"></a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">

                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('vision360') }}">Home <span class="sr-only">(current)</span></a>
                </li>

                @if (Auth::check() && Auth::user()->admin())
                <li class="nav-item dropdown">
                    <a  class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Carga masiva
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenu1">
                        <a class="dropdown-item"  href="{{ route('plantillas.fileupload') }}">Importar</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a  class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Evaluacion
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenu1">

                        <a class="dropdown-item"  href="{{ route('plantillas.index') }}">Masivas</a>
                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item"  href="{{ route('proyectoevaluado.index') }}">Proyectos</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"  href="{{ route('lanzar.index') }}">Evaluados</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a  class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Admon
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenu2">
                        <a class="dropdown-item"  href="{{ route('talent.index') }}">Plantilla</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"  href="{{ route('nivelCargo.index') }}">Nivel</a>
                        <a class="dropdown-item"  href="{{ route('cargo.index') }}">Cargo</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"  href="{{ route('ubicacion.index') }}">Ubicacion</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a  class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Proyectos
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenu3">
                        <a class="dropdown-item"  href="{{ route('proyecto.index') }}">Proyecto</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"  href="{{ route('subproyecto.index') }}">Sub proyecto</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a  class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenu4" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Modelos
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenu4">
                        <a class="dropdown-item"  href="{{ route('tipo.index') }}">Tipo</a>
                        <a class="dropdown-item"  href="{{ route('competencia.index') }}">Competencias</a>
                        <a class="dropdown-item"  href="{{ route('modelo.index') }}">Modelo</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"  href="{{ route('frecuencia.index') }}">Frecuencia</a>
                    </div>
                </li>

                <li class="nav-item ">
                    <a  class="nav-link" href="{{ route('user.index') }}">Usuarios</a>
                </li>
                @endif

                @if (Auth::check() && Auth::user()->is_manager)
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('evaluacion.index') }}">Mis Evaluados<span class="sr-only">(current)</span></a>
                </li>
                @endif

                @if (Auth::check() && Auth::user()->is_manager)
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('manager.index') }}">FeedBack<span class="sr-only">(current)</span></a>
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
                        <a id="navbarDropdownMenu5" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons " style="font-size:1rem; color: green">person</i> <span class="username">{{ Auth::user()->name }}</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenu5">
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

        </div>

    </nav>

    <main role="main" class="container">

        <div class="row">

            {{-- <div class="col-md-12">
            </div> --}}
            @yield('content')

            {{-- <div class="col-sm-4 col-md-2">
                @section('sidebar')
                @show
            </div> --}}

        </div>

    </main>

    <footer id="footer" class="footer">
        <div class="xcontainer">
           <span class="text-white d-flex justify-content-center">Sistema de Gestion por Competencias Talent360</span>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    {{-- <script src={{ asset('bs40/core/js/jquery-3.2.1.slim.min.js') }}> </script>
    <script src={{ asset('bs40/core/js/popper.min.js') }}> </script>
    <script src={{ asset('bs40/core/js/bootstrap.min.js') }}> </script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS -->
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> --}}
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

    @yield('scripts')

    @include('sweetalert::alert')


  </body>

</html>
