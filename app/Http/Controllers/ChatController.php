<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Chat;
use App\Models\Room;
use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;

class ChatController extends Controller
{
    public function openChat(User $user)
    {
        // 自分と相手のIDを取得
        $myUserId = auth()->user()->id;
        $otherUserId = $user->id; // ここで相手のユーザーIDを指定

        // データベース内でチャットが存在するかを確認
        $chatroom = Room::where(function($query) use ($myUserId, $otherUserId) {
            $query->where('user1_id', $myUserId)
                ->where('user2_id', $otherUserId);
        })->orWhere(function($query) use ($myUserId, $otherUserId) {
            $query->where('user1_id', $otherUserId)
                ->where('user2_id', $myUserId);
        })->first();

        // チャットが存在しない場合、新しいチャットを作成
        if (!$chatroom) {
            $chatroom = new Room();
            $chatroom->user1_id = $myUserId;
            $chatroom->user2_id = $otherUserId;
            $chatroom->save();
        }

        $messages = Message::where('chatroom_id', $chatroom->id)->orderBy('updated_at', 'DESC')->get();;


        return view('chatrooms/chatroom')->with(['chatroom' => $chatroom, 'messages' => $messages]);
    }
    public function sendMessage(Message $message, Request $request,)
    {
        // auth()->user() : 現在認証しているユーザーを取得
        $user = auth()->user();
        $strUserId = $user->id;
        $strUsername = $user->name;

        // リクエストからデータの取り出し
        $strMessage = $request->input('message');

        // メッセージオブジェクトの作成
        $chatroom = new ChatRoom;
        $chatroom->content = $strMessage;
        $chatroom->chatroom_id = $request->input('chatroom_id');

        $chatroom->userName = $strUsername;
        MessageSent::dispatch($chatroom);    

        //データベースへの保存処理
        $message->sender_id = $strUserId;
        $message->content = $strMessage;
        $message->chatroom_id = $request->input('chatroom_id');
        $message->save();

        return response()->json(['message' => 'Message sent successfully']);
    }
}
