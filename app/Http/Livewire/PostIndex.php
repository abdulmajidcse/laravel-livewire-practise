<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PostIndex extends Component
{
    use WithPagination, WithFileUploads;

    public $post, $postId;

    protected $validationAttributes = [
        'post.category_id' => 'Category',
        'post.title' => 'Title',
        'post.content' => 'Content',
        'post.image' => 'Image',
    ];

    private function resetPost()
    {
        $this->post = [
            'category_id' => null,
            'title' => null,
            'content' => null,
            'image' => null,
        ];

        $this->postId = null;
    }

    public function mount()
    {
        $this->resetPost();
    }

    protected function rules()
    {
        return [
            'post.category_id' => 'required|integer',
            'post.title' => 'required|string',
            'post.content' => 'required|string',
            'post.image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $validateData = $this->validate();
        $this->resetPost();
        $this->emit('postAdded');
        session()->flash('message', 'Post successfully saved.');
        session()->flash('alertType', 'success');
    }

    public function render()
    {
        $posts = Post::latest('id')->paginate(10);
        return view('livewire.post-index', compact('posts'));
    }
}
