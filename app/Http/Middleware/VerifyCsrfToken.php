<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'payment_gateway/stripe_verify_payment', 'payment_gateway/paystack_verify_payment', 'payment_gateway/razorpay_verify', 'add-to-cart','update-cart','remove-from-cart'
    ];
}
