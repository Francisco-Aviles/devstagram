@extends('layouts.app')

@section('titulo')
    Editar Perfil: {{Auth::user()->username}}
@endsection

@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6">
            <form  method="POST" action="{{route('perfil.store')}}" enctype="multipart/form-data" class="mt-10 md:mt-0">
                @csrf
                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">
                        Username
                    </label>
                    <input 
                    type="text" 
                    name="username" 
                    id="username"
                    placeholder="Tu nombre de usuario"
                    value="{{Auth()->user()->username}}"
                    class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror"
                    >
                    @error('username')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{$message}}
                        </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                        Email
                    </label>
                    <input 
                    type="text" 
                    name="email" 
                    id="email"
                    placeholder="Tu nuevo Email"
                    value="{{Auth()->user()->email}}"
                    class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror"
                    >
                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                            {{$message}}
                        </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="imagen" class="mb-2 block uppercase text-gray-500 font-bold">
                        Imagen de Perfil
                    </label>
                    <input 
                    type="file" 
                    name="imagen" 
                    id="imagen"
                    value=""
                    class="border p-3 w-full rounded-lg"
                    accept=".jpg, .jpeg, .png"
                    >
                </div>

                <input 
                type="submit"
                value="Guardar Cambios"
                class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                >
            </form>
        </div>
    </div>
@endsection