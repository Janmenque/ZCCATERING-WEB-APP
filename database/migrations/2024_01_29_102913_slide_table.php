<?php

use App\Models\Slide;
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
        Schema::create('slides', function(Blueprint $table){
$table->id();
$table->string('pix');
$table->timestamp('created_at')->nullable();
$table->timestamp('updated_at')->nullable();
        });

        Slide::insert([
            ['pix' => 's1.jpg'],
            ['pix' => 's2.jpg'],
            ['pix' => 's3.jpg']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
