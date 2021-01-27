<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index() {
        $data = [
            'posts' => Post::all()
        ];
        return view('guest.posts.index', $data);
    }
    public function show($slug) {
        $post = Post::where('slug', $slug)->first();
        if(!$post) {
            abort(404);
        }
        $data = ['post' => $post];
        return view('guest.posts.show', $data);
    }
}
