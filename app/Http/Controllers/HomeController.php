<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      // $this->middleware('auth');
    }

    /**
     * Show the application entry home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        return view('master');

    }

    /**Hacer el logout */
    public function logout()
    {

        Auth::logout();
        return redirect()->route('vision360');
    }

    /**Mostrar un view con una breve descripcion del sistema */
    public function vision360(){

        return view('vision360');


    }
}
