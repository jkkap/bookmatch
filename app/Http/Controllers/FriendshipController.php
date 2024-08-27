<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FriendshipController extends Controller
{
     // フレンドリクエストを送信
    public function sendRequest($receiverId)
    {
        $friendship = Friendship::create([
            'requester_id' => auth()->id(),
            'receiver_id' => $receiverId,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Friend request sent!']);
    }

    // フレンドリクエストを承認
    public function acceptRequest($requesterId)
    {
        $friendship = Friendship::where('requester_id', $requesterId)
                                ->where('receiver_id', auth()->id())
                                ->firstOrFail();

        $friendship->update(['status' => 'accepted']);

        return response()->json(['message' => 'Friend request accepted!']);
    }

    // フレンドリクエストを拒否
    public function rejectRequest($requesterId)
    {
        $friendship = Friendship::where('requester_id', $requesterId)
                                ->where('receiver_id', auth()->id())
                                ->firstOrFail();

        $friendship->update(['status' => 'rejected']);

        return response()->json(['message' => 'Friend request rejected!']);
    }
}
