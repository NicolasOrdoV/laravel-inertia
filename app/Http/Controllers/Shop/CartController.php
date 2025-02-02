<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Post $post, int $count)
    {
        $cart = session('cart', []);
        //delete
        if ($count <= 0) {
            if (Arr::exist($cart, $post->id)) {
                unset($cart[$post->id]);
                session(['cart' => $cart]);
                $this->saveDb($cart);
                return redirect()->back();
            }
        }

        //add
        if (Arr::exist($cart, $post->id)) {
            //update
            $cart[$post->id][1] = $count;
        } else {
            //add
            $cart[$post->id] = [$post, $count];
        }

        session(['cart' => $cart]);
        return redirect()->back();
    }

    private function saveDb($cart)
    {
        if (Auth::check()) {
            $control = time();
            $user = Auth::user();
            foreach ($cart as $c) {
                ShoppingCart::updateOrCreate([
                    'user_id' => $user->id,
                    'post_id' => $c[0]->id,
                ], [
                    'count' => $c[1],
                    'control' => $control,
                    'user_id' => $user->id,
                    'post_id' => $c[0]->id,
                ]);
            }

            ShoppingCart::whereNot('control', $control)
                ->where('user_id', Auth::id())
                ->delete();
        }
    }

    function index()
    {
        return inertia('Shop/Index');
    }
}
