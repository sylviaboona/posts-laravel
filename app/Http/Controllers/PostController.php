<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index(){
        // latest = orderBy('created_at', 'desc')
        $posts = Post::latest()->with(['user', 'likes'])->paginate(20);
        return view('posts.index', [
            'posts' => $posts
        ]);
    }
    public function store(Request $request){
        $this->validate($request, [
            'body'=> 'required'
        ]);

        $request->user()->posts()->create($request->only('body'));
        // $request->user()->posts()->create([
        //     'body'=>$request->body
        // ]);
        return back();

        // Post::create([
        //     'user_id' => auth()->user()->id,
        //     'body'=> $request->body
        // ]);
    }

    public function destroy(Post $post){
        $this->authorize('delete', $post);
        $post->delete();
        return back();
    }
}
