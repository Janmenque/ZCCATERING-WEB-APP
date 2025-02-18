<x-back-template>
    <x-slot:title>POS</x-slot:title>
    <div class='row'>
        <div class='col-sm-7 mb-2'>
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
                                <select name='category' class='form-control'>
                                    <option value=''>Category</option>
                                    @if ($category_list->count() > 0)
                                        @foreach ($category_list as $item)
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
                                        <th>Pix</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $item)
                                        <tr>
                                            <td><img src='{{ url('public/uploads/product/' . $item->pix) }}'
                                                    class='img-fluid rounded-circle' width='50'></td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ config('settings.currency') . number_format($item->price, 2) }}</td>
                                            <td>{{ $item->category->name }}</td>
                                            <td>
                                                <div class='d-grid gap-2 d-sm-block'>
                                                    <button class='btn btn-success'
                                                        onclick="add_to_cart({{ $item->id }})"><i
                                                            class='bi bi-cart'></i> Add to cart</button>
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
        </div>
        <div class='col-sm-5 mb-2'>
            <form action='{{ route('pos_store') }}' method='post'>
                @csrf
                <div class='row mb-4'>
                    <div class='col-sm-8'>
                        <select name="user" class="form-control" required>
                            <option value="">Select User</option>
                            @foreach ($user_list as $item)
                                <option value='{{ $item->id }}'>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='col-sm-4'>
                        <a href='{{ route('user_create') }}' class='btn btn-primary'><i class='bi bi-plus'></i></a>
                    </div>
                </div>
<div id="cart">
    <x-cart/>
</div>
                
            </form>
        </div>
    </div>
</x-back-template>
