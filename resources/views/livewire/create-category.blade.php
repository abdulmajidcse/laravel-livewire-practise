<div>
    @if (session()->has('message'))
        <div class="alert alert-primary alert-dismissible" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div wire:loading>
        Processing...
    </div>
    <form wire:submit.prevent="save">
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" wire:model="name" class="form-control" id="name" aria-describedby="nameError">
          @error('name') <div id="nameError" class="form-text text-danger">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Save</button>
    </form>
</div>
