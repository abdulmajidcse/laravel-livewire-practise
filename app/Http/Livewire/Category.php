<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Category extends Component
{
    public $name, $message;

    protected $rules = [
        'name' => 'required|string',
    ];

    public function save()
    {
        $this->validate();
        
        $this->message = 'Form Submitted!';
    }

    public function render()
    {
        return view('livewire.category');
    }
}
