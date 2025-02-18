<x-back-template>
    <x-slot:title>Categories</x-slot:title>
    <p><a href='#' class='btn btn-primary' data-bs-toggle="modal" data-bs-target="#category_add_modal"><i
                class='bi bi-plus'></i> Add</a></p><br />

    <!-- Modal -->
    <div class="modal fade" id="category_add_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('category_store') }}" method='post'>
                    @csrf
                    <div class="modal-body">
                        <div class='mb-3'>
                            <label>Name*</label>
                            <input type='text' required class='form-control' name='name' />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($list->count() < 1)
        <x-no-record />
    @else
        <div class="card">
            <div class="card-body">
              <div class='table-responsive'>
                <table class="table">
                    <thead>
                        <tr class="users-table-info">
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>
                                    
                                    <div class='d-grid gap-2 d-sm-block'>
                                      <a href="#" data-bs-toggle="modal"
                                      data-bs-target="#category_edit_modal{{ $item->id }}" class='btn btn-warning btn-sm'><i class='bi bi-pencil'></i> Edit</a> <a href='{{ route('category_delete', ['id' => $item->id]) }}' class='btn btn-danger btn-sm' onclick="return confirm_action()"><i class='bi bi-trash'></i> Delete</a>
                                  </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="category_edit_modal{{ $item->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Category
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('category_store') }}" method='post'>
                                                    @csrf
                                                    <input type='hidden' name='category_id'
                                                        value='{{ $item->id }}'>
                                                    <div class="modal-body">
                                                        <div class='mb-3'>
                                                            <label>Name*</label>
                                                            <input type='text' required class='form-control'
                                                                name='name' value="{{ $item->name }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
            </div>
          </div>
    @endif
</x-back-template>
