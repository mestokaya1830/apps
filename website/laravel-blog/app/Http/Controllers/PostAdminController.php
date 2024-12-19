<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Auth::user()->posts()->latest()->paginate(6);
        return view('admin.index', ['posts' => $posts]);
        // $posts = Post::all();
        // $posts = Post::get();
        // $posts = Post::latest();
        // $posts = Post::input();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
            return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //create post without images--------------------
        // $newPost = $request->validate([
        //     'title' => ['required', 'max:255'],
        //     'body' => ['required'],
        //     'image' => ['nullable', 'file', 'max:1024', 'mimes:png,jpg,webp,jpeg']//1mb
        // ]);
        // Post::create($newPost);//without relationship
        // Auth::user()->posts()->create($newPost); without image

        //create post with images and relationship--------------------
        $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
            'image' => ['nullable', 'file', 'max:1024', 'mimes:png,jpg,webp,jpeg']//1mb
        ]);
        $path = null;
        if($request->hasFile('image')){
            $path = Storage::disk('public')->put('post_images', $request->image);
            // 1 Storage::put('post_images', $request->image);//default path
            // 2 Storage::disk('public')->put('post_images', $request->image);//to storage/app/public folder
            //if you want save to public folder outside of storage folder open terminal and paste this
            // php artisan storage:link //or use php artisan storage:unlink to back storage
        }

        Auth::user()->posts()->create([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $path
        ]);

        return back()->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $admin) //with resource route param (not param must be with route)
    {
        return view('admin.show', ['post' => $admin]);
    }
    //or manually id
    // public function show($id) //with resource route param
    // {
    //     $post = Post::find($id);
    //     return view('admin.show', ['post' => $post]);
    // }


    public function edit(Post $admin)
    {
        $post = $admin;
        return view('admin.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $admin)
    {

        //without image----------------------------------------------
        // $updatePost = $request->validate([
        //     'title' => ['required', 'max:255'],
        //     'body' => ['required'],
        //     'image' => ['nullable', 'file', 'max:1024', 'mimes:png,jpg,webp,jpeg']//1mb
        // ]);
        // $admin->update($updatePost);
        // return redirect('admin') ->with('update', 'Your post has been updated successfully!');

        //with image-------------------------------------
        $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
            'image' => ['nullable', 'file', 'max:1024', 'mimes:png,jpg,webp,jpeg']//1mb
        ]);

        $path = $admin->image ?? null;
        if($request->hasFile('image')){
            if($admin->image){
                Storage::disk('public')->delete($admin->image);
            }
            $path = Storage::disk('public')->put('post_images', $request->image);
            $admin->image;
        }
        $admin->update([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $path
        ]);
        return redirect('admin') ->with('update', 'Your post has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $admin)
    {
        $admin->delete();
        if($admin->image){
            Storage::disk('public')->delete($admin->image);
        }
        return redirect('admin') ->with('delete', 'Your post has been deleted successfully!');
    }
}

