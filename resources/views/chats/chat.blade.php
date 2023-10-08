<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Chat</title>
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
        <div class="content">
            <div class='mypost' onclick="location.href='/posts/{{ $post->id }}'">
                <div style="margin-left: 20px; color: blue; display: flex;">
                    <span>投稿者：</span>
                    <span><a href="/users/{{ $post->user->id }}">{{ $post->user->name }}</a></span>
                </div>
                <div class='origin' style="margin:0 20px; display: inline;">
                    <span style="width: 70px;">出発地：</span>
                    <span id="origin" style="flex: 1;">{{ $post->origin }}</span>
                </div>
                <div class='destination' style="margin:0 20px; display: flex;">
                    <span style="width: 70px;">目的地：</span>
                    <span id="destination" style="flex: 1;">{{ $post->destination }}</span>
                </div>
                <div class='people' style="margin:0 20px; display: flex;">
                    <span style="width: 85px;">最大人数：</span>
                    <span style="flex: 1;">{{ $post->people }}</span>
                </div>
                <div class='time_zone' style="margin:0 20px; display: flex;">
                    <span style="width: 70px;">時間帯：</span>
                    <span style="flex: 1;">{{ $post->time_zone->format('Y年n月j日H時i分') }}</span>
                </div>
                <div class='comment' style="margin:0 20px; display: flex;">
                    <div style="width: 70px;">コメント：</div>
                    <div style="flex: 1;">{{ $post->comment }}</div>
                </div>
            </div>
        </div>
        <a class="btn btn-link btn-sm" style="margin-left: 10%;" href="/posts/{{ $post->id }}">戻る</a>
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
    
        <small style="margin-left: 20px">ホスト：{{ $post->user->name }}</small>
        <div class="footer" style="margin-bottom: 20px; margin-left: 10px;">
            <a class="btn btn-danger btn-sm" href="/">参加を辞める</a>
        </div>
        <div style="width: 90%; height: 500px; overflow-y: scroll;">
            <ul class="list-disc" id="list_message" style="text-align: auto">
                @foreach ($chats as $chat)
                    @if($chat->post_id === $post->id)
                        @if($chat->user_id == Auth::user()->id)
                            <li>
                                <strong style="color: blue;">{{ $chat->user->name }}</strong>
                                <small style="text-align: right;">{{ $chat->created_at->format('Y/n/j/H:i')  }}</small>
                                <div class="mymessage">
                                    {{ $chat->message }}
                                </div>
                            </li>
                        @else
                            <li>
                                <strong>{{ $chat->user->name }}</strong>
                                <small>{{ $chat->created_at->format('Y/n/j/H:i')  }}</small>
                                <div class="message">
                                    {{ $chat->message }}
                                </div>
                            </li>
                        @endif
                    @endif
                @endforeach
            </ul>
        </div>
            
        <form method="POST" action=""　onsubmit="onsubmit_Form(); return false;">
            @csrf
            <span>
                <input type="text" id="input_message" name="chat[message]" placeholder="メッセージを入力" autocomplete="off" style="margin-top: 10px; width: 500px; height: 30px;"/>
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
            
            function onsubmit_Form()
            {
                let strMessage = elementInputMessage.value;
                if( !strMessage )
                {
                    return;
                }
    
                params = { 'message': strMessage };

                axios
                    .post( '', params )
                    .then( response => {
                        console.log(response);
                    } )
                    .catch(error => {
                        console.log(error.response)
                    } );
    
                elementInputMessage.value = "";
            }
            
            window.addEventListener( "DOMContentLoaded", ()=>
            {
                const elementListMessage = document.getElementById( "list_message" );
                
                window.Echo.private('taxi_matching').listen( 'MessageSent', (e) =>
                {
                    let strUsername = e.message.username;
                    let strMessage = e.message.body;
                    
                    const now  = new Date();
	                const time = now.getFullYear() + "/" + 
				                (now.getMonth() + 1)  + "/" + 
				                now.getDate() + "/" + 
				                now.getHours() + ":" + 
				                now.getMinutes(); 
    
                    let elementLi = document.createElement( "li" );
                    let elementUsername = document.createElement( "strong" );
                    let elementNow = document.createElement( "small" );
                    let elementMessage = document.createElement( "div" );
                    elementUsername.textContent = strUsername;
                    elementNow.textContent = time;
                    elementMessage.textContent = strMessage;
                    elementMessage.classList.add("message");
                    elementLi.append( elementUsername );
                    elementLi.append( elementNow );
                    elementLi.append( elementMessage );
                    elementListMessage.append( elementLi ); 
                });
            } );
        </script>
    </x-app-layout>
</html>
