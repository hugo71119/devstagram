<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct()
    {
        // Tiene que estar autenticado para ver la pagina principal pero si no lo esta, lo llevas a el 'login
        $this->middleware('auth');
    }

    public function index()
    {
        // Obtener a quienes seguimos (obteniendo los id's de las personas que seguimos)
        $ids = auth()->user()->followings->pluck('id')->toArray();
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);


        // Pasando información hacia la vista
        return view('home', [
            'posts' => $posts
        ]);
    }
}
