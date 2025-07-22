<?php
// ChatList
namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\User;
class ChatList extends Component
{

    public $search = '';
    public $users;
    public $selectedUser = null;

    public function mount()
    {
        $this->users = User::all();

        // Check if there are any users and select the first one
        if ($this->users->isNotEmpty()) {
            $this->selectUser($this->users->first()->id);
        }
    }

    public function updatedSearch()
    {
        $this->users = User::where('name', 'like', '%' . $this->search . '%')
                           ->orWhere('email', 'like', '%' . $this->search . '%')
                           ->get();

        // Optional: Re-select the first user from the filtered list if search changes
        if ($this->users->isNotEmpty()) {
            if (!$this->selectedUser || !$this->users->contains('id', $this->selectedUser->id)) {
                $this->selectUser($this->users->first()->id);
            }
        } else {
            // No users found after search, clear selected user
            $this->selectedUser = null;
            // Livewire 3: Use dispatch() for inter-component events
            $this->dispatch('clearChat');
        }
    }

    public function selectUser($userId)
    {


        $this->selectedUser = User::find($userId);
        // This is the key part: it dispatches an event
        $this->dispatch('userSelected', userId: $userId);
    }

    public function render()
    {
        return view('livewire.chat.chat-list');
    }
}
