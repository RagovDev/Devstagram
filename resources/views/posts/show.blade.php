@extends('layouts.app')

@section('titulo')
    {{ $post->titulo }}
@endsection

@section('contenido')
    <section class="container mx-auto md:flex">  
        
        {{-- Contenedor izquierdo, imagen --}}
        <div class="md:w-1/2">

            {{-- Imagen --}}
            <img src="{{ asset('uploads').'/'.$post->imagen }}" alt="Imagen del post {{ $post->titulo }}">

            {{-- Likes --}}
            <div class="p-3 flex items-center gap-4">
                {{-- para que solo una persona autenticada pueda dar like a un post --}}
                @auth  

                    {{-- se usa comilla doble para crear la variable segun  la documentacion de livewire --}}
                    <livewire:like-post :post="$post" />

                    {{-- ------------------------------------------------------------------ --}}
                    {{-- El siguiente codigo fue remplazada por el codigo que se usa en los archivos like-post.blade.php y LikePost.php. Usando la libreria de componentes livewire --}}

                    {{-- para los usuarios que no han dado like --}}

                    {{-- @if($post->checkLike(auth()->user()))  
                        <form action="{{route('posts.likes.destroy',$post)}}" method="post">
                            @method('DELETE')
                            @csrf
                            <div class="my-4">
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" data-slot="icon" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>                  
                                </button>
                            </div>
                        </form>      --}}

                    {{-- para los usuarios que ya hicieron like en una publicacion --}}

                    {{-- @else
                        <form action="{{route('posts.likes.store',$post)}}" method="post">
                            @csrf
                            <div class="my-4">
                                
                            </div>
                        </form>
                    @endif --}}

                    {{-- ------------------------------------------------------------------ --}}

                @endauth    
            </div> 

            {{-- info del post --}}
            <div>
                <p>
                    {{-- nombre usuario --}}
                    <span class="font-bold">{{ $post->user->username }}</span>
                    {{-- descripcion del post --}}
                    <span class="ms-2">{{ $post->descripcion }}</span>
                </p>                
                <p class="text-sm text-gray-500 pt-1">{{ $post->created_at->diffForHumans() }}</p>
            </div>

            @auth
                @if ($post->user_id == auth()->user()->id)
                    <form action="{{route('posts.destroy', $post)}}" method="post">
                        {{-- la directiva @method('delete') es un  metodo spoofing, permite agregar otro tipo de peticiones, ya que el navegador solo soporte los metodos get y post --}}
                        @method('DELETE')
                        @csrf
                        <input type="submit" value="Eliminar publicacion" class="bg-red-500 hover:bg-red-600 p-2 rounded text-white font-bold mt-4 cursor-pointer ">
                    </form>
                @endif                
            @endauth
        </div>  

        {{-- Contenedor derecho, caja de comentarios  --}}
        <div class="md:w-1/2 p-5">
            <div class="shadow bg-white p-5 mb-5">

                {{-- titulo --}}
                <p class="text-xl font-bold text-center mb-4">Comentarios</p>
                
                {{-------------------------------------------------}}
                {{-- para usuarios autencicados --}}
                @auth                    
                

                @if (session('mensaje'))
                    <div class='bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold'>
                        {{ session('mensaje') }}
                    </div>
                @endif

                {{-- form para hacer comentario --}}
                <form action="{{ route('comentarios.store', ['post'=>$post, 'user'=>$user] ) }}" method="POST">
                    @csrf
                    {{-- caja comentario nuevo --}}
                    <div class="mb-5">
                        <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">
                            Añade un comentario
                        </label>
                        <textarea id="comentario" name="comentario" placeholder="Agrega un comentario" class="border p-3 w-full rounded-lg @error('comentario') border-red-500 @enderror"> </textarea>

                        @error('comentario')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                        @enderror
                    </div> 

                    {{-- Boton submit --}}
                    <input type="submit" value="Comentar" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg">           
                </form>

                @endauth
                {{-------------------------------------------------}}

                <div class="bg-white shadow-inner mb-5 max-h-96 overflow-y-scroll mt-5">
                    @if ($post->comentarios->count())
                    @foreach ($post->comentarios as $comentario)
                        <div class="p-5 border-gray-300 border-b">
                        {{-- $comentario para acceder al item iterado y luego nuevamente comentario para acceder a la columna comentario del item que estamos iterando --}}
                            <p>
                                <a href="{{route('posts.index', $comentario->user)}}" class="font-bold">
                                    {{$comentario->user->username}}
                                </a>                            
                                {{ $comentario->comentario }}
                            </p>
                            <p class="text-sm text-gray-500">{{ $comentario->created_at->diffForHumans() }}</p>
                        </div>
                    @endforeach
                        
                    @else
                        <p class="p-10 text-center">
                            No hay comentarios aún.
                        </p>
                    @endif                    
                </div>

            </div>    
        </div>   

    </section>
@endsection