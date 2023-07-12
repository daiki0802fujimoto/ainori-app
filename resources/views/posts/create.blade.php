<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Create</title>
    </head>
    <body>
        <div class="back">[<a href="/">戻る</a>]</div>
        <h1>相乗り投稿</h1>
        <form action="/posts" method="POST">
            @csrf
            <div class="user_id">
                <h2>ユーザID</h2>
                <input type="text" name="post[user_id]" placeholder="例：2" value="{{ old('post.user_id') }}"/>
                <p class="user_id__error" style="color:red">{{ $errors->first('post.user_id') }}</p>
            </div>
            <div class="origin">
                <h2>出発地</h2>
                <input type="text" name="post[origin]" placeholder="例：東京駅" value="{{ old('post.origin') }}"/>
                <p class="origin__error" style="color:red">{{ $errors->first('post.origin') }}</p>
            </div>
            <div class="destination">
                <h2>目的地</h2>
                <input type="text" name="post[destination]" placeholder="例：東京タワー" value="{{ old('post.destination') }}"/>
                <p class="destination__error" style="color:red">{{ $errors->first('post.destination') }}</p>
            </div>
            <div class="people">
                <h2>人数</h2>
                <input type="number" name="post[people]" placeholder="例：3" value="{{ old('post.people') }}" min="1" max="3"/>
                <p class="people__error" style="color:red">{{ $errors->first('post.people') }}</p>
            </div>
            <div class="time_zone">
                <h2>時間帯</h2>
                <input type="datetime-local" name="post[time_zone]" placeholder="例：2022-10-10" value="{{ old('post.time_zone') }}" min="<?php echo date('Y-m-d\TH:i'); ?>"/>
                <p class="time_zone__error" style="color:red">{{ $errors->first('post.time_zone') }}</p>
            </div>
            <div class="comment">
                <h2>コメント</h2>
                <textarea name="post[comment]">よろしくお願いいたします。{{ old('post.comment') }}</textarea>
                <p class="comment__error" style="color:red">{{ $errors->first('post.comment') }}</p>
            </div>
            <input type="submit" value="募集する！"/>
        </form>
    </body>
</html>