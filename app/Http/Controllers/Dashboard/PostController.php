<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\Put;
use App\Http\Requests\Post\Store;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$posts = Post::where('id', '>=', 1);
        $posts = new Post();
        $categories = Category::get();

        //--data----/
        $type = request('type');
        $category_id = request('category_id');
        $posted = request('posted');
        $from = request('from');
        $to = request('to');
        $search = request('search');

        // $posts = Post::when(request('search'), function (Builder $query, string $search) {
        //     $query->where(function($query) use ($search) {
        //         $query->orWhere('id', 'like', '%' . $search . '%')
        //             ->orWhere('title', 'like', '%' . $search . '%')
        //             ->orWhere('description', 'like', '%' . $search . '%');
        //     })->where(request('type'), function(Builder $query, string $type) {
        //         $query->where('type', $type);
        //     })->where(request('category_id'), function(Builder $query, string $category_id) {
        //         $query->where('category_id', $category_id);
        //     })->where(request('posted'), function(Builder $query, string $posted) {
        //         $query->where('posted', $posted);
        //     })->whereBetween('date', [date(request('from')), date(request('to'))]);

        // })->with('category')->paginate(20);


        if(request('type')) {
            $posts = $posts->where('type', request('type'));
        }

        if(request('search')) {
            $posts = $posts->where(function($query) {
                $query->orWhere('id', 'like', '%' . request('search') . '%')
                    ->orWhere('title', 'like', '%' . request('search') . '%')
                    ->orWhere('description', 'like', '%' . request('search') . '%');
            });
        }

        if(request('category')) {
            $posts = $posts->where('category_id', request('category'));
        }

        if(request('posted')) {
            $posts = $posts->where('posted', request('posted'));
        }

        if(request('from') && request('to')) {
            $posts = $posts->whereBetween('date', [date(request('from')), date(request('to'))]);
        }

        $posts = $posts->with('category')->paginate(20);
        //return inertia('Dashboard/Post/Index', compact('posts', 'categories'));
        return inertia('Dashboard/Post/Index', [
            'posts' => $posts,
            'categories' => $categories,
            'prop_type' => $type,
            'prop_category_id' => $category_id,
            'prop_posted' => $posted,
            'prop_from' => $from,
            'prop_to' => $to,
            'porp_search' => $search
        ]);
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
