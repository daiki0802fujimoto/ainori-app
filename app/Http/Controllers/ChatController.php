<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Chat;
use Illuminate\Http\Request;
use App\Library\Message;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function chat(Post $post, Chat $chat)
    {
        return view('chats.chat')->with(['post' => $post, 'chats' => $chat->get()]);
    }
    
    public function sendMessage(Chat $chat, Request $request)
    {
        $input = $request['chat'];
        $input['user_id'] = $request->user()->id;
        $input['post_id'] = $request->input('post_id');
        $chat->fill($input)->save();
        
        $user = auth()->user();
        $strUsername = $user->name;
        
        $strMessage = $request->input('chat')['message'];

        $message = new Message;
        $message->username = $strUsername;
        $message->body = $strMessage;
       
        MessageSent::dispatch($message);
        return redirect()->back();
    }
}

