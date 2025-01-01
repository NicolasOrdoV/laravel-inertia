<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\Put;
use App\Http\Requests\Post\Store;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::paginate(2);
        return inertia('Dashboard/Post/Index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return inertia('Dashboard/Post/Save', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        $post = Post::create($request->validated());
        $this->upload($request, $post);
        return redirect()->route('post.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::get();
        return inertia('Dashboard/Post/Save', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Put $request, Post $post)
    {
        $post->update($request->validated());
        $this->upload($request, $post);
        return to_route('post.index')->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
    }

    public function upload(Request $request, Post $post)
    {
        $request->validate(['image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1024']);
        Storage::disk('public')->delete('image/post/' . $post->image);
        $data['image'] = $filename = time() . '.' . $request->image->extension();
        $request->image->move(public_path('image/post'),  $filename);
        $post->update($data);
        //return to_route('post.index')->with('success', 'Image uploaded successfully');
    }

    public function imageDelete(Post $post)
    {
        Storage::disk('public')->delete('image/post/' . $post->image);
        $post->update(['image' => null]);
        return to_route('post.edit', $post)->with('message', 'Image deleted successfully');
    }
}
