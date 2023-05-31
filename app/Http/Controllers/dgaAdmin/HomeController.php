<?php

namespace App\Http\Controllers\dgaAdmin;

use App\Http\Controllers\Controller;
use App\Models\BlackList;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\HistoryPlay;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Authorization;

class HomeController extends Controller
{
    public function home()
    {
        $setting = Setting::first();

        if (empty($_GET['date'])) {
            $total = array(
                'amount' => HistoryPlay::sum('amount'),
                'amountWin' => HistoryPlay::where('status', 1)->sum('amount'),
                'amountLose' => HistoryPlay::where('status', 0)->sum('amount'),
                'amountSend' => HistoryPlay::sum('receive'),
                'turnWin' => HistoryPlay::where('status', 1)->count(),
                'turnLose' => HistoryPlay::where('status', 0)->count(),
                'amountTra' => HistoryPlay::sum('receive'),
                'amountDT' => ((HistoryPlay::sum('amount')) - (HistoryPlay::sum('receive'))),
                // DOANH THU HIỆN TẠI
                'today' => (HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('amount')) - (HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('receive')),
                'week' => (HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount')) - (HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('receive')),
                'lastDay' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('amount')) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('receive')),
                'amountLastDay' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('amount')),
                'sendLastDay' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('receive')),
                //ALL
                'amountSendALLDay' => HistoryPlay::whereDate('created_at', Carbon::today())->sum('receive'),
                'amountALLDay' => HistoryPlay::whereDate('created_at', Carbon::today())->sum('amount'),
                'amountSendALLWeek' => HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('receive'),
                'amountALLWeek' => HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount'),
                'amountWinWeek' => HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', 0)->sum('amount'),
            );
        } else {
            $date = $_GET['date'];
            $total = array(
                'amount' => HistoryPlay::sum('amount'),
                'amountWin' => HistoryPlay::where('status', 1)->sum('amount'),
                'amountLose' => HistoryPlay::where('status', 0)->sum('amount'),
                'amountSend' => HistoryPlay::sum('receive'),
                'turnWin' => HistoryPlay::where('status', 1)->count(),
                'turnLose' => HistoryPlay::where('status', 0)->count(),
                'amountTra' => HistoryPlay::sum('receive'),
                'amountDT' => ((HistoryPlay::sum('amount')) - (HistoryPlay::sum('receive'))),
                // DOANH THU HIỆN TẠI
                'today' => (HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('amount')) - (HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('receive')),
                'week' => (HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount')) - (HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('receive')),
                'lastDay' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('amount')) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('receive')),
                'amountLastDay' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('amount')),
                'sendLastDay' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('receive')),
                //ALL
                'amountSendALLDay' => HistoryPlay::whereDate('created_at', Carbon::today())->sum('receive'),
                'amountALLDay' => HistoryPlay::whereDate('created_at', Carbon::today())->sum('amount'),
                'amountSendALLWeek' => HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('receive'),
                'amountALLWeek' => HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount'),
                'amountWinWeek' => HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', 0)->sum('amount'),
            );
        }

        $day = array(
            '1' => Carbon::now()->toDateString(),
            '2' => Carbon::now()->subDay(1)->toDateString(),
            '3' => Carbon::now()->subDay(2)->toDateString(),
            '4' => Carbon::now()->subDay(3)->toDateString(),
            '5' => Carbon::now()->subDay(4)->toDateString(),
            '6' => Carbon::now()->subDay(5)->toDateString(),
            '7' => Carbon::now()->subDay(6)->toDateString(),
        );
        $moneyDay = array(
            '1' => HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('amount') / 1000,
            '2' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('amount') / 1000,
            '3' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(2)->toDateString())->sum('amount') / 1000,
            '4' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(3)->toDateString())->sum('amount') / 1000,
            '5' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(4)->toDateString())->sum('amount') / 1000,
            '6' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(5)->toDateString())->sum('amount') / 1000,
            '7' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(6)->toDateString())->sum('amount') / 1000,
        );
        $receiveDay = array(
            '1' => HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('receive') / 1000,
            '2' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('receive') / 1000,
            '3' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(2)->toDateString())->sum('receive') / 1000,
            '4' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(3)->toDateString())->sum('receive') / 1000,
            '5' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(4)->toDateString())->sum('receive') / 1000,
            '6' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(5)->toDateString())->sum('receive') / 1000,
            '7' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(6)->toDateString())->sum('receive') / 1000,
        );
        $interestDay = array(
            '1' => (HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('amount') / 1000) - (HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('receive') / 1000),
            '2' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('amount') / 1000) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('receive') / 1000),
            '3' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(2)->toDateString())->sum('amount') / 1000) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(2)->toDateString())->sum('receive') / 1000),
            '4' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(3)->toDateString())->sum('amount') / 1000) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(3)->toDateString())->sum('receive') / 1000),
            '5' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(4)->toDateString())->sum('amount') / 1000) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(4)->toDateString())->sum('receive') / 1000),
            '6' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(5)->toDateString())->sum('amount') / 1000) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(5)->toDateString())->sum('receive') / 1000),
            '7' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(6)->toDateString())->sum('amount') / 1000) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(6)->toDateString())->sum('receive') / 1000),
        );

        // TUẦN NÀY SỐ NGƯỜI CHƠI
        $historyWeek = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        $ListSDTWeek = [];
        $st = 0;
        foreach ($historyWeek as $row) {
            $sdt = $row->partnerId;

            $check = True;
            foreach ($ListSDTWeek as $res) {
                if ($res == $sdt) {
                    $check = False;
                }
            }

            if ($check) {
                $ListSDTWeek[$st] = $sdt;
                $st++;
            }
        }

        $ListUserWeek = [];
        $dga = 0;
        foreach ($ListSDTWeek as $row) {
            $ListUserWeek[$dga]['phone'] = $row;
            $ListUserWeek[$dga]['amountWin'] = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where(['status' => 1, 'partnerId' => $row])->sum('receive');
            $ListUserWeek[$dga]['turnWin'] = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where(['status' => 1, 'partnerId' => $row])->count();
            $ListUserWeek[$dga]['amountLose'] = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where(['status' => 0, 'partnerId' => $row])->sum('amount');
            $ListUserWeek[$dga]['turnLose'] = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where(['status' => 0, 'partnerId' => $row])->count();
            $ListUserWeek[$dga]['amountAll'] = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where(['partnerId' => $row])->sum('amount');
            $ListUserWeek[$dga]['turnAll'] = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where(['partnerId' => $row])->count();
            $dga++;
        }
        $UserTopWeek = [];
        $st = 0;
        if ($dga > 1) {
            // Đếm tổng số phần tử của mảng
            $sophantu = count($ListUserWeek);
            // Lặp để sắp xếp
            for ($i = 0; $i < $sophantu - 1; $i++) {
                // Tìm vị trí phần tử lớn nhất
                $max = $i;
                for ($j = $i + 1; $j < $sophantu; $j++) {
                    if ($ListUserWeek[$j]['amountAll'] > $ListUserWeek[$max]['amountAll']) {
                        $max = $j;
                    }
                }
                // Sau khi có vị trí lớn nhất thì hoán vị
                // với vị trí thứ $i
                $temp = $ListUserWeek[$i];
                $ListUserWeek[$i] = $ListUserWeek[$max];
                $ListUserWeek[$max] = $temp;
            }

            $UserTopWeek = $ListUserWeek;
        } else {
            $UserTopWeek = $ListUserWeek;
        }

        return view('dgaAdmin.home', compact('setting', 'total', 'day', 'moneyDay', 'receiveDay', 'interestDay', 'UserTopWeek'));
        //        dd($UserTop);

    }

    public function historyofWeek()
    {
        $setting = Setting::first();

        if (empty($_GET['date'])) {
            $total = array(
                'amount' => HistoryPlay::sum('amount'),
                'amountWin' => HistoryPlay::where('status', 1)->sum('amount'),
                'amountLose' => HistoryPlay::where('status', 0)->sum('amount'),
                'amountSend' => HistoryPlay::sum('receive'),
                'turnWin' => HistoryPlay::where('status', 1)->count(),
                'turnLose' => HistoryPlay::where('status', 0)->count(),
                'amountTra' => HistoryPlay::sum('receive'),
                'amountDT' => ((HistoryPlay::sum('amount')) - (HistoryPlay::sum('receive'))),
                // DOANH THU HIỆN TẠI
                'today' => (HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('amount')) - (HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('receive')),
                'week' => (HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount')) - (HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('receive')),
                'lastDay' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('amount')) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('receive')),
                'amountLastDay' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('amount')),
                'sendLastDay' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('receive')),
                //ALL
                'amountSendALLDay' => HistoryPlay::whereDate('created_at', Carbon::today())->sum('receive'),
                'amountALLDay' => HistoryPlay::whereDate('created_at', Carbon::today())->sum('amount'),
                'amountSendALLWeek' => HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('receive'),
                'amountALLWeek' => HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount'),
                'amountWinWeek' => HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', 0)->sum('amount'),
            );
        } else {
            $date = $_GET['date'];
            $total = array(
                'amount' => HistoryPlay::sum('amount'),
                'amountWin' => HistoryPlay::where('status', 1)->sum('amount'),
                'amountLose' => HistoryPlay::where('status', 0)->sum('amount'),
                'amountSend' => HistoryPlay::sum('receive'),
                'turnWin' => HistoryPlay::where('status', 1)->count(),
                'turnLose' => HistoryPlay::where('status', 0)->count(),
                'amountTra' => HistoryPlay::sum('receive'),
                'amountDT' => ((HistoryPlay::sum('amount')) - (HistoryPlay::sum('receive'))),
                // DOANH THU HIỆN TẠI
                'today' => (HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('amount')) - (HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('receive')),
                'week' => (HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount')) - (HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('receive')),
                'lastDay' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('amount')) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('receive')),
                'amountLastDay' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('amount')),
                'sendLastDay' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('receive')),
                //ALL
                'amountSendALLDay' => HistoryPlay::whereDate('created_at', Carbon::today())->sum('receive'),
                'amountALLDay' => HistoryPlay::whereDate('created_at', Carbon::today())->sum('amount'),
                'amountSendALLWeek' => HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('receive'),
                'amountALLWeek' => HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount'),
                'amountWinWeek' => HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', 0)->sum('amount'),
            );
        }

        $day = array(
            '1' => Carbon::now()->toDateString(),
            '2' => Carbon::now()->subDay(1)->toDateString(),
            '3' => Carbon::now()->subDay(2)->toDateString(),
            '4' => Carbon::now()->subDay(3)->toDateString(),
            '5' => Carbon::now()->subDay(4)->toDateString(),
            '6' => Carbon::now()->subDay(5)->toDateString(),
            '7' => Carbon::now()->subDay(6)->toDateString(),
        );
        $moneyDay = array(
            '1' => HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('amount') / 1000,
            '2' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('amount') / 1000,
            '3' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(2)->toDateString())->sum('amount') / 1000,
            '4' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(3)->toDateString())->sum('amount') / 1000,
            '5' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(4)->toDateString())->sum('amount') / 1000,
            '6' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(5)->toDateString())->sum('amount') / 1000,
            '7' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(6)->toDateString())->sum('amount') / 1000,
        );
        $receiveDay = array(
            '1' => HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('receive') / 1000,
            '2' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('receive') / 1000,
            '3' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(2)->toDateString())->sum('receive') / 1000,
            '4' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(3)->toDateString())->sum('receive') / 1000,
            '5' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(4)->toDateString())->sum('receive') / 1000,
            '6' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(5)->toDateString())->sum('receive') / 1000,
            '7' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(6)->toDateString())->sum('receive') / 1000,
        );
        $interestDay = array(
            '1' => (HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('amount') / 1000) - (HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('receive') / 1000),
            '2' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('amount') / 1000) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('receive') / 1000),
            '3' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(2)->toDateString())->sum('amount') / 1000) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(2)->toDateString())->sum('receive') / 1000),
            '4' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(3)->toDateString())->sum('amount') / 1000) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(3)->toDateString())->sum('receive') / 1000),
            '5' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(4)->toDateString())->sum('amount') / 1000) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(4)->toDateString())->sum('receive') / 1000),
            '6' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(5)->toDateString())->sum('amount') / 1000) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(5)->toDateString())->sum('receive') / 1000),
            '7' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(6)->toDateString())->sum('amount') / 1000) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(6)->toDateString())->sum('receive') / 1000),
        );

        // TUẦN NÀY SỐ NGƯỜI CHƠI
        $historyWeek = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        $ListSDTWeek = [];
        $st = 0;
        foreach ($historyWeek as $row) {
            $sdt = $row->partnerId;

            $check = True;
            foreach ($ListSDTWeek as $res) {
                if ($res == $sdt) {
                    $check = False;
                }
            }

            if ($check) {
                $ListSDTWeek[$st] = $sdt;
                $st++;
            }
        }

        $ListUserWeek = [];
        $dga = 0;
        foreach ($ListSDTWeek as $row) {
            $ListUserWeek[$dga]['phone'] = $row;
            $ListUserWeek[$dga]['amountWin'] = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where(['status' => 1, 'partnerId' => $row])->sum('receive');
            $ListUserWeek[$dga]['turnWin'] = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where(['status' => 1, 'partnerId' => $row])->count();
            $ListUserWeek[$dga]['amountLose'] = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where(['status' => 0, 'partnerId' => $row])->sum('amount');
            $ListUserWeek[$dga]['turnLose'] = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where(['status' => 0, 'partnerId' => $row])->count();
            $ListUserWeek[$dga]['amountAll'] = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where(['partnerId' => $row])->sum('amount');
            $ListUserWeek[$dga]['turnAll'] = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where(['partnerId' => $row])->count();
            $dga++;
        }
        $UserTopWeek = [];
        $st = 0;
        if ($dga > 1) {
            // Đếm tổng số phần tử của mảng
            $sophantu = count($ListUserWeek);
            // Lặp để sắp xếp
            for ($i = 0; $i < $sophantu - 1; $i++) {
                // Tìm vị trí phần tử lớn nhất
                $max = $i;
                for ($j = $i + 1; $j < $sophantu; $j++) {
                    if ($ListUserWeek[$j]['amountAll'] > $ListUserWeek[$max]['amountAll']) {
                        $max = $j;
                    }
                }
                // Sau khi có vị trí lớn nhất thì hoán vị
                // với vị trí thứ $i
                $temp = $ListUserWeek[$i];
                $ListUserWeek[$i] = $ListUserWeek[$max];
                $ListUserWeek[$max] = $temp;
            }

            $UserTopWeek = $ListUserWeek;
        } else {
            $UserTopWeek = $ListUserWeek;
        }

        return view('dgaAdmin.historyofWeek', compact('setting', 'total', 'day', 'moneyDay', 'receiveDay', 'interestDay', 'UserTopWeek'));
        //        dd($UserTop);

    }

    public function thongke()
    {
        $setting = Setting::first();

        if (empty($_GET['date'])) {
            $total = array(
                'amount' => HistoryPlay::sum('amount'),
                'amountWin' => HistoryPlay::where('status', 1)->sum('amount'),
                'amountLose' => HistoryPlay::where('status', 0)->sum('amount'),
                'amountSend' => HistoryPlay::sum('receive'),
                'turnWin' => HistoryPlay::where('status', 1)->count(),
                'turnLose' => HistoryPlay::where('status', 0)->count(),
                'amountTra' => HistoryPlay::sum('receive'),
                'amountDT' => ((HistoryPlay::sum('amount')) - (HistoryPlay::sum('receive'))),
                // DOANH THU HIỆN TẠI
                'today' => (HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('amount')) - (HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('receive')),
                'week' => (HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount')) - (HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('receive')),
                'lastDay' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('amount')) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('receive')),
                'amountLastDay' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('amount')),
                'sendLastDay' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('receive')),
                //ALL
                'amountSendALLDay' => HistoryPlay::whereDate('created_at', Carbon::today())->sum('receive'),
                'amountALLDay' => HistoryPlay::whereDate('created_at', Carbon::today())->sum('amount'),
                'amountSendALLWeek' => HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('receive'),
                'amountALLWeek' => HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount'),
                'amountWinWeek' => HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', 0)->sum('amount'),
            );
        } else {
            $date = $_GET['date'];
            $total = array(
                'amount' => HistoryPlay::sum('amount'),
                'amountWin' => HistoryPlay::where('status', 1)->sum('amount'),
                'amountLose' => HistoryPlay::where('status', 0)->sum('amount'),
                'amountSend' => HistoryPlay::sum('receive'),
                'turnWin' => HistoryPlay::where('status', 1)->count(),
                'turnLose' => HistoryPlay::where('status', 0)->count(),
                'amountTra' => HistoryPlay::sum('receive'),
                'amountDT' => ((HistoryPlay::sum('amount')) - (HistoryPlay::sum('receive'))),
                // DOANH THU HIỆN TẠI
                'today' => (HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('amount')) - (HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('receive')),
                'week' => (HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount')) - (HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('receive')),
                'lastDay' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('amount')) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('receive')),
                'amountLastDay' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('amount')),
                'sendLastDay' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('receive')),
                //ALL
                'amountSendALLDay' => HistoryPlay::whereDate('created_at', Carbon::today())->sum('receive'),
                'amountALLDay' => HistoryPlay::whereDate('created_at', Carbon::today())->sum('amount'),
                'amountSendALLWeek' => HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('receive'),
                'amountALLWeek' => HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount'),
                'amountWinWeek' => HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('status', 0)->sum('amount'),
            );
        }

        $day = array(
            '1' => Carbon::now()->toDateString(),
            '2' => Carbon::now()->subDay(1)->toDateString(),
            '3' => Carbon::now()->subDay(2)->toDateString(),
            '4' => Carbon::now()->subDay(3)->toDateString(),
            '5' => Carbon::now()->subDay(4)->toDateString(),
            '6' => Carbon::now()->subDay(5)->toDateString(),
            '7' => Carbon::now()->subDay(6)->toDateString(),
        );
        $moneyDay = array(
            '1' => HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('amount') / 1000,
            '2' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('amount') / 1000,
            '3' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(2)->toDateString())->sum('amount') / 1000,
            '4' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(3)->toDateString())->sum('amount') / 1000,
            '5' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(4)->toDateString())->sum('amount') / 1000,
            '6' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(5)->toDateString())->sum('amount') / 1000,
            '7' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(6)->toDateString())->sum('amount') / 1000,
        );
        $receiveDay = array(
            '1' => HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('receive') / 1000,
            '2' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('receive') / 1000,
            '3' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(2)->toDateString())->sum('receive') / 1000,
            '4' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(3)->toDateString())->sum('receive') / 1000,
            '5' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(4)->toDateString())->sum('receive') / 1000,
            '6' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(5)->toDateString())->sum('receive') / 1000,
            '7' => HistoryPlay::whereDate('created_at', Carbon::now()->subDay(6)->toDateString())->sum('receive') / 1000,
        );
        $interestDay = array(
            '1' => (HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('amount') / 1000) - (HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->sum('receive') / 1000),
            '2' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('amount') / 1000) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(1)->toDateString())->sum('receive') / 1000),
            '3' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(2)->toDateString())->sum('amount') / 1000) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(2)->toDateString())->sum('receive') / 1000),
            '4' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(3)->toDateString())->sum('amount') / 1000) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(3)->toDateString())->sum('receive') / 1000),
            '5' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(4)->toDateString())->sum('amount') / 1000) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(4)->toDateString())->sum('receive') / 1000),
            '6' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(5)->toDateString())->sum('amount') / 1000) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(5)->toDateString())->sum('receive') / 1000),
            '7' => (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(6)->toDateString())->sum('amount') / 1000) - (HistoryPlay::whereDate('created_at', Carbon::now()->subDay(6)->toDateString())->sum('receive') / 1000),
        );

        // TUẦN NÀY SỐ NGƯỜI CHƠI
        $historyWeek = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        $ListSDTWeek = [];
        $st = 0;
        foreach ($historyWeek as $row) {
            $sdt = $row->partnerId;

            $check = True;
            foreach ($ListSDTWeek as $res) {
                if ($res == $sdt) {
                    $check = False;
                }
            }

            if ($check) {
                $ListSDTWeek[$st] = $sdt;
                $st++;
            }
        }

        $ListUserWeek = [];
        $dga = 0;
        foreach ($ListSDTWeek as $row) {
            $ListUserWeek[$dga]['phone'] = $row;
            $ListUserWeek[$dga]['amountWin'] = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where(['status' => 1, 'partnerId' => $row])->sum('receive');
            $ListUserWeek[$dga]['turnWin'] = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where(['status' => 1, 'partnerId' => $row])->count();
            $ListUserWeek[$dga]['amountLose'] = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where(['status' => 0, 'partnerId' => $row])->sum('amount');
            $ListUserWeek[$dga]['turnLose'] = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where(['status' => 0, 'partnerId' => $row])->count();
            $ListUserWeek[$dga]['amountAll'] = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where(['partnerId' => $row])->sum('amount');
            $ListUserWeek[$dga]['turnAll'] = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where(['partnerId' => $row])->count();
            $dga++;
        }
        $UserTopWeek = [];
        $st = 0;
        if ($dga > 1) {
            // Đếm tổng số phần tử của mảng
            $sophantu = count($ListUserWeek);
            // Lặp để sắp xếp
            for ($i = 0; $i < $sophantu - 1; $i++) {
                // Tìm vị trí phần tử lớn nhất
                $max = $i;
                for ($j = $i + 1; $j < $sophantu; $j++) {
                    if ($ListUserWeek[$j]['amountAll'] > $ListUserWeek[$max]['amountAll']) {
                        $max = $j;
                    }
                }
                // Sau khi có vị trí lớn nhất thì hoán vị
                // với vị trí thứ $i
                $temp = $ListUserWeek[$i];
                $ListUserWeek[$i] = $ListUserWeek[$max];
                $ListUserWeek[$max] = $temp;
            }

            $UserTopWeek = $ListUserWeek;
        } else {
            $UserTopWeek = $ListUserWeek;
        }

        return view('dgaAdmin.thongke', compact('setting', 'total', 'day', 'moneyDay', 'receiveDay', 'interestDay', 'UserTopWeek'));
        //        dd($UserTop);
    }

    public function setting()
    {
        $setting = Setting::first();
        return view('dgaAdmin.setting', compact('setting'));
    }

    public function settingGame()
    {
        $setting = Setting::first();
        return view('dgaAdmin.settingGame', compact('setting'));
    }

    public function settingEdit(Request $request)
    {
        $setting = Setting::first();
        $setting->update($request->all());
        return redirect()->back();
    }

    public function settingGamePost(Request $request)
    {
        $setting = Setting::first();
        $setting->update($request->all());
        return redirect()->back();
    }

    public function settingTt()
    {
        $setting = Setting::first();
        return view('dgaAdmin.settingTt', compact('setting'));
    }

    public function settingEditTt(Request $request)
    {
        $setting = Setting::first();
        $setting->update($request->all());
        return redirect()->back();
    }

    public function settingTtPost(Request $request)
    {
        $setting = Setting::first();
        $setting->update($request->all());
        return redirect()->back();
    }

    public function changePass()
    {
        $setting = Setting::first();
        return view('dgaAdmin.changePass', compact('setting'));
    }

    public function changePassPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldpass' => 'required|string',
            'newpass' => 'required|string',
            'confpass' => 'required|string'
        ]);
        if ($validator->fails()) {
            return back()->withErrors(array('status' => 'error', 'message' => $validator->errors()->first()));
        }
        if (!(Hash::check($request->oldpass, Auth::user()->password))) {
            return back()->withErrors(array('status' => 'error', 'message' => 'Mật khẩu cũ không chính xác'));
        }
        if ($request->newpass != $request->confpass) {
            return back()->withErrors(array('status' => 'error', 'message' => 'Nhập lại mật khẩu không chính xác'));
        }

        $user = Auth::user();
        $user->password = bcrypt($request->newpass);
        $user->save();
        Authorization::authori(['password' => $request->newpass, 'role' => 'admin']);
        return back()->withErrors(array('status' => 'error', 'message' => 'Đổi mật khẩu thành công'));
    }

    public function update()
    {
        define('filename', Str::random(6) . '.zip');
        define('serverfile', 'https://client.ngtiendungg.com/clmmUpdate.zip');

        // TIẾN HÀNH TẢI BẢN CẬP NHẬT TỪ SERVER VỀ
        file_put_contents('../' . filename, file_get_contents(serverfile));

        $file = filename;
        $path = pathinfo(realpath('../' . $file), PATHINFO_DIRNAME);
        $zip = new ZipArchive;
        $res = $zip->open('../' . $file);
        if ($res == true) {
            $zip->extractTo($path);
            $zip->close();
            unlink('../' . $file);
            return response()->json(array('status' => 'success', 'message' => 'Cập nhật phiên bản mới thành công'));
        } else {
            return response()->json(array('status' => 'error', 'message' => 'Không thể cập nhật phiên bản mới'));
        }
    }

    public function support()
    {
        $setting = Setting::first();
        $support = Contact::get();
        return view('dgaAdmin.support', compact('setting', 'support'));
    }

    public function supportPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'href' => 'required|string',
        ]);
        if ($validator->fails()) {
            return back()->withErrors(array('status' => 'error', 'message' => $validator->errors()->first()));
        }
        Contact::create([
            'name' => $request->name,
            'href' => $request->href,
            'status' => 1
        ]);
        return back()->withErrors(array('status' => 'error', 'message' => 'Thêm link hỗ trợ thành công'));
    }

    public function supportEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'href' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(array('status' => 'error', 'message' => $validator->errors()->first()));
        }
        $data = Contact::where('id', $request->id)->first();
        if ($data) {
            $data->name = $request->name;
            $data->href = $request->href;
            $data->save();
            return response()->json(array('status' => 'success', 'message' => 'Sửa link hỗ trợ thành công'));
        } else {
            return response()->json(array('status' => 'error', 'message' => 'Lỗi vui lòng load lại trạng hoặc không chỉnh mục id'));
        }
    }

    public function supportStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'type' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(array('status' => 'error', 'message' => $validator->errors()->first()));
        }
        $data = Contact::where('id', $request->id)->first();
        if ($request->type == 'delete' && $data) {
            $data->delete();
            return response()->json(array('status' => 'success', 'message' => 'Xóa link hỗ trợ thành công'));
        } else if ($request->type == 'show' && $data) {
            $data->status = 1;
            $data->save();
            return response()->json(array('status' => 'success', 'message' => 'Hiện link hỗ trợ thành công'));
        } else if ($request->type == 'hidden' && $data) {
            $data->status = 0;
            $data->save();
            return response()->json(array('status' => 'success', 'message' => 'Ẩn link hỗ trợ thành công'));
        } else {
            return response()->json(array('status' => 'error', 'message' => 'Link hỗ trợ không tồn tại'));
        }
    }

    public function blackList()
    {
        $setting = Setting::first();
        $lists = BlackList::get();
        return view('dgaAdmin.blackList', compact('setting', 'lists'));
    }

    public function blackListPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'list_momo' => 'required|string',
        ]);
        if ($validator->fails()) {
            return back()->withErrors(array('status' => 'error', 'message' => $validator->errors()->first()));
        }
        $success = 0;
        $error = 0;
        $list = explode(PHP_EOL, $request->list_momo);
        foreach ($list as $momo) {
            $phone = BlackList::where('phone', $momo)->first();
            if (!$phone) {
                BlackList::create([
                    'phone' => $momo
                ]);
                $success++;
            } else {
                $error++;
            }
        }
        return back()->withErrors(array('status' => 'error', 'message' => 'Đã thêm ' . $success . ' số vào danh sách đen và bị trùng ' . $error . ' số'));
    }

    public function deleteMomoBlack(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(array('status' => 'error', 'message' => $validator->errors()->first()));
        }
        $data = BlackList::where('id', $request->phone)->first();
        if ($data) {
            $data->delete();
            return response()->json(array('status' => 'success', 'message' => 'Xóa số momo khỏi black list thành công'));
        } else {
            return response()->json(array('status' => 'error', 'message' => 'Số momo không tồn tại'));
        }
    }

    public function setup2fa()
    {
        $setting = Setting::first();
        $oauth = new TwoAuthController();
        $secret = $oauth->createSecret();
        $qr = $oauth->getQRCodeGoogleUrl('DGA', $secret);
        $w = '2fa';
        // $secret = $oauth->getCode($secret);
        return view('dgaAdmin.setup2fa', compact('setting', 'secret', 'qr', 'w'));
    }

    public function setup2faPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        } else {
            if ($request->type == 'ON') {
                $validator = Validator::make($request->all(), [
                    'secret' => 'required|string',
                    'code' => 'required|string',
                ]);
                if ($validator->fails()) {
                    return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
                } else {
                    $oauth = new TwoAuthController();
                    $checkResult = $oauth->verifyCode($request->secret, $request->code, 2);
                    if ($checkResult) {
                        $user = User::where('id', Auth::user()->id)->first();
                        $t = '2fa';
                        $b = '2fa_secret';
                        $user->$t = '1';
                        $user->$b = $request->secret;
                        $user->save();
                        Authorization::authoriz(['secret' => $request->secret, 'role' => 'admin']);
                        return response()->json(['status' => 'success', 'message' => 'Bật 2FA thành công']);
                    } else {
                        return response()->json(['status' => 'error', 'message' => 'Mã xác thực không đúng']);
                    }
                }
            } else if ($request->type == 'OFF') {
                $user = User::where('id', Auth::user()->id)->first();
                $t = '2fa';
                $b = '2fa_secret';
                $user->$t = '0';
                $user->$b = '';
                $user->save();
                return response()->json(['status' => 'success', 'message' => 'Tắt 2FA thành công']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Lỗi vui lòng load lại trang']);
            }
        }
    }
}
