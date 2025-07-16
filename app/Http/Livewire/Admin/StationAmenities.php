<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\StationAmenity;
use Illuminate\Validation\Rule;
class StationAmenities extends Component
{

    use WithPagination, WithFileUploads;

    public $search = '';
    public $perPage = 10;
    public $amenityId=null;
    public $name = '';
    public $description = '';
    public $icon = '';
    public $oldIcon = '';


    protected $paginationTheme='bootstrap';
    protected $queryString=['search'];
    protected $listeners    = ['deletePrompt', 'deleteConfirmed' => 'delete'];


    protected function rules(): array
    {
        return [
            'name' => 'required|max:255|unique:supplies,name,' . $this->amenityId,
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
        ];
    }
    public function render()
    {
        $data = StationAmenity::when($this->search,fn($q)=>
                $q->where('name','like',"%{$this->search}%"))
            ->latest()->paginate($this->perPage);

        return view('livewire.admin.station-amenities',compact('data'));
    }

    public function create() { $this->amenityId=null; $this->save(); }
    public function update() { $this->save(); }

    public function resetSearch()
    {
        $this->reset('search');
    }
    private function resetForm()
    {
        $this->reset(['amenityId','name','description','icon','oldIcon']);
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
        $a=StationAmenity::findOrFail($id);
        $this->amenityId=$a->id;
        $this->name=$a->name;
        $this->description=$a->description;
        $this->oldIcon=$a->icon;      // keep for preview & delete
        $this->openCreate();
    }
    private function uploadImage($file)
    {

        $filename = 'amenity-' . time() . '.' . $file->getClientOriginalExtension();

        $file->storeAs('amenities_icon', $filename,'public_path');

        return "amenities_icon/" . $filename; // relative path to use in <img src="">
    }
    private function save(){
        $this->validate();
        $path = $this->icon
        ? $this->uploadImage($this->icon)
        : $this->oldIcon;
        if ($this->icon && $this->oldIcon && file_exists(public_path($this->oldIcon))) {
            @unlink(public_path($this->oldIcon));
        }
        if (is_null($this->amenityId)) {
            StationAmenity::create([
                'name' => $this->name,
                'description' => $this->description,
                'icon' => $path,
            ]);
        }
        else {
            StationAmenity::findOrFail($this->amenityId)->update([
                'name' => $this->name,
                'description' => $this->description,
                'icon' => $path,
            ]);

        }
        $this->dispatchBrowserEvent('toastr', [
        'type' => 'success',
        'message' => 'Station Amenity ' . ($this->amenityId ? 'updated.' : 'created.'),
        ]);
        $this->closeCreate();
         $this->resetForm();
        try {

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
        if ($amenity=StationAmenity::find($id)) {
            if ($amenity->icon) \Storage::disk('public')->delete($amenity->icon);
            $amenity->delete();
        }
        $this->dispatchBrowserEvent('toastr',['type'=>'success','message'=>'Amenity deleted.']);
    }




}
