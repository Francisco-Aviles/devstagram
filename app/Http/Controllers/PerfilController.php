<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class PerfilController extends Controller
{
    //
    public function index()
    {
        // dd('Aqui se muestra el formulario');
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        //Modificar el request de username
        $request->request->add(['username' => Str::slug($request->username)]);

        $request->validate([
            'username' => ['required', 'unique:users,username,'.Auth::user()->id, 'min:2', 'max:20', 'not_in:twitter,editar-perfil']
        ]);

        if ($request->imagen) {

            $manager = new ImageManager(new Driver());

            $imagen = $request->file('imagen');
    
            $nombreImagen = Str::uuid() . "." . $imagen->extension();
    
            // Guardar la imagen al servidor
            $imagenServidor = $manager->read($imagen);
    
            //tamaño que tendra la imagen
            $imagenServidor->scale(1000, 1000);
            
            //ruta donde se guardara la imagen
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        //Guardar cambios
        $usuario = User::find(Auth::user()->id);
        $usuario->username = $request->username;
        //sino hay imagen lo guarda como vacio
        $usuario->imagen = $nombreImagen ?? Auth::user()->imagen ?? 'sin imagen';
        $usuario->save();

        //redireccionar al usuario a su perfil
        return redirect()->route('post.index', $usuario->username);
    }
}

