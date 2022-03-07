<?php

namespace App\Http\Controllers;

use App\Role;
use App\RoleUser;
use App\User;
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
       $this->middleware('auth');

    }

    /**
     * Show the application entry home.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // $role= Role::firstOrCreate([
        //     'name'=>'simulador',
        // ],['description'=>'Simulador']);

        $role = Role::where('name', 'simulador')->first();

        if($request->user()->hasRole($role->name)){
            return view('mastersimulador');
        }
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


        return view('master');


    }
}
