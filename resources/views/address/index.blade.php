<x-back-template>
    <x-slot:title>Addresses</x-slot:title>
    <p><a href='{{ route('address_create') }}' class='btn btn-primary'><i
                class='bi bi-plus'></i> Add</a></p><br />

    @if ($list->count() < 1)
        <x-no-record />
    @else
        <div class="card">
            <div class="card-body">
              <div class='table-responsive'>
                <table class="table">
                    <thead>
                        <tr class="users-table-info">
                            <th>Title</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Address</th>
                            <th>Default</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->state }}</td>
                                <td>{{ $item->city }}</td>
                                <td>{{ $item->address }}</td>
                                <td>@if($item->default == 1) <span class='badge bg-success'>Default</span> @endif</td>
                                <td>
                                    
                                    <div class='d-grid gap-2 d-sm-block'>
                                        <a href="{{ route('address_make_default', ['id' => $item->id]) }}" class='btn btn-info btn-sm'><i class='bi bi-balloon-fill'></i> Make Default</a> <a href="{{ route('address_create', ['id' => $item->id]) }}" class='btn btn-warning btn-sm'><i class='bi bi-pencil'></i> Edit</a> <a href='{{ route('address_delete', ['id' => $item->id]) }}' class='btn btn-danger btn-sm' onclick="return confirm_action()"><i class='bi bi-trash'></i> Delete</a>
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
