<?php

namespace App\Http\Livewire;

use Livewire\Component;

class EditCategory extends Component
{
    public $name, $category;

    protected function rules()
    {
        return [
            'name' => 'required|string|unique:categories,name,'.$this->category->id,
        ];
    }

    public function mount()
    {
        $this->name = $this->category->name;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $validateData = $this->validate();
        $this->category->update([
            'name' => $validateData['name'],
        ]);

        session()->flash('message', 'Category successfully saved.');
        session()->flash('alertType', 'success');
    }

    public function render()
    {
        return view('livewire.edit-category');
    }
}
