<?php
//
//namespace App\Http\Controllers\Web\Chat;
//
//use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
//use Kreait\Firebase\Factory;
//use Kreait\Firebase\Database;
//use Illuminate\Support\Str;
//
//class ChatController extends Controller
//{
//    protected $database;
//    protected $auth;
//
//    public function __construct()
//    {
//        $factory = (new Factory)->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')));
//        $this->database = $factory->createDatabase();
//        $this->auth = $factory->createAuth();
//    }
//
//    public function showChat()
//    {
//        $user = auth()->user();
//        if (!$user) {
//            return redirect('/login');
//        }
//
//        // Aapke login code ke mutabiq, role 'role_id' mein aur ID 'id' mein hai
//        $role = strtolower($user->role_id);
//        $businessId = $user->id;
//
//        if (!$role || !$businessId) {
//            abort(500, 'User role or ID is not defined.');
//        }
//
//        // Firebase se is business ID ka UID dhoondein
//        $path = "business_uid/{$role}/{$businessId}";
//        $uids = $this->database->getReference($path)->getValue();
//
//        if (empty($uids)) {
//            abort(500, "Could not find Firebase UID for {$role} ID: {$businessId}.");
//        }
//
//        $firebaseUid = array_key_first($uids);
//
//        $customToken = $this->auth->createCustomToken($firebaseUid);
//        $firebaseToken = $customToken->toString();
//
//        return view('user.artist_chat', [
//            'firebaseToken' => $firebaseToken,
//            'currentUser' => $user,
//            'currentFirebaseUid' => $firebaseUid,
//        ]);
//    }
//
//    public function sendMessage(Request $request)
//    {
//        $validated = $request->validate([ 'text' => 'required|string', 'artistId' => 'required|string', 'studioId' => 'required|string', 'meUid' => 'required|string', 'myBusinessId' => 'required|string', 'myUserType' => 'required|string', 'myName' => 'required|string', 'myAvatar' => 'required|string', 'peerUserType' => 'required|string', 'peerName' => 'required|string', 'peerAvatar' => 'required|string', 'peerBusinessId' => 'sometimes|string', ]);
//        $artistId = $validated['artistId']; $studioId = $validated['studioId']; $text = $validated['text']; $meUid = $validated['meUid']; $myUserType = $validated['myUserType']; $convKey = "studio_{$studioId}__artist_{$artistId}";
//        $messagesPath = "pair-room-messages/{$artistId}/{$studioId}"; $msgId = (string) Str::uuid();
//
//        $messageData = [ 'senderId' => $meUid, 'senderRole' => $myUserType, 'text' => $text, 'type' => 'text', 'timestamp' => Database::SERVER_TIMESTAMP, ];
//        $this->database->getReference($messagesPath . '/' . $msgId)->set($messageData);
//
//        $roomPath = "pair-rooms/{$artistId}/{$studioId}";
//        $updates = [ "{$roomPath}/lastMessage/text" => $text, "{$roomPath}/lastMessage/timestamp" => Database::SERVER_TIMESTAMP, "conversations/{$meUid}/{$convKey}/lastMessage" => $text, "conversations/{$meUid}/{$convKey}/lastTimestamp" => Database::SERVER_TIMESTAMP, "conversations/{$meUid}/{$convKey}/peerName" => $validated['peerName'], "conversations/{$meUid}/{$convKey}/peerAvatar" => $validated['peerAvatar'], "conversations/{$meUid}/{$convKey}/peerUserType" => $validated['peerUserType'], "conversations/{$meUid}/{$convKey}/roomId" => $convKey, ];
//        $this->database->getReference()->update($updates);
//
//        return response()->json(['status' => 'success', 'message' => 'Message sent!']);
//    }
//}


namespace App\Http\Controllers\Web\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    protected $database;
//    protected $auth;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));
        $this->database = $factory->createDatabase();
//        $this->auth = $factory->createAuth();
    }

    /**
     * Show Chat Page
     */
