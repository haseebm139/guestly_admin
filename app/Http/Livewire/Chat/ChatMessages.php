<?php
// ChatMessage
namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\User; // Assuming you have a User model
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On; // Don't forget this import

use Carbon\Carbon; //
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

        $this->dispatch('chatOpened', selectedUserId: $userId, currentUserId: Auth::id());

    }

    #[On('clearChat')]
    public function resetChat()
    {

        $this->selectedUserId = null;
        $this->selectedUser = null;
        $this->messages = [];
        $this->message = '';
    }


    #[On('setMessages')]
    public function setMessages(array $messages)
    {

        usort($messages, function ($a, $b) {
            return ($a['timestamp'] ?? 0) <=> ($b['timestamp'] ?? 0);
        });
        $this->messages = $messages;

        $this->dispatch('scrollToBottom');
    }
    // This listener method will be called when 'addMessage' is dispatched from JavaScript


    public function sendMessage()
    {
        if (empty($this->message) || !$this->selectedUserId) {
            return;
        }

        $optimisticMessage = [
            'sender_id' => Auth::id(),
            'receiver_id' => $this->selectedUserId,
            'message_text' => $this->message,
            'timestamp' => Carbon::now()->timestamp,

        ];
        $this->messages[] = $optimisticMessage;
        $this->dispatch('scrollToBottom');


        $this->dispatch('sendMessageToFirebase',
            senderId: Auth::id(),
            receiverId: $this->selectedUserId,
            messageText: $this->message,

        );

        $this->message = '';
    }


    public function render()
    {
        return view('livewire.chat.chat-messages');
    }
}
