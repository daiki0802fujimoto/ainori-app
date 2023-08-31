<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Report;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(User $user, Request $request)
    {
        $users = User::query()->paginate(20);
        $username = $request->input('username');
        // $originSearch = $username['username'] ?? null;

        // クエリビルダ
        $query = User::query();

        $query->where(function ($query) use ($username) {
            if ($username) {
                $query->orWhere('name', 'like', '%' . $username . '%');
            }
        });
        $users = $query->orderBy('updated_at', 'DESC')->paginate(10);
        
        return view('admins.users')->with(['users' => $users, 'search' => $username]);
        // return view('users.index')->with(['users' => $user->getPaginateByLimit()]);

    }
    public function report(Report $reports, Request $request)
    {
        $reports = Report::query()->paginate(20);
        $username = $request->input('username');
        // $originSearch = $username['username'] ?? null;

        // クエリビルダ
        $query = Report::query();

        $query->where(function ($query) use ($username) {
            if ($username) {
                $query->orWhere('name', 'like', '%' . $username . '%');
            }
        });
        $reports = $query->orderBy('updated_at', 'DESC')->paginate(10);
        
        return view('admins.reports')->with(['reports' => $reports, 'search' => $username]);
    }
    public function register()
    {
        return view('admins.register');
    }
    public function store(User $user, Request $request) 
    {
        $input = $request['user'];
        $input['password'] = Hash::make($input['password']); // パスワードをハッシュ化
        $input['admin'] = true;
        $user->admin = true; // ここで再度代入
        $user->fill($input)->save();
        return redirect('/admin/users');
    }
    public function delete(User $user, Post $post)
    {
        // if($user){
        //     dd($user);
        //     $user->delete();
        // }
        // else{
        //     dd($post);
        // }
        $post->delete();
        return redirect('/admin/users');
    }
}
