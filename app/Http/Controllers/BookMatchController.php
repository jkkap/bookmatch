<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models_User;
use App\Models\BookMatch;

class BookMatchController extends Controller
{
    public function createMatch(User $user1, User $user2)
    {
        $genre = $user1->preference === $user2->preference ? $user1->preference : 'Mixed Genre';

        $match = BookMatch::create([
            'user1_id' => $user1->id,
            'user2_id' => $user2->id,
            'genre' => $genre,
        ]);

        return response()->json(['match' => $match], 201);
    }

    // ユーザーのマッチングを表示するメソッド
    public function showMatches(User $user)
    {
        $matches = $user->bookMatches();

        return response()->json(['matches' => $matches], 200);
    }
    
}
