@extends('layouts.app')

@section('titulo')
    {{ $user->username }}
@endsection

@section('contenido')   
    <div class="flex justify-center mt-5">
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
            <div class="w-6/12 lg:w-8/12 px-5">
                <img src="{{ $user->imagen ? asset('perfiles').'/'.$user->imagen : asset('img/usuario.svg') }}" alt="imageUser" class="w-50 h-50 rounded-full">
            </div>
            <div class="md:w-6/12 lg:w-8/12 px-5 flex flex-col items-center md:items-start py-10 md:py-10 md:justify-center">
                {{-- para nombre de usuario --}}
                <div class="flex items-center gap-2">
                    <p class="text-gray-700 text-2xl">
                        {{ $user->username }}
                    </p>
    
                    @auth
                        @if ($user->id === auth()->user()->id)
                            <a href="{{route('perfil.index')}}" class="text-gray-500 hover:text-gray-600 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                                  </svg>                              
                            </a>
                        @endif
                    @endauth
                </div>               

                {{-- para numero de seguidores --}}
                <p class="text-gray-800 text-sm mb-3 font-bold mt-5">
                    {{$user->followers()->count()}}
                    <span class="font-normal">@choice('Seguidor|Seguidores',$user->followers()->count())</span>
                    {{-- La directiva @choice permite pasarle una especie de diccionario en la cual en base a una condicion. Se utiliza para manejar pluralización de cadenas de texto de manera sencilla y elegante en las vistas, permitiendo mostrar diferentes mensajes dependiendo de un número dado.  --}}
                </p>

                {{-- para numero de seguidos --}}
                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{$user->followings()->count()}}
                    <span class="font-normal">Siguiendo</span>
                </p>

                {{-- para numero de posts --}}
                <p class="text-gray-800 text-sm mb-3 font-bold">
                {{$user->posts->count()}}
                <span class="font-normal">Posts</span>
                </p>


                @auth
                    @if($user->id !== auth()->user()->id)
                        @if(!$user->siguiendo(auth()->user()))
                            <form action="{{route('users.follow',$user)}}" method="POST">
                                @csrf
                                <input type="submit" class="bg-blue-600 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer" value="Seguir">
                            </form>
                        @else
                            <form action="{{route('users.unfollow',$user)}}" method="POST">
                                @csrf
                                @method('DELETE') 
                                <input type="submit" class="bg-red-600 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer" value="Dejar de seguir">
                            </form>
                        @endif
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <hr class="border-gray-300 mt-5" />

    <section class="container mx-auto mt-5">
        <h2 class="text-3xl justify-center font-black my-5 flex items-center space-x-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
            </svg>
            <span>Publicaciones</span>
          </h2>       
          
          <x-listar-post :posts="$posts"/>
            
    </section>
@endsection