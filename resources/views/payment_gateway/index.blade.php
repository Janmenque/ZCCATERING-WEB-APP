<x-back-template>
    <x-slot:title>Payment Gateway</x-slot:title>

    @if ($list->count() < 1)
        <x-no-record />
    @else
        <div class='card'>
            <div class='card-body'>

                <small>{{ $list->count() }} records</small>
                <div class='table-responsive'>
                    <table class='table'>
                        <tr class='text-uppercase text-secondary text-xxs font-weight-bolder opacity-7'>
                            <th>Name</th>
                            <th>Webhook</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($list as $item)
                            <tr class='text-secondary text-xs font-weight-bold'>
                                <td>{{ $item->name }}</td>
                                <td>
                                    @if($item->id == 1)
{{ route('stripe_verify_payment') }}
                                    @endif
                                </td>
                                <td>{!! status('payment_gateways', $item) !!}</td>
                                <td>
                                    <div class='d-grid gap-2 d-sm-block'>

                                        <a href='#' class='btn btn-warning btn-sm' data-bs-toggle="modal"
                                            data-bs-target="#gateway_modal{{ $item->id }}"><i
                                                class='fa fa-pencil'></i> Edit</a>

                                    @if ($item->status == 'Disabled')
                                        <a href='{{ route('payment_gateway_enable', ['id' => $item->id]) }}'
                                            class='btn btn-success btn-sm'>Enable</a>
                                    @elseif($item->status == 'Enabled')
                                        <a href='{{ route('payment_gateway_disable', ['id' => $item->id]) }}'
                                            class='btn btn-danger btn-sm'>Disable</a>
                                    @endif
                                    <!-- Modal -->
                                    <div class="modal fade" id="gateway_modal{{ $item->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action='{{ route('payment_gateway_store') }}' method='post'>
                                                    @csrf
                                                    <input type='hidden' name='id'
                                                        value='{{ $item->id }}'>
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit
                                                            Gateway</h1>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class='mb-3'>
                                                            <label>Secret Key</label>
                                                            <input type='text' name='sk'
                                                                class='form-control' value='{{ $item->sk }}'>
                                                        </div>
                                                    
                                                    <div class='mb-3'>
                                                        @if ($item->id == 1)
                                                            <label>Webhook Secret</label>
                                                        @elseif($item->id == 3)
                                                            <label>Key ID</label>
                                                        @else
                                                            <label>Public Key</label>
                                                        @endif
                                                        <input type='text' name='pk' class='form-control'
                                                            value='{{ $item->pk }}'>
                                                    </div>
                                            
                                            @if ($item->id == 3)
                                                <div class='mb-3'>
                                                    <label>Currency</label>
                                                    <select name='currency' class='form-control'>
                                                        <option value='INR'
                                                            @if (@$item->currency == 'INR') selected @endif>INR
                                                        </option>
                                                        <option value='USD'
                                                            @if (@$item->currency == 'USD') selected @endif>USD
                                                        </option>
                                                        <option value='EUR'
                                                            @if (@$item->currency == 'EUR') selected @endif>EUR
                                                        </option>
                                                        <option value='SGD'
                                                            @if (@$item->currency == 'SGD') selected @endif>SGD
                                                        </option>
                                                    </select>
                                                </div>
                                            @endif
                                                    </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                </div>
                </td>

                </tr>
    @endforeach
    </table>
    </div>

    </div>
    </div>

    @endif

</x-back-template>
