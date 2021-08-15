<div>
    <section class="container my-3">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">Post List</div>
                    <div class="col-md-6 text-end">
                        <button type="button" wire:click="postModal('New Post')" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#postForm">Add New</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Category</th>
                            <th scope="col">Title</th>
                            <th scope="col">Publish At</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr wire:key="{{ $loop->index }}">
                                    <th scope="row">{{ ++$loop->index }}</th>
                                    <td>{{ $post->category->name }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <button type="button" wire:click="postModal('Post View', {{ $post->id }}, 'show')" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#postView">View</button>
                                        <button type="button" wire:click="postModal('Edit Post', {{ $post->id }}, 'edit')" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#postForm">Edit</button>
                                        @if($confirming===$post->id)
                                            <button wire:click="delete({{ $post->id }})" class="btn btn-sm btn-danger">Sure?</button>
                                            <button wire:click="deleteCancel" class="btn btn-sm btn-secondary">No</button>
                                        @else
                                            <button wire:click="deleteConfirm({{ $post->id }})" class="btn btn-sm btn-danger">Delete</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="float-end">
                    {{ $posts->links('vendor.livewire.bootstrap') }}
                </div>                
            </div>
          </div>
    </section>

    <!-- post form modal -->
    <div wire:ignore.self class="modal fade" id="postForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="postFormLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="postFormLabel">{{ $modalTitle }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="save">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select wire:model="form.category_id" class="form-control" id="category_id" aria-describedby="category_idError">
                            <option>Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('form.category_id') <div id="category_idError" class="form-text text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" wire:model="form.title" class="form-control" id="title" aria-describedby="titleError">
                        @error('form.title') <div id="titleError" class="form-text text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea wire:model="form.content" class="form-control" id="content" aria-describedby="contentError" rows="3"></textarea>
                        @error('form.content') <div id="contentError" class="form-text text-danger">{{ $message }}</div>@enderror
                    </div>

                    @if ($postEdit)
                        <div class="my-3">
                            <img src="{{ Storage::url($postEdit->image) }}" style="width: 200px;">
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" wire:model="form.image" class="form-control-file" id="image" aria-describedby="imageError">
                        @error('form.image') <div id="imageError" class="form-text text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <!-- post view modal -->
    <div wire:ignore.self class="modal fade" id="postView" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="postViewLabel" aria-hidden="true">
        <div class="modal-dialog">
            @if ($postView)
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="postViewLabel">{{ $modalTitle }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Category: {{ $postView->category->name }}</p>
                        <p>Title: {{ $postView->title }}</p>
                        <p>Content: {{ $postView->content }}</p>
                        <img src="{{ Storage::url($postView->image) }}" style="width: 200px;">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if (session()->has('message') && session()->has('alertType'))
        <script>
            Swal.fire({
            title: '',
            text: "{{ session('message') }}",
            icon: "{{ session('alertType') }}",
            });
        </script>
    @endif

    @push('scripts')
        <script>
            Livewire.on('modalClose', () => {
                let postModal = document.getElementById('postForm');
                let imageField = document.getElementById('image');
                // hide postModal
                const modal = bootstrap.Modal.getInstance(postModal);
                modal.hide();
                // reset image input field
                imageField.value = '';
            });
        </script>
    @endpush

</div>
