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
            管理画面
        </x-slot>
        <body>
            <h1 style="text-align: center;">管理画面</h1>
            <h1 style="text-align: center;">相乗りマッチング</h1>
            
            <form method="GET" action="/admin/users">
                @csrf
                <input type="search" placeholder="ユーザ名を入力" name="username" style="width: 200px; height: 30px; margin-left: 20px;" value="@if (isset($username)) {{ $username }} @endif">
                <span>
                    <button type="submit" style="color: blue;">検索</button>
                    <button>
                        <a href="/admin/users" style="color: red;">
                            クリア
                        </a>
                    </button>
                </span>
            </form>
            
            <h2 style="margin-left: 20px;">ユーザ一覧</h2>
            <div class='users'>
                @foreach ($users as $user)
                    <div class='user' style="border: 2px solid #000; margin: 10px 30px 10px;">
                        @if($user->admin)
                            <span class='admin' style="margin-left: 20px; color: red;">管理者</span>
                        @endif
                        <span class='user' style="margin-left: 20px;">ユーザネーム：<a href="/admin/user/{{ $user->id }}">{{ $user->name }}</a></span>
                        <span class='origin' style="margin-left: 20px;">メールアドレス：{{ $user->email }}</span>
                        <!--<span class='destination' style="margin-left: 20px">：{{ $user->password }}</span>-->
                        <span class='people' style="margin-left: 20px">年齢：{{ $user->age }}</span>
                        <span class='time_zone' style="margin-left: 20px">性別：{{ $user->sex->sex }}</span>
                        <span class='comment' style="margin-left: 20px">画像：{{ $user->image }}</span>
                        <div>
                            <form action="/admin/users/{{ $user->id }}" id="form_{{ $user->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="deleteUser({{ $user->id }})" style="margin-left: 10px; color: blue;">削除する</button> 
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class='paginate'>
                {{ $users->links() }}
            </div>
            <script>
                function deleteUser(id) {
                    'use strict'
            
                    if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                        document.getElementById(`form_${id}`).submit();
                    }
                }
            </script>
        </body>
    </x-app-layout>
</html>