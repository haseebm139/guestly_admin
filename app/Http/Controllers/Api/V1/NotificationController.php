<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Notification;
use App\Http\Controllers\Api\BaseController as BaseController;
class NotificationController extends BaseController
{

    public function index(Request $request)
    {
        try {
            $notifications = Notification::where('receiver_id', $request->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();
    
            return $this->sendResponse($notifications, 'Notification fetched successfully.');
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong');
        }
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'receiver_id'   => 'required|exists:users,id',
            'title'         => 'required|string|max:255',
            'body'          => 'nullable|string',
            'type'          => 'nullable|string',
            'studio_name'   => 'nullable|string',
            'artist_name'   => 'nullable|string',
            'url'           => 'nullable|string',
            // 'data'          => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first(), 422);
        }

        try {
            $receiver = User::find($request->receiver_id);
            $sender   = $request->user();
    
            $notification = Notification::create([
                'sender_id'     => $sender->id ?? null,
                'receiver_id'   => $receiver->id,
                'sender_role'   => $sender->role_id ?? null,
                'receiver_role' => $receiver->role_id ?? null,
                'type'          => $request->type ?? null,
                'title'         => $request->title ?? null,
                'body'          => $request->body ?? null,
                'studio_name'   => $request->studio_name ?? null,
                'artist_name'   => $request->artist_name ?? null,
                'url'           => $request->url ?? null, 
            ]);
            return $this->sendResponse($notification, 'Notification sent successfully.');
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong');
        }

    }


    /**
     * Mark notification as read
     */
    public function markAsRead(Request $request, $id)
    {
        try {
            $notification = Notification::where('receiver_id', auth()->user()->id)->find($id);
            if(!$notification){
                return $this->sendError('Notification not Found');
            }
            $notification->update([
                'is_read' => true,  
                'read_at' => now(),
            ]);
            return $this->sendResponse([], 'Notification marked as read.'); 
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong');
        }
    }


}
