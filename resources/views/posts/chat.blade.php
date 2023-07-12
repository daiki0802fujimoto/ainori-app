<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Chat</title>
    </head>
    <body>
        <div class="back">[<a href="/posts/{{ $post->id }}">戻る</a>]</div>
        <h1 class="title">チャット画面</h1>
    </body>
</html>