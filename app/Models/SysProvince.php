<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysProvince extends Model
{
    use HasFactory;
    protected $table = 'sys_province';
    protected $fillable = [
        'name',
        'name_normalized',
        'key_word',
        'type_region',
    ];
}
