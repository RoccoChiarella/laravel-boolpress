<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
           'posts' => Post::all()
       ];
       return view('admin.posts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'categories' => Category::all(),
            'tags' => Tag::all()
        ];
        return view('admin.posts.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'exists:tags,id'
        ]);
        $formData = $request->all();
        $newPost = new Post();
        $newPost->fill($formData);
        $slug = Str::slug($newPost->title);
        $slugBase = $slug;
        $currentPost = Post::where('slug', $slug)->first();
        $cont = 1;
        while($currentPost) {
            $slug = $slugBase . '-' . $cont;
            $cont++;
            $currentPost = Post::where('slug', $slug)->first();
        }
        $newPost->slug = $slug;
        $newPost->save();
        if(array_key_exists('tags', $formData)) {
            $newPost->tags()->sync($formData['tags']);
        }
        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if(!$post) {
            abort(404);
        }
        return view('admin.posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if(!$post) {
            abort(404);
        }
        $data = [
            'post' => $post,
            'categories' => Category::all(),
            'tags' => Tag::all()
        ];

        return view('admin.posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'exists:tags,id'
        ]);
        $formData = $request->all();
        if($formData['title'] != $post->title) {
            $slug = Str::slug($formData['title']);
            $slugBase = $slug;
            $post_presente = Post::where('slug', $slug)->first();
            $cont = 1;
            while($post_presente) {
                $slug = $slugBase . '-' . $cont;
                $cont++;
                $post_presente = Post::where('slug', $slug)->first();
            }
            $formData['slug'] = $slug;
        }
        $post->update($formData);
        if(array_key_exists('tags', $formData)) {
            $post->tags()->sync($formData['tags']);
        }
        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        $post->tags()->sync([]);
        return redirect()->route('admin.posts.index');
    }
}
