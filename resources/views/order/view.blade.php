<x-back-template>
    <x-slot:title>Order Details</x-slot:title>

    <!--In Head-->
    <link href="{{ url('public/css') }}/track.css" rel="stylesheet" media="screen">
    <!--in head end-->
    <div class="row shop-tracking-status">

        <div class="col-md-12">
            <div class="well">



                <div class="order-status">

                    <div class="order-status-timeline">
                        <!--change status here-->
                        <!-- class names: c0 c1 c2 c3 and c4 -->
                        @php
                            $cstat = '';
                            if ($info->order_status_id == 1) {
                                $cstat = 'c3';
                            } elseif ($info->order_status_id == 4) {
                                $cstat = 'c1';
                            } elseif ($info->order_status_id == 5) {
                                $cstat = 'c0';
                            } elseif ($info->order_status_id == 6) {
                                $cstat = 'c2';
                            } elseif ($info->order_status_id == 7) {
                                $cstat = 'c4';
                            }

                        @endphp
                        <div class="order-status-timeline-completion {{ $cstat }}"></div>
                        <!--change status here end-->
                    </div>

                    <div class="image-order-status image-order-status-new active img-circle">
                        <span class="status">Accepted</span>
                        <div class="icon"></div>
                    </div>
                    <div class="image-order-status image-order-status-active active img-circle">
                        <span class="status">In progress</span>
                        <div class="icon"></div>
                    </div>
                    <div class="image-order-status image-order-status-intransit active img-circle">
                        <span class="status">Shipped</span>
                        <div class="icon"></div>
                    </div>
                    <div class="image-order-status image-order-status-delivered active img-circle">
                        <span class="status">Delivered</span>
                        <div class="icon"></div>
                    </div>
                    <div class="image-order-status image-order-status-completed active img-circle">
                        <span class="status">Completed</span>
                        <div class="icon"></div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class='card'>
        <div class='card-body'>
            <div class='row mb-4'>
                <div class='col-sm-8'>
                    <h3>Invoice To</h3><br />
                    @if ($address_info != '')
                        <p>{{ $address_info->address . ', ' . $address_info->city . ', ' . $address_info->state }}</p>
                            @endif
                            <small class='text-danger'>{{ $info->user->name }}</small><br />{{ $info->user->email }}
                        
                   
                </div>
                <div class='col-sm-4'>
                    <table class='table'>
                        <tr>
                            <th>Order ID:</th>
                            <td>{{ $info->id }}</td>
                        </tr>
                        <tr>
                            <th>Date:</th>
                            <td>{{ $info->created_at }}</td>
                        </tr>
                    </table>
                </div>
            </div>
@php
    $total = 0;
@endphp
            <div class='table-responsive'>
<table class='table table-striped'>
    <tr>
    <th>#</th>
    <th>Item</th>
    <th>Quantity</th>
    <th>Total</th>
</tr>
@foreach($info->order as $item)
<tr>
    <td>{{ $item->id }}</td>
    <td>{{ $item->product->name }}</td>
    <td>{{ $item->quantity }}</td>
    <td>{{ config('settings.currency').number_format($item->amount, 2) }}</td>
</tr>
@php
    $total = $total + $item->amount;
@endphp
@endforeach
<tr>
    <th colspan="3">Total</th>
    <th>{{ config('settings.currency').number_format($total, 2) }}</th>
</tr>
</table>
            </div>

        </div>
    </div>
@if(Auth::user()->user_role_id == 1)
    <div class='card mt-5'>
        <div class='card-header bg-primary text-white'>Update Status</div>
        <div class='card-body'>
            <form action='{{ route('order_status_update') }}' method='post'>
                @csrf
<input type='hidden' name='id' value='{{ $info->id }}'>
<div class='mb-3'>
    <select name='status' class='form-control'>
        <option value=''>Select Status</option>
        @foreach($status_list as $item)
<option value='{{ $item->id }}'>{{ $item->name }}</option>
        @endforeach
    </select>
</div>
<input type='submit' name='update' value='Update' class='btn btn-success'>
            </form>
        </div>
    </div>
    @endif

</x-back-template>
