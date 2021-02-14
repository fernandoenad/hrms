<?php

namespace App\Http\Controllers\ICTU;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupportController extends Controller
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
        $posts = Post::where('type', '=', 'Help')
            ->orderBy('created_at', 'desc')->paginate(15);

        return view('ictu.support.index', compact('posts'));
    }

    public function search()
    {
        $str = request()->get('str');

        $posts = Post::where('type', '=', 'Help')
            ->where(function ($query) use ($str){
                $query->where('title', 'like', '%' . $str . '%')
                    ->orWhere('title', 'like', '%' . $str . '%');
            })
            ->orderBy('created_at', 'desc')->paginate(15);

        $posts = $posts->appends(['str' => $str]);

        return view('ictu.support.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ictu.support.create');
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

        return redirect()->route('ictu.support.show', compact('post'))->with('status', 'Posting was successful.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('ictu.support.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('ictu.support.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
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

        return redirect()->route('ictu.support.show', compact('post'))->with('status', 'Post modification was successful.');       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('ictu.support')->with('status', 'Post deletion was successful.');
    }
}
