<?php

namespace App\Models;


use App\Models\Like;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    //La siguiente relacion belongTo se hace para traer la informacion del usuario relacionada al post realizado
    public function user(){
        return $this->belongsTo(User::class)->select(['name','username']);
    }

    //La relacion hasMany se hace para traer los comentarios relacionados con el post que estoy mirando
    public function comentarios(){
        return $this->hasMany(Comentario::class);
    }

    //La relacion hasMany se hace para traer la info relacionada con el post que estoy mirando al dar like
    public function likes(){
        return $this->hasMany(Like::class);
    }

    // cuenta cuantos likes ha hecho un usuario en una publicacion, utilizando la funcion anterior LIke() que contiene dicha informacion. Por eso en el return le pasamos la variable que contiene esa info.
    // Luego la funcion contains, va ala tabla Likes en la BD y verifica si ya existe mi id en esa tabla y con que publicacion para que no pueda realizar varios likes a la misma publicacion.
    public function checkLike(User $user){
        return $this->likes->contains('user_id',$user->id);
    }
}
