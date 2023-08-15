<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Taxi</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <x-app-layout>
        <x-slot name="header">
            myposts
        </x-slot>
        <body>
            <h1 style="text-align: center;">相乗りマッチング</h1>
            <h2 style="text-align: center;">相乗りを募集したい方はこちら</h2>
            <div style="text-align: center;  color: red;">
                <button type=“button” onclick="location.href='/posts/create'" style="width: 10em; height: 3em;">【募集する】</button>
            </div>
            
            <form method="GET" action="/">
                @csrf
                <input type="search" placeholder="出発地を入力" name="search[origin]" style="width: 200px; height: 30px; margin-left: 20px;" value="@if (isset($originSearch)) {{ $originSearch }} @endif">
                <input type="search" placeholder="目的地を入力" name="search[destination]" style="width: 200px; height: 30px; margin-left: 20px;" value="@if (isset($destinationSearch)) {{ $destinationSearch }} @endif">
                <span>
                    <button type="submit" style="color: blue;">検索</button>
                    <button>
                        <a href="/" style="color: red;">
                            クリア
                        </a>
                    </button>
                </span>
            </form>
            
            <h2 style="margin-left: 20px;">募集中の投稿</h2>
            <div class='posts'>
                @foreach ($posts as $post)
                    @if($post->user_id == Auth::user()->id)
                        <div class='post' style="border: 2px solid #000; margin: 10px 30px 10px;">
                            <div class="actions" style="display: flex; margin-left: 10px;">
                                <div class='chat' style="margin-left: 10px; color: red;">
                                    <div class="edit"><a href="/myposts/{{ $post->id }}/edit">編集する</a></div>
                                </div>
                                <div>
                                    <form action="/myposts/{{ $post->id }}" id="form_{{ $post->id }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="deletePost({{ $post->id }})" style="margin-left: 10px; color: blue;">削除する</button> 
                                    </form>
                                </div>
                            </div>
                            <span class='user' style="margin-left: 20px;">投稿者：{{ $post->user->name }}</span>
                            <span class='origin' style="margin-left: 20px;">出発地：{{ $post->origin }}</span>
                            <span class='destination' style="margin-left: 20px">目的地：{{ $post->destination }}</span>
                            <span class='people' style="margin-left: 20px">最大人数：{{ $post->people }}</span>
                            <span class='time_zone' style="margin-left: 20px">時間帯：{{ $post->time_zone }}</span>
                            <span class='comment' style="margin-left: 20px">コメント：{{ $post->comment }}</span>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class='paginate'>
                {{ $posts->links() }}
            </div>
            <script>
                function deletePost(id) {
                    'use strict'
            
                    if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                        document.getElementById(`form_${id}`).submit();
                    }
                }
            </script>
        </body>
    </x-app-layout>
</html>