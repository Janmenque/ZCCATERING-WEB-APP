<x-back-template>
    <x-slot:title>Orders</x-slot:title>

    <div class='card mb-5'>
        <div class='card-header'>Filter</div>
        <div class='card-body'>
            <form action='{{ route('filter', ['route' => Route::currentRouteName()]) }}' method='post'>
                @csrf
                <div class='row'>
                    <div class='col-sm-3 mb-2'>
                        <input type='text' name='id' placeholder="Order ID" class='form-control'>
                    </div>
                    <div class='col-sm-3 mb-2'>
                        <select name='status' class='form-control'>
                            <option value=''>Status</option>
                            @if ($status_list->count() > 0)
                                @foreach ($status_list as $item)
                                    <option value='{{ $item->id }}'>{{ $item->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class='col-sm-3 mb-2'>
                        <input type='submit' name='filter' class='btn btn-primary' value='Filter'>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ($vfilter != '')
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
                                <th>Order ID</th>
                                @if (Auth::user()->user_role_id == 1)
                                    <th>Customer</th>
                                @endif
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    @if (Auth::user()->user_role_id == 1)
                                        <td><a
                                                href="{{ route('user_view', ['id' => $item->user_id]) }}">{{ $item->user->name }}</a>
                                        </td>
                                    @endif
                                    <td>{{ config('settings.currency') . number_format($item->total, 2) }}</td>
                                    <td>{!! status('order_batches', $item) !!}</td>
                                    <td>{{ date('Y-m-d H:i:s', strtotime($item->created_at)) }}</td>
                                    <td>
                                        <div class='d-grid gap-2 d-sm-block'>
                                            <a href='{{ route('order_view', ['id' => $item->id]) }}'
                                                class='btn btn-success btn-sm'><i class='bi bi-eye'></i> View</a>
                                            @if (Auth::user()->user_role_id == 1)
                                                <a href='{{ route('order_delete', ['id' => $item->id]) }}'
                                                    class='btn btn-danger btn-sm' onclick="return confirm_action()"><i
                                                        class='bi bi-trash'></i> Delete</a>
                                            @endif
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
