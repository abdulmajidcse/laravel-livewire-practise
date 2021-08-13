<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryIndex extends Component
{
    use WithPagination;

    public function render()
    {
        $categories = Category::latest('id')->paginate(3);
        return view('livewire.category-index', ['categories' => $categories]);
    }
}
