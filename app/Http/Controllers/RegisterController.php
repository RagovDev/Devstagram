<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //
    public function index() {
        return view('auth.register');
    }

    public function store(Request $request){
        // dd('Post...');
        // dd($request->get('name'));

        // Modifica el request
        $request->request->add(['username' => Str::slug($request->username)]);

        //validacion
        $this->validate($request, [
            // Cualquiera de las dos sintaxis se puede usar
            //laravel recomienda usar la sintaxis de arreglo cuando son mas de tres reglas de validacion, por ende, es mejor usar siempre la sintaxis de arreglo
            // 'name' => ['required','min:5','max:30'],
            'name' => 'required|min:5|max:30',
            'username' => 'required|unique:users|min:5|max:15',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6', 
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username, //convierte a formato url, quita esapcios acento y convierte a minuculas
            'email' => $request->email,
            'password' => Hash::make($request-> password) //por defecto, laravel me hasheo el password. Sin usar la funcion Hash::make(). Pero la uso para aprenderla
        ]);

        //autenticar usuario 
        //funcion que nos da laravel para poder autenticar un usuario
        // auth()->attempt([
        //     'email' => $request->email,
        //     'password' => $request->password
        // ]);

        // otra forma de autenticar
        auth()->attempt($request->only('email', 'password'));

        // redireccionamos a los datos
        return redirect()->route('post.index', auth()->user()->username);

    }
}
