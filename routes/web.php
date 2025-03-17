<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('principal');
// });

// Route::get('/',[HomeController::class, 'index'])->name('home');
// Como en el controlador solo vamos a tener una unica funcion lo declaramos de esta forma, solo cuando haya 1 funcion
Route::get('/', HomeController::class)->name('home')->middleware('auth');


Route::get('/crear-cuenta',[RegisterController::class,'index'])->name('register');
Route::post('/crear-cuenta',[RegisterController::class,'store']);

Route::get('/login',[LoginController::class,'index'])->name('login');
Route::post('/login',[LoginController::class,'store']);

//usamos metodo post para tener acceso al formulario y hacer mas seguro en endpoint
Route::post('/logout',[LogoutController::class,'store'])->name('logout');

Route::middleware('auth')->group(function(){
    Route::get('/editar-perfil',[PerfilController::class,'index'])->name('perfil.index');
    Route::post('/editar-perfil',[PerfilController::class,'store'])->name('perfil.store');
});


Route::middleware('auth')->group(function(){
    Route::get('/post/create',[PostController::class, 'create'])->name('post.create');
    Route::post('posts',[PostController::class, 'store'])->name('post.store');
});
Route::get('/{user:username}',[PostController::class,'index'])->name('post.index');
Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::delete('/posts/{post}',[PostController::class, 'destroy'])->name('post.destroy');

Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');

Route::post('/imagenes',[ImagenController::class, 'store'])->name('imagenes.store');

//Guardar el like de las fotos
Route::post('/post/{post}/likes',[LikeController::class,'store'])->name('post.imagenes.likes');
Route::delete('/post/{post}/likes',[LikeController::class,'destroy'])->name('post.imagenes.destroy');

//rutas para agregar seguidores
Route::post('/{user:username}/follow',[FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow',[FollowerController::class, 'destroy'])->name('users.unfollow');

