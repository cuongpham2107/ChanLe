<?php

namespace App\Http\Controllers;

use App\Models\HistoryPlay;
use App\Models\LotteriaGames;
use App\Models\LotteriaSettings;
use App\Models\Setting;
use App\Models\SysProvince;

class LotteryController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        $lotteria = LotteriaSettings::first();
        $listProvince = SysProvince::where('key_word', '<>', 'MB')->get();
        $history_play = LotteriaGames::limit(5)->orderBy('created_at','desc')->get();
        $history_win = HistoryPlay::where('game', 'LO-DE')->where('status', 1)->limit(5)->orderBy('created_at','desc')->get();

        return view('lottery', compact('setting', 'lotteria', 'listProvince', 'history_play', 'history_win'));
    }
}
