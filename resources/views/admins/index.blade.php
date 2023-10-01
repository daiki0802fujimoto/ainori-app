<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Taxi</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <x-app-layout>
        <x-slot name="header">
            管理画面
        </x-slot>
        <body>
            <h1 style="text-align: center;">管理画面</h1>
            <h1 style="text-align: center;">相乗りマッチング</h1>
            
            <form method="GET" action="/admin">
                @csrf
                <input type="search" placeholder="出発地を入力" name="search[origin]" style="width: 200px; height: 30px; margin-left: 20px;" value="@if (isset($originSearch)) {{ $originSearch }} @endif">
                <input type="search" placeholder="目的地を入力" name="search[destination]" style="width: 200px; height: 30px; margin-left: 20px;" value="@if (isset($destinationSearch)) {{ $destinationSearch }} @endif">
                <span>
                    <button type="submit" style="color: blue;">検索</button>
                    <button>
                        <a href="/admin" style="color: red;">
                            クリア
                        </a>
                    </button>
                </span>
            </form>
            
            <h2 style="margin-left: 20px;">募集中の投稿</h2>
            <div class='posts'>
                @foreach ($posts as $post)
                    <div class='post'>
                        <div class='chat' style="margin-left: 10px; color: red;">
                            <a href="/posts/{{ $post->id }}">この投稿で相乗りする</a>
                        </div>
                        <span style="margin-left: 20px;">投稿者：<a href="/admin/user/{{ $post->user_id }}">{{ $post->user->name }}</a></span>
                        <span class='origin' style="margin-left: 20px;">出発地：{{ $post->origin }}</span>
                        <span class='destination' style="margin-left: 20px">目的地：{{ $post->destination }}</span>
                        <span class='people' style="margin-left: 20px">最大人数：{{ $post->people }}</span>
                        <span class='time_zone' style="margin-left: 20px">時間帯：{{ $post->time_zone }}</span>
                        <span class='comment' style="margin-left: 20px">コメント：{{ $post->comment }}</span>
                    </div>
                @endforeach
            </div>
            <div class='paginate'>
                {{ $posts->links('vendor.pagination.tailwind-custom') }}
            </div>
        </body>
    </x-app-layout>
</html>