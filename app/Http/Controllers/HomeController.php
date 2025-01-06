<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    //para los que miran la pagina principal pero no han iniciado sesion
    public function __construct(){
        $this->middleware('auth');
    }

    //
    public function __invoke(){

        //----------------------------------------------------------------
        /*Este mentodo me trae la lista de los seguidores del usuario autenticado.
        La funcion pluck() me filtra de la informacion que trae el metodo followings, unicamente el id.
        La funcion toArray() convierte a array la informacion que trae el metodo followings*/
        //----------------------------------------------------------------

        $ids = auth()->user()->followings->pluck('id')->toArray();
        $posts = Post::whereIn('user_id',$ids)->latest()->paginate(20);


        return view('home',[
            'posts' => $posts
        ]);
    }
}
