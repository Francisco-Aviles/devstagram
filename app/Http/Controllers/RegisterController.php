<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\USUARIOS;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store( Request $request) 
    {
        //dd($request->get('name'));

        //Modificar el request de username
        $request->request->add(['username' => Str::slug($request->username)]);

        //Validacion
        $validated = $request->validate([
            'name' => 'required|unique:users',
            'username' => 'required|unique:users|min:2|max:20',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6'
            // 'email' => 'required|email',
        ]);

        //Insertamos el registro en la base de datos
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            //agregar funcion para hashear el password
            'password' => Hash::make($request->password)
        ]);

        // Autenticar al usuario
        Auth::attempt($request->only('email', 'password'));


        // auth()->attempt([
        //     'email' => $request->email,
        //     'password' => $request->password
        // ]);

        // $validated = $request->validate([
        //     'name' => 'required|unique:usuarios,nombre',
        //     'username' => 'required|unique:usuarios,usuario|min:2|max:20',
        //     'email' => 'required|email',
        //     'password' => 'required|confirmed|min:6'
        //     // 'email' => 'required|email',

        // ]);


        //DIFERENTES FORMAS DE GUARDAR EN LA BASE DE DATOS, CREANDO EL MODELO SIN MIGRACIONES

        // USUARIOS::create([
        //     'nombre' => $request->name,
        //     'usuario' => $request->username,
        //     'contrasena' => $request->password,
        //     // 'contrasena_confirm ' => $request->password_confirmation
        // ]);

        // $parametros = new USUARIOS();
        // $parametros->nombre = $request->name;
        // $parametros->usuario = $request->username;
        // $parametros->contrasena = $request->password;
        // $parametros->save();

        return redirect()->route('post.index');
    }
}

