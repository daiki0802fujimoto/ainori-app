<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Posts</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <div class="footer">
            <a href="/">戻る</a>
        </div>
        <div class="content">
            <div class="content__post" style="border: 2px solid #000; margin: 10px 30px 10px;">
                <span class='user'>投稿者：{{ $post->user->name }}</span>
                <span class='origin'>出発地：{{ $post->origin }}</span>
                <span class='destination'>目的地：{{ $post->destination }}</span>
                <span class='people'>最大人数：{{ $post->people }}</span>
                <span class='time_zone'>時間帯：{{ $post->time_zone }}</span>
                <span class='comment'>コメント：{{ $post->comment }}</span>   
            </div>
        </div>
        <div>あと何人</div>
        <div class="chat">
            <button type=“button” onclick="location.href='/posts/{{ $post->id }}/chat'" style="width: 10em; height: 3em;">参加する</button>
        </div>
    </body>
</html>