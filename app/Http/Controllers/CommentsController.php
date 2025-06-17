<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $comment = $post->comments()->create([
            'body' => $validated['body'],
            'user_id' => auth()->id(),
            'post_id' => $post->id
        ]);

        return response()->json([
            'message' => 'Comment added successfully',
            'comment' => $comment->load('user')
        ], 201);
    }

    public function index(Post $post)
    {
        $comments = $post->comments()->with(['user']);

        return response()->json($comments);
    }

    public function destroy(Post $post, Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return response()->json([
                'error' => 'You can only delete your own comments',
            ], 403);
        }

        $comment->delete();
        return response()->noContent();
    }
}