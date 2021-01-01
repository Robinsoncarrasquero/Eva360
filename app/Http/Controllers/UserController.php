<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\Departamento;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       // $users->withPath('list');
       $buscarWordKey = $request->get('buscarWordKey');
       $users = User::name($buscarWordKey)->orderBy('name','ASC')->paginate(25);

        return \view('user.index',compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $cargos =Cargo::all();
        $departamentos = Departamento::all();
        $roles = Role::all();

        return view('user.create',\compact('roles','cargos','departamentos'));
        return redirect()->back()
        ->withWarning('Los usuarios pueden autoregistrarse por el sistema de autenticacion integrado y verificar su correo.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,1',
            'email' => 'email:rfc,dns',
            'departamento' => 'required',
            'cargo' => 'required',
            'roluser' => 'required',
            ],
            [
            'name.required'=> 'El Nombre es requerido.',
            'cargo.required'=> 'El Cargo es requerido.',
            'departamento.required'=> 'El Departamento es requerido.',
            'roluser.required' => "Rol del usuario es requerido.",
            'email.email' => "Este email es requerido y debe tener el formato correcto.",
            'email.required' => "Email del usuario es unico y obligatorio.",

        ]);

        try {
            $record = new User();
            $record->name=$request->name;
            $record->email=$request->email;
            $record->departamento_id=$request->departamento;
            $record->cargo_id = $request->cargo;
            $record->codigo=$request->codigo;
            $record->email_verified_at= now();
            $record->password = bcrypt('secret1234');
            $record->remember_token=Str::random(10);
            $record->save();

            //Agredamos el nuevo rol
            $new_rol = Role::find($request->roluser);
            $record->roles()->attach($new_rol);


        } catch (QueryException $e) {
            return redirect()->back()
            ->withErrors('Error imposible crear este registro. correo ya fue tomado por otro usuario.');
        }

        Alert::success('Registro exitoso',Arr::random(['Good','Excelente','Magnifico','Muy bien']));

        return \redirect('user')->withSuccess('Usuario : '.$request->name.' Registrado exitosamente');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        //
        $user = User::findOrFail($user);
        $cargos= Cargo::all();
        $departamentos= Departamento::all();
        $roles = Role::all();
        return \view('user.edit',\compact('user','roles','departamentos','cargos'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate(
            [
                'name' => 'required',
                'email' => 'required|unique:users,email,'.$id,
                'roluser' => 'required',
                'newrol' => 'required',
                'departamento' => 'required',
                'cargo' => 'required',
            ],
            [
                'name.required'=>'El nombre es requerido.',
                'email.required' => "Email del usuario es unico y obligatorio.",
                'roluser.required' => "Debe especificar el Rol del usuario.",
                'newrol.required' => "Nuevo Rol es requerido.",
                'email.unique' => "Este email ya ha sido tomado por otro Usuario.",
                'departamento.required' => "Departamento es Requerido.",
                'cargo.required' => "Cargo es Requerido.",

            ]);
        $user =User::findOrFail($id);
        $user->email=$request['email'];
        $user->name = $request['name'];
        $user->cargo_id = $request['cargo'];
        $user->departamento_id = $request['departamento'];
        $user->save();

        //Eliminamos el rol anterior
        $userRol = Role::find($request->roluser);
        $user->roles($userRol)->detach();

        //Agredamos el nuevo rol
        $new_rol = Role::find($request->newrol);
        $user->roles()->attach($new_rol);
        return redirect()->route('user.index')->withSuccess('Usuario Modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        //
        $user = User::find($user);
        if ($user->admin()){
            $success = false;
            $message = "No esta permitido Eliminar Un Administrador del Sistema";
            // return redirect()->back()
            // ->withError('No esta permitido Eliminar Un Administrador del Sistema');
        }else {
            # code...
            try {
                $user->delete();
                $success = true;
                $message = "Usuario eliminado exitosamente";
            } catch (QueryException $e) {
                $success = false;
                $message = "No se puede borrar este usuario, data restringida";
                // return redirect()->back()
                // ->withErrors('Error imposible Eliminar este registro, tiene restricciones con algunas Evaluaciones.');
            }
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);

    }
}
