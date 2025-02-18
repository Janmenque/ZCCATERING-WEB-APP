<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $list = Address::orderBy('created_at', 'desc')->get();
        return view('address.index', ['list' => $list]);
    }

    public function create($id = '--')
    {
        if($id != '')
        {
            $info = Address::find($id);
        }

        return view('address.create', ['info' => @$info, 'id' => $id]);
    }

    public function store(Request $request)
    {
        if($request->has('address_id'))
        {
            $table = Address::find($request->input('address_id'));
        }
        else
        {
            $table = new Address();
        }
        $table->title = $request->input('title');
        $table->user_id = Auth::id();
        $table->address = $request->input('address');
        $table->state = $request->input('state');
        $table->city = $request->input('city');
        //check if has address
        $check = Address::where('user_id', Auth::id())->count();
        if($check < 1)
        {
            $table->default = 1;
        }
        $table->save();

        return redirect()->route('address')->with('status', 'Address saved');
    }

    public function delete($id)
    {
        $table = Address::find($id);
        $table->delete();

        return redirect()->back()->with('status', 'Address deleted');
    }

    public function make_default($id)
    {
        //remove all defaults
        Address::where('user_id', Auth::id())->update([
'default' => 0
        ]);

        $table = Address::find($id);
        if($table->user_id == Auth::id())
        {
            $table->default = 1;
            $table->save();
        }

return redirect()->back()->with('status', 'Default set');
    }
}
