<?php

namespace App\Http\Controllers;

use LDAP\Result;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Validation\ValidatesRequests;

class PostController extends Controller
{
    use ValidatesRequests;

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function index(User $user)
    {
        // dd(Auth::user(), session());
        // dd($user);
        // dd($user->username);

        //filtrar los posts
        // $posts = Post::where('user_id', $user->id)->get();
        $posts = Post::where('user_id', $user->id)->latest()->paginate(1);

        // dd($post);

        return view('layouts.dashboard', [
            'user' => $user, //pasamos la informacion del usuario a la vista
            'posts' => $posts
        ]);
    }

    public function create(User $user)
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        // dd('Guardando post....');
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);

        //guardamos la publiacion

        Post::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id'=> Auth::user()->id
        ]);

        return redirect()->route('post.index', Auth::user()->username);
    }

    public function show(User $user, Post $post)
    {
        return view('posts.show',[
            'post' => $post,
            'user' => $user
        ]);
    }

    public function destroy(Post $post)
    {
        // dd('Eliminando', $post->id);
        Gate::authorize('delete', $post);
        $post->delete();

        //eliminar imagen
        $imagen_path = public_path('uploads/' . $post->imagen);
        
        //la clase file comprueba si existe la imagen y despues de vamos a eliminar
        if (File::exists($imagen_path)) {
            unlink($imagen_path); //con esto eliminamos la imagen del servidor
        }

        return redirect()->route('post.index', Auth::user()->username);

    }
}
