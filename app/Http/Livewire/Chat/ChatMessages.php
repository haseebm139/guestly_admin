<?php
namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChatMessages extends Component
{
    public $selectedUserId;
    public $selectedUser;
    public $message = '';
    public $messages = [];


    protected $listeners = [
        'userSelected' => 'loadChat',
        'clearChat' => 'resetChat',
        'applyMessageChanges', // Handles all Firebase snapshot changes
    ];


    public function loadChat($userId)
    {
        \Log::info('ChatMessages: loadChat called with user ID: ' . $userId);

        $this->selectedUserId = $userId;
        $this->selectedUser = User::find($userId);
        $this->messages = []; // Clear current messages on new chat load

        $this->emit('chatOpened', $userId, Auth::id());
        \Log::info('ChatMessages: Emitted chatOpened event to JavaScript.');
    }

    public function resetChat()
    {
        \Log::info('ChatMessages: resetChat called.');
        $this->selectedUserId = null;
        $this->selectedUser = null;
        $this->messages = [];
        $this->message = '';
    }

    public function applyMessageChanges(array $changes)
    {
        \Log::info('ChatMessages: applyMessageChanges called with ' . count($changes) . ' changes.');

        $currentUserId = Auth::id();

        // Separate changes for initial load vs. ongoing updates
        $initialLoad = empty($this->messages) && count($changes) > 1; // Heuristic for initial load

        foreach ($changes as $change) {
            $messageData = $change['message'];
            $messageType = $change['type'];
            $messageFirebaseId = $messageData['id']; // This is the real Firebase document ID

            $existingIndex = null;
            foreach ($this->messages as $index => $msg) {
                // PRIMARY MATCH: By real Firebase ID (if already confirmed or from another user)
                if (isset($msg['id']) && $msg['id'] === $messageFirebaseId) {
                    $existingIndex = $index;
                    break;
                }
                // SECONDARY MATCH: For 'added' messages that *we* sent, if they are still optimistic
                // This handles the race condition where `onSnapshot` 'added' arrives from local cache
                if ($messageType === 'added' &&
                    $messageData['sender_id'] == $currentUserId && // Ensure it's our own message
                    str_starts_with($msg['id'] ?? '', 'temp_') && // And our existing message is still optimistic
                    $msg['message_text'] === ($messageData['message_text'] ?? null) // Match by content to be sure
                ) {
                    \Log::info("ChatMessages: Matched optimistic message for Firebase ID: {$messageFirebaseId}");
                    $existingIndex = $index;
                    break;
                }
            }

            switch ($messageType) {
                case 'added':
                    if ($existingIndex === null) {
                        // Truly new message (from another user, or first time this message is seen by Livewire)
                        // Directly append it to the end of the array
                        $this->messages[] = $messageData;
                        \Log::info("ChatMessages: Appended new message: {$messageFirebaseId}");
                    } else {
                        // This message already exists (optimistically or already processed).
                        // Update its data in place to ensure it has the latest and correct Firebase data.
                        $this->messages[$existingIndex] = array_merge($this->messages[$existingIndex], $messageData);
                        // Ensure the ID is updated to the real Firebase ID if it was a temp_id match
                        $this->messages[$existingIndex]['id'] = $messageFirebaseId;
                        \Log::info("ChatMessages: Updated existing message: {$messageFirebaseId}");
                    }
                    break;
                case 'modified':
                    if ($existingIndex !== null) {
                        $this->messages[$existingIndex] = array_merge($this->messages[$existingIndex], $messageData);
                        \Log::info("ChatMessages: Modified message: {$messageFirebaseId}");
                    }
                    break;
                case 'removed':
                    if ($existingIndex !== null) {
                        array_splice($this->messages, $existingIndex, 1);
                        \Log::info("ChatMessages: Removed message: {$messageFirebaseId}");
                    }
                    break;
            }
        }

        // ONLY SORT ON INITIAL LOAD, or if specifically needed.
        // If the array was empty and multiple changes came in, it's likely an initial load.
        // Otherwise, assume messages are added/updated in place.
        if ($initialLoad) {
            usort($this->messages, function ($a, $b) {
                $tsA = $a['timestamp'] ?? 0; // Use 0 for null timestamps on initial load for sorting purposes
                $tsB = $b['timestamp'] ?? 0;
                return $tsA <=> $tsB;
            });
            \Log::info('ChatMessages: Messages sorted due to initial load.');
        } else {
             // For non-initial loads, we want to ensure the array keys are sequential
             // and that Livewire tracks changes correctly if an ID changed.
             $this->messages = array_values($this->messages);
        }


        // Trigger scroll only after all messages are processed
        $this->emit('scrollToBottomJs');
    }

    public function sendMessage()
    {
        if (empty($this->message) || !$this->selectedUserId) {
            return;
        }

        \Log::info('ChatMessages: sendMessage called. Selected user ID: ' . $this->selectedUserId);

        // Generate a unique client-side temporary ID for this message
        $tempId = 'temp_' . uniqid();

        // Optimistic update: Add the message to the local array immediately at the end
        $optimisticMessage = [
            'id' => $tempId, // Assign a temporary ID (will be replaced by real Firebase ID by onSnapshot)
            'sender_id' => Auth::id(),
            'receiver_id' => $this->selectedUserId,
            'message_text' => $this->message,
            'timestamp' => Carbon::now()->timestamp, // Use local timestamp for initial sorting, will be overridden by serverTimestamp
        ];

        $this->messages[] = $optimisticMessage; // Always add to the end
        $this->emit('scrollToBottomJs'); // Scroll immediately to show the new message

        // Dispatch to Firebase
        $this->emit('sendMessageToFirebase',
            Auth::id(),
            $this->selectedUserId,
            $this->message,
            $tempId // Pass tempId
        );

        $this->message = ''; // Clear the input field
    }

    public function render()
    {
        return view('livewire.chat.chat-messages');
    }
}
