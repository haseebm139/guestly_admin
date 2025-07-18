<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Chat;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

//Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//    return (int) $user->id === (int) $id;
//});
// MESSAGE
Broadcast::channel('chat.{chatId}', function ($user, $chatId) {

    return Chat::where('id', $chatId)
        ->where(function ($q) use ($user) {
            $q->where('sender_id', $user->id)->orWhere('receiver_id', $user->id);
        })->exists();
});

// NEW CHAT
Broadcast::channel('user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

// Broadcast::channel('chat.{id}', function ($user, $id) {
//     return true; // ✅ allow all authenticated users
// });

// Broadcast::channel('chat.{receiverId}', function ($user, $receiverId) {
//     return true; // Can be used for auth check
// });
