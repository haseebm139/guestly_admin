<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Supply;

class Supplies extends Component

 {
    use WithPagination;

    /* search + pagination */
    public $search = '';
    public $perPage = 10;

    /* modal fields */
    public $supplyId = null;
    public $name = '';
    public $description = '';

    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['search'];
    protected $listeners    = ['deletePrompt', 'deleteConfirmed' => 'delete'];

    /* validation */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255|unique:supplies,name,' . $this->supplyId,
            'description' => 'nullable|string',
        ];
    }

    /* render */
    public function render()
    {
        $supplies = Supply::when($this->search, fn ($q) =>
                $q->where('name', 'like', "%{$this->search}%"))
            ->latest()->paginate($this->perPage);

        return view('livewire.admin.supplies', compact('supplies'));
    }

    /* ───── Create UI ───── */
    public function openCreate()
    {
        $this->resetForm();
        $this->dispatchBrowserEvent('showSupplyModal');
    }


    public function create()
    {
        $this->supplyId = null;          // ensure we validate as "create"
        $data = $this->validate();

        Supply::create([
            'name'=>$data['name'],
            'description'=>$data['description'],
        ]);

        $this->dispatchBrowserEvent('toastr', [
            'type'    => 'success',
            'message' => 'Supply created.',
        ]);
        $this->dispatchBrowserEvent('hideSupplyModal');
        $this->resetForm();
    }

    public function edit(int $id)
    {
        $s                 = Supply::findOrFail($id);
        $this->supplyId    = $s->id;
        $this->name        = $s->name;
        $this->description = $s->description;
        $this->dispatchBrowserEvent('showSupplyModal');
    }

    public function update()
    {
        try {
            $this->validate();

            if (is_null($this->supplyId)) {
                throw new \Exception('Supply ID is required.');
            }

            $supply = Supply::findOrFail($this->supplyId);

            $supply->update([
                'name'        => $this->name,
                'description' => $this->description,
            ]);

            // success toast
            $this->dispatchBrowserEvent('toastr', [
                'type'    => 'success',
                'message' => 'Supply updated.',
            ]);

            $this->dispatchBrowserEvent('hideSupplyModal');
            $this->resetForm();
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('hideSupplyModal');
            $this->resetForm();
            $this->dispatchBrowserEvent('toastr', [
                'type'    => 'error',
                'message' => 'Something went wrong. ',
            ]);
        }

    }

    public function delete($id)
    {
        Supply::destroy($id);
        $this->dispatchBrowserEvent('toastr', [
            'type' => 'success',
            'message' => 'Supply deleted.',
        ]);
    }

    private function resetForm()
    {
        $this->reset(['supplyId','name','description']);
        $this->resetValidation();
    }
    /* CRUD helpers */
    public function openCreateModal()
    {
        $this->reset('supplyId','name','description');
        $this->dispatchBrowserEvent('showSupplyModal');
    }



    public function save()
    {
        $this->validate();

        Supply::updateOrCreate(
            ['id' => $this->supplyId],
            ['name' => $this->name, 'description' => $this->description]
        );

        $msg = $this->supplyId ? 'Supply updated.' : 'Supply created.';
        $this->dispatchBrowserEvent('toastr', ['type' => 'success', 'message' => $msg]);

        $this->dispatchBrowserEvent('hideSupplyModal');
        $this->reset('supplyId','name','description');
    }

    public function deletePrompt($id)   // called by Delete button
    {
        $this->dispatchBrowserEvent('confirming-delete', ['id' => $id]);
    }



    public function updatingSearch() { $this->resetPage(); }
}

