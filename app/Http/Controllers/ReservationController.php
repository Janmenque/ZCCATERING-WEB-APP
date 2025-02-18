<?php

namespace App\Http\Controllers;

use App\Mail\ReservationEmail;
use App\Mail\ReservationStatusEmail;
use App\Models\Reservation;
use App\Models\ReservationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    public function index($xfilter = '--')
    {
        $my_id = Auth::id();

        $filter = filter($xfilter);
        $and = $filter['and'];
        $vfilter = $filter['vfilter'];

        if(Auth::user()->user_role_id == 2)
        {
            $and = $and." and user_id = $my_id ";
        }

        $status_list = ReservationStatus::all();

        $list = Reservation::whereRaw("id > 0 $and")->orderBy('date', 'desc')->paginate(20);
        return view('reservation.index', ['vfilter' => $vfilter, 'list' => $list, 'status_list' => $status_list]);
    }

    public function store(Request $request)
    {
        $table = new Reservation();
        $table->name = $request->input('name');
        $table->email = $request->input('email');
        $table->tell = $request->input('tell');
        $table->date = $request->input('date');
        $table->time = $request->input('time');
        $table->guest_num = $request->input('guest_num');
        $table->message = $request->input('message');
        $table->reservation_status_id = 4;
        $table->user_id = Auth::id();
        $table->save();

        Mail::to(config('settings.email'))->send(new ReservationEmail($request));

        return redirect()->back()->with('status', 'Form submitted, we will get in touch');
    }

    public function update_status($id, $status_id)
    {
        $info = Reservation::find($id);

        $table = $info;
        $table->reservation_status_id = $status_id;
        $table->save();

        //send email
        Mail::to($info->user->email)->send(new ReservationStatusEmail($table));
        return redirect()->back()->with('status', 'Status Updated');
    }
}
