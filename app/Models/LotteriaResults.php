<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotteriaResults extends Model
{
    use HasFactory;
    protected $table = 'sys_lottery';
    protected $fillable = [
        'province_id',
        'jackpot',
        'g1',
        'g2',
        'g3',
        'g4',
        'g5',
        'g6',
        'g7',
        'g8',
        'date',
        'type_region',
    ];

    public function province()
    {
        return $this->belongsTo(SysProvince::class);
    }
}
