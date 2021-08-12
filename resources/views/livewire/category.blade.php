<div>
    @if($message) <p class="alert alert-success mt-3 p-3">{{ $message }}</p>@endif
    <form wire:submit.prevent="save" class="p-5">
        <input wire:model="name" type="text" class="form-control mb-3">
        @error('name') <p class="text-danger mb-3">{{ $message }}</p> @enderror
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
