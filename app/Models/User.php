<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // Atraves de este campo agrego los imputs que laravel no me recibe
    // por defecto, y que tuve que crear y agregar con una migracion 
    // a la BD. Esto se hace para que el modelo sepa que debe capturar y modificar el query y enviar ese campo tambien
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //una relacion es como un query que se hace a BD
    //cada modelo tiene su propia relacion
    //en este caso la siguiente relacion se hace para traer todos los post relacionados a un usuario
    public function posts(){
        //relacion one to many (Donde un usuario puede tener multiples post)
        return $this->hasMany(Post::class);
    }

    //trae todos los post a los cuales se les ha dado like
    public function likes(){
        return $this->hasMany(like::class);
    }

    //Almacena los seguidores de un usuario
    public function followers(){
        return $this->belongsToMany(User::class,'followers','user_id','follower_id');
    }

    //Almacena los que seguimos
    public function followings(){
        return $this->belongsToMany(User::class,'followers','follower_id','user_id');
    }

    //comprobar si un usuario ya lo esta siguiendo
    public function siguiendo (User $user){
        return $this->followers->contains($user->id);
    }

    


}
