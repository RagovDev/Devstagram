<div>
    <!-- Knowing is not enough; we must apply. Being willing is not enough; we must do. - Leonardo da Vinci -->
    {{-- ----------------------------------------- --}}
    {{-- Variable slot del componente --}}
    {{-- {{$titulo}} --}}

    {{-- Variable del todo el componente --}}
    {{-- <h1>{{$slot}}</h1> --}}
    {{-- ----------------------------------------- --}}
        
    @if($posts->count())
        <div class="grid md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6">
            @foreach ($posts as $post)
                <div>
                    <a href="{{ route('posts.show', ['post'=>$post, 'user'=>$post->user]) }}">
                        {{ $post->user->username }}
                        <img src="{{ asset('uploads').'/'.$post->imagen }}" alt="Imagen del post {{ $post->titulo }}">
                    </a>
                </div>
            @endforeach
        </div>

        <div class="my-10">
            {{ $posts->links('pagination::tailwind')}}
        </div>
    @else
        <p class="text-center">No hay posts para mostrar, sigue a alguien para poder mostrar sus posts.</p>
    @endif

    
</div>