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
            
            <form method="GET" action="/admin/reports">
                @csrf
                <input type="search" placeholder="ユーザ名を入力" name="username" style="width: 200px; height: 30px; margin-left: 20px;" value="@if (isset($reportname)) {{ $reportname }} @endif">
                <span>
                    <button type="submit" style="color: blue;">検索</button>
                    <button>
                        <a href="/admin/reports" style="color: red;">
                            クリア
                        </a>
                    </button>
                </span>
            </form>
            
            <h2 style="margin-left: 20px;">通報一覧</h2>
            <div class='reports'>
                @foreach ($reports as $report)
                    <div class='user' style="border: 2px solid #000; margin: 10px 30px 10px;">
                        <span class='user' style="margin-left: 20px;">通報者：<a href="/admin/user/{{ $report->id }}">{{ $report->user->name }}</a></span>
                        <span class='origin' style="margin-left: 20px;">通報理由：{{ $report->report }}</span>
                        <div class='user' style="margin-left: 20px;">投稿者：<a href="/admin/user/{{ $report->id }}">{{ $report->post->user->name }}</a></div>
                        <span class='origin' style="margin-left: 20px;">出発地：{{ $report->post->origin }}</span>
                        <span class='destination' style="margin-left: 20px">目的地：{{ $report->post->destination }}</span>
                        <span class='people' style="margin-left: 20px">最大人数：{{ $report->post->people }}</span>
                        <span class='time_zone' style="margin-left: 20px">時間帯：{{ $report->post->time_zone }}</span>
                        <span class='comment' style="margin-left: 20px">コメント：{{ $report->post->comment }}</span>
                        <div>
                            <form action="/admin/reports/{{ $report->post->id }}" id="form_{{ $report->post->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="deleteUser({{ $report->post->id }})" style="margin-left: 10px; color: blue;">削除する</button> 
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class='paginate'>
                {{ $reports->links() }}
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