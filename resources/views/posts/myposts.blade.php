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
                <p style="font-size: 20px;">相乗りマッチング！</p>
                <p>ainori</p>
            </div>
        </x-slot>
        <body>
            <div style="text-align: center; margin-top: 10px;">
                <button class="btn btn-primary btn-lg" type=“button” onclick="location.href='/posts/create'">相乗りを募集する！</button>
            </div>
            <div class='posts'>
                @php
                    $hasMatchingPosts = false;
                @endphp
                @foreach ($posts as $post)
                    @if($post->user_id == Auth::user()->id)
                        <div class='mypost'>
                            <div class="actions" style="display: flex; margin-left: 10px;">
                                <div class='chat' style="margin-left: 10px; color: blue;">
                                    <div class="edit"><a class="btn btn-primary btn-sm" href="/myposts/{{ $post->id }}/edit">編集する</a></div>
                                </div>
                                <div>
                                    <form action="/myposts/{{ $post->id }}" id="form_{{ $post->id }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <div>
                                            <button class="btn btn-danger btn-sm" type="button" onclick="deletePost({{ $post->id }})" style="margin-left: 10px; background-color: red;">削除する</button> 
                                        </div>
                                    </form>
                                </div>
                                <div class='chat' style="margin-left: 10px; color: red;">
                                    <button class="btn btn-info btn-sm" type=“button” onclick="location.href='/posts/chats/{{ $post->id }}'">チャットへ</button>
                                </div>
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
                        @php
                            $hasMatchingPosts = true;
                        @endphp
                    @endif
                @endforeach
                
                @if (!$hasMatchingPosts)
                    <p style="text-align: center; margin-top: 10px; font-size: 20px;">まだ投稿はありません</p>
                @endif
            </div>
            <div class='paginate'>
                {{ $posts->links('vendor.pagination.tailwind-custom') }}
            </div>
            <script>
                function deletePost(id) {
                    'use strict'
            
                    console.log("sss");
                    if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                        document.getElementById(`form_${id}`).submit();
                    }
                }
            </script>
        </body>
    </x-app-layout>
</html>