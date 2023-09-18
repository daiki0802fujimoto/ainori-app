<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Taxi</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <x-app-layout>
        <x-slot name="header">
            <div class="custom_header">
                相乗りマッチング！
            </div>
        </x-slot>
        <body>
            <div style="text-align: center; margin-top: 10px;">
                <button class="btn btn-primary btn-lg" type=“button” onclick="location.href='/posts/create'">募集する！</button>
            </div>
            
            <form method="GET" action="/">
                @csrf
                <input type="search" placeholder="出発地で検索" name="search[origin]" style="width: 200px; height: 30px; margin-left: 20px;" value="@if (isset($originSearch)) {{ $originSearch }} @endif">
                <input type="search" placeholder="目的地で検索" name="search[destination]" style="width: 200px; height: 30px; margin-left: 20px;" value="@if (isset($destinationSearch)) {{ $destinationSearch }} @endif">
                <span>
                    <button class="btn btn-primary btn-sm" type=“submit”>検索</button>
                    <button>
                        <a class="btn btn-danger btn-sm" href="/">クリア</a>
                    </button>
                </span>
            </form>
            
            <h2 style="text-align: center; font-size: 20px;">募集中の投稿</h2>
            <div class='posts'>
                @foreach ($posts as $post)
                    <div class='index_post' onclick="location.href='/posts/{{ $post->id }}'">
                        <div style="margin-left: 20px; color: blue;">投稿者：<a href="/user/{{ $post->user_id }}">{{ $post->user->name }}</a></div>
                        <span class='origin' style="margin-left: 20px;">出発地：{{ $post->origin }}</span>
                        <span class='destination' style="margin-left: 20px">目的地：{{ $post->destination }}</span>
                        <span class='people' style="margin-left: 20px">最大人数：{{ $post->people }}</span>
                        <span class='time_zone' style="margin-left: 20px">時間帯：{{ $post->time_zone->format('Y年n月j日H時i分') }}</span>
                        <div class='comment' style="margin-left: 20px">コメント：{{ $post->comment }}</div>
                    </div>
                @endforeach
            </div>
            <div class='paginate'>
                {{ $posts->links('vendor.pagination.tailwind-custom') }}
            </div>
        </body>
    </x-app-layout>
</html>