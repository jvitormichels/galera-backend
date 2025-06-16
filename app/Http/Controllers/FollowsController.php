<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Resources\UserResource;

class FollowsController extends Controller
{
    public function followers(User $user)
    {
        $followers = $user->followers;
        return UserResource::collection($followers);
    }

    public function following(User $user)
    {
        $following = $user->following;
        return UserResource::collection($following);
    }

    public function store(User $user)
    {
        if (auth()->id() === $user->id) {
            return response()->json([
                'error' => "You can't follow youself",
            ], 400);
        }

        auth()->user()->follow($user);
        
        return response()->json([
            'message' => "User {$user->name} followed",
        ], 201);
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return response()->json([
                'error' => "You can't unfollow youself",
            ], 400);
        }
        
        auth()->user()->unfollow($user);
        
        return response()->noContent();
    }
}
