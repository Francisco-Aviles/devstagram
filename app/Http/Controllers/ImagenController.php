<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Laravel\Facades\Image;

class ImagenController extends Controller
{
    //
    public function store(Request $request)
    {
        // dd('Desde imagenes.....');
        // return "Desde imagen controller";

        // $input = $request->all();

        $manager = new ImageManager(new Driver());

        $imagen = $request->file('file');

        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        // Guardar la imagen al servidor
        $imagenServidor = $manager->read($imagen);

        //tamaño que tendra la imagen
        $imagenServidor->scale(1000, 1000);
        
        //ruta donde se guardara la imagen
        $imagenPath = public_path('uploads') . '/' . $nombreImagen;
        $imagenServidor->save($imagenPath);

        return response()->json(['imagen' => $nombreImagen]);
        // return response()->json(['imagen' => $imagen->extension()]);
    }
}
