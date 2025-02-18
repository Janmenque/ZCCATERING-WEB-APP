<?php

use App\Models\OrderStatus;
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
        Schema::create('order_statuses', function(Blueprint $table){
$table->id();
$table->string('name');
$table->timestamp('created_at')->nullable();
$table->timestamp('updated_at')->nullable();
        });

        OrderStatus::insert([
            ['name' => 'Delivered'],
            ['name' => 'Declined'],
            ['name' => 'Pending'],
            ['name' => 'In progress']
        ]);

        Schema::table('order_batches', function(Blueprint $table){
$table->foreignId('order_status_id')->default(3)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
