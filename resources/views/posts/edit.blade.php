<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Blog</title>
    </head>
    <x-app-layout>
        <x-slot name="header">
            edit
        </x-slot>
        <body>
            <!-- body内だけを表示しています。 -->
            <div style="margin-left: 20px">
                <div class="back">[<a href="/myposts">戻る</a>]</div>
                <h1 class="title">編集画面</h1>
                <div class="content">
                    <form action="/myposts/{{ $post->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="origin">
                            <h2>出発地</h2>
                            <input type="text" name="post[origin]" placeholder="例：東京駅" value="{{ $post->origin }}"/>
                        </div>
                        <div class="destination">
                            <h2>目的地</h2>
                            <input type="text" name="post[destination]" placeholder="例：東京タワー" value="{{ $post->destination }}"/>
                        </div>
                        <div class="people">
                            <h2>人数</h2>
                            <input type="number" name="post[people]" placeholder="例：3" value="{{ $post->people }}" min="1" max="3"/>
                        </div>
                        <div class="time_zone">
                            <h2>時間帯</h2>
                            <input type="datetime-local" name="post[time_zone]" placeholder="例：2022-10-10" value="{{ $post->time_zone }}" min="<?php echo date('Y-m-d\TH:i'); ?>"/
                        </div>
                        <div class="comment">
                            <h2>コメント</h2>
                            <textarea name="post[comment]" placeholder="例：よろしくお願いいたします。">{{ $post->comment }}</textarea>
                        </div>
                        <input type="submit" value="保存">
                    </form>
                </div>
            </div>
        </body>
    </x-app-layout>
</html>