<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Blog</title>
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
            <div class="back" style="margin-left: 10px;">
                <a class="btn btn-link btn-sm" href="/">戻る</a>
            </div>
            <div style="margin:auto; width: 70%;">
                <p style="margin: 10 auto; color: red; text-align: center;">
                    ※すべての項目を入力してください
                </p>
                <form class="create_form" action="/posts" method="POST">
                    @csrf
                    <div class="origin" style="margin: 5px auto; width: 90%;">
                        <h2>出発地</h2>
                        <input type="text" name="post[origin]" placeholder="例：東京駅" style="height:30px; width: 100%;" value="{{ old('post.origin') }}"/>
                        <p class="origin__error" style="color:red">{{ $errors->first('post.origin') }}</p>
                    </div>
                    <div class="destination" style="margin: 5px auto; width: 90%;">
                        <h2>目的地</h2>
                        <input type="text" name="post[destination]" placeholder="例：東京タワー" style="height:30px; width: 100%;" value="{{ old('post.destination') }}"/>
                        <p class="destination__error" style="color:red">{{ $errors->first('post.destination') }}</p>
                    </div>
                    <div class="people" style="margin: 5px auto; width: 90%;">
                        <h2>人数</h2>
                        <input type="number" name="post[people]" value="{{ old('post.people') }}" min="1" max="3"/>
                        <p class="people__error" style="color:red">{{ $errors->first('post.people') }}</p>
                    </div>
                    <div class="time_zone" style="margin: 5px auto; width: 90%;">
                        <h2>時間帯</h2>
                        <input type="datetime-local" name="post[time_zone]" placeholder="例：2022-10-10" value="{{ old('post.time_zone') }}" min="<?php echo date('Y-m-d\TH:i'); ?>"/>
                        <p class="time_zone__error" style="color:red">{{ $errors->first('post.time_zone') }}</p>
                    </div>
                    <div class="comment" style="margin: 5px auto; width: 90%;">
                        <h2>コメント</h2>
                        <textarea name="post[comment]" placeholder="例：よろしくお願いいたします。" style="height:90px; width: 100%;">{{ old('post.comment') }}</textarea>
                        <p class="comment__error" style="color:red">{{ $errors->first('post.comment') }}</p>
                    </div>
                    <div style="margin: 5px auto; width: 10%">
                        <input class="text-white bg-blue-700 rounded px-4 py-1" type="submit" value="募集する！"/>
                    </div>
                </form>
            </div>
        </body>
    </x-app-layout>
</html>