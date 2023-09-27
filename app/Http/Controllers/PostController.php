<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Report;
use App\Http\Requests\PostRequest;
use App\Http\Requests\ReportRequest; 
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Post $post, Request $request)
    {
        $posts = Post::query()->paginate(20);
        $search = $request->input('search');
        $originSearch = $search['origin'] ?? null;
        $destinationSearch = $search['destination'] ?? null;
        $query = Post::query();
        $query->where(function ($query) use ($originSearch, $destinationSearch) {
            if ($originSearch) {
                $query->orWhere('origin', 'like', '%' . $originSearch . '%');
            }
            if ($destinationSearch) {
                $query->orWhere('destination', 'like', '%' . $destinationSearch . '%');
            }
        });
        $posts = $query->orderBy('updated_at', 'DESC')->paginate(3);
        
        if ($request->user()->admin){
            return view('admins.index')->with(['posts' => $posts, 'originSearch' => $originSearch, 'destinationSearch' => $destinationSearch]);
        }
        else{
            return view('posts.index')->with(['posts' => $posts, 'originSearch' => $originSearch, 'destinationSearch' => $destinationSearch]);
        }
    }
    
    public function admin(Post $post, Request $request)
    {
        $posts = Post::query()->paginate(20);
        $search = $request->input('search');
        $originSearch = $search['origin'] ?? null;
        $destinationSearch = $search['destination'] ?? null;
        $query = Post::query();
        $query->where(function ($query) use ($originSearch, $destinationSearch) {
            if ($originSearch) {
                $query->orWhere('origin', 'like', '%' . $originSearch . '%');
            }
            if ($destinationSearch) {
                $query->orWhere('destination', 'like', '%' . $destinationSearch . '%');
            }
        });
        $posts = $query->orderBy('updated_at', 'DESC')->paginate(10);
        
        return view('admins.index')->with(['posts' => $posts, 'originSearch' => $originSearch, 'destinationSearch' => $destinationSearch]);
    }
    
    public function adminposts(Post $post)
    {
        return view('admins.myposts')->with(['posts' => $post->getPaginateByLimit()]);
    }
    
    public function myposts(Post $post)
    {
        return view('posts.myposts')->with(['posts' => $post->getPaginateByLimit()]);
    }
    
    public function edit(Post $post)
    {
        return view('posts.edit')->with(['post' => $post]);
    }
    
    public function update(PostRequest $request, Post $post)
    {
        $input_post = $request['post'];
        $input_post += ['user_id' => $request->user()->id];
        $post->fill($input_post)->save();
    
        return redirect('/myposts');
    }
    
    public function delete(Post $post)
    {
        $post->delete();
        if (auth()->user()->admin) {
            return redirect('/admin/posts');
        } 
        else {
            return redirect('/myposts');
        }
    }

    public function show(Post $post)
    {
        return view('posts.show')->with(['post' => $post]);
    }
    
    public function user(Post $post, User $user)
    {
        return view('users.user')->with(['user' => $user, 'posts' => $post->getPaginateByLimit()]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Post $post, PostRequest $request)
    {
        $input = $request['post'];
        $input += ['user_id' => $request->user()->id];
        $post->fill($input)->save();
        return redirect('/myposts');
    }
    
    public function report(Post $post, Report $report, ReportRequest $request)
    {
        $input = $request['post'];
        $input += ['user_id' => $request->user()->id];
        $input += ['post_id' => $post->id];
        $report->fill($input)->save();
        return back();
    }
}