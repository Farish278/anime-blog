<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\SavePostRequest;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', 
            [
                'posts' => Post::all()
            ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    private function savePost(Post $post, SavePostRequest $request)
    {
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->content = $request->content;
        $post->excerpt = $request->excerpt;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $post->image = $imagePath;
        }

        $post->published_at = $request->published_at ?: now();
        $post->save();
    }

    public function store(SavePostRequest $request)
    {
        $post = new Post();
        $this->savePost($post, $request);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(SavePostRequest $request, Post $post)
    {
        $this->savePost($post, $request);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
