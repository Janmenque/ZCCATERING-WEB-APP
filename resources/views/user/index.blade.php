<x-back-template>
    <x-slot:title>Users</x-slot:title>
    <p><a href='{{ route('user_create') }}' class='btn btn-primary'><i class='bi bi-plus'></i> Add</a></p><br />

    <div class='card mb-5'>
        <div class='card-header'>Filter</div>
        <div class='card-body'>
<form action='{{ route('filter', ['route' => Route::currentRouteName()]) }}' method='post'>
@csrf
<div class='row'>
    <div class='col-sm-3 mb-2'>
        <input type='text' name='search' placeholder="Search" class='form-control'>
    </div>
    <div class='col-sm-3 mb-2'>
        <div class="input-group">
            <input type="text" id="drange" class="form-control" name='drange' placeholder="Date Range" autocomplete="off">
            <span class="input-group-text" id="basic-addon2"><i class="bi bi-calendar"></i></span>
          </div>
    </div>
    <div class='col-sm-3 mb-2'>
<input type='submit' name='filter' class='btn btn-primary' value='Filter'>
    </div>
</div>
</form>
        </div>
    </div>

    @if($vfilter != '')
    <p><a class="btn btn-success mb-3" href="{{ route('user',['xfilter' => $xfilter, 'type' => 'export']) }}"><i class='bi bi-print'></i> Export</a></p>
    <p><small class='text-danger'>Filter:</small> {!! $vfilter !!}</p><br />
    @endif
    @if ($list->count() < 1)
        <x-no-record />
    @else
        {{ $list->firstItem() . ' - ' . $list->lastItem() . ' of ' . $list->total() }}
        <div class="card">
            <div class="card-body">
                <div class='table-responsive'>
                <table class="table">
                    <thead>
                        <tr class="users-table-info">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $item)
                            <tr>
                                <td><a href='{{ route('user_view', ['id' => $item->id]) }}'>{{ $item->name }}</a></td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <div class='d-grid gap-2 d-sm-block'>
                                        <a href='{{ route('user_create', ['id' => $item->id]) }}' class='btn btn-warning btn-sm'><i class='bi bi-pencil'></i> Edit</a> <a href='{{ route('user_delete', ['id' => $item->id]) }}' class='btn btn-danger btn-sm' onclick="return confirm_action()"><i class='bi bi-trash'></i> Delete</a>
                                    </div>
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            </div>
        </div><br />
        {{ $list->links() }}
    @endif
</x-back-template>
