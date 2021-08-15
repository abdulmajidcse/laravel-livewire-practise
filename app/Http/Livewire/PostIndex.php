<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PostIndex extends Component
{
    use WithPagination, WithFileUploads;

    public $modalTitle, $form, $postView, $postEdit, $postId, $confirming;

    protected $validationAttributes = [
        'form.category_id' => 'Category',
        'form.title' => 'Title',
        'form.content' => 'Content',
        'form.image' => 'Image',
    ];

    private function resetPost()
    {
        $this->form = [
            'category_id' => null,
            'title' => null,
            'content' => null,
            'image' => null,
        ];

        $this->modalTitle = null;
        $this->postView = null;
        $this->postEdit = null;
        $this->postId = null;
    }

    protected function rules()
    {
        return [
            'form.category_id' => 'required|integer',
            'form.title' => 'required|string',
            'form.content' => 'required|string',
            'form.image' => $this->postId ? 'nullable' : 'required' . '|image|mimes:jpg,jpeg,png|max:5120',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

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
        Post::findOrFail($id)->delete();
        session()->flash('message', 'Post successfully deleted.');
        session()->flash('alertType', 'success');
    }

    /**
     * when click button to open modal, get $modalTitle & $postId
     * set modal title and post id
     * detect this modal will use to create or edit post
     */
    public function postModal($modalTitle, $postId = null, $mode = 'create')
    {
        $this->resetPost();
        $this->modalTitle = $modalTitle;
        $this->postId     = $postId;
        if ($this->postId && $mode == 'show') {
            $this->postView = Post::findOrFail($this->postId);
        } elseif ($this->postId && $mode == 'edit') {
            $this->postEdit = Post::findOrFail($this->postId);
            $this->form = [
                'category_id' => $this->postEdit->category_id,
                'title' => $this->postEdit->title,
                'content' => $this->postEdit->content,
            ];
        }
    }

    public function save()
    {
        $validateData = $this->validate();
        if ($this->postId) {
            $post = Post::findOrFail($this->postId);
        } else {
            $post = new Post;
        }
        $post->category_id = $validateData['form']['category_id'];
        $post->title       = $validateData['form']['title'];
        $post->content     = $validateData['form']['content'];
        if (array_key_exists('image', $validateData['form'])) {
            $post->image       = $validateData['form']['image']->store('posts');
        }
        $post->save();

        $this->emit('modalClose');
        $this->resetPost();
        session()->flash('message', 'Post successfully saved.');
        session()->flash('alertType', 'success');
    }

    public function render()
    {
        $posts = Post::latest('id')->paginate(10);
        $categories = Category::latest('id')->get();
        return view('livewire.post-index', compact('posts', 'categories'));
    }
}
