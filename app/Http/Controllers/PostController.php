<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except('show','index');
    }
    
    //agregamos el modelo pues en el route wb.php, se esta asignando como variable
    public function index(User $user){ 
        
        //llamamos la info de la BD
        //usamos la funcion paginate para paginar los post realizados por el usuario
        //para que esto funcione, deben hacerse algunos ajustes en el archivo dashboard.blade.php, y agregar en el archivo tailwind.config.js los links de las carpetas de vendor donde se usaran las dependecias de tailwind, para que laravel las encuentre 
        $posts = Post::where('user_id', $user->id)->latest()->paginate(6);

        //Pasamos la info que requerimos ala vista
        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create(){
        return view('posts.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required',
        ]);

        Post::create([
            'titulo'=> $request->titulo,
            'descripcion'=> $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);

        //otra forma de crear registros en BD
        // $post = new Post;
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;
        //$post->save();

        //forma 3; utilizando la relacion creada en el model post
        // $request->user()->posts()->create([
        //     'titulo'=> $request->titulo,
        //     'descripcion'=> $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id' => auth()->user()->id
        // ]);

        return redirect()->route('posts.index', auth()->user()->username);
    }


    public function show(User $user, Post $post){
        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }

    //se usa para borrar una publicacion. Este metodo usa un policdy que se encuentra en el archivo postPolicy.php, el cual se creo usando comando en cmd. COn este policy protegemos de que el usuario que vaya a borrar la publicacion sea el mismo que la creo. Asi tenemos doble proteccion. El metodo authorize retorna true o false. Y ejecuta el metodo que se encuentra en el policy postPolicy.php
    public function destroy(Post $post){
       $this->authorize('delete',$post);
       $post->delete();
       //y para eliminar la imagen hacemos lo siguiente
       $imagen_path = public_path('uploads/'.$post->imagen);

       //File es un facedes.. se encuentra en la clase importada arriba
       if(File::exists($imagen_path)){  
            unlink($imagen_path);
       }
       return redirect()->route('posts.index',auth()->user()->username);
    }
}
