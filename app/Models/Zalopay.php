<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zalopay extends Model
{
    use HasFactory;
    protected $fillable = [
        'phone',
        'password',
        'username',
        'balance',
        'deviceId',
        'salt',
        'public_key',
        'otp',
        'token',
        'time_login',
        'session_id',
        'display_name',
        'access_token',
        'zalo_id',
        'user_id',
        'profile_level',
        'status',
        'min',
        'max',
        'amount',
        'amountMonth',
        'show_order',
        'try',
        'times'
    ];
}
