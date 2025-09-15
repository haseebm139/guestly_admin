<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AddUserModal extends Component
{
    use WithFileUploads;
    public $user_id;
    public $name;     
    public $last_name;
    public $email;
    public $phone;
    public $role;
    public $avatar;
    public $saved_avatar; 


    public $role_id;
    public $role_name;
    public $edit_mode = false;

    protected $rules = [
        'name' => 'required|string',
        'last_name'  => 'required|string|max:100',
        'email'      => 'required|email',
        'phone'      => 'required|string|max:20', 
        'role' => 'required|string',
        'avatar' => 'nullable|sometimes|image|max:1024',
    ];

    protected $listeners = [
        'delete_user' => 'deleteUser',
        'update_user' => 'updateUser',
    ];

    public function mount($role_id = null)
    {
        if ($role_id) {
            $this->role_id = $role_id;
            $this->role_name = Role::find($role_id)?->name; // get role name
        }
    }

    public function render()
    {
        if ($this->role_id) {
            // Show only the single role passed in
            $roles = Role::where('id', $this->role_id)->get();
        } elseif ($this->role_name) {
            // Or fetch by role name
            $roles = Role::where('name', $this->role_name)->get();
        } else {
            // Default: all roles
            $roles = Role::all();
        }
        

        $roles_description = [
            'administrator' => 'Best for business owners and company administrators',
        'developer' => 'Best for developers or people primarily using the API',
        'analyst' => 'Best for people who need full access to analytics data, but don\'t need to update business settings',
        'support' => 'Best for employees who regularly refund payments and respond to disputes',
        'trial' => 'Best for people who need to preview content data, but don\'t need to make any updates',
        'artist' => 'Best for studio artists to manage bookings and services',
        'studio' => 'Best for studios to manage services and clients',
        'user' => 'Best for users who need to view content data, but don\'t need to make any updates',
        ];
        foreach ($roles as $i => $role) {
            $roles[$i]->description = $roles_description[$role->name] ?? '';
        }
        if ($roles->count() === 1) {
            $this->role = $roles->first()->name;
        }
        return view('livewire.user.add-user-modal', compact('roles'));
    }

    public function submit()
    {
        // Validate the form input data
        $this->validate();
         

        DB::transaction(function () {
            $data = [
                'name'       => $this->name,
                'last_name'  => $this->last_name,
                'phone'      => $this->phone,
                'email'      => $this->email,
                'profile_photo_path' => $this->avatar 
                    ? $this->avatar->store('avatars', 'public') 
                    : null,
                'user_type'  => $this->role ?? 'user',
            ];

            if ($this->edit_mode) {
                 
                $user = User::find($this->user_id);
                 
                if(!$user){
                    $this->emit('error', 'Email not found');
                }
                 

                 
                $user->update([
                    'name'       => $this->name,
                    'last_name'  => $this->last_name,
                    'phone'      => $this->phone,                     
                    'profile_photo_path' => $data['profile_photo_path'],
                    'avatar' => $data['profile_photo_path'],
                ]);

                 

                $this->emit('success', ucfirst($this->role_name) . " updated successfully");
            } else {
                // 🔹 Create new user
                
                $data['password'] = Hash::make($this->email);
                $data['avatar'] = $data['profile_photo_path'];
                $user = User::create($data);

                $user->assignRole($this->role);

                Password::sendResetLink(['email' => $user->email]);

                $this->emit('success', ucfirst($this->role_name) . " added successfully");
            }
        });

        $this->resetForm();
    }

    public function deleteUser($id)
    {
        // Prevent deletion of current user
        if ($id == Auth::id()) {
            $this->emit('error', ucfirst($this->role_name) . ' cannot be deleted');
            return;
        }

        // Delete the user record with the specified ID
        User::destroy($id);

        // Emit a success event with a message
        $this->emit('success', ucfirst($this->role_name) . ' successfully deleted');
    }

    public function updateUser($id)
    {

        $this->edit_mode = true;
        $this->user_id = $id;     
        $user = User::find($id);
        
         
        $this->saved_avatar = $user->avatar??asset('avatar/default.png');
        $this->name = $user->name;
        $this->last_name    = $user->last_name;
        $this->phone        = $user->phone;
        $this->email = $user->email;
        $this->role = $user->roles?->first()->name ?? '';
    }
    private function resetForm()
    {
        $this->reset([ 
            'edit_mode',
            'name',
            'last_name',
            'phone',
            'email',
            'avatar',
            'saved_avatar',
             
        ]);
    }
    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
