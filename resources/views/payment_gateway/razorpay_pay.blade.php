<x-log-template>
    <x-slot:title>Razorpay</x-slot:title>

    <section class='bg-light py-5'>
        <div class='container'>
            <x-auth-session-status :status="session('status')" />
            <x-auth-errors :errors="$errors" />

            <table align='center'>
                <tr>
                    <td>
                        <div class='card w-auto'>
<div class='card-body text-center'>
    <p class='lead'>You are about to make a payment of <span class='text-danger'>{{ config('settings.currency').number_format(session('razorpay_amount'), 2) }}</span> using <strong>Razorpay</strong>.</p>
    <p><button id="rzp-button1" class='btn btn-success'>Pay Now</button></p>
</div>
                        </div>
                    </td>
                </tr>
            </table>
           


        </div>
    </section>
</x-log-template>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "{{ $info->pk }}", // Enter the Key ID generated from the Dashboard
    "amount": "{{ session('razorpay_amount') * 100 }}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
    "currency": "{{ $info->currency }}",
    "name": "{{ config('settings.name') }}", //your business name
    "description": "Order",
    "image": "{{ url('public/images/'.config('settings.logo')) }}",
    "order_id": "{{ $oid->id }}", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
    "callback_url": "{{ route('razorpay_verify') }}",
    "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information especially their phone number
        "name": "{{ Auth::user()->name }}", //your customer's name
        "email": "{{ Auth::user()->email }}",
        "contact": "{{ config('settings.tell') }}" //Provide the customer's phone number for better conversion rates 
    },
    "theme": {
        "color": "#3399cc"
    }
};
var rzp1 = new Razorpay(options);
document.getElementById('rzp-button1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>
