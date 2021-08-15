<div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">SL</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr wire:key="{{ $loop->index }}">
                        <th scope="row">{{ ++$loop->index }}</th>
                        <td>{{ $category->name }}</td>
                        <td>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-success">Edit</a>
                            @if($confirming===$category->id)
                                <button wire:click="delete({{ $category->id }})" class="btn btn-sm btn-danger">Sure?</button>
                                <button wire:click="deleteCancel" class="btn btn-sm btn-secondary">No</button>
                            @else
                                <button wire:click="deleteConfirm({{ $category->id }})" class="btn btn-sm btn-danger">Delete</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="float-end">
        {{ $categories->links('vendor.livewire.bootstrap') }}
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
    
</div>
