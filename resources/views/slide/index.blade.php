<x-back-template>
    <x-slot:title>Slides</x-slot:title>
    <p><a href='{{ route('slide_create') }}' class='btn btn-primary'><i class='bi bi-plus'></i> Add</a></p><br />

    @if ($list->count() < 1)
        <x-no-record />
    @else
        {{ $list->count().' records' }}
        <div class="card">
            <div class="card-body">
                <div class='table-responsive'>
                    <table class="table">
                        <thead>
                            <tr class="users-table-info">
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $item)
                                <tr>
                                    <td><img src='{{ url('public/uploads/slides/' . $item->pix) }}'
                                            class='img-fluid' width='150'></td>
                                    <td>
                                        <div class='d-grid gap-2 d-sm-block'>
                                            <a href='{{ route('slide_delete', ['id' => $item->id]) }}'
                                                class='btn btn-danger btn-sm' onclick="return confirm_action()"><i
                                                    class='bi bi-trash'></i> Delete</a>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div><br />

    @endif
</x-back-template>
