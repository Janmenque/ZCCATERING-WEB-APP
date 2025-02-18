<?php

use App\Models\TransactionType;
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
        Schema::create('transaction_types', function(Blueprint $table){
            $table->id();
$table->string('name');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        TransactionType::insert([
            ['name' => 'Product Purchase']
        ]);

        Schema::create('transactions', function(Blueprint $table){
$table->id();
$table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
$table->foreignId('transaction_type_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
$table->text('description');
$table->double('amount');
$table->string('ref')->nullable();
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
