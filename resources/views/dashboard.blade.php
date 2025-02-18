<x-back-template>
    <x-slot:title>Dashboard</x-slot:title>

    <div class="row stat-cards mb-5">

        <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
                <div class="stat-cards-icon primary">
                    <i data-feather="bar-chart-2" aria-hidden="true"></i>
                </div>
                <div class="stat-cards-info">
                    <p class="stat-cards-info__num">{{ number_format($order_count) }}</p>
                    <p class="stat-cards-info__title">Total orders</p>

                </div>
            </article>
        </div>
        <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
                <div class="stat-cards-icon success">
                    <i data-feather="feather" aria-hidden="true"></i>
                </div>
                <div class="stat-cards-info">
                    <p class="stat-cards-info__num">{{ number_format($today_order_count) }}</p>
                    <p class="stat-cards-info__title">Today orders</p>

                </div>
            </article>
        </div>
        <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
                <div class="stat-cards-icon warning">
                    <i data-feather="file" aria-hidden="true"></i>
                </div>
                <div class="stat-cards-info">
                    <p class="stat-cards-info__num">{{ number_format($reservation_count) }}</p>
                    <p class="stat-cards-info__title">Reservation</p>
                   
                </div>
            </article>
        </div>
        @if(Auth::user()->user_role_id == 1)
        <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item">
                <div class="stat-cards-icon purple">
                    <i data-feather="user" aria-hidden="true"></i>
                </div>
                <div class="stat-cards-info">
                    <p class="stat-cards-info__num">{{ number_format($user_count) }}</p>
                    <p class="stat-cards-info__title">Total Users</p>
                    
                </div>
            </article>
        </div>
        @endif
        
    </div>
 
@if ($order_list->count() < 1)
    <x-no-record />
@else
    <div class="card">
        <div class='card-header bg-info text-white'>Latest Orders</div>
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order_list as $item)
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

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class='d-grid gap-2 mt-2'><a href='{{ route('orders') }}' class='btn btn-success rounded-pill'>View All</a></div>
        </div>
    </div>
@endif


</x-back-template>