//    public function showChat()
//    {
//        $user = auth()->user();
//        if (!$user) {
//            return redirect('/login');
//        }
//
//        // Assuming your user has 'role_id' and 'id'
//        $role = strtolower($user->role_id);
//        $businessId = $user->id;
//
//        if (!$role || !$businessId) {
//            abort(500, 'User role or ID is not defined.');
//        }
//
//        // Get Firebase UID from database
//        $path = "business_uid/{$role}/{$businessId}";
//        $uids = $this->database->getReference($path)->getValue();
//
//        if (empty($uids)) {
//            abort(500, "Could not find Firebase UID for {$role} ID: {$businessId}.");
//        }
//
//        $firebaseUid = array_key_first($uids);
//
//        // Generate Firebase Custom Token
//        $customToken = $this->auth->createCustomToken($firebaseUid);
//        $firebaseToken = $customToken->toString();
//
//        // ✅ Update user online status in Firebase
//        $this->database->getReference("users/{$firebaseUid}")->update([
//            'isOnline' => true,
//            'lastActive' => ['.sv' => 'timestamp'],
//        ]);
//
//        return view('user.dashboard.artist.artist_chat', [
//            'firebaseToken' => $firebaseToken,
//            'currentUser' => $user,
//            'currentFirebaseUid' => $firebaseUid,
//        ]);
//    }

    /**
     * Send Message to Firebase
     */
    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'text' => 'required|string',
            'artistId' => 'required|string',
            'studioId' => 'required|string',
            'meUid' => 'required|string',
            'myBusinessId' => 'required|string',
            'myUserType' => 'required|string',
            'myName' => 'required|string',
            'myAvatar' => 'required|string',
            'peerUserType' => 'required|string',
            'peerName' => 'required|string',
            'peerAvatar' => 'required|string',
            'peerBusinessId' => 'sometimes|string',
        ]);

        $artistId = $validated['artistId'];
        $studioId = $validated['studioId'];
        $text = $validated['text'];
        $meUid = $validated['meUid'];
        $myUserType = $validated['myUserType'];

        $convKey = "studio_{$studioId}__artist_{$artistId}";
        $messagesPath = "pair-room-messages/{$artistId}/{$studioId}";
        $msgId = (string)Str::uuid();

        // ✅ Firebase safe timestamp
        $serverTimestamp = ['.sv' => 'timestamp'];

        // Prepare message data
        $messageData = [
            'senderId' => $meUid,
            'senderRole' => $myUserType,
            'text' => $text,
            'type' => 'text',
            'timestamp' => $serverTimestamp,
        ];

        // Save message in Firebase
        $this->database->getReference($messagesPath . '/' . $msgId)->set($messageData);

        // Update last message info in Firebase
        $roomPath = "pair-rooms/{$artistId}/{$studioId}";

        $updates = [
            "{$roomPath}/lastMessage/text" => $text,
            "{$roomPath}/lastMessage/timestamp" => $serverTimestamp,

            "conversations/{$meUid}/{$convKey}/lastMessage" => $text,
            "conversations/{$meUid}/{$convKey}/lastTimestamp" => $serverTimestamp,
            "conversations/{$meUid}/{$convKey}/peerName" => $validated['peerName'],
            "conversations/{$meUid}/{$convKey}/peerAvatar" => $validated['peerAvatar'],
            "conversations/{$meUid}/{$convKey}/peerUserType" => $validated['peerUserType'],
            "conversations/{$meUid}/{$convKey}/roomId" => $convKey,
        ];

        $this->database->getReference()->update($updates);

        return response()->json(['status' => 'success', 'message' => 'Message sent!']);
    }

    /**
     * ✅ Mark user offline on logout
     */
//    public function logout()
//    {
//        $user = auth()->user();
//        if ($user) {
//            $role = strtolower($user->role_id);
//            $businessId = $user->id;
//
//            $path = "business_uid/{$role}/{$businessId}";
//            $uids = $this->database->getReference($path)->getValue();
//
//            if (!empty($uids)) {
//                $firebaseUid = array_key_first($uids);
//
//                // Mark user offline in Firebase
//                $this->database->getReference("users/{$firebaseUid}")->update([
//                    'isOnline' => false,
//                    'lastActive' => ['.sv' => 'timestamp'],
//                ]);
//            }
//
//            auth()->logout();
//        }
//
//        return redirect('/login');
//    }
}
