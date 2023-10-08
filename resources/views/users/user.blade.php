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
            <div class='posts'>
                <h2 style="margin-top:20px; text-align: center; font-size: 20px;">{{ $user->name }}さんの投稿</h2>
                @foreach ($posts as $post)
                    @if($post->user_id == $user->id)
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
                    @endif
                @endforeach
            </div>
            <div class='paginate'>
                {{ $posts->links('vendor.pagination.tailwind-custom') }}
            </div>
            <div style="margin:5% 30%;">
                <form action="/reports/{{ $post->id }}" id="form_{{ $post->id }}" method="POST">
                    @csrf
                    <div class="report">
                        <h2>このユーザを通報する</h2>
                        <textarea name="post[report]" placeholder="通報理由" style="height:90px; width:100%;">{{ old('report') }}</textarea>
                        <p class="report__error" style="color:red">{{ $errors->first('report') }}</p>
                    </div>
                     <input type="submit" class="text-white bg-red-600 rounded px-3 py-1" value="通報する" onClick="return reportPost()">
                </form>
            </div>
            <script>
                function reportPost() {
                    'use strict'
                    
                    if (confirm('この投稿を通報しますか？')) {
                        alert("送信しました");
                        return true;
                    }
                    else {
                        alert("キャンセルしました");
                        return false;
                    }
                }
            </script>
        </body>
    </x-app-layout>
</html>