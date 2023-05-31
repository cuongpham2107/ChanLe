<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPlay extends Model
{
    use HasFactory;
    protected $fillable = [
        'tranId',
        'partnerName',
        'partnerId',
        'comment',
        'amount',
        'receive',
        'status',
        'pay',
        'game',
        'phoneSend',
        'phonePayment'
    ];

    public function lotteriaGame()
    {
        return $this->belongsTo(LotteriaGames::class, 'tranId', 'tranId');
    }
}
