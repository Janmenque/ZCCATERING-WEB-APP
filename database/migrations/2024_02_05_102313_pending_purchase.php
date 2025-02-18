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
        Schema::create('pending_purchases', function(Blueprint $table){
$table->id();
$table->longText('comment');
$table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
$table->string('type')->default('stripe');
$table->timestamp('created_at')->nullable();
$table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('pending_purchases');
    }
};
