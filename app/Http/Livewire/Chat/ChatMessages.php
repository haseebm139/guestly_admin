<?php

namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\User; // Assuming you have a User model
use Illuminate\Support\Facades\Auth;
class ChatMessages extends Component
{

    public $selectedUserId;
    public $selectedUser;
    public $message = '';
    public $messages = []; // This will hold messages fetched from Firebase

    // CORRECTED: Using protected $listeners array for Livewire v2
    protected $listeners = [
        'userSelected' => 'loadChat',
        'clearChat' => 'resetChat',
        'addMessage' // If 'addMessage' is emitted from JS, this is correct
    ];

    public function loadChat($userId)
    {
        $this->selectedUserId = $userId;
        $this->selectedUser = User::find($userId);
        $this->messages = []; // Clear previous messages

        // CORRECTED: Using emit() for Livewire v2 browser events
        // Pass arguments positionally.
        $this->emit('chatOpened', $userId, Auth::id());
    }

    public function sendMessage()
    {
        if (empty($this->message) || !$this->selectedUserId) {
            return;
        }

        // CORRECTED: Using emit() for Livewire v2 browser events
        // Pass arguments positionally.
        $this->emit('sendMessageToFirebase',
            Auth::id(),
            $this->selectedUserId,
            $this->message,
            now()->timestamp
        );

        $this->message = ''; // Clear the input field
    }

    // This method is called from JavaScript when a new message is received from Firebase
    public function addMessage($message) // Listener method receives arguments
    {
        // Ensure the message belongs to the currently selected chat
        $currentUserId = Auth::id();
        if (($message['sender_id'] == $currentUserId && $message['receiver_id'] == $this->selectedUserId) ||
            ($message['sender_id'] == $this->selectedUserId && $message['receiver_id'] == $currentUserId)) {
            $this->messages[] = $message;
            // CORRECTED: Using emit() for Livewire v2 browser events
            $this->emit('scrollToBottom'); // Scroll chat to bottom after new message
        }
    }

    public function resetChat()
    {
        $this->selectedUserId = null;
        $this->selectedUser = null;
        $this->messages = [];
        $this->message = '';
    }

    public function render()
    {
        return view('livewire.chat.chat-messages');
    }
}
