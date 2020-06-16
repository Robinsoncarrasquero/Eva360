<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{

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
        // Log::info($input);
        // $user = Evaluador::find(1);
        // $user->seleccion= $id;

        return response()->json(['success'=>'Got Simple Ajax Request.'.$input['name']]);
    }
    //
}
