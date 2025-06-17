<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
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
        $post = Post::with(['user', 'comments.user'])->findOrFail($id);
        
        return new PostResource($post);
    }

    public function userPosts(User $user)
    {
        $posts = $user->posts()
            ->latest()
            ->paginate()
            ->through(function ($post) use ($user) {
                $post->setRelation('user', $user);
                return $post;
            });

        return PostResource::collection($posts);
    }

    public function timeline()
    {
        $posts = Post::whereHas('user.followers', function ($query) {
                $query->where('follower_id', auth()->id());
            })
            ->with('user')
            ->latest()
            ->get();

        return PostResource::collection($posts);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return response()->noContent();
    }
}