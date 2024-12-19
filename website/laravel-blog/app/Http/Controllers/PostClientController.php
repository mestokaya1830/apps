<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->paginate(6);
        return view('client.index', ['posts' => $posts]);
        // $posts = Post::all();
        // $posts = Post::get();
        // $posts = Post::latest();
        // $posts = Post::input();
    }


    public function clientUserPosts(User  $user)
    {
       $posts = $user->posts()->latest()->paginate(6);
        return view('client.posts', ['posts' => $posts, 'user' => $user->name]);
    }

    public function show($id)
    {
       $post = Post::find($id);
        return view('client.show', ['post' => $post]);
    }
}

