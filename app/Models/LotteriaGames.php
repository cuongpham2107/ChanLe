<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotteriaGames extends Model
{
    use HasFactory;
    protected $fillable = [
        'tranId',
        'ratio',
        'province_id',
        'predicted_number',
        'game_type'
    ];

    /**
     * Get his play associated with the lotte game.
     */
    public function historyPlay()
    {
        return $this->hasOne(HistoryPlay::class, 'tranId', 'tranId');
    }

    /**
     * Get his play associated with the lotte game.
     */
    public function province()
    {
        return $this->hasOne(SysProvince::class, 'id', 'province_id');
    }
}
