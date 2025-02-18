<?php

namespace App\Http\Controllers;

use Razorpay\Api\Api;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\PendingPurchase;
use Illuminate\Support\Facades\Auth;

class PaymentGatewayController extends Controller
{
    public function index()
    {
        $list = PaymentGateway::all();
        return view('payment_gateway.index', ['list' => $list]);
    }

    public function store(Request $request)
    {
        $table = PaymentGateway::find($request->input('id'));
        $table->sk = $request->input('sk');
        $table->pk = $request->input('pk');
        $table->currency = $request->input('currency');
        $table->save();

        return redirect()->back()->with('status', 'Settings saved');
    }

    public function enable($id)
    {
        $table = PaymentGateway::find($id);
        $table->status = 'Enabled';
        $table->save();

        return redirect()->back()->with('status', 'Gateway enabled');
    }

    public function disable($id)
    {
        $table = PaymentGateway::find($id);
        $table->status = 'Disabled';
        $table->save();

        return redirect()->back()->with('status', 'Gateway disabled');
    }

    public function success(Request $request)
    {
        $request->session()->forget('cart');
        return view('payment_gateway.success');
    }
    public function fail()
    {
        return view('payment_gateway.fail');
    }

    public function stripe_pay()
    {
        $info = PaymentGateway::find(1);
        \Stripe\Stripe::setApiKey($info->sk);
        header('Content-Type: application/json');

        $YOUR_DOMAIN = env('APP_URL');

        if (session('cart')) {
            $pay_amount = 0;
            foreach (session('cart') as $id => $details) {
                //get price
                $product_info = Product::find($id);
                $pay_amount = $pay_amount + ($details['price'] * $details['quantity']);
            }
        } else {
            return redirect()->route('welcome');
        }

        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[
                # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                'price_data' => [
                    'unit_amount' => $pay_amount * 100,
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Product Purchase',

                    ]
                ],
                'quantity' => 1,
            ]],
            'client_reference_id' => Auth::id(),
            'customer_email' => Auth::user()->email,
            'mode' => 'payment',
            'success_url' => route('payment_gateway_success'),
            'cancel_url' => route('payment_gateway_fail'),
        ]);

        //delete pending purchase
        $table = PendingPurchase::where('user_id', Auth::id())->where('type', 'stripe');
        $table->delete();

        $xst = json_encode(session('cart'));

        $table = new PendingPurchase();
        $table->comment = $xst;
        $table->user_id = Auth::id();
        $table->save();

        header("HTTP/1.1 303 See Other");
        return redirect()->away($checkout_session->url);
    }

    public function stripe_verify_payment(Request $request)
    {
        $info = PaymentGateway::find(1);
        // Set your secret key. Remember to switch to your live secret key in production.
        // See your keys here: https://dashboard.stripe.com/apikeys
        \Stripe\Stripe::setApiKey($info->sk);

        // You can find your endpoint's secret in your webhook settings
        $endpoint_secret = $info->pk;

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

        function fulfill_order($line_items)
        {
            // TODO: fill me in
            error_log("Fulfilling order...");
            error_log($line_items);
        }

        // Handle the checkout.session.completed event
        if ($event->type == 'checkout.session.completed') {
            // Retrieve the session. If you require line items in the response, you may include them by expanding line_items.
            $session = \Stripe\Checkout\Session::retrieve([
                'id' => $event->data->object->id,
                'expand' => ['line_items'],
            ]);

            $line_items = $session->line_items;
            // Fulfill the purchase...
            fulfill_order($line_items);

            verify_payment($request, 'stripe', $event);
            /*$st = print_r($event, true);
            $st = $this->db->escape($st);
            $param['table'] = 'test';
            $param['field'] = 'id, comment';
            $param['value'] = "0, $st";
            $this->general_model->insert($param);
            $param = array();*/
        }



        http_response_code(200);
    }

    public function paystack_verify_payment(Request $request)
    {
        $curl = curl_init();
        $info = PaymentGateway::find(2);

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . $request->input('ref'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer {$info->sk}",
                "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            //echo $response;
            $result = json_decode($response);
            if ($result->data->status != 'success') {
                echo 'Something went wrong. Please try again later';
            } else {
                verify_payment($request, 'paystack', $result);
                $request->session()->flash('status', 'Payment Successful');
                echo 'success';
            }
        }
    }

    public function razorpay_pay(Request $request)
    {
        $info = PaymentGateway::find(3);
        //get order_id
        $api = new Api($info->pk, $info->sk);
        $ref = time() . rand(10 * 45, 100 * 98);
        if (session('cart')) {
            $total = 0;
            foreach (session('cart') as $id => $details) {
                $total += $details['price'] * $details['quantity'];
            }
        }

        $oid = $api->order->create(array('receipt' => $ref, 'amount' => 100 * $request->session()->get('razorpay_amount'), 'currency' => $info->currency));
        $request->session()->put('razorpay_order_id', $oid->id);

        return view('payment_gateway.razorpay_pay', ['info' => $info, 'oid' => $oid]);
    }

    public function razorpay_verify(Request $request)
    {
        $info = PaymentGateway::find(3);
        $api = new Api($info->pk, $info->sk);

        $razorpayOrderId = $request->razorpay_order_id;
        $razorpayPaymentId = $request->razorpay_payment_id;
        $razorpaySignature = $request->razorpay_signature;

        //echo $request->razorpay_order_id.' | '.session('razorpay_order_id')."<br />";


        $generated_signature = hash_hmac('sha256', session('razorpay_order_id') . "|" . $razorpayPaymentId, $info->sk);

        if ($generated_signature == $razorpaySignature) {
            verify_payment($request, 'razorpay', $generated_signature);
            $request->session()->forget('razorpay_amount');
            $request->session()->forget('razorpay_order_id');
            return redirect()->route('orders')->with('status', 'Payment Successful');
        } else {
            return redirect()->route('payment_gateway_fail');
        }
    }
}
