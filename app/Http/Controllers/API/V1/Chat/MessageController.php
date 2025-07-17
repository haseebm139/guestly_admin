<?php

namespace App\Http\Controllers\API\V1\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use App\Events\Chat\MessageSent;

class MessageController extends Controller
{
    public function index(Chat $chat)
    {

//        $this->authorize('view', $chat);

        return $chat->messages()->with('sender')->orderBy('created_at')->get();
    }

    public function store(Request $request, Chat $chat)
    {

//        $this->authorize('view', $chat);

        $request->validate(['message' => 'required|string']);

        $message = $chat->messages()->create([
            'sender_id' => auth()->id(),
            'message' => $request->message,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }
}
