<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotteriaSettings extends Model
{
    use HasFactory;
    protected $table = 'lotteria_settings';
    protected $fillable = [
        'momo_receiver_phone',
        'northern_lo_x2',
        'northern_lo_x3',
        'northern_lo_x4',
        'northern_de_x2',
        'northern_de_x3',
        'northern_de_x3',
        'province_lo_x2',
        'province_lo_x3',
        'province_lo_x4',
        'province_de_x2',
        'province_de_x3',
        'province_de_x4',
        'syntax_lo',
        'syntax_de',
        'web_url',
        'sync_password',
        'crawl_url',
        'active',
        'min',
        'max',
        'created_at',
        'updated_at',
    ];
}
