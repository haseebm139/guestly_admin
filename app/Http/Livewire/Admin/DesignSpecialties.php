<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DesignSpecialty;

use Illuminate\Validation\Rule;
class DesignSpecialties extends Component
{

    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $specialtyId  =null;
    public $name = '';


    protected $paginationTheme='bootstrap';
    protected $queryString=['search'];
    protected $listeners    = ['deletePrompt', 'deleteConfirmed' => 'delete'];

    protected function rules(): array
    {
        return [
            'name' => 'required|max:255' . $this->specialtyId ,
        ];
    }
    public function render()
    {
        $data = DesignSpecialty::when($this->search,fn($q)=>
                $q->where('name','like',"%{$this->search}%"))
            ->latest()->paginate($this->perPage);
        return view('livewire.admin.design-specialties',compact('data'));
    }

    public function create() { $this->specialtyId =null; $this->save(); }
    public function update() { $this->save(); }

    public function resetSearch()
    {
        $this->reset('search');
    }
    private function resetForm()
    {
        $this->reset(['specialtyId','name']);
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
        $a=DesignSpecialty::findOrFail($id);
        $this->specialtyId =$a->id;
        $this->name=$a->name;
        $this->openCreate();
    }

    private function save(){
        try {
            $this->validate();

            if (is_null($this->specialtyId )) {
                DesignSpecialty::create([
                    'name' => $this->name,


                ]);
            }
            else {
                DesignSpecialty::findOrFail($this->specialtyId )->update([
                    'name' => $this->name,

                ]);

            }
            $this->dispatchBrowserEvent('toastr', [
            'type' => 'success',
            'message' => 'Design Specialty ' . ($this->specialtyId  ? 'updated.' : 'created.'),
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
        DesignSpecialty::destroy($id);
        $this->dispatchBrowserEvent('toastr',['type'=>'success','message'=>'Design Specialty deleted.']);
    }

    public function toggleStatus($id)
    {
        $item =DesignSpecialty::findOrFail($id); // or StationAmenity
        $item->status = !$item->status;
        $item->save();

        $this->dispatchBrowserEvent('toastr', [
            'type' => 'success',
            'message' => 'Status ' . ($item->status ? 'activated' : 'deactivated') . ' successfully.',
        ]);
    }

}

