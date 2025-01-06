<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ComentarioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ruta para el home. (se define diferente por que usa un solo metodo, y en este caso es un metodo invoke que es como un constructor, es decir un metodo que se llama automaticamente)
Route::get('/', HomeController::class)->name('home'); //


Route::get('/register', [RegisterController::class,'index'])->name('register');
Route::post('/register', [RegisterController::class,'store'])->name('register');

Route::get('/login', [LoginController::class,'index'])->name('login');
Route::post('/login', [LoginController::class,'store'])->name('login');
Route::post('/logout', [LogoutController::class,'store'])->name('logout');

// Rutas para el perfil
Route::get('/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index');
Route::post('/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');

// muetra la pagina apra crar nuevo post
Route::get('/posts/create', [PostController::class,'create'])->name('post.create');

// guarda un nuevo post
Route::post('/posts',[PostController::class,'store'])->name('posts.store');

// Muestra la web con la info de un post de un user
Route::get('/{user:username}/posts/{post}', [PostController::class,'show'])->name('posts.show');

// Guardar comentario de un user a un post
Route::post('/{user:username}/posts/{post}', [ComentarioController::class,'store'])->name('comentarios.store');

// Guardar imagen de nuevo post
Route::post('/imagenes',[ImagenController::class, 'store'])->name('imagenes.store');

//Eliminar comentarios hechos
Route::delete('/posts/{post}',[PostController::class, 'destroy'])->name('posts.destroy');

//likes a las fotos
Route::post('/posts/{post}/likes',[LikeController::class, 'store'])->name('posts.likes.store');

//delete likes ya dados a publicaciones
Route::delete('/posts/{post}/likes',[LikeController::class, 'destroy'])->name('posts.likes.destroy');

//Este metodo se conoce como route model binding
//Al colocarle llaves convierte el link a verificar en una variable
//user es el nombre de un modelo que se crea por defecto en el proyecto de laravel
//Al colocar el nombre de un modelo en la variable se aplica el metodo routeModelBinding 
Route::get('/{user:username}', [PostController::class,'index'])->name('posts.index');

// Siguiedo usuarios
Route::post('/{user:username}/follow',[FollowerController::class,'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow',[FollowerController::class,'destroy'])->name('users.unfollow'); 