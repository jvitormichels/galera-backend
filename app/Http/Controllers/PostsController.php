<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;

use App\Http\Resources\PostResource;

class PostsController extends Controller
{
    public function store(Request $request)
    {
        $registerPostData = $request->validate([
            'text'=>'required|string'
        ]);

        $user = auth()->user();
        $post = $user->posts()->create($request->only('text'));

        return response()->json([
            $post,
        ], 201);
    }

    public function show($id)
    {
        $post = Post::with('user')->findOrFail($id);
        
        return new PostResource($post);
    }

    public function index()
    {
        $posts = Post::with('user')->get();
        
        return PostResource::collection($posts);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            'message' => "Post deleted"
        ], 204);
    }
}