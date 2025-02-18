<?php

use App\Models\User;
use App\Models\UserRole;
use App\Models\UserStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_roles', function(Blueprint $table){
$table->id();
$table->string('name');
$table->timestamp('created_at')->nullable();
$table->timestamp('updated_at')->nullable();
        });

        UserRole::insert([
            ['name' => 'Super Admin'],
            ['name' => 'User'],
            ['name' => 'Admin']
        ]);

        Schema::create('user_statuses', function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
                    });

                    UserStatus::insert([
                        ['name' => 'Actve'],
                        ['name' => 'Inactive'],
                        ['name' => 'Blocked']
                    ]);

        Schema::table('users', function(Blueprint $table){
$table->foreignId('user_role_id')->default(2)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
$table->foreignId('user_status_id')->default(1)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });

        $table = new User();
        $table->name = 'Admin';
        $table->email = 'admin@admin.com';
        $table->email_verified_at = date('Y-m-d H:i:s', time());
        $table->password = Hash::make('admin');
        $table->user_role_id = 1;
        $table->save();

        Schema::create('addresses', function(Blueprint $table){
            $table->id();
            $table->string('title');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
$table->text('address');
            $table->string('state');
            $table->string('city');
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
