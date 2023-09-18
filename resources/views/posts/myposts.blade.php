<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Taxi</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <x-slot name="header">
        管理画面
    </x-slot>
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
            <div class='posts'>
                @foreach ($posts as $post)
                    @if($post->user_id == Auth::user()->id)
                        <div class='post'>
                            <div class="actions" style="display: flex; margin-left: 10px;">
                                <div class='chat' style="margin-left: 10px; color: red;">
                                    <div class="edit"><a href="/myposts/{{ $post->id }}/edit">編集する</a></div>
                                </div>
                                <div class='chat' style="margin-left: 10px; color: red;">
                                    <button class="btn btn-primary btn-sm" type=“button” onclick="location.href='/posts/chats/{{ $post->id }}'">チャットへ</button>
                                    <!--<div class="edit"><a href="/posts/chats/{{ $post->id }}">チャットへ</a></div>-->
                                </div>
                                <div>
                                    <form action="/myposts/{{ $post->id }}" id="form_{{ $post->id }}" method="post">
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
                            <span class='time_zone' style="margin-left: 20px">時間帯：{{ $post->time_zone->format('Y年n月j日H時i分') }}</span>
                            <div class='comment' style="margin-left: 20px">コメント：{{ $post->comment }}</div>
                        </div>
                    @endif
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