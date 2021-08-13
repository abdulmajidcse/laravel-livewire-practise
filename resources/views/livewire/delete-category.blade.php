<div class="d-inline">
    <span onclick="return confirm('Are you sure?')" wire:click="delete" class="btn btn-sm btn-danger">Delete</span>
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
