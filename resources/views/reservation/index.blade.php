<x-back-template>
    <x-slot:title>Reservations</x-slot:title>

    <div class='card mb-5'>
        <div class='card-header'>Filter</div>
        <div class='card-body'>
<form action='{{ route('filter', ['route' => Route::currentRouteName()]) }}' method='post'>
@csrf
<div class='row'>
    <div class='col-sm-3 mb-2'>
        <input type='text' name='id' placeholder="Reservation ID" class='form-control'>
    </div>
    <div class='col-sm-3 mb-2'>
        <input type='date' name='date' placeholder="Date" class='form-control'>
    </div>
    <div class='col-sm-3 mb-2'>
        <select name='status' class='form-control'>
            <option value=''>Status</option>
            @if($status_list->count() > 0)
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

    @if($vfilter != '')
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
                            <th>ID</th>
                            @if(Auth::user()->user_role_id == 1)
                            <th>Customer</th>
                            @endif
                            <th>Date</th>
                            <th>Time</th>
                            <th>No of guest</th>
                            <th>More</th>
                            <th>Status</th>
                            @if(Auth::user()->user_role_id == 1)
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                @if(Auth::user()->user_role_id == 1)
                                <td><a href="{{ route('user_view', ['id' => $item->user_id]) }}">{{ $item->user->name }}</a></td>
                                @endif

                                <td>{{ $item->date }}</td>
                                <td>{{ $item->time }}</td>
                                <td>{{ $item->guest_num }}</td>
                                <td>
                                    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reservation_modal{{ $item->id }}">
    <i class='bi bi-eye'></i>
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="reservation_modal{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">More Info</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class='table-responsive'>
            <table class='table'>
                <tr>
                    <th>Name</th>
                    <td>{{ $item->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $item->email }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $item->tell }}</td>
                </tr>
                <tr>
                    <th>Message</th>
                    <td>{{ $item->message }}</td>
                </tr>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
                                </td>
                                <td>{!! status('reservations', $item) !!}</td>
                                @if(Auth::user()->user_role_id == 1)
                                <td>
                                    <select onchange="location = this.options[this.selectedIndex].value;" class='form-control'>
                                        <option>Change Status</option>
                                        @foreach($status_list as $sitem)
                                        <option value="{{ route('reservation_update_status', ['id' => $item->id, 'status_id' => $sitem->id]) }}">{{ $sitem->name }}</option>
                                        @endforeach
                        
                                    </select>
                                    
                                </td>
                                @endif
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
