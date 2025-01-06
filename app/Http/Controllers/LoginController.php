<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{    
    public function index() {
        return view('auth.login');
    }

    public function store(Request $request) {

        //valida los datos recibidos que nos interesa para continuar con el inicio de session
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //autentica en bd los datos recibidos 
        if(!auth()->attempt($request->only('email', 'password'), $request->remember)){
            //redirecciona al link de donde proviene la informaicon y muestra el mensaje indicado
            return back()->with('mensaje','Credenciales incorrectas');
        }

        //redireccionamos si la autenticacion fue correcta
        return redirect()->route('posts.index', auth()->user()->username);
    }
}
