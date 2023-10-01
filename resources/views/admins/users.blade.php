<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Taxi</title>
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
            <table class="users_table">
                <thead>
                    <tr>
                        <td>管理者</td>
                        <td>アイコン</td>
                        <td>ユーザネーム</td>
                        <td>メールアドレス</td>
                        <td>年齢</td>
                        <td>性別</td>
                        <td>削除</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            @if($user->admin)
                                <td class='admin' style="margin-left: 20px; color: red;">○</td>
                            @else
                                <td class='admin' style="margin-left: 20px; color: red;"></td>
                            @endif
                            <td class='comment' style="margin-left: 20px">{{ $user->image }}</td>
                            <td style="margin-left: 20px;"><a href="/admin/user/{{ $user->id }}">{{ $user->name }}</a></td>
                            <td class='origin' style="margin-left: 20px;">{{ $user->email }}</td>
                            <td class='people' style="margin-left: 20px">{{ $user->age }}</td>
                            <td class='time_zone' style="margin-left: 20px">{{ $user->sex->sex }}</td>
                            <td>
                                <form action="/admin/users/{{ $user->id }}" id="form_{{ $user->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="deleteUser({{ $user->id }})" style="margin-left: 10px; color: blue;">削除する</button> 
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class='users'>
            </div>
            <div class='paginate'>
                {{ $users->links('vendor.pagination.tailwind-custom') }}
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