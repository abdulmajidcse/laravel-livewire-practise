<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;

class CreateCategory extends Component
{
    public $name;

    protected $rules = [
        'name' => 'required|string|unique:categories',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $validateData = $this->validate();
        Category::create([
            'name' => $validateData['name'],
        ]);

        $this->name = '';
        session()->flash('message', 'Category successfully saved.');
        session()->flash('alertType', 'success');
    }

    public function render()
    {
        return view('livewire.create-category');
    }
}
