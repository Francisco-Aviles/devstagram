<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function __invoke()
    {
        $ids = (Auth::user()->following->pluck('id')->toArray());
        $posts = Post::whereIn('user_id',$ids)->latest()->paginate(10);
        // dd($posts);
        return view('home', [
            'posts' => $posts
        ]);
    }


    // public function index()
    // {
    //     return view('principal');
    // }

}
