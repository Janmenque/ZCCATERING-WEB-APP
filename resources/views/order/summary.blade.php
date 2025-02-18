<x-front-template>
    <x-slot:title>Order Summary</x-slot:title>
    <section class="section">
        <div class='container'>
            <h4>Order Summary</h4><br />
            <div class='card mb-5'>
                <div class='card-header bg-success text-white'>Shipping Address</div>
                <div class='card-body'>

                    <div class='table-responsive'>
                        <table class='table table-striped'>
                            <tr>
                                <th>Title:</th>
                                <td>{{ $address_info->title }}</td>
                            </tr>
                            <tr>
                                <th>State:</th>
                                <td>{{ $address_info->state }}</td>
                            </tr>
                            <tr>
                                <th>City:</th>
                                <td>{{ $address_info->city }}</td>
                            </tr>
                            <tr>
                                <th>Address:</th>
                                <td>{{ $address_info->address }}</td>
                            </tr>
                        </table>
                    </div>
                    <p><a href='{{ route('address') }}' class='btn btn-warning'><i class='bi bi-pencil'></i> Edit</a></p>
                </div>
            </div>

            <div class='card mb-3'>
                <div class='card-header bg-info text-white'>Items</div>
                <div class='card-body'>
                    <div class='table-responsive'>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0 @endphp
                                @if (session('cart'))
                                    @foreach (session('cart') as $id => $details)
                                        @php $total += $details['price'] * $details['quantity'] @endphp
                                        <tr data-id="{{ $id }}">
                                            <td data-th="Product">
                                                <div class="row">
                                                    <div class="col-sm-3 hidden-xs"><img
                                                            src="{{ url('public/uploads/product') . '/' . $details['image'] }}"
                                                            width="100" height="100" class="img-responsive" />
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <h4 class="nomargin">{{ $details['name'] }}</h4>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-th="Price">{{ config('settings.currency') }}{{ $details['price'] }}
                                            </td>
                                            <td data-th="Quantity">
                                                {{ $details['quantity'] }}
                                            </td>
                                            <td data-th="Subtotal" class="text-center">
                                                {{ config('settings.currency') }}{{ $details['price'] * $details['quantity'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right">
                                        <h3><strong>Total
                                                {{ config('settings.currency') }}{{ $total }}</strong></h3>
                                    </td>
                                </tr>

                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <form action='' method='post'>
                @csrf
                @foreach ($payment_gateway_list as $item)
                    @if ($item->id == 1 && $item->status == 'Enabled')
                        <a href="{{ route('stripe_pay') }}" class="btn btn-success">Pay with Stripe </a>
                    @endif
                    @if ($item->id == 2 && $item->status == 'Enabled')
                        <a class="btn btn-success" onclick="payWithPaystack()">Pay with Paystack </a>
                        <script src="https://js.paystack.co/v1/inline.js"></script>
                        <script>
                            function payWithPaystack() {
                                var handler = PaystackPop.setup({
                                    key: "{{ $item->pk }}", // Replace with your public key
                                    email: "{{ Auth::user()->email }}",
                                    amount: {{ $total }} *
                                        100, // the amount value is multiplied by 100 to convert to the lowest currency unit
                                    currency: "{{ $item->currency }}", // Use GHS for Ghana Cedis or USD for US Dollars
                                    ref: "{{ ref() }}", // Replace with a reference you generated
                                    callback: function(response) {
                                        //this happens after the payment is completed successfully
                                        var reference = response.reference;
                                        //alert('Payment complete! Reference: ' + reference);
                                        // Make an AJAX call to your server with the reference to verify the transaction
                                        $.ajax({
                                            type: 'post',
                                            url: "{{ route('paystack_verify_payment') }}",
                                            data: {
                                                ref: reference
                                            },
                                            success: function(response) {
                                                if (response == "success") {
                                                    window.location.href = "{{ route('orders') }}";
                                                } else {
                                                    alert(response);
                                                }
                                            }
                                        });

                                    },
                                    onClose: function() {
                                        alert('Transaction was not completed, window closed.');
                                    },
                                });
                                handler.openIframe();
                            }
                        </script>
                    @endif
                    @if ($item->id == 3 && $item->status == 'Enabled')
                        <input type='submit' name='btn_razorpay' class='btn btn-success' value='Pay with Razorpay'>
                    @endif
                @endforeach
            </form>
        </div>
    </section>

</x-front-template>
