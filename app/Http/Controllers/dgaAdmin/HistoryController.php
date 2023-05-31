<?php

namespace App\Http\Controllers\dgaAdmin;

use App\Http\Controllers\Controller;
use App\Models\HistoryHu;
use App\Models\Muster;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\HistoryPlay;
use App\Models\Momo;
use App\Models\HistoryDayMission;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\HistoryWeekTop;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\dgaAdmin\MomoController;
use App\Models\HistoryBank;
use App\Http\Controllers\dgaAdmin\MomoApi;
use App\Models\LotteriaGames;
use App\Models\Zalopay;
use Illuminate\Support\Facades\Validator;

class HistoryController extends Controller
{
    public function historyPlay($game)
    {
        $setting = Setting::first();
        $history = HistoryPlay::where('game', $game)->orderBy('id', 'DESC')->limit(500)->get();
        return view('dgaAdmin.history', compact('setting', 'history'));
    }

    public function historyPlayALL(Request $request)
    {
        $code = $request->code;
        if (isset($code)) {
            $history = HistoryPlay::where('tranId', $code)->orderBy('id', 'DESC')->get();
            $setting = Setting::first();
            return view('dgaAdmin.historyAll', compact('setting', 'history'));
        } else {
            $setting = Setting::first();
            // $history = HistoryPlay::orderBy('id', 'DESC')->limit(10)->get(); 
            $history = HistoryPlay::orderBy('id', 'DESC')->limit(700)->get();
            return view('dgaAdmin.historyAll', compact('setting', 'history'));
        }
    }

    public function historyPlayError(Request $request)
    {
        $setting = Setting::first();
        $history = HistoryPlay::where(['pay' => 100])->orderBy('id', 'DESC')->limit(700)->get();
        $momo = Zalopay::get();
        $GetAccountMomo = [];
        $i = 0;
        foreach ($momo as $row) {
            $GetAccountMomo[$i] = $row;
            if ($row->status != 3) {
                // $GetAccountMomo[$i]['name'] = json_decode($row->info)->Name;
                // $GetAccountMomo[$i]['balance'] = json_decode($row->info)->balance;
                $GetAccountMomo[$i]['times'] = HistoryPlay::where(['phoneSend' => $row->phone, 'status' => 1])->whereDate('created_at', Carbon::today())->count();
                $GetAccountMomo[$i]['amount'] = HistoryPlay::where(['phoneSend' => $row->phone, 'status' => 1])->whereDate('created_at', Carbon::today())->sum('receive');
                $GetAccountMomo[$i]['amountMonth'] = HistoryPlay::where('phoneSend', $row->phone)->whereMonth('created_at', date('m'))->sum('receive');
            }
            if ($row->status == 1) {
                $GetAccountMomo[$i]['status_text'] = '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success" id="status_' . $row->id . '">Hoạt động</span>';
            } else if ($row->status == 2) {
                $GetAccountMomo[$i]['status_text'] = '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-danger-light text-danger" id="status_' . $row->id . '">Ẩn</span>';
            } else if ($row->status == 0) {
                $GetAccountMomo[$i]['status_text'] = '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-danger-light text-danger" id="status_' . $row->id . '">Bảo trì</span>';
            } else if ($row->status == 3) {
                $GetAccountMomo[$i]['status_text'] = '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-warning-light text-warning" id="status_' . $row->id . '">Đang xác thực</span>';
            } else if ($row->status == 4) {
                $GetAccountMomo[$i]['status_text'] = '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-warning-light text-warning" id="status_' . $row->id . '">Ngâm</span>';
            }
            $i++;
        }
        return view('dgaAdmin.historyError', compact('setting', 'history', 'GetAccountMomo'));
    }

