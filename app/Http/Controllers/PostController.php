<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Post;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function posts() {
        $posts = Post::all();
        return $posts;
    }

    public function posts_create(Request $request) {
        $userId = User::where('api_token', $request->token)
            ->first();
        Post::create([
            //'user_id' => $request->user_id,
            'user_id' => $userId->id,
            'title' => $request->title,
            'body' => $request->body,
        ]);
        return 'New post created';
    }

    public function posts_delete(Request $request, $id) {
        $postCheck = Post::where('id', $id)
            ->where('user_id', $request->user_id)
            ->first();
        if(!$postCheck) dd('Post NOT exists');

        Post::where('id', $id)
        ->where('user_id', $request->user_id)
        ->delete();
        return 'Post with id = '.$id.' deleted';
    }

    public function posts_update(Request $request, $id) {
        $postCheck = Post::where('id', $id)
            ->where('user_id', $request->user_id)
            ->first();
        if(!$postCheck) dd('Post NOT exists');

        Post::find($id)->update($request->all());
        return 'Post with id = '.$id.' updated';
    }

    public function one_post(Request $request, $id) {
        $onePost = Post::where('id', $id)
            ->first();
        return $onePost;
    }

}

