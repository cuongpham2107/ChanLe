<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Momo extends Model
{
    use HasFactory;
    protected $fillable = [
        'token',
        'phone',
        'min',
        'max',
        'info',
        'times',
        'amount',
        'amountMonth',
        'status',
        'comment',
        'time_login',
        'try',
        'user_group'
    ];
}
