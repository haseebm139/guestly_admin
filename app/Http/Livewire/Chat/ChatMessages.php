<?php
// ChatMessage
namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\User; // Assuming you have a User model
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On; // Don't forget this import
class ChatMessages extends Component
{

    public $selectedUserId;
    public $selectedUser;
    public $message = '';
    public $messages = [];


    #[On('userSelected')]
    public function loadChat($userId)
    {


        $this->selectedUserId = $userId;
        $this->selectedUser = User::find($userId);
        $this->messages = []; // Clear current messages before loading new ones

        // Dispatch browser event for JS to start/update Firebase listener
        $this->dispatch('chatOpened', selectedUserId: $userId, currentUserId: Auth::id());

    }

    #[On('clearChat')]
    public function resetChat()
    {
        \Log::info('ChatMessages: resetChat called.');
        $this->selectedUserId = null;
        $this->selectedUser = null;
        $this->messages = [];
        $this->message = '';

    }


    #[On('setMessages')]
    public function setMessages(array $messages) // <-- Corrected: Directly accept 'messages'
    {

        $this->messages = $messages; // Use $messages directly
        $this->dispatch('scrollToBottom');
    }
    // This listener method will be called when 'addMessage' is dispatched from JavaScript
    #[On('addMessage')]
    public function addMessage(array $message) // Type-hinting array for clarity
    {
        $currentUserId = Auth::id();
        if (($message['sender_id'] == $currentUserId && $message['receiver_id'] == $this->selectedUserId) ||
            ($message['sender_id'] == $this->selectedUserId && $message['receiver_id'] == $currentUserId)) {
            $this->messages[] = $message;
            $this->dispatch('scrollToBottom');
        }
    }

    public function sendMessage()
    {
        if (empty($this->message) || !$this->selectedUserId) {
            return;
        }

        // Livewire 3: Use dispatch() for browser events
        $this->dispatch('sendMessageToFirebase',
            senderId: Auth::id(),
            receiverId: $this->selectedUserId,
            messageText: $this->message,
            timestamp: now()->timestamp
        );

        $this->message = ''; // Clear the input field
    }

    public function render()
    {
        return view('livewire.chat.chat-messages');
    }
}
