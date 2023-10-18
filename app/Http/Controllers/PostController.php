<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\fileExists;

class PostController extends Controller
{

        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $all_posts = Post::get();
        return view('post.index', compact('all_posts'));
    }
    

    public function create(){
        return view('post.create');
    }

    public function store(Request $request){


        $request->validate([
            'title' => 'required|max:100',
            'description' => 'nullable|max:1600',
            
        ]);

        $data = new Post(); 
        $data -> title = $request->title;
        $data -> description = $request-> description;
        $data -> save();

        return redirect()->route('post.index')->with('success', 'post insert successfull!');
    }

    public function show($id){
        $post = Post::find($id);
        return view('post.show', compact('post'));
       
        
    }

    public function edit($id){
        $post = Post::find($id);
        return view('post.edit', compact('post'));
    }

    public function update(Request $request, $id){
        $post = Post::find($id);
        
        $request->validate([
            'title' => 'required|max:100',
            'description' => 'nullable|max:1600',
            
        ]);

        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'updated_at' => Carbon::now()
        ]);
        return redirect()->route('post.index')->with('success', 'post update successfull!');
    }

    public function destroy($id){
        $post = Post::find($id);
        
         $post->delete();
        
        return back()->with('success', 'post deleted');
    }

    public function statusupdate(Post $post){
        
        if($post->status == 1){
            $post->status = 2;
        }else{
            $post->status = 1;
        }
        $post->save();

        return back()->with('success', 'status updated!');
    }





}
