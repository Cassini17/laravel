<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;

use Carbon\Carbon;

class PostsController extends Controller
{
    // need login to create a post
    public function __construct()
    {
//    	$this->middleware('auth')->except(['index','show']);
    }
    
    public function index()
    {    	
    	$posts = Post::latest()->filter(request(['year','month']))->get();
    	
    	return view('posts.index',compact('posts'));
    }
    
    public function show(Post $post)
    {   	
    	return view('posts.show',compact('post'));
    }
    
    public function create()
    {  
    	return view('posts.create',compact('posts'));
    }
    
    public function store()
    {
    	//dd(request()->all());
    	$this->validate(request(),[
    		'title'=>'required',
    		'body'=>'required'
    	]);
    	
    	auth()->user()->publish(
    		new Post(request(['title','body']))
    	);
    	
    	session()->flash('message','The post was successfully published!');
    	
    	return redirect()->home();  	
    }
    
}
