<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    //
    public function store( Request $request){
        $imagen = $request->file('file');

        //genera un id unico apra cada imagen
        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        //para que intervention image la reciba y podamos procesarla
        $imagenServidor = Image::make($imagen);

        //recorta la imagen para que las imagenes subidas a la redsocial sean todas de las mismas dimensiones
        $imagenServidor->fit(1000, 1000);

        // apunta a la ruta de la carpeta  public/uploads para guardar la imagen
        $imagenPath = public_path('uploads') . '/' . $nombreImagen;

        //guardamos la imagen en la ruta
        $imagenServidor->save($imagenPath);   

        return response()->json(['imagen' => $nombreImagen]) ;

    }
}
