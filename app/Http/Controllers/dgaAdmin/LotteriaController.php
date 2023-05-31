<?php

namespace App\Http\Controllers\dgaAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Momo;
use Illuminate\Support\Facades\Http;
use App\Models\HistoryPlay;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\SysProvince;
use App\Models\LotteriaGames;
use App\Models\LotteriaResults;
use App\Models\LotteriaSettings;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;

class LotteriaController extends Controller
{
    private function stripVN($str)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);

        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        $str = preg_replace("/ /", '', $str);
        return strtolower($str);
    }
    public function normalizeProvincesName()
    {
        $list_province = SysProvince::get();
        foreach ($list_province as $item) {
            $name_normalized = $this->stripVN($item->name);
            $item->name_normalized = $name_normalized;
            $item->save();
        }
    }

    public function syncLotteriaResults(Request $request)
    {
        $setting = Setting::first();
        $lotteria_setting = LotteriaSettings::first();
        if ($setting->lotteria_active != 1) return response('Lotteria is not active', 203);

        $validator = Validator::make($request->all(), [
            'results' => 'required|array',
            'date' => 'required|string',
            'type_region' => 'required|numeric',
            'syncPassword' => 'required|string'
        ]);
        $date = $request->date;
        $type_region = $request->type_region;
        $results = ($request->results);

        if ($validator->fails() || count($results) < 1 || $request->syncPassword !== $lotteria_setting->sync_password) {
            return response('Wrong input', 201);
        }

        $isExist = LotteriaResults::where('date', $date)->where('type_region', $type_region)->first();
        if ($isExist !== null)
            return response('Duplicate result ', 202);

        foreach ($results as $item) {
            $item = (object)$item;
            $item_name_normalized = $this->stripVn($item->name);
            $item_province = SysProvince::where('name_normalized', $item_name_normalized)->first();
            $g8 = $type_region == 2 ?  null : $item->g8;
            if ($item_province !== null) {

                LotteriaResults::create([
                    'province_id' => $item_province->id,
                    'g1' => $item->g1,
                    'g2' => $item->g2,
                    'g3' => $item->g3,
                    'g4' => $item->g4,
                    'g5' => $item->g5,
                    'g6' => $item->g6,
                    'g7' => $item->g7,
                    'g8' => $g8,
                    'jackpot' => $item->jackpot,
                    'type_region' => $type_region,
                    'date' => $date
                ]);
            }
        }
        return response('Sync results success', 200);
    }

    public function handleLotteriaTran($data, $fromCheckTran = false)
    {
        $setting = Setting::first();
        $lotteria_setting = LotteriaSettings::first();
        $receiver_momo = Momo::where('phone', $lotteria_setting->momo_receiver_phone)->first();

        $comment = $data['comment'];
        $amount = $data['amount'];
        $partnerId = $data['patnerID'];
        $partnerName = $data['partnerName'];
        $tranId = (string)$data['tranId'];
        $history = HistoryPlay::where('tranId', $tranId)->first();
        if (!$history) {
            if ($setting->hu == 1 && $amount >= 10000) {
                (new MiniGame())->xuLyHu($tranId, $partnerId);
            }
            $comments_array = explode("_", Str::upper($comment));
            $ratio_name = 'null';
            $province = null;
            $predicted_number = -1;
            $game_type = '';
            if (count($comments_array) === 2 && is_numeric($comments_array[1])) //mien bac
            {
                $province = SysProvince::where('key_word', 'MB')->first();
                $predicted_number = $comments_array[1];
                $num_count = strlen($predicted_number);
                if ($comments_array[0] === Str::upper($lotteria_setting->syntax_lo)) {
                    $ratio_name = 'northern_lo_x' . $num_count;
                    $game_type = 'lo';
                }
                if ($comments_array[0] === Str::upper($lotteria_setting->syntax_de)) {
                    $ratio_name = 'northern_de_x' . $num_count;
                    $game_type = 'de';
                }
            } else if (count($comments_array) === 3 && is_numeric($comments_array[2])) //tinh
            {
                $province = SysProvince::where('key_word', $comments_array[1])->first();
                if ($province) {
                    $predicted_number = $comments_array[2];
                    $num_count = strlen($predicted_number);
                    if ($comments_array[0] === Str::upper($lotteria_setting->syntax_lo)) {
                        $ratio_name = 'province_lo_x' . $num_count;
                        $game_type = 'lo';
                    }

                    if ($comments_array[0] === Str::upper($lotteria_setting->syntax_de)) {
                        $ratio_name = 'province_de_x' . $num_count;
                        $game_type = 'de';
                    }
                }
            }
            $ratio = $lotteria_setting->$ratio_name;
            if ($ratio && $province) {
                if ($amount >= $lotteria_setting->min && $amount <= $lotteria_setting->max) {
                    HistoryPlay::create([
                        'tranId' => $tranId,
                        'partnerName' => $partnerName,
                        'partnerId' => $partnerId,
                        'comment' => $comment,
                        'amount' => $amount,
                        'receive' => 0,
                        'status' => 5,
                        'pay' => 5,
                        'game' => 'LO-DE',
                        'phoneSend' => $receiver_momo->phone,
                        'phonePayment' => $receiver_momo->phone
                    ]);
                    LotteriaGames::create([
                        'tranId' => $tranId,
                        'province_id' => $province->id,
                        'ratio' => $ratio,
                        'predicted_number' => $predicted_number,
                        'game_type' => $game_type
                    ]);
                    // if ($fromCheckTran) $this->handleLotteriaGamesResult($province->type_region);
                } else { //wrong limit
                    HistoryPlay::create([
                        'tranId' => $tranId,
                        'partnerName' => $partnerName,
                        'partnerId' => $partnerId,
                        'comment' => $comment,
                        'amount' => $amount,
                        'receive' => 0,
                        'status' => 3,
                        'pay' => 1,
                        'game' => 'LO-DE',
                        'phoneSend' => $receiver_momo->phone,
                        'phonePayment' => $receiver_momo->phone
                    ]);
                }
            } else { //wrong comment
                HistoryPlay::create([
                    'tranId' => $tranId,
                    'partnerName' => $partnerName,
                    'partnerId' => $partnerId,
                    'comment' => $comment,
                    'amount' => $amount,
                    'receive' => 0,
                    'status' => 2,
                    'pay' => 1,
                    'game' => 'DUNGA',
                    'phoneSend' => $receiver_momo->phone,
                    'phonePayment' => $receiver_momo->phone
                ]);
            }
            return true;
        }
        return false;
    }

    public function getLotteriaGames()
    {
        $setting = Setting::first();
        if ($setting->lotteria_active != 1) return;
        $lotteria_setting = LotteriaSettings::first();
        $receiver_momo = Momo::where('phone', $lotteria_setting->momo_receiver_phone)->first();
        if ($receiver_momo) {
            $get_history = route('admin.historyMomoV2', ['token' => $receiver_momo->token]);
            $response = Http::get($get_history)->json();
            if (!empty($response['data'])) {
                $tran_count = 0;
                foreach ($response['data'] as $data) {
                    if ($this->handleLotteriaTran($data, $receiver_momo))
                        $tran_count++;
                }
                die('SUCCESS - Lay duoc ' . $tran_count . ' MGD');
            }
        }
    }

    private function getEndHourRegion(Int $type_region)
    {
        switch ($type_region) {
            case 2:
                return 18;
            case 1:
                return 17;
            case 0:
                return 16;
            default:
                return -1;
        }
    }

    private function handleLotteriaGamesResult(Int $type_region)
    {
        $setting = Setting::first();
        if ($setting->lotteria_active != 1) return;

        $endHour = $this->getEndHourRegion($type_region);
        $endTimeToday = Carbon::today();
        $endTimeToday->hour = $endHour;
        $endTimeToday->minute = 1;
        $endTimeToday->second = 0;
        $startTimeYesterday = Carbon::today()->addDay(-1);
        $startTimeYesterday->hour = $endHour;
        $startTimeYesterday->minute = 1;
        $startTimeYesterday->second = 0;

        $histories = HistoryPlay::where('status', 5)->whereBetween('created_at',  [$startTimeYesterday, $endTimeToday])->get();
        $today = Carbon::today()->format('d-m-Y');

        foreach ($histories as $history) {
            $lotteria_game = LotteriaGames::where('tranId', $history->tranId)->first();
            $province_data = SysProvince::where('id', $lotteria_game->province_id)->first();
            if (!$lotteria_game || $province_data->type_region !== $type_region) continue;
            // $this->handleLogicGame($game);
            $lotteria_result = LotteriaResults::where('province_id', $lotteria_game->province_id)->where('date', $today)->first();
            if ($lotteria_result) {
                $num_count = strlen($lotteria_game->predicted_number);
                $results = [$lotteria_result->jackpot];
                if ($lotteria_game->game_type == 'lo') {
                    $results =  array_merge($results, explode(" ", $lotteria_result->g1));
                    $results = array_merge($results, explode(" ", $lotteria_result->g2));
                    $results = array_merge($results, explode(" ", $lotteria_result->g3));
                    $results = array_merge($results, explode(" ", $lotteria_result->g4));
                    $results = array_merge($results, explode(" ", $lotteria_result->g5));
                    $results = array_merge($results, explode(" ", $lotteria_result->g6));
                    $results = array_merge($results, explode(" ", $lotteria_result->g7));
                    if ($lotteria_result->g8) array_merge($results, explode(" ", $lotteria_result->g8));
                }

                $win_count = 0;
                foreach ($results as $result) {
                    if (substr($result, -$num_count) == $lotteria_game->predicted_number)
                        $win_count++;
                }
                if ($win_count > 0) {
                    $history->status = 1;
                    // $history->pay = 0; //auto payment
                    $history->receive = $history->amount * $lotteria_game->ratio * $win_count;
                } else { //no win
                    $history->status = 0;
                    $history->pay = 1;
                }
            } else { //no result 
                $history->status = 0;
                $history->pay = 1;
            }
            $history->save();
        }
        return redirect()->back();
    }

    public function historyPlayALL(Request $request)
    {
        $setting = Setting::first();
        $query = HistoryPlay::where('game', 'LO-DE');
        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        $history = $query->orderBy('id', 'DESC')->limit(700)->get();
        return view('dgaAdmin.lotteriaHistoryPlay', compact('setting', 'history'));
    }

    public function settingGame()
    {
        $setting = LotteriaSettings::first();
        return view('dgaAdmin.lotteriaSetting', compact('setting'));
    }

    public function settingGamePost(Request $request)
    {
        $setting = LotteriaSettings::first();
        $setting->update($request->all());
        return redirect()->back();
    }

    public function lotteriaResult(Request $request)
    {
        $setting = Setting::first();
        $query = LotteriaResults::orderBy('id', 'DESC');
        if ($request->date) {
            $query->where('date', Carbon::createFromDate($request->date)->format('d-m-Y'));
        }

        $history = $query->limit(700)->get();
        return view('dgaAdmin.lotteriaResult', compact('setting', 'history'));
    }

    private function isWrongTimeGetResults(Int $type_region)
    {
        $now = Carbon::now();
        switch ($type_region) {
            case 2:
                return $now->hour < 18  || ($now->hour == 18 && $now->minute < 32);
            case 1:
                return $now->hour < 17  || ($now->hour == 17 && $now->minute < 32);
            case 0:
                return $now->hour < 16  || ($now->hour == 16 && $now->minute < 32);
            default:
                return true;
        }
    }

    public function getLotteriaResults(Request $request)
    {

        $type_region = $request->type_region;

        if ($this->isWrongTimeGetResults($type_region)) return redirect()->back()->withErrors(['msg' => 'Chưa đến giờ lấy kết quả xổ số: ' . $this->getEndHourRegion($type_region) . 'h32']); //chua den gio

        $lotteria_setting = LotteriaSettings::first();
        $crawl_url = $lotteria_setting->crawl_url;
        $web_url = $lotteria_setting->web_url;
        $sync_password = $lotteria_setting->sync_password;
        // dd($crawl_url, $sync_password, $web_url);
        if (!$crawl_url || !$web_url || !$sync_password)  return redirect()->back()->withErrors(['msg' => 'Chưa config các tham số']);
        $request = Http::post($lotteria_setting->crawl_url, [
            "webUrl" => $web_url,
            "syncPassword" => $sync_password,
            "type_region" => $type_region
        ])->json();

        if ($request['is_success'] === true) {
            $this->handleLotteriaGamesResult($type_region);
        } else {
            return redirect()->back()->withErrors(['msg' => 'Lỗi cron. Vui lòng thử lại sau']);
        }
    }
    public function autoPayLotteriaBills()
    {

        // $endTimeToday = Carbon::today();
        // $endTimeToday->hour = 17;
        // $endTimeToday->minute = 31;
        // $endTimeToday->second = 0;
        // $startTimeYesterday = Carbon::today()->addDay(-1);
        // $startTimeYesterday->hour = 17;
        // $startTimeYesterday->minute = 31;
        // $startTimeYesterday->second = 0;

        try {
            //code...
            $histories = HistoryPlay::where('pay', 5)->where('status', 1)->get();
            foreach ($histories as $history) {
                $history->pay = 0;
                $history->save();
            }
            return response()->json(array('status' => 'success', 'message' => 'Thành công'));
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(array('status' => 'error', 'message' => $th));
        }
    }
}
