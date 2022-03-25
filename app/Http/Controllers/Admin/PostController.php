<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Post;
use App\Category;
use App\Tag;

class PostController extends Controller
{
    protected $validation = [
        'title'=>'required|max:200',
        'content'=>'required',
        'category_id'=>'nullable|exists:categories,id'
    ];

    protected function slug($title = "", $id = ""){
        $tmp=Str::slug($title);
        $count=1;
        while(Post::where('slug', $tmp)->where('id', '!=', $id)->first()){
            $tmp=Str::slug($title)."-".$count;
            $count ++;
        };
        return $tmp; 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        $tags = Tag::all();
        return view('admin.posts.index', compact('posts', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=Category::all();
        $post=Post::all();
        $tags=Tag::all();
        return view('admin.posts.create', compact(['post', 'categories', 'tags']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->validation);

        $form_data=$request->all();

        // $slugTmp = Str::slug($form_data['title']);
        // $count=1;
        // while(Post::where('slug', $slugTmp)->first()){
        //     $slugTmp=Str::slug($form_data['title'])."-".$count;
        //     $count ++;
        // };
        $form_data['slug']=$this->slug($form_data['title']);


        // $form_data['slug'] = $slugTmp;
        // $new_post = new Post();

        $newPost = Post::create($form_data);
        $newPost->tags()->sync($form_data['tags']);

        return redirect()->route('admin.posts.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', compact(['post', 'categories', 'tags']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate($this->validation);

        $data = $request->all();

        // if($post->title == $data['title']){
        //     $slug = $data['slug'];
        // }
        // else{
        //     $slug = Str::slug($data['title']);
        //     $count = 1;
        //     while(Post::where('slug', $slug)->where('id', '!=', $post->id)->first()){
        //         $slug = Str::slug($data['title'])."-".$count;
        //         $count ++;
        //     }
        // }
        $data['slug'] = ($post->title == $data['title']) ? $post->slug : $this->slug($data['title'], $post->id);

        $post->update($data);
            
        $post->tags()->sync(isset($data['tags']) ? $data['tags'] : []);
        return redirect()->route('admin.posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
