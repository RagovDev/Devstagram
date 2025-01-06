<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('perfil.index');
    }

    public function store(Request $request){
        // Modifica el request
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            'username' => ['required','unique:users,username,'.auth()->user()->id,'min:3','max:20','not_in:twitter,editar-perfil'],
        ]);

        if($request->imagen){
            $imagen = $request->file('imagen');

            //genera un id unico apra cada imagen
            $nombreImagen = Str::uuid() . "." . $imagen->extension();
    
            //para que intervention image la reciba y podamos procesarla
            $imagenServidor = Image::make($imagen);
    
            //recorta la imagen para que las imagenes subidas a la redsocial sean todas de las mismas dimensiones
            $imagenServidor->fit(1000, 1000);
    
            // apunta a la ruta de la carpeta  public/uploads para guardar la imagen
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
    
            //guardamos la imagen en la ruta
            $imagenServidor->save($imagenPath);   
        }

        //Guardar cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save();

        //Redireccionar
        return redirect()->route('posts.index',$usuario->username);
    }
}
