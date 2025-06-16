<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;

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
            'message' => $post,
        ], 201);
    }

    public function show(Post $post)
    {
        return response()->json($post, 200);
    }
}