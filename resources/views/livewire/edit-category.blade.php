<div>
    <form wire:submit.prevent="save">
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" wire:model="name" class="form-control" id="name" aria-describedby="nameError">
          @error('name') <div id="nameError" class="form-text text-danger">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Save</button>
    </form>

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
