<?php

namespace App\Livewire;

use Livewire\Component;

class LikePost extends Component
{
    public $post;
    public $isLiked;
    public $likes;

    // ----------------------------------------------------------------
    // La siguiente funcion trabaja igual que un constructor. Se ejecuta al cargar el archivo, cuando se entra a una publicacion.
    // ----------------------------------------------------------------
    public function mount($post){
        $this->isLiked = $post->checkLike(auth()->user());
        $this->likes = $post->likes->count();
    }

    public function like(){

        //----------------------------------------------------------------
        // El siguiente codigo remplaza el codigo comentado en el archivo show. blade.php, disenado para guardar los likes datos por el usuario a los post.
        // Esta nueva funcion hace lo mismo pero sin recargar toda la pagina, como lo hacia la funcion anterior. En su lugar, solo actualiza el like de la publicacion, usando livewire. De la misma forma que lo haria ajax.
        //Las variables $isLiked y $likes se actualizan en el codigo siguiente para hacer que se ejecute la funcion mount() y de esta forma la actualizacion de los likes y el corazon se haga automaticamente.
        //----------------------------------------------------------------

        if($this->post->checkLike(auth()->user())){
            $this->post->likes()->where('post_id',$this->post->id)->delete();
            $this->isLiked = false;
            $this->likes--;
        }else{
            $this->post->likes()->create([
                'user_id' => auth()->user()->id
            ]);
            $this->isLiked = true;
            $this->likes++;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
