<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\PushNotification;
use App\Http\Controllers\Api\BaseController as BaseController;
use Validator;
use App\Models\Notification;
use App\Services\FirebaseService; 
use Illuminate\Support\Facades\Log;
class NotificationController extends BaseController
{

    protected $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }
    public function index(Request $request)
    {
        try {
            $notifications = Notification::where('receiver_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->get();
    
            return $this->sendResponse($notifications, 'Notification fetched successfully.');
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong');
        }
    }

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
    /**
     * Save or update FCM token for authenticated user
     */
    /**
     * Send notification to single user by user_id
     */
    public function sendToUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receiver_id'   => 'required|exists:users,id',
            'title'         => 'required|string|max:255',
            'body'          => 'nullable|string',
            'type'          => 'nullable|string',
            'studio_name'   => 'nullable|string',
            'artist_name'   => 'nullable|string',
            'url'           => 'nullable|string',
            'token'         => 'nullable|string', 
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $receiver = User::find($request->receiver_id);
        $sender   = auth()->user();
          
        if (!$receiver->fcm_token) {
            return $this->sendError('Target user does not have an FCM token.');
        }
        
        try {
            $this->firebase->sendToToken(
                $receiver->fcm_token,
                $request->title,
                $request->body,
                 
            );
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
                'token'         => $request->token ?? null,
                 
            ]);
            return $this->sendResponse([], 'Notification sent successfully.');
        } catch (\Throwable $e) {
            Log::error('SendToUser error: '.$e->getMessage());
            return $this->sendError('Failed to send notification.');
        }
    }

    /**
     * Send notification to multiple users
     */
    public function sendToMany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_ids'   => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'title'      => 'required|string',
            'body'       => 'required|string',
            'data'       => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }

        $users = User::whereIn('id', $request->user_ids)
            ->whereNotNull('fcm_token')
            ->get();

        if ($users->isEmpty()) {
            return $this->sendError('No users with FCM tokens found.');
        }

        $tokens = $users->pluck('fcm_token')->filter()->unique()->values()->all();

        $results = $this->firebase->sendToMany(
            $tokens,
            $request->title,
            $request->body,
            $request->data ?? []
        );
        $res['results'] = $results;
        $res['count'] = $count;

        return $this->sendResponse($res , 'Bulk notification sent successfully.');
    }

    /**
     * Send notification to a single user
     */
    public function sendToUser1(Request $request)
    {
         
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'title'   => 'required|string|max:255',
            'body'    => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $user = User::find($validated['user_id']);

        if (!$user->fcm_token) {
            return $this->sendError('User does not have a registered FCM token.');
            
        }

        $user->notify(new PushNotification($validated['title'], $validated['body']));
        return $this->sendResponse([],"Notification sent successfully.");
         
    }

    /**
     * Send notification to multiple users
     */
    public function sendToMany1(Request $request)
    {
         
        $validator = Validator::make($request->all(), [
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'title'   => 'required|string|max:255',
            'body'    => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        $users = User::whereIn('id', $validated['user_ids'])
                     ->whereNotNull('fcm_token')
                     ->get();

        foreach ($users as $user) {
            $user->notify(new PushNotification($validated['title'], $validated['body']));
        }

        $count = $users->count();
        return $this->sendResponse($count,"Notification sent successfully.");
         
    }
}
