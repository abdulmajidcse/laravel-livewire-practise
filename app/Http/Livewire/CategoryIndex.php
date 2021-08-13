<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryIndex extends Component
{
    use WithPagination;

    public $confirming;

    public function deleteConfirm($id)
    {
        $this->confirming = $id;
    }

    public function deleteCancel()
    {
        $this->confirming = null;
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        session()->flash('message', 'Category successfully deleted.');
        session()->flash('alertType', 'success');
    }

    public function render()
    {
        $categories = Category::latest('id')->paginate(3);
        return view('livewire.category-index', ['categories' => $categories]);
    }
}
