<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Address;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderBatch;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
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

        $status_list = OrderStatus::all();

        $list = OrderBatch::whereRaw("id > 0 $and")->orderBy('created_at', 'desc')->paginate(20);
        return view('order.index', ['vfilter' => $vfilter, 'list' => $list, 'status_list' => $status_list]);
    }

    public function summary(Request $request)
    {
        //check if address is set
        if(Auth::user()->address->where('default', 1)->count() < 1)
        {
            return redirect()->route('address')->withErrors(['Kindy set delivery address']);
        }
        $address_info = Auth::user()->address->where('default', 1)->first();
        $total = 0;
        $payment_gateway_list = PaymentGateway::all();

        if($request->has('btn_razorpay'))
        {
            if(session('cart'))
            {
                foreach(session('cart') as $id => $details)
                {
                $total += $details['price'] * $details['quantity'];
                }
            }
            

            $request->session()->put('razorpay_amount', $total);
        return redirect()->route('razorpay_pay');
        }

        return view('order.summary', ['total' => $total, 'address_info' => $address_info, 'payment_gateway_list' => $payment_gateway_list]);
    }

    public function view($id)
    {
        $info = OrderBatch::find($id);

        if(Auth::user()->user_role_id != 1 && $info->user_id != Auth::id())
        {
            return redirect()->route('welcome');
        }

        $address_info = Address::where('user_id', $info->user_id)->where('default', 1)->first();
        $status_list = OrderStatus::all();

        return view('order.view', ['info' => $info, 'address_info' => $address_info, 'status_list' => $status_list]);
    }

    public function status_update(Request $request)
    {
        $id = $request->input('id');
        $table = OrderBatch::find($id);
        $table->order_status_id = $request->input('status');
        $table->save();

        return redirect()->back()->with('status', 'Status updated');
    }

    public function delete($id)
    {
        $table = OrderBatch::find($id);
        $table->delete();

        return redirect()->back()->with('status', 'Order deleted successfully');
    }

    public function pos($xfilter = '--')
    {
        $filter = filter($xfilter);
        $and = $filter['and'];
        $vfilter = $filter['vfilter'];

        $category_list = Category::orderBy('name')->get();
        $user_list = User::where('user_role_id', 2)->orderBy('name')->get();

        $list = Product::whereRaw("id > 0 $and")->orderBy('created_at', 'desc')->paginate(20);
        return view('order.pos', ['vfilter' => $vfilter, 'list' => $list, 'category_list' => $category_list, 'user_list' => $user_list]);
    }

    public function pos_store(Request $request)
    {
        $obj = [];
        $obj['ref'] = ref();
        $obj['user'] = $request->input('user');
        $obj['total'] = $request->input('total');
        verify_payment($request, 'pos', $obj);

        return redirect()->back()->with('status', 'Order placed successfully');
    }


}
