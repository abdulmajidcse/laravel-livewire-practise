<x-app>
    <section class="container my-3">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">Category List</div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">Add New</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @livewire('category-index')
            </div>
          </div>
    </section>
</x-app>