    public function submitPayError(Request $request)
    {

        $setting = Setting::first();
        $validator = Validator::make($request->all(), [
            'phoneSend' => 'required|string|max:11',
            'histories' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors(array('status' => 'error', 'message' => 'Vui lòng chọn giao dịch muốn thanh toán'));
        }

        $historiesArr = explode(',', $request->histories);

        $momo = Zalopay::where(['phone' => $request->phoneSend])->first();
        $success = 0;
        $failed = 0;
        foreach ($historiesArr as $historyPlayId) {
            $info = HistoryPlay::where('id', (int)$historyPlayId)->where(['status' => 1, 'pay' => 100])->first();

            if ($momo) {

                $token = $momo->token;
                $info->pay = 1;
                $info->save();

                $url = route('admin.sendMoneyMomo', ['token' => $token, 'amount' => $info->receive, 'comment' => $setting->content . ' ' . $info->tranId, 'receiver' => $info->partnerId, 'tranId' => $info->tranId]);
                $response = Http::get($url)->json();

                if (empty($response) || $response == null) { // CHUYỂN TIỀN LỖI
                    $info->pay = 100;
                    $info->save();
                    $failed++;
                    continue;
                }

                if ($response["status"] == "error") { // CHUYỂN TIỀN LỖI
                    $info->pay = 100;
                    $info->save();
                    $failed++;
                    continue;
                }
                $info->phonePayment = $momo->phone;
                $info->save();
                $success++;
            } else {
                return back()->withErrors(array('status' => 'error', 'message' => 'Không tồn tại acc momo'));
            }
        }
        return back()->withErrors(array('status' => 'success', 'message' => 'Trả thưởng thành công ' . $success . ' bill và thất bại ' . $failed));
    }

    public function historyDayMission()
    {
        $setting = Setting::first();
        $history = HistoryDayMission::orderBy('id', 'DESC')->limit(500)->get();
        // $history = HistoryDayMission::orderBy('id', 'DESC')->paginate(10);
        return view('dgaAdmin.dayMission', compact('setting', 'history'));
    }

    public function weekTop()
    {
        $setting = Setting::first();
        $top = HistoryWeekTop::limit(100)->get();
        $historyPLay = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        $ListSDT = [];
        $st = 0;
        foreach ($historyPLay as $row) {
            $sdt = $row->partnerId;

            $check = True;
            foreach ($ListSDT as $res) {
                if ($res == $sdt) {
                    $check = False;
                }
            }

            if ($check) {
                $ListSDT[$st] = $sdt;
                $st++;
            }
        }
        $ListUser = [];
        $dga = 0;
        foreach ($ListSDT as $row) {
            $ListUser[$dga]['phone'] = $row;
            $ListUser[$dga]['receive'] = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where(['status' => 1, 'partnerId' => $row])->sum('receive');
            $dga++;
        }
        $UserTop = [];
        $st = 0;

        if ($dga > 1) {
            // Đếm tổng số phần tử của mảng
            $sophantu = count($ListUser);
            // Lặp để sắp xếp
            for ($i = 0; $i < $sophantu - 1; $i++) {
                // Tìm vị trí phần tử lớn nhất
                $max = $i;
                for ($j = $i + 1; $j < $sophantu; $j++) {
                    if ($ListUser[$j]['receive'] > $ListUser[$max]['receive']) {
                        $max = $j;
                    }
                }
                // Sau khi có vị trí lớn nhất thì hoán vị
                // với vị trí thứ $i
                $temp = $ListUser[$i];
                $ListUser[$i] = $ListUser[$max];
                $ListUser[$max] = $temp;
            }

            $UserTop = $ListUser;
        } else {
            $UserTop = $ListUser;
        }
        $gift = explode('|', $setting->gift_week);
        $UserTopTuan = [];
        $dga = 0;
        $key = 1;
        foreach ($UserTop as $row) {
            if ($dga < count($gift)) {
                $UserTopTuan[$dga] = $row;
                $UserTopTuan[$dga]['key'] = $key++;
                $UserTopTuan[$dga]['receive'] = $row['receive'];
                $UserTopTuan[$dga]['phone'] = $row['phone'];
                $UserTopTuan[$dga]['gift'] = $gift[$dga];
                $dga++;
            }
        }
        /// NGÀY
        $historyPLayDay = HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->get();
        $ListSDTDay = [];
        $st = 0;
        foreach ($historyPLayDay as $row) {
            $sdt = $row->partnerId;

            $check = True;
            foreach ($ListSDTDay as $res) {
                if ($res == $sdt) {
                    $check = False;
                }
            }

            if ($check) {
                $ListSDTDay[$st] = $sdt;
                $st++;
            }
        }
        $ListUserDay = [];
        $dga = 0;
        foreach ($ListSDTDay as $row) {
            $ListUserDay[$dga]['phone'] = $row;
            $ListUserDay[$dga]['receive'] = HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->where(['status' => 1, 'partnerId' => $row])->sum('receive');
            $dga++;
        }

        if ($dga > 1) {
            // Đếm tổng số phần tử của mảng
            $sophantu = count($ListUserDay);
            // Lặp để sắp xếp
            for ($i = 0; $i < $sophantu - 1; $i++) {
                // Tìm vị trí phần tử lớn nhất
                $max = $i;
                for ($j = $i + 1; $j < $sophantu; $j++) {
                    if ($ListUserDay[$j]['receive'] > $ListUserDay[$max]['receive']) {
                        $max = $j;
                    }
                }
                // Sau khi có vị trí lớn nhất thì hoán vị
                // với vị trí thứ $i
                $temp = $ListUserDay[$i];
                $ListUserDay[$i] = $ListUserDay[$max];
                $ListUserDay[$max] = $temp;
            }

            $UserToppDay = $ListUserDay;
        } else {
            $UserToppDay = $ListUserDay;
        }
        $gift = explode('|', $setting->gift_week);
        $UserTopDay = [];
        $dga = 0;
        $key = 1;

        foreach ($UserToppDay as $row) {
            if ($dga < count($gift)) {
                if ($row['receive'] > 0) {
                    $UserTopDay[$dga] = $row;
                    $UserTopDay[$dga]['key'] = $key++;
                    $UserTopDay[$dga]['phone'] = $row['phone'];
                    $UserTopDay[$dga]['receive'] = $row['receive'];
                    $UserTopDay[$dga]['gift'] = $gift[$dga];
                    $dga++;
                }
            }
        }

        return view('dgaAdmin.weekTop', compact('setting', 'UserTopTuan', 'top', 'UserTopDay'));
    }

    public function payWeekTop()
    {
        $setting = Setting::first();
        if ($setting->week_top == 1) {
            $historyPLay = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
            $ListSDT = [];
            $st = 0;
            foreach ($historyPLay as $row) {
                $sdt = $row->partnerId;

                $check = True;
                foreach ($ListSDT as $res) {
                    if ($res == $sdt) {
                        $check = False;
                    }
                }

                if ($check) {
                    $ListSDT[$st] = $sdt;
                    $st++;
                }
            }
            $ListUser = [];
            $dga = 0;
            foreach ($ListSDT as $row) {
                $ListUser[$dga]['phone'] = $row;
                $ListUser[$dga]['receive'] = HistoryPlay::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where(['status' => 1, 'partnerId' => $row])->sum('receive');
                $dga++;
            }
            $UserTop = [];
            $st = 0;

            if ($dga > 1) {
                // Đếm tổng số phần tử của mảng
                $sophantu = count($ListUser);
                // Lặp để sắp xếp
                for ($i = 0; $i < $sophantu - 1; $i++) {
                    // Tìm vị trí phần tử lớn nhất
                    $max = $i;
                    for ($j = $i + 1; $j < $sophantu; $j++) {
                        if ($ListUser[$j]['receive'] > $ListUser[$max]['receive']) {
                            $max = $j;
                        }
                    }
                    // Sau khi có vị trí lớn nhất thì hoán vị
                    // với vị trí thứ $i
                    $temp = $ListUser[$i];
                    $ListUser[$i] = $ListUser[$max];
                    $ListUser[$max] = $temp;
                }

                $UserTop = $ListUser;
            } else {
                $UserTop = $ListUser;
            }
            $gift = explode('|', $setting->gift_week);
            $dga = 0;
            $key = 1;
            if (Carbon::now()->format('d') != Carbon::now()->endOfWeek()->format('d')) {
                return response()->json(array('status' => 'error', 'message' => 'Hôm nay không phải cuối tuần nhé bạn!'));
            }
            if ($setting->top_phone != null) {
                return response()->json(array('status' => 'error', 'message' => 'Fake top còn trả gì nữa?'));
            }
            foreach ($UserTop as $row) {
                if ($dga < count($gift)) {
                    if ($row['receive'] > 0) {

                        $phoneNum = Zalopay::where('status', 1)->count();
                        if ($phoneNum > 0) {
                            $dataMomo = Zalopay::where('status', 1)->inRandomOrder()->first();
                            // $UserTopTuan[$dga] = $row;
                            // $UserTopTuan[$dga]['key'] = $key++;
                            // $UserTopTuan[$dga]['receive'] = $row['receive'];
                            // $UserTopTuan[$dga]['phone'] = $row['phone'];
                            // $UserTopTuan[$dga]['gift'] = $gift[$dga];
                            $url = route('admin.sendMoneyMomo', ['token' => $dataMomo->token, 'receive' => $gift[$dga], 'comment' => $setting->content_week . ' ' . Str::upper(Str::random(6)), 'receiver' => $row['phone']]);
                            $response = Http::get($url)->json();
                            if (empty($response)) {
                                (new MomoController)->loginMomo($dataMomo->phone);
                                HistoryWeekTop::create([
                                    'phone' => $row['phone'],
                                    'receive' => $row['receive'],
                                    'top' => $key++,
                                    'gift' => $gift[$dga],
                                    'status' => 100,
                                    'phoneSend' => $dataMomo->phone
                                ]);
                            }
                            if ($response['status'] != 'success') { // CHUYỂN TIỀN LỖI
                                HistoryWeekTop::create([
                                    'phone' => $row['phone'],
                                    'receive' => $row['receive'],
                                    'top' => $key++,
                                    'gift' => $gift[$dga],
                                    'status' => 100,
                                    'phoneSend' => $dataMomo->phone
                                ]);
                            } else {
                                HistoryWeekTop::create([
                                    'phone' => $row['phone'],
                                    'receive' => $row['receive'],
                                    'top' => $key++,
                                    'gift' => $gift[$dga],
                                    'status' => 1,
                                    'phoneSend' => $dataMomo->phone
                                ]);
                            }
                            $dga++;
                        }
                    }
                }
            }
        }
        if ($setting->day_top == 1) {
            $historyPLay = HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->get();
            $ListSDT = [];
            $st = 0;
            foreach ($historyPLay as $row) {
                $sdt = $row->partnerId;

                $check = True;
                foreach ($ListSDT as $res) {
                    if ($res == $sdt) {
                        $check = False;
                    }
                }

                if ($check) {
                    $ListSDT[$st] = $sdt;
                    $st++;
                }
            }
            $ListUser = [];
            $dga = 0;
            foreach ($ListSDT as $row) {
                $ListUser[$dga]['phone'] = $row;
                $ListUser[$dga]['receive'] = HistoryPlay::whereDate('created_at', Carbon::now()->toDateString())->where(['status' => 1, 'partnerId' => $row])->sum('receive');
                $dga++;
            }
            $UserTop = [];
            $st = 0;

            if ($dga > 1) {
                // Đếm tổng số phần tử của mảng
                $sophantu = count($ListUser);
                // Lặp để sắp xếp
                for ($i = 0; $i < $sophantu - 1; $i++) {
                    // Tìm vị trí phần tử lớn nhất
                    $max = $i;
                    for ($j = $i + 1; $j < $sophantu; $j++) {
                        if ($ListUser[$j]['receive'] > $ListUser[$max]['receive']) {
                            $max = $j;
                        }
                    }
                    // Sau khi có vị trí lớn nhất thì hoán vị
                    // với vị trí thứ $i
                    $temp = $ListUser[$i];
                    $ListUser[$i] = $ListUser[$max];
                    $ListUser[$max] = $temp;
                }

                $UserTop = $ListUser;
            } else {
                $UserTop = $ListUser;
            }
            $gift = explode('|', $setting->gift_week);
            $dga = 0;
            $key = 1;
            if ($setting->top_phone != null) {
                return response()->json(array('status' => 'error', 'message' => 'Fake top còn trả gì nữa?'));
            }
            foreach ($UserTop as $row) {
                if ($dga < count($gift)) {
                    if ($row['receive'] > 0) {

                        $phoneNum = Zalopay::where('status', 1)->count();
                        if ($phoneNum > 0) {
                            $dataMomo = Zalopay::where('status', 1)->inRandomOrder()->first();
                            // $UserTopTuan[$dga] = $row;
                            // $UserTopTuan[$dga]['key'] = $key++;
                            // $UserTopTuan[$dga]['receive'] = $row['receive'];
                            // $UserTopTuan[$dga]['phone'] = $row['phone'];
                            // $UserTopTuan[$dga]['gift'] = $gift[$dga];
                            $url = route('admin.sendMoneyMomo', ['token' => $dataMomo->token, 'receive' => $gift[$dga], 'comment' => $setting->content_week . ' ' . Str::upper(Str::random(6)), 'receiver' => $row['phone']]);
                            $response = Http::get($url)->json();
                            if (empty($response)) {
                                (new MomoController)->loginMomo($dataMomo->phone);
                                HistoryWeekTop::create([
                                    'phone' => $row['phone'],
                                    'receive' => $row['receive'],
                                    'top' => $key++,
                                    'gift' => $gift[$dga],
                                    'status' => 100,
                                    'phoneSend' => $dataMomo->phone
                                ]);
                            }
                            if ($response['status'] != 'success') { // CHUYỂN TIỀN LỖI
                                HistoryWeekTop::create([
                                    'phone' => $row['phone'],
                                    'receive' => $row['receive'],
                                    'top' => $key++,
                                    'gift' => $gift[$dga],
                                    'status' => 100,
                                    'phoneSend' => $dataMomo->phone
                                ]);
                            } else {
                                HistoryWeekTop::create([
                                    'phone' => $row['phone'],
                                    'receive' => $row['receive'],
                                    'top' => $key++,
                                    'gift' => $gift[$dga],
                                    'status' => 1,
                                    'phoneSend' => $dataMomo->phone
                                ]);
                            }
                            $dga++;
                        }
                    }
                }
            }
        }
        return response()->json(array('status' => 'success', 'message' => 'Trả thưởng tuần thành công'));
    }

    public function historyBank(Request $request)
    {
        $receiver_phone = $request->receiver_phone;
        $setting = Setting::first();
        if (isset($receiver_phone)) {
            $history = HistoryBank::where('receiver_phone', $receiver_phone)->orderBy('id', 'desc')->limit(1500)->get();
        } else if (isset($request->no_comment)) {
            $history = HistoryBank::where('comment', '')->whereDate('created_at', Carbon::today()->toDateString())->orderBy('id', 'desc')->limit(1500)->get();
        } else if (isset($request->no_trans)) {
            $history = HistoryBank::where('tranId', 0)->whereDate('created_at', Carbon::today()->toDateString())->orderBy('id', 'desc')->limit(1500)->get();
        } else {
            $history = HistoryBank::orderBy('id', 'desc')->limit(1500)->get();
        }

        return view('dgaAdmin.historyBank', compact('setting', 'history'));
    }

    public function addNewHistory()
    {
        $setting = Setting::first();
        $game = ['CL', 'CL2', 'TX', 'TX2', '1P3', 'LO', 'H3', 'G3', 'Xien', 'XSMB'];
        $momo = Momo::get();

        return view('dgaAdmin.addBill', compact('momo', 'setting', 'game'));
    }
    public function insertNewHistory(Request $request)
    {
        $setting = Setting::first();
        $validator = Validator::make($request->all(), [
            'partnerId' => 'required|string|max:11',
            // 'partnerName' => 'required',
            'phoneSend' => 'required|string|max:11',
            'comment' => 'required',
            'amount' => 'numeric|required',
            'tranId' => 'required|string',
            'game' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors(['status' => 'danger', 'message' => $validator->errors()->first()]);
        }
        $partnerName = $request->partnerId;
        if ($request->has('partnerName'))
            $partnerName = $request->partnerName;
        HistoryPlay::create([
            'tranId' => $request->tranId,
            'partnerName' => $partnerName,
            'partnerId' => $request->partnerId,
            'comment' => $request->comment,
            'amount' => $request->amount,
            'receive' => $request->receive,
            'status' => 1,
            'pay' => 1,
            'game' => $request->game,
            'phoneSend' => $request->phoneSend,
            'phonePayment' => $request->phoneSend
        ]);
        if ($setting->hu == 1) {
            (new MiniGame)->xuLyHu($request->tranId, $request->partnerId);
        }
        return redirect()->route('admin.historyPlayALL');
    }

    public function historyMuster()
    {
        $setting = Setting::first();
        $history = Muster::orderBy('id', 'DESC')->limit(500)->get();
        // $history = Muster::orderBy('id', 'desc')->paginate(10);
        return view('dgaAdmin.historyMuster', compact('setting', 'history'));
    }

    public function historyHu(Request $request)
    {
        $code = $request->code;
        $setting = Setting::first();
        /* if(isset($code)){
            $history = HistoryHu::where('tranId', $code)->orderBy('id', 'desc')->paginate(10);
        }else{
            $history = HistoryHu::orderBy('id', 'desc')->paginate(10);
        } */
        $history = HistoryHu::orderBy('id', 'DESC')->limit(500)->get();
        return view('dgaAdmin.historyHu', compact('setting', 'history'));
    }

    public function historyTransMomo()
    {
        $setting = Setting::first();
        $momo = Momo::get();
        $dga = new MomoApi();
        if ($_GET) {
            $dataMomo = Momo::where('phone', $_GET['phone'])->first();
            $data = json_decode($dataMomo->info, true);
            $result = $dga->QUERY_TRAN_HIS_NEW_V2($data, $_GET['from'], $_GET['to'], $_GET['limit']);
            if (!empty($result)) {
                $history = $result['data'];
            } else {
                $history = [];
            }
        } else {
            $history = [];
        }
        return view('dgaAdmin.historyTransMomo', compact('setting', 'momo', 'history'));
    }

    public function infoTran($tran, $full = '')
    {
        $isDisabled = $full === 'dd' ? '' : 'disabled';
        $setting = Setting::first();
        $info = HistoryPlay::where('tranId', $tran)->first();
        $momo = Zalopay::get();
        if ($info) {
            $isWin = (new MiniGame)->logicMinigame($info->tranId, Str::upper($info->comment), $info->game);
            $ratioName = 'ratio' . $info->game;
            $ratio = $setting->$ratioName;
            if ($info->status == 3 || $info->status == 4)
                $ratio = $isWin ? $setting->ratioHoan : 0;
            if ($info->game === 'LO-DE') {
                $ratio = LotteriaGames::where('tranId', $info->tranId)->first()->ratio;
            }
            $infoPhoneReceive = Zalopay::where('phone', $info->phoneSend)->first();
            $infoPhonePayment = Zalopay::where('phone', $info->phonePayment)->first();

            return view('dgaAdmin.info', compact('setting', 'info', 'tran', 'ratio', 'momo', 'infoPhoneReceive', 'infoPhonePayment', 'isWin', 'isDisabled'));
        }
    }

    public function infoTranEdit(Request $request, $tran)
    {
        $info = HistoryPlay::where('tranId', $tran)->first();
        $info->update($request->all());
        return redirect()->back();
    }
}
