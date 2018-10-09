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
        //return 'New post created';
        return response()->json([
            'message' => 'New post created',
        ], 200);
    }

    public function posts_delete(Request $request, $id) {
        $postCheck = Post::where('id', $id)
            ->where('user_id', $request->user_id)
            ->first();
        if(!$postCheck)
            return response()->json([
                'message' => 'Post NOT exists',
            ], 400);
            //dd('Post NOT exists');

        Post::where('id', $id)
        ->where('user_id', $request->user_id)
        ->delete();
        //return 'Post with id = '.$id.' deleted';
        return response()->json([
            'message' => 'Post with id = '.$id.' deleted',
        ], 200);
    }

    public function posts_update(Request $request, $id) {
        $postCheck = Post::where('id', $id)
            ->where('user_id', $request->user_id)
            ->first();
        if(!$postCheck)
            return response()->json([
                'message' => 'Post NOT exists',
            ], 400);

            //dd('Post NOT exists');

        Post::find($id)->update($request->all());
        //return 'Post with id = '.$id.' updated';
        return response()->json([
            'message' => 'Post with id = '.$id.' updated',
        ], 200);
    }

    public function one_post(Request $request, $id) {
        $onePost = Post::where('id', $id)
            ->first();
        if(is_null($onePost)) return response()->json([
            'message' => 'Record not found',
        ], 400);
        return $onePost;
    }

}

