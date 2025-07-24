<?php

namespace App\Http\Controllers\API\V1\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use App\Events\Chat\MessageSent;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController as BaseController;
class MessageController  extends BaseController
{
    public function index($chatId)
    {

        try {
            $chat = Chat::findOrFail($chatId);
            $data = $chat->messages()->with('sender')->orderBy('created_at')->get();
            return $this->sendResponse($data , 'fetched', 201);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return $this->sendError('Chat not found',$errorMessages = [], 404);
        }

    }

    public function store(Request $request, $chatId)
    {

        try {
            $validator = Validator::make($request->all(), [
                'message' => 'required|string'
            ]);

            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first(),$errorMessages = [], 422);
            }

            $chat = Chat::findOrFail($chatId);
            $message = $chat->messages()->create([
                'sender_id' => auth()->id(),
                'message' => $request->message,
            ]);
            broadcast(new MessageSent($message))->toOthers();

            return $this->sendResponse($message, 'Message sent successfully.', 201);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->sendError('Chat not found',$errorMessages = [], 404);
        }


    }
}
