<?php

namespace App\Http\Controllers\Api\V1\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use App\Events\Chat\NewChatStarted;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController as BaseController;
class ChatController  extends BaseController
{
    public function startChat(Request $request)
    {
        try {

            $this->validate($request, [
                'receiver_id' => 'required|integer|exists:users,id',
                'chat_type' => 'required|in:user_artist,artist_studio',
            ]);
            $validator = Validator::make($request->all(), [
                'receiver_id' => 'required|integer|exists:users,id',
                'chat_type' => 'required|in:user_artist,artist_studio',
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first(),$errorMessages = [], 422);
            }

            $chat = Chat::firstOrCreate([
                'sender_id' => auth()->id(),
                'receiver_id' => $request->receiver_id,
                'chat_type' => $request->chat_type,
            ], []);

            broadcast(new NewChatStarted($chat))->toOthers();
            if ($chat->wasRecentlyCreated) {

            }

            return $this->sendResponse($chat, 'Start Chat', 201);
        } catch (\Throwable $th) {
            return $this->sendError('Failed to start chat');
        }
    }

    public function index()
    {
        try {
            //code...
            $userId = auth()->id();

            $chat = Chat::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['lastMessage', 'receiver', 'sender'])
            ->orderByDesc(
                Message::select('created_at')
                    ->whereColumn('chat_id', 'chats.id')
                    ->latest()
                    ->take(1)
            )
            ->get();

            return $this->sendResponse($chat, 'Chats Fetched');
        } catch (\Throwable $th) {
            return $this->sendError('Failed to fetch chats');
        }
    }


}
