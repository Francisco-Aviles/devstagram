<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ComentarioController extends Controller
{
    use ValidatesRequests;

    //
    public function store(Request $request, User $user, Post $post)
    {
        // dd('Desde comentarios');

        //validar
        $this->validate($request, [
            'comentario' => 'required|max:255'
        ]);

        //almacenar el comentario
        Comentario::create([
            'user_id'=> $request->user()->id,
            'post_id'=> $post->id,
            'comentario' => $request->comentario
        ]);

        //mostrar un mensaje
        return back()->with('mensaje', 'Se realizo el comentario correctamente');

    }
}
