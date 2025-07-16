<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Supply;

class Supplies extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $supplyId = null;
    public $name = '';
    public $description = '';

    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['search'];
    protected $listeners    = ['deletePrompt', 'deleteConfirmed' => 'delete'];
    // protected $listeners = ['deleteConfirmed' => 'delete'];

    protected function rules(): array
    {
        return [
            'name' => 'required|max:255|unique:supplies,name,' . $this->supplyId,
            'description' => 'nullable|string',
        ];
    }

    public function render()
    {
        $supplies = Supply::when($this->search, fn ($q) =>
                $q->where('name', 'like', "%{$this->search}%"))
            ->latest()->paginate($this->perPage);

        return view('livewire.admin.supplies', compact('supplies'));
    }

    public function create()
    {

        $this->save();
    }


    public function update()
    {
        $this->save();
    }



    public function resetSearch()
    {
        $this->reset('search');
    }
    private function resetForm()
    {
        $this->reset(['supplyId', 'name', 'description']);
        $this->resetValidation();
    }
    public function openCreate()
    {
        $this->reset('search');
        $this->resetForm();
        $this->dispatchBrowserEvent('showSupplyModal');
    }


    public function closeCreate()
    {
        $this->reset('search');
        $this->resetForm();
        $this->dispatchBrowserEvent('hideSupplyModal');
    }
    public function edit(int $id)
    {
        $s = Supply::findOrFail($id);
        $this->supplyId = $s->id;
        $this->name = $s->name;
        $this->description = $s->description;
        $this->dispatchBrowserEvent('showSupplyModal');
    }
    public function save()
    {
        try {
            $this->validate();

            if (is_null($this->supplyId)) {
                Supply::create([
                    'name' => $this->name,
                    'description' => $this->description,
                ]);
            } else {
                Supply::findOrFail($this->supplyId)->update([
                    'name' => $this->name,
                    'description' => $this->description,
                ]);
            }

            $this->dispatchBrowserEvent('toastr', [
                'type' => 'success',
                'message' => 'Supply ' . ($this->supplyId ? 'updated.' : 'created.'),
            ]);
            $this->closeCreate();
            $this->resetForm();
        } catch (\Throwable $th) {
            $this->resetForm();
            $this->dispatchBrowserEvent('toastr', [
                'type' => 'error',
                'message' => 'Something went wrong. ',
            ]);
        }

    }
    public function deletePrompt($id)   // called by Delete button
    {
        $this->dispatchBrowserEvent('confirming-delete', ['id' => $id]);
    }
    public function delete($id)
    {

        Supply::destroy($id);
        $this->dispatchBrowserEvent('toastr', [
            'type' => 'success',
            'message' => 'Supply deleted.',
        ]);
    }


}

