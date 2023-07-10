<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Blog</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1>相乗りしたい投稿</h1>
        <div class='posts'>
            @foreach ($posts as $post)
                <div class='post'>
                    <h2 class='chat'>
                        <a href="/posts/{{ $post->id }}">相乗りチャットする</a>
                    </h2>
                    <p class='origin'>出発地：{{ $post->origin }}</p>
                    <p class='destination'>目的地：{{ $post->destination }}</p>
                    <p class='people'>最大人数：{{ $post->people }}</p>
                    <p class='time_zone'>時間帯：{{ $post->time_zone }}</p>
                    <p class='comment'>コメント：{{ $post->comment }}</p>
                </div>
            @endforeach
        </div>
        <div class='paginate'>
            {{ $posts->links() }}
        </div>
    </body>
</html>