<?php

namespace App\Http\Controllers\Api\V1\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;

class ChatController extends Controller
{
    public function startChat(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|integer|exists:users,id',
            'chat_type' => 'required|in:user_artist,artist_studio',
        ]);

        $chat = Chat::firstOrCreate([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'chat_type' => $request->chat_type,
        ]);

        return response()->json($chat);
    }

    public function index()
    {
        return Chat::where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->get();
    }
}
