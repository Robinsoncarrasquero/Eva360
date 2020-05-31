<?php

namespace App\Http\Controllers;
use App\Evaluador;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\Console\Input\Input;

class AjaxController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function ajaxRequest()
    {
        return view('ajaxRequest');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function ajaxRequestPost(Request $request)
    {
        $input = $request->all();
       // \Log::info($input);
        // $user = Evaluador::find(1);
        // $user->seleccion= $id;



        return response()->json(['success'=>'Got Simple Ajax Request.']);
    }

}
