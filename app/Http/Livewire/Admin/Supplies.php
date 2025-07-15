<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Supply;

class Supplies extends Component

{
    use WithPagination;

    /* ---------- table / search ---------- */
    public $search   = '';
    public $perPage  = 10;

    /* ---------- form fields ---------- */
    public $supplyId = null;
    public $name     = '';
    public $description = '';

    protected $paginationTheme = 'bootstrap';
    protected $queryString     = ['search'];

    protected $listeners = ['deleteConfirmed' => 'delete'];

    /* ---------- validation ---------- */
    protected function rules()
    {
        return [
            'name'        => 'required|max:255|unique:supplies,name,' . $this->supplyId,
            'description' => 'nullable|string',
        ];
    }

    /* ---------- render ---------- */
    public function render()
    {
        $supplies = Supply::query()
            ->when($this->search, fn ($q) =>
                $q->where('name', 'like', '%' . $this->search . '%'))
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.supplies', compact('supplies'));
    }

    /* ---------- CRUD helpers ---------- */
    public function openCreateModal()
    {
        $this->resetForm();
        $this->dispatchBrowserEvent('showSupplyModal');
    }

    public function edit(int $id)
    {
        $s = Supply::findOrFail($id);
        $this->supplyId   = $s->id;
        $this->name       = $s->name;
        $this->description= $s->description;
        $this->dispatchBrowserEvent('showSupplyModal');
    }

    public function save()
    {
        $this->validate();

        Supply::updateOrCreate(
            ['id' => $this->supplyId],
            ['name' => $this->name, 'description' => $this->description]
        );
        $message = $this->supplyId ? 'Supply updated.' : 'Supply created.';
        $this->dispatchBrowserEvent('toastr', ['type' => 'success', 'message' => $message]);

        $this->dispatchBrowserEvent('hideSupplyModal');
        $this->resetForm();
    }

    public function delete(int $id)
    {
        Supply::destroy($id);
        $this->dispatchBrowserEvent('toastr', [
            'type' => 'success',
            'message' => 'Supply deleted.'
        ]);
    }

    public function updatingSearch()   { $this->resetPage(); }
    private function resetForm()       { $this->reset(['supplyId','name','description']); }
}

