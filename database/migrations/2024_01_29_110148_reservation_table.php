<?php

use App\Models\ReservationStatus;
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
Schema::create('reservation_statuses', function(Blueprint $table){
$table->id();
$table->string('name');
$table->timestamp('created_at')->nullable();
$table->timestamp('updated_at')->nullable();
});

ReservationStatus::insert([
    ['name' => 'Approved'],
    ['name' => 'Disapproved'],
    ['name' => 'Cancelled']
]);

        Schema::create('reservations', function(Blueprint $table){
$table->id();
$table->string('name');
$table->string('email');
$table->string('tell');
$table->date('date');
$table->time('time');
$table->bigInteger('guest_num');
$table->text('message')->nullable();
$table->foreignId('reservation_status_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
$table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
