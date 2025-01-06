{{-- directivas (apuntan automaticamente a la carpeta views) --}}
@extends('layouts.app')

@section('titulo')
    Página Principal
@endsection

@section('contenido')

    {{-- ----------------------------------------- --}}
    {{-- La x seguida de un guuion, indica que el codigo es un componente. Este componente puede tener slots o no. Si el componente tiene diagonal (/) de cierre, en la etiqueta de apertura significa que el componente no admite slots; asi: <x-listar-post/>.
    Pero si el componente tiene apertura y cierre por separado, asi:  <x-listar-post>Contenido<x-listar-post/>, entonces si permite tener slots, es decir que todo lo escrito entre las etiquetas sera enviado ala vista listar.blade.php
    Ahora dentro del component puedo crear multiples varibles de tipo slot, que puede pasar cada una con su propia informacion proveniente de diferentes lugares --}}
    {{-- <x-listar-post>
        <x-slot:titulo>
            <header>Esto es un header</header>
        </x-slot:titulo>
        <h1>Mostrando Post desde slot</h1>
    </x-listar-post> --}}
    {{-- ----------------------------------------- --}}

    <x-listar-post :posts="$posts"/>

@endsection