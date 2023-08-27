<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Post $post, Request $request)
    {
        $posts = Post::query()->paginate(20);
        $search = $request->input('search');
        $originSearch = $search['origin'] ?? null;
        $destinationSearch = $search['destination'] ?? null;

        // クエリビルダ
        $query = Post::query();

       // もし検索フォームにキーワードが入力されたら
        // if ($search) {

        //     // 全角スペースを半角に変換
        //     $spaceConversion = mb_convert_kana($search, 's');

        //     // 単語を半角スペースで区切り、配列にする（例："山田 翔" → ["山田", "翔"]）
        //     $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);


        //     // 単語をループで回し、ユーザーネームと部分一致するものがあれば、$queryとして保持される
        //     foreach($wordArraySearched as $value) {
        //         $query->where('origin', 'like', '%'.$value.'%');
        //     }
            
        // }
        $query->where(function ($query) use ($originSearch, $destinationSearch) {
            if ($originSearch) {
                $query->orWhere('origin', 'like', '%' . $originSearch . '%');
            }
            if ($destinationSearch) {
                $query->orWhere('destination', 'like', '%' . $destinationSearch . '%');
            }
        });
        $posts = $query->orderBy('updated_at', 'DESC')->paginate(10);
        
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

        // クエリビルダ
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
            // 管理者の場合の処理
            return redirect('/admin/posts');
        } 
        else {
            // 一般ユーザーの場合の処理
            return redirect('/myposts');
        }
    }

    public function show(Post $post)
    {
        return view('posts.show')->with(['post' => $post]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Post $post, PostRequest $request) // 引数をRequestからPostRequestにする
    {
        $input = $request['post'];
        $input += ['user_id' => $request->user()->id];
        $post->fill($input)->save();
        return redirect('/posts/' . $post->id);
    }
}