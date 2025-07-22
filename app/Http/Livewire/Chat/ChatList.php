<?php

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
        // Fetch all users or a subset
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
            // CORRECTED: Using emit() for Livewire v2 inter-component communication
            $this->emit('clearChat');
        }
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::find($userId);
        // CORRECTED: Using emit() for Livewire v2 inter-component communication
        // Pass userId directly as an argument, not named.
        $this->emit('userSelected', $userId);
    }

    public function render()
    {
        return view('livewire.chat.chat-list');
    }
}
