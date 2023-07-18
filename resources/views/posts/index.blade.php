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
            index
        </x-slot>
        <body>
            <h1 style="text-align: center;">相乗りマッチング</h1>
            <h2 style="text-align: center;">相乗りを募集したい方はこちら</h2>
            <!--<a href='/posts/create'>相乗りを募集する</a>-->
            <div style="text-align: center;  color: red;">
                <button type=“button” onclick="location.href='/posts/create'" style="width: 10em; height: 3em;">【募集する】</button>
            </div>
            <h2 style="margin-left: 20px;">募集中の投稿</h2>
            <div class='posts'>
                @foreach ($posts as $post)
                    <div class='post' style="border: 2px solid #000; margin: 10px 30px 10px;">
                        <div class='chat' style="margin-left: 10px; color: red;">
                            <a href="/posts/{{ $post->id }}">この投稿で相乗りする</a>
                        </div>
                        <span class='user' style="margin-left: 20px;">投稿者：{{ $post->user->name }}</span>
                        <span class='origin' style="margin-left: 20px;">出発地：{{ $post->origin }}</span>
                        <span class='destination' style="margin-left: 20px">目的地：{{ $post->destination }}</span>
                        <span class='people' style="margin-left: 20px">最大人数：{{ $post->people }}</span>
                        <span class='time_zone' style="margin-left: 20px">時間帯：{{ $post->time_zone }}</span>
                        <span class='comment' style="margin-left: 20px">コメント：{{ $post->comment }}</span>
                    </div>
                @endforeach
            </div>
            <div class='paginate'>
                {{ $posts->links() }}
            </div>
        </body>
    </x-app-layout>
</html>