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
            <div class="recruit">
                <button class="btn btn-primary btn-lg" type=“button” onclick="location.href='/posts/create'">相乗りを募集する！</button>
            </div>
            
            <form method="GET" action="/">
                @csrf
                <div class="search_box">
                    <input type="search" placeholder="出発地で検索" name="search[origin]" class="search" value="@if (isset($originSearch)) {{ $originSearch }} @endif">
                    <input type="search" placeholder="目的地で検索" name="search[destination]" class="search" value="@if (isset($destinationSearch)) {{ $destinationSearch }} @endif">
                    <span>
                        <button class="btn btn-primary btn-sm" type=“submit”>検索</button>
                        <button>
                            <a class="btn btn-danger btn-sm" href="/">クリア</a>
                        </button>
                    </span>
                </div>
            </form>
            
            <h2 style="text-align: center; font-size: 20px;">募集中の投稿</h2>
            <div class='posts'>
                @foreach ($posts as $post)
                    <div class='index_post' onclick="location.href='/posts/{{ $post->id }}'">
                        <div style="margin-left: 20px; color: blue; display: flex;">
                            <span>投稿者：</span>
                            <span><a href="/users/{{ $post->user->id }}">{{ $post->user->name }}</a></span>
                        </div>
                        <div class='origin' style="margin:0 20px; display: inline;">
                            <span style="width: 70px;">出発地：</span>
                            <span style="flex: 1;">{{ $post->origin }}</span>
                        </div>
                        <div class='destination' style="margin:0 20px; display: flex;">
                            <span style="width: 70px;">目的地：</span>
                            <span style="flex: 1;">{{ $post->destination }}</span>
                        </div>
                        <div class='people' style="margin:0 20px; display: flex;">
                            <span style="width: 85px;">最大人数：</span>
                            <span style="flex: 1;">{{ $post->people }}</span>
                        </div>
                        <div class='time_zone' style="margin:0 20px; display: flex;">
                            <span style="width: 70px;">時間帯：</span>
                            <span style="flex: 1;">{{ $post->time_zone->format('Y年n月j日H時i分') }}</span>
                        </div>
                        <div class='comment' style="margin:0 20px; display: flex;">
                            <div style="width: 70px;">コメント：</div>
                            <div style="flex: 1;">{{ $post->comment }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class='paginate'>
                {{ $posts->links('vendor.pagination.tailwind-custom') }}
            </div>
        </body>
    </x-app-layout>
</html>