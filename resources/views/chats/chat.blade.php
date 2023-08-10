<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Chat</title>
    </head>
    <x-app-layout>
        <x-slot name="header">
            Chat
        </x-slot>
        
        <div class="content">
            <div class="content__post" style="border: 2px solid #000; margin: 10px 30px 10px;">
                <small style="margin-left: 20px">{{ $post->user->sex_id }}</small>
                <small style="margin-left: 20px">{{ $post->user->name }}</small>
                <span class='user' style="margin-left: 20px">投稿者：{{ $post->user->name }}</span>
                <span class='origin' style="margin-left: 20px">出発地：{{ $post->origin }}</span>
                <span class='destination' style="margin-left: 20px">目的地：{{ $post->destination }}</span>
                <span class='people' style="margin-left: 20px">最大人数：{{ $post->people }}</span>
                <span class='time_zone' style="margin-left: 20px">時間帯：{{ $post->time_zone }}</span>
                <span class='comment' style="margin-left: 20px">コメント：{{ $post->comment }}</span>   
            </div>
        </div>
        <a href="/posts/{{ $post->id }}">【戻る】</a>
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
    
        <small style="margin-left: 20px">ホスト：{{ $post->user->name }}</small>
        <small style="margin-left: 20px">ポストID：{{ $post->id }}</small>
        <div class="footer" style="margin-bottom: 40px; margin-left: 10px; color: red;">
            <!--<a href="javascript:history.back()">[戻る]</a>-->
            <a href="/">【参加を辞める】</a>
        </div>
        
        {{-- エンターキーによるボタン押下を行うために、
             <button type="button">ではなく、<form>と<button type="submit">を使用。
             ボタン押下(=submit)時にページリロードが行われないように、
             onsubmitの設定の最後に"return false;"を追加。
             (return false;の結果として、submitが中断され、ページリロードは行われない。）--}}
        <ul class="list-disc" id="list_message">
            @foreach ($chats as $chat)
                @if($chat->post_id === $post->id)
                    <li>
                        <strong>{{ $chat->user->name }}</strong>
                        <small>{{ $chat->created_at }}</small>
                        <div style="margin: 10px 10px 10px 10px; border: 1px solid #afadad; border-radius: 5px; width: fit-content; padding: 5px 10px;">
                            {{ $chat->message }}
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
        
        
        <!--type="text" name="post[title]" placeholder="タイトル"-->
        <!--<form method="POST" action="/posts/chats" onsubmit="onsubmit_Form(); return false;">-->
        <form method="POST" action=""　onsubmit="onsubmit_Form(); return false;">
            @csrf
            <span>
                <input type="text" id="input_message" name="chat[message]" placeholder="メッセージを入力" autocomplete="off" style="width: 500px; height: 30px;"/>
            </span>
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <input type="submit" class="text-white bg-blue-700 px-4 py-1" value="送信"/>
        </form>
    
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            const elementInputMessage = document.getElementById( "input_message" );
            
            {{-- formのsubmit処理 --}}
            function onsubmit_Form()
            {
                {{-- 送信用テキストHTML要素からメッセージ文字列の取得 --}}
                let strMessage = elementInputMessage.value;
                if( !strMessage )
                {
                    return;
                }
    
                params = { 'message': strMessage };
    
                {{-- POSTリクエスト送信処理とレスポンス取得処理 --}}
                axios
                    .post( '', params )
                    .then( response => {
                        console.log(response);
                    } )
                    .catch(error => {
                        console.log(error.response)
                    } );
    
                {{-- テキストHTML要素の中身のクリア --}}
                elementInputMessage.value = "";
            }
            
            {{-- ページ読み込み後の処理 --}}
            window.addEventListener( "DOMContentLoaded", ()=>
            {
                const elementListMessage = document.getElementById( "list_message" );
                
                {{-- Listen開始と、イベント発生時の処理の定義 --}}
                window.Echo.private('taxi_matching').listen( 'MessageSent', (e) =>
                {
                    {{-- メッセージの整形 --}}
                    let strUsername = e.message.username;
                    let strMessage = e.message.body;
                    
                    const now  = new Date();
	                const time = now.getFullYear() + "/" + 
				                (now.getMonth() + 1)  + "/" + 
				                now.getDate() + "/" + 
				                now.getHours() + ":" + 
				                now.getMinutes(); 
    
                    {{-- 拡散されたメッセージをメッセージリストに追加 --}}
                    let elementLi = document.createElement( "li" );
                    let elementUsername = document.createElement( "strong" );
                    let elementNow = document.createElement( "small" );
                    let elementMessage = document.createElement( "div" );
                    elementUsername.textContent = strUsername;
                    elementNow.textContent = time;
                    elementNow.style.cssText = "margin-left: 20px;";
                    elementMessage.textContent = strMessage;
                    elementMessage.style.cssText = "margin: 10px 10px 10px 10px; border: 1px solid #afadad; border-radius: 5px; width: fit-content; padding: 5px 10px;";
                    elementLi.append( elementUsername );
                    elementLi.append( elementNow );
                    elementLi.append( elementMessage );
                    //elementListMessage.prepend( elementLi );  // リストの一番上に追加
                    elementListMessage.append( elementLi );  // リストの一番下に追加
                });
            } );
        </script>
    </x-app-layout>
</html>
