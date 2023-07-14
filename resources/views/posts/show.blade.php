<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Posts</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <x-app-layout>
        <x-slot name="header">
            show
        </x-slot>
        <body>
            <div class="content">
                <div class="content__post" style="border: 2px solid #000; margin: 10px 30px 10px;">
                    <small style="margin-left: 20px">{{ $post->user->sex_id }}</small>
                    <small style="margin-left: 20px">{{ $post->user->name }}</small>
                    <span class='user' style="margin-left: 20px">投稿者：{{ $post->user->name }}</span>
                    <span class='origin' style="margin-left: 20px">出発地：{{ $post->origin }}</span>
                    <span class='destination' style="margin-left: 20px">目的地：{{ $post->destination }}</span>
                    <span class='people' style="margin-left: 20px">最大人数：{{ $post->people }}</span>
                    <span class='time_zone' style="margin-left: 20px">時間帯：{{ $post->time_zone }}</span>
                    <span class='comment' style="margin-left: 20px">コメント：{{ $post->comment }}</span>   
                </div>
            </div>
            <h1 class="chat">
                チャット画面
            </h1>
            <div class="footer">
                <a href="/">戻る</a>
            </div>
        </body>
    </x-app-layout>
</html>