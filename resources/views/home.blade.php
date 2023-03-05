@extends('layouts.app')

@section('titulo')
    Página Principal
@endsection

@section('contenido')
    
    @if ($posts->count())

        @foreach ($posts as $post)
            <div class="container mx-auto md:flex gap-3">
                <div class="md:w-1/2">
                    <p class="font-bold"> <span>@</span>{{$post->user->username}}</p>
                    <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}">
                        <img class="mb-4 mt-1" src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{$post->titulo}}">
                    </a>

                    <div class="flex items-center gap-3">
                        @auth()
                            <livewire:like-post  :post="$post"/>
                        @endauth
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">
                            {{ $post->created_at->diffForHumans() }}
                        </p>
                        <p class="mt-2 mb-10">
                            {{ $post->descripcion }}
                        </p>
                    </div>

                </div>



                <div class="md:w-1/2">
                    
                    <div class="shadow bg-white p-5 mb-5 mt-7">
                        @auth
                            <p class="text-xl font-bold text-center mb-4">Agrega un nuevo comentario</p>
        
                            @if (session('mensaje'))
                                <div class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                                    {{session('mensaje')}}
                                </div>
                            @endif
        
                        
                            <form action="{{ route('comentarios.store', ['post' => $post, 'user' => auth()->user()->username]) }}" method="POST">
                                @csrf
                                <div class="mb-5">
                                    <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">Añade un Comentario</label>
                                    <textarea id="comentario"
                                        name="comentario"
                                        placeholder="Agrega un comentario"
                                        class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror"
                                    ></textarea>
                
                                    @error('comentario')
                                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{$message}}</p>
                                    @enderror
                                </div>
        
                                <input
                                type="submit"
                                value="Comentar"
                                class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                                />
                            </form>
                        @endauth
        
                        <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-10">
                            @if ($post->comentarios->count())
                                @foreach ($post->comentarios as $comentario)
                                    <div class="p-5 border-gray-300 border-b">
                                        <a href="{{ route('post.index', $comentario->user) }}" class="font-bold">
                                            <span>@</span>{{$comentario->user->username}}
                                        </a>
                                        <p>{{ $comentario->comentario }}</p>
                                        <p class="text-sm text-gray-500">{{ $comentario->created_at->diffForHumans() }}</p>
                                    </div>
                                @endforeach
                            @else
                                <p class="p-10 text-center">No Hay Comentarios Aún</p>
                            @endif
                        </div>
                    </div>

                    
                </div>
            </div>
        @endforeach

        {{-- <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($posts as $post)
                <div>
                    <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}">
                        <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{$post->titulo}}">
                    </a>
                </div>
            @endforeach
        </div> --}}
    @else
        <p class="text-center">No hay posts, sigue a otras cuentas!</p>
    @endif

@endsection