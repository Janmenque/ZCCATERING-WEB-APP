<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

public function reservation()
{
    return $this->hasMany(Reservation::class);
}

public function address()
{
    return $this->hasMany(Address::class);
}
public function user_role()
{
    return $this->belongsTo(UserRole::class);
}
public function user_status()
{
    return $this->belongsTo(UserStatus::class);
}
public function pending_purchase()
{
    return $this->hasOne(PendingPurchase::class);
}
public function order_batch()
{
    return $this->hasMany(OrderBatch::class);
}
public function transaction()
{
    return $this->hasMany(Transaction::class);
}

}
