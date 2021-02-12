<?php

namespace App\Http\Controllers\PS;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ps.rms.posts.index');
    }

    public function type($type)
    {
        $posts = Post::where('type', '=', $type)
            ->orderBy('created_at', 'desc')->get();

        return view('ps.rms.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ps.rms.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $data = request()->validate([
            'type' => ['required', 'string', 'min:3', 'max:255'],
            'title' => ['required', 'string', 'min:3', 'max:255', 'unique:posts'],
            'content' => ['required', 'min:3'],
            ]);

        $post = Post::create($data);

        return redirect()->route('ps.rms.posts-show', compact('post'))->with('status', 'Posting was successful.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\m  $m
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('ps.rms.posts.show', compact('post'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\m  $m
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('ps.rms.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\m  $m
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post)
    {
        $data = request()->validate([
            'type' => ['required', 'string', 'min:3', 'max:255'],
            'title' => ['required', 'string', 'min:3', 'max:255', Rule::unique('posts')->ignore($post->id)],
            'content' => ['required', 'min:3'],
            ]);

        $post->update($data);

        return redirect()->route('ps.rms.posts-show', compact('post'))->with('status', 'Post modification was successful.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\m  $m
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $type = $post->type;
        $post->delete();

        return redirect()->route('ps.rms.posts', compact('type'))->with('status', 'Post deletion was successful.');
     
    }
}
