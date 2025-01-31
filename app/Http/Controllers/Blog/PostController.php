<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    function index()
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


        if (request('type')) {
            $posts = $posts->where('type', request('type'));
        }

        if (request('search')) {
            $posts = $posts->where(function ($query) {
                $query->orWhere('id', 'like', '%' . request('search') . '%')
                    ->orWhere('title', 'like', '%' . request('search') . '%')
                    ->orWhere('description', 'like', '%' . request('search') . '%');
            });
        }

        if (request('category')) {
            $posts = $posts->where('category_id', request('category'));
        }

        if (request('from') && request('to')) {
            $posts = $posts->whereBetween('date', [date(request('from')), date(request('to'))]);
        }

        $posts = $posts->with('category')->paginate(20);
        //return inertia('Dashboard/Post/Index', compact('posts', 'categories'));
        return inertia('Blog/Index', [
            'posts' => $posts,
            'categories' => $categories,
            'prop_type' => $type,
            'prop_category_id' => $category_id,
            'prop_posted' => $posted,
            'prop_from' => $from,
            'prop_to' => $to,
            'prop_search' => $search
        ]);
    }

    function show(Post $post)
    {
        $post->category;
        return inertia('Blog/Show', compact('post'));
    }
}
