<div>
    <section class="container my-3">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">Post List</div>
                    <div class="col-md-6 text-end">
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#postForm">Add New</button>
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
                                        <a href="{{ route('categories.edit', $post) }}" class="btn btn-sm btn-success">Edit</a>
                                        {{-- @if($confirming===$post->id)
                                            <button wire:click="delete({{ $post->id }})" class="btn btn-sm btn-danger">Sure?</button>
                                            <button wire:click="deleteCancel" class="btn btn-sm btn-secondary">No</button>
                                        @else
                                            <button wire:click="deleteConfirm({{ $post->id }})" class="btn btn-sm btn-danger">Delete</button>
                                        @endif --}}
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
                <h5 class="modal-title" id="postFormLabel">Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="save">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <input type="text" wire:model="post.category_id" class="form-control" id="category_id" aria-describedby="category_idError">
                        @error('post.category_id') <div id="category_idError" class="form-text text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" wire:model="post.title" class="form-control" id="title" aria-describedby="titleError">
                        @error('post.title') <div id="titleError" class="form-text text-danger">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea wire:model="post.content" class="form-control" id="content" aria-describedby="contentError" rows="3"></textarea>
                        @error('post.content') <div id="contentError" class="form-text text-danger">{{ $message }}</div>@enderror
                    </div>

                    @if ($post['image'])
                        <div class="my-3">
                            Image Preview:
                            <img src="{{ $post['image']->temporaryUrl() }}" style="width: 200px;">
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" wire:model="post.image" class="form-control-file" id="image" aria-describedby="imageError">
                        @error('post.image') <div id="imageError" class="form-text text-danger">{{ $message }}</div>@enderror
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
            Livewire.on('postAdded', () => {
                alert('A post was added');
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
