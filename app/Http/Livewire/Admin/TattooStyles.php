<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TattooStyle;

use Illuminate\Validation\Rule;

class TattooStyles extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $styleId =null;
    public $name = '';
    public $icon = ''; // Emoji



    protected $paginationTheme='bootstrap';
    protected $queryString=['search'];
    protected $listeners    = ['deletePrompt', 'deleteConfirmed' => 'delete'];


    protected function rules(): array
    {
        return [
            'name' => 'required|max:255' . $this->styleId ,
            'icon' => 'nullable|string',
        ];
    }
    public function render()
    {
        $data = TattooStyle::when($this->search,fn($q)=>
                $q->where('name','like',"%{$this->search}%"))
            ->latest()->paginate($this->perPage);

        return view('livewire.admin.tattoo-styles',compact('data'));
    }

    public function create() { $this->styleId =null; $this->save(); }
    public function update() { $this->save(); }

    public function resetSearch()
    {
        $this->reset('search');
    }
    private function resetForm()
    {
        $this->reset(['styleId','name','icon']);
        $this->resetValidation();
    }
    public function openCreate()
    {


        $this->dispatchBrowserEvent('modelShow');
    }

    public function closeCreate()
    {
        $this->reset('search');
        $this->resetForm();
        $this->dispatchBrowserEvent('modelHide');
    }
    public function edit($id)
    {
        $a=TattooStyle::findOrFail($id);
        $this->styleId =$a->id;
        $this->name=$a->name;
        $this->icon=$a->icon;
        $this->openCreate();
    }

    private function save(){
        try {
            $this->validate();

            if (is_null($this->styleId )) {
                TattooStyle::create([
                    'name' => $this->name,

                    'icon' => $this->icon,
                ]);
            }
            else {
                TattooStyle::findOrFail($this->styleId )->update([
                    'name' => $this->name,
                    'icon' => $this->icon,
                ]);

            }
            $this->dispatchBrowserEvent('toastr', [
            'type' => 'success',
            'message' => 'Tattoo Style ' . ($this->styleId  ? 'updated.' : 'created.'),
            ]);
            $this->closeCreate();
             $this->resetForm();

        } catch (\Throwable $th) {
            $this->closeCreate();
            $this->resetForm();
            $this->dispatchBrowserEvent('toastr', [
                'type' => 'error',
                'message' => 'Something went wrong. ',
            ]);
        }
    }

    public function deletePrompt($id)
    {
        $this->dispatchBrowserEvent('confirming-delete',['id'=>$id]);
    }
    public function delete($id)
    {
        TattooStyle::destroy($id);
        $this->dispatchBrowserEvent('toastr',['type'=>'success','message'=>'Tattoo Style deleted.']);
    }

    public function toggleStatus($id)
    {
        $item =TattooStyle::findOrFail($id); // or StationAmenity
        $item->status = !$item->status;
        $item->save();

        $this->dispatchBrowserEvent('toastr', [
            'type' => 'success',
            'message' => 'Status ' . ($item->status ? 'activated' : 'deactivated') . ' successfully.',
        ]);
    }
}
