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

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Custom styles for this template -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <style>
        .spellcheck{
        color:darkgreen;
        }

        .radio-checkeado,.radio-no-checkeado{
            margin-left: 2px;
        }

        .radio-checkeado{
        width: 1em;
        height: 1em;
        border-radius: 3ex;
        top: -2px;
        left: -3px;
        position: relative;
        background-color:green;
        content: '';
        visibility: visible;
        border: 1px solid white;
        display: inline-block;

        }


        .radio-no-checkeado{
        width: 1em;
        height: 1em;
        border-radius: 3ex;
        top: -2px;
        left: -3px;
        position: relative;
        background-color:orange;
        content: '';
        visibility: visible;
        border: 1px solid white;
        display: inline-block;

        }
        .btnquitar{

        }

        Input:Focus {
            Background-color: yellow;
        }
        input[type=text] {
            width: 100%;
            padding: 2px 10px;
            margin: 4px 0;
            box-sizing: border-box;
        }
        input[type=email] {
            width: 100%;
            padding: 2px 10px;
            margin: 4px 0;
            box-sizing: border-box;
        }
        .title-auth{
            background-color:mediumaquamarine;
        }
    </style>

  </head>

  <body>


    <header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="{{ route('home') }}"><img src="logo/eva360.png" style=" width: 10ex; height:3ex" alt="Vision 360"></a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">

                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
                </li>

                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('lanzar.index') }}">Lanzar Prueba</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('evaluado.index') }}">Evaluado</a>
                    </li>
                    <li class="nav-item">
                        <a  class="nav-link" href="{{ route('tipo.index') }}">Tipo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('competencia.index') }}">Competencias</a>
                    </li>
                    <li class="nav-item ">
                        <a  class="nav-link" href="{{ route('frecuencia.index') }}">Frecuencia</a>
                    </li>
            @endauth

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
                        <i class="material-icons " style="color: green">person</i>{{ Auth::user()->name }} <span class="caret"></span>
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

    <footer class="footer">
      <div class="container">
        <span class="text text-muted">Sistema de Valoracion de Puestos por Competencias Basados en los Métodos o Sistemas de Vision 90 180 360 grados.</span>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    @yield('scripts')

  </body>

</html>
