<?php

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderBatch;
use App\Models\OrderStatus;
use App\Models\Transaction;
use App\Models\PendingPurchase;
use App\Models\ReservationStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

function filter($xfilter)
{
    $and = '';
    $vfilter = '';
    if ($xfilter != '--') {
        $exp = explode('--', $xfilter);
        foreach ($exp as $item) {
            $exp2 = explode('__', $item);
            if ($exp2[0] == 'search') {
                $and = $and . " and name like '%$exp2[1]%' ";
                $vfilter = $vfilter . "<strong>Search:</strong> $exp2[1] | ";
            }
            if ($exp2[0] == 'category') {
                $and = $and . " and category_id = $exp2[1] ";
                $category_info = Category::find($exp2[1]);
                $vfilter = $vfilter . "<strong>Category:</strong> " . $category_info->name . " | ";
            }
            if ($exp2[0] == 'status') {
                if (Route::currentRouteName() == 'orders') {
                    $and = $and . " and order_status_id = $exp2[1] ";
                    $status_info = OrderStatus::find($exp2[1]);
                }
                if (Route::currentRouteName() == 'reservation') {
                    $and = $and . " and reservation_status_id = $exp2[1] ";
                    $status_info = ReservationStatus::find($exp2[1]);
                }
                $vfilter = $vfilter . "<strong>Status:</strong> " . $status_info->name . " | ";
            }
            if ($exp2[0] == 'id') {
                $and = $and . " and id = $exp2[1] ";
                $vfilter = $vfilter . "<strong>ID:</strong> " . $exp2[1] . " | ";
            }
            if ($exp2[0] == 'date') {
                $and = $and . " and date = '$exp2[1]' ";
                $vfilter = $vfilter . "<strong>Date:</strong> " . $exp2[1] . " | ";
            }
            if ($exp2[0] == 'drange') {
$dexp = explode(' - ', $exp2[1]);
$st = $dexp[0].' 00:00:01';
$et = $dexp[1].' 23:59:59';

                $and = $and . " and created_at >= '$st' and created_at <= '$et' ";
                $vfilter = $vfilter . "<strong>Date Range:</strong> " . $exp2[1] . " | ";
            }
        }
    }

    $var['and'] = $and;
    $var['vfilter'] = substr($vfilter, 0, -3);

    return $var;
}

function delete_product_pix($pix)
{
    @unlink('public/uploads/product/' . $pix);
}

function verify_payment($request, $type, $obj)
{

    if ($type == 'stripe') {
        $ref = $obj->data->object->id;
        $total = $obj->data->object->amount_total / 100;

        $user_id = $obj->data->object->client_reference_id;
        $purchase_info = PendingPurchase::where('user_id', $user_id)->where('type', 'stripe')->first();

        $products = json_decode($purchase_info->comment, true);
        $user = $purchase_info->user_id;
    }
    if ($type == 'paystack') {
        $ref = $obj->data->reference;
        $user_id = Auth::id();
        $total = $obj->data->amount / 100;
        $products = session('cart');
    }
    if ($type == 'razorpay') {
        $ref = $obj;
        $user_id = Auth::id();
        $total = $request->session()->get('razorpay_amount');
        $products = session('cart');
    }
    if($type == 'pos')
    {
        $ref = $obj['ref'];
        $user_id = $obj['user'];
        $total = $obj['total'];
        $products = session('cart');
    }

    //batch
    $table = new OrderBatch();
    $table->user_id = $user_id;
    $table->total = $total;
    if($type == 'pos')
    {
        $table->order_status_id = 7;
    }
    $table->save();
    $batch_id = $table->id;

    if ($products) {
        foreach ($products as $id => $details) {
            $product_info = Product::find($id);
            $pay_amount = $details['price'] * $details['quantity'];

            //order
            $table = new Order();
            $table->amount = $pay_amount;
            $table->product_id = $id;
            $table->order_batch_id = $batch_id;
            $table->quantity = $details['quantity'];
            $table->save();

            $order_id = $table->id;

            $table = new Transaction();
            $table->user_id = $user_id;
            $table->transaction_type_id = 1;
            $table->description = $details['name'] . ' product purchase';
            $table->amount = $pay_amount;
            $table->ref = $ref;
            $table->save();
        }
    }
    $request->session()->forget('cart');
}

function ref()
{
    $ref = uniqid();
    return $ref;
}

function status($table, $info)
{
    $bg = 'primary';
    $status = 'Status';
    
    if ($table == 'order_batches') {
        switch ($info->order_status_id) {
            case 1:
                $bg = 'success';
                break;
            case 2:
                $bg = 'danger';
                break;
            case 3:
                $bg = 'info';
                break;
            case 4:
                $bg = 'warning';
                break;
        }

        $status = $info->order_status->name;
    }

    if ($table == 'reservations') {
        switch ($info->reservation_status_id) {
            case 1:
                $bg = 'success';
                break;
            case 2:
                $bg = 'danger';
                break;
            case 3:
                $bg = 'warning';
                break;
            case 4:
                $bg = 'info';
                break;
                case 5:
                    $bg = 'primary';
                    break;
        }

        $status = $info->reservation_status->name;
    }

    if ($table == 'payment_gateways') {
        switch ($info->status) {
            case 'Enabled':
                $bg = 'success';
                break;
            case 'Disabled':
                $bg = 'danger';
                break;
        }

        $status = $info->status;
    }

    $stat = "<span class='badge bg-$bg'>$status</span>";
    return $stat;
}

function setEnv($key, $value)
{
    $value = '"' . $value . '"';
    $envFile = app()->environmentFilePath();
    $str = file_get_contents($envFile);
    $oldValue = env($key);
    $str = str_replace("{$key}={$oldValue}", "{$key}={$value}", $str);
    $str = str_replace($key . '=' . '"' . $oldValue . '"', "{$key}={$value}", $str);
    $fp = fopen($envFile, 'w');
    fwrite($fp, $str);
    fclose($fp);
    /*echo $key.'='.$oldValue;
    exit;*/
}
