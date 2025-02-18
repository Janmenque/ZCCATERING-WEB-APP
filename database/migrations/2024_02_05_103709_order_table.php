<?php

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
        Schema::create('order_batches', function(Blueprint $table){
$table->id();
$table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
$table->double('total');
$table->timestamp('created_at')->nullable();
$table->timestamp('updated_at')->nullable();
        });

        Schema::create('orders', function(Blueprint $table){
            $table->id();
            $table->double('amount');
            $table->foreignId('product_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('order_batch_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
                    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
