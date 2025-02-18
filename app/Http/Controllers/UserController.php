<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Exports\ExportUser;
use App\Models\OrderBatch;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function dashboard()
    {
        $my_id = Auth::id();
        $and = '';
        $today = date('Ymd', time());
        if(Auth::user()->user_role_id == 2)
        {
            $and = $and." and user_id = $my_id ";
        }
//orders
$order_count = OrderBatch::whereRaw("id > 0 $and")->count();
//today order
$today_order_count = OrderBatch::whereRaw("DATE_FORMAT(created_at, '%Y%m%d') = $today $and")->count();
//reservation
$reservation_count = Reservation::whereRaw("id > 0 and reservation_status_id = 5 $and")->count();
//user
$user_count = User::where('user_role_id', 2)->count();

//latest orders
$order_list = OrderBatch::whereRaw("id > 0 $and")->orderBy('created_at', 'desc')->limit(5)->get();

        return view('dashboard', ['order_count' => $order_count, 'reservation_count' => $reservation_count, 'user_count' => $user_count, 'today_order_count' => $today_order_count, 'order_list' => $order_list]);
    }

    public function index($xfilter = '--', $type = '--')
    {
        $filter = filter($xfilter);
        $and = $filter['and'];
        $vfilter = $filter['vfilter'];

        $and = $and . " and user_role_id = 2 ";

        $list = User::whereRaw("id > 0 $and")->orderBy('created_at', 'desc')->paginate(20);
        if ($type == 'export') {
            return Excel::download(new ExportUser($list), 'user.xlsx');
        }

        return view('user.index', ['vfilter' => $vfilter, 'list' => $list, 'xfilter' => $xfilter]);
    }

    public function create($id = '--')
    {
        if ($id != '--') {
            $info = User::find($id);
        }
        return view('user.create', ['info' => @$info, 'id' => $id]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'unique:users'
        ]);

        if ($request->input('user_id') == '--') {
            $table = new User();
        } else {
            $table = User::find($request->input('user_id'));
        }
        $table->name = $request->input('name');
        $table->email = $request->input('email');
        $table->password = Hash::make('restaurantC3$');
        $table->save();

        return redirect()->route('user')->with('status', 'User saved');
    }

    public function delete($id)
    {
        $table = User::find($id);
        $table->delete();

        return redirect()->route('user')->with('status', 'User deleted');
    }

    public function view($id)
    {
        $info = User::find($id);
        return view('user.view', ['info' => $info]);
    }
}
