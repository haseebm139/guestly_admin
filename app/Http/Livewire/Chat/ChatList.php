<?php
namespace App\Http\Livewire\Chat;

use Livewire\Component;
use App\Models\User;

class ChatList extends Component
{
    public $search = '';
    public $users;
    public $selectedUser = null;


    protected $listeners = [];


    public function mount()
    {
        $myId = auth()->user()->id;
        $this->users = User::where('id', '!=', $myId)->get();

        if ($this->users->isNotEmpty()) {
            $this->selectUser($this->users->first()->id);
        }
    }

    public function updatedSearch()
    {
        $myId = auth()->user()->id;
        $this->users = User::where('id', '!=', $myId)->where('name', 'like', '%' . $this->search . '%')
                             ->orWhere('email', 'like', '%' . $this->search . '%')
                             ->get();


        if ($this->users->isNotEmpty()) {
            if (!$this->selectedUser || !$this->users->contains('id', $this->selectedUser->id)) {
                $this->selectUser($this->users->first()->id);
            }
        } else {
            // No users found after search, clear selected user
            $this->selectedUser = null;
            // Livewire 2: Use $this->emit() for inter-component events
            $this->emit('clearChat');
        }
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::find($userId);
        // Livewire 2: Use $this->emit() for inter-component events
        $this->emit('userSelected', $userId); // Pass arguments directly
    }

    public function render()
    {
        return view('livewire.chat.chat-list');
    }
}
