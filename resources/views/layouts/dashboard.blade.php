@extends('layouts.app')

@section('titulo')
    Perfil: {{$user->username}}
@endsection

@section('contenido')
    {{-- @dd($posts) --}}
    <div class="flex justify-center">
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
            <div class="w-8/12 lg:w-6/12 px-5">
                <img src="{{
                    $user->imagen ? 
                    asset('perfiles') . '/' . $user->imagen : 
                    asset('img/usuario.svg')}}" 
                    alt="Imagen de perfil de {{$user->username}}"
                    class="rounded-full"
                >
            </div>
            <div class="md:w-8/12 lg:w-6/12 p-5 mflex flex-col items-center md:justify-center md:items-start py-10  md:py-10">
                {{-- {{dd($user)}} debugueamos la informacion del user --}}
                {{-- <p>{{Auth::user()->username}}</p> --}}
                <div class="flex items-center gap-2">
                    <p class="text-gray-600 text-2xl">{{$user->username}}</p>
                    @auth
                        {{-- comprobamos que el usuario autenticado sea el mismo --}}
                        @if ($user->id === Auth::user()->id)
                            <a 
                                href="{{route('perfil.index')}}"
                                class="text-gray-500 hover:text-gray-600 cursor-pointer"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                </svg>
                            </a>
                        @endif
                    @endauth
                </div>

                <p class="text-gray-800 text-sm mb-3 font-bold mt-5">
                    {{$user->followers->count()}}
                    <span class="font-normal">
                        {{-- Metodo para poner el texto segun la cantidad --}}
                        @choice('Seguidor|Seguidores', $user->followers->count())
                    </span>
                </p>

                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{$user->following->count()}}
                    <span class="font-normal">Siguiendo</span>
                </p>

                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{$user->posts->count()}}
                    <span class="font-normal"> posts</span>
                </p>
                @auth
                    {{-- Condicion para evitar que nosotros mismos podamos segurinos --}}
                    @if ($user->id !== Auth::user()->id)
                        {{-- Negamos la condicion para saber si ya estamos siguiendo al usuario --}}
                        @if (!$user->siguiendo(Auth::user()))
                            <form 
                                action="{{route('users.follow', $user)}}"
                                method="POST"
                            >
                                @csrf
                                <input 
                                    type="submit"
                                    class="bg-blue-500 text-white rounded-lg uppercase px-3 py-1 text-xs font-bold cursor-pointer"
                                    value="Seguir"
                                >
                            </form>
                        @else
                            <form 
                                action="{{route('users.unfollow', $user)}}"
                                method="POST"
                            >
                                @method('DELETE')
                                @csrf
                                <input 
                                    type="submit"
                                    class="bg-red-500 text-white rounded-lg uppercase px-3 py-1 text-xs font-bold cursor-pointer"
                                    value="Dejar de seguir"
                                >
                            </form>
                        @endif
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <section class="conta mx-auto mt-10">
        <h2 class="text-4xl text-center font-black my-10">
            Publicaciones
        </h2>
        
        {{-- componente de laravel --}}
        <x-listar-post :posts="$posts"/>
        {{-- {{dd($posts)}} --}}
    </section>
@endsection

