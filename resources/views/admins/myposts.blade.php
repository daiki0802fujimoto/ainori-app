<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Taxi</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <x-app-layout>
        <x-slot name="header">
            管理画面myposts()
        </x-slot>
        <body>
            <div class="footer" style="margin-left: 20px">
                <a href="/admin">戻る</a>
            </div>
            
            <form method="GET" action="/admin/posts">
                @csrf
                <input type="search" placeholder="出発地を入力" name="search[origin]" style="width: 200px; height: 30px; margin-left: 20px;" value="@if (isset($originSearch)) {{ $originSearch }} @endif">
                <input type="search" placeholder="目的地を入力" name="search[destination]" style="width: 200px; height: 30px; margin-left: 20px;" value="@if (isset($destinationSearch)) {{ $destinationSearch }} @endif">
                <span>
                    <button type="submit" style="color: blue;">検索</button>
                    <button>
                        <a href="/admin/posts" style="color: red;">
                            クリア
                        </a>
                    </button>
                </span>
            </form>
            
            <h2 style="margin-left: 20px;">募集中の投稿</h2>
            <div class='posts'>
                @foreach ($posts as $post)
                    <div class='post'>
                        <div class="actions" style="display: flex; margin-left: 10px;">
                            <div class='chat' style="margin-left: 10px; color: red;">
                                <div class="edit"><a href="/admin/posts/{{ $post->id }}/edit">編集する</a></div>
                            </div>
                            <div>
                                <form action="/admin/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="deletePost({{ $post->id }})" style="margin-left: 10px; color: blue;">削除する</button> 
                                </form>
                            </div>
                        </div>
                        <span style="margin-left: 20px;">投稿者：{{ $post->user->name }}</span>
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