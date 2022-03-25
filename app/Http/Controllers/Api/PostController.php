<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index($category = null){
        // return response()->json([
        //     "name"=>"Francesco",
        //     "surname"=>"Abri"
        // ]);

        // if($category){
        //     $posts=Post::where("category_id", $category)->get();
        // }else{
        //     $posts=Post::all();
        // }

        $posts = Post::with('category', 'tags')->get();

        return response()->json($posts);
    }

    public function show($slug){

        $post=Post::where("slug", $slug)->with("category", "tags")->first();

        return response()->json($post);
    }
}
