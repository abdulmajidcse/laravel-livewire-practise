<x-app>
    <section class="container my-3">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">New Category</div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('categories.index') }}" class="btn btn-sm btn-primary">Category List</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
              @livewire('create-category')
            </div>
          </div>
    </section>
</x-app>