<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Library\Message;   // for new Message;
use App\Events\MessageSent; // for MessageSent::dispatch()

class ChatController extends Controller
{
    public function __construct()
    {
        // 認証されたユーザーだけが、このコントローラのページにアクセスすることができる。
        $this->middleware('auth');
    }

    public function chat(Post $post)
    {
        return view('chats.chat')->with(['post' => $post]);
    }
    
    // メッセージ送信時の処理
    public function sendMessage( Request $request )
    {
        // auth()->user() : 現在認証しているユーザーを取得
        $user = auth()->user();
        $strUsername = $user->name;
        
        // リクエストからデータの取り出し
        $strMessage = $request->input('message');
        
        // メッセージオブジェクトの作成と公開メンバー設定
        $message = new Message;
        $message->username = $strUsername;
        $message->body = $strMessage;
       
        // 送信者を含めてメッセージを送信
        //event( new MessageSent( $message ) ); // Laravel V7までの書き方
        MessageSent::dispatch($message);    // Laravel V8以降の書き方
        
        // 送信者を除いて他者にメッセージを送信
        // Note : toOthersメソッドを呼び出すには、
        //        イベントでIlluminate\Broadcasting\InteractsWithSocketsトレイトをuseする必要がある。
        //broadcast( new MessageSent($message))->toOthers();
        
        //return ['message' => $strMessage];
        return $request;
    }
}

