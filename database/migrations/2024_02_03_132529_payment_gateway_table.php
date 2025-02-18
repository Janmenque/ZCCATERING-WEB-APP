<?php

use App\Models\PaymentGateway;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_gateways', function(Blueprint $table){
$table->id();
$table->string('name');
$table->string('sk')->nullable();
$table->string('pk')->nullable();
$table->string('status', 30)->default('Enabled');
$table->string('currency', 50)->nullable();
$table->timestamp('created_at')->nullable();
$table->timestamp('updated_at')->nullable();
        });

        PaymentGateway::insert([
            ['name' => 'Stripe'],
            ['name' => 'Paystack'],
            ['name' => 'Razorpay']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('payment_gateways');
    }
};
