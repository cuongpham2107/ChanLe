<?php

namespace App\Http\Controllers\dgaAdmin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\dgaAdmin\MomoApi;
use App\Models\Device;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Momo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use App\Models\HistoryPlay;
use App\Models\HistoryBank;
use App\Models\LotteriaSettings;
use App\Models\Zalopay;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SebastianBergmann\Environment\Console;

class MomoController extends Controller
{

    private $TimeSetup = 900;

    public function addMomo()
    {
        $setting = Setting::first();
        $momo = Momo::get();
        $GetAccountMomo = [];
        $i = 0;
        return view('dgaAdmin.addMomo', compact('setting', 'GetAccountMomo'));
    }

    public function sendMomo()
    {
        $setting = Setting::first();
        // $momo = Momo::get();
        // $GetAccountMomo = [];
        // $i = 0;
        // foreach ($momo as $row) {
        //     $GetAccountMomo[$i] = $row;
        //     if ($row->status != 3) {
        //         $GetAccountMomo[$i]['name'] = json_decode($row->info)->Name;
        //         $GetAccountMomo[$i]['balance'] = json_decode($row->info)->balance;
        //         $GetAccountMomo[$i]['times'] = HistoryPlay::where(['phoneSend' => $row->phone, 'status' => 1])->whereDate('created_at', Carbon::today())->count();
        //         $GetAccountMomo[$i]['amount'] = HistoryPlay::where(['phoneSend' => $row->phone, 'status' => 1])->whereDate('created_at', Carbon::today())->sum('receive');
        //         $GetAccountMomo[$i]['amountMonth'] = HistoryPlay::where('phoneSend', $row->phone)->whereMonth('created_at', date('m'))->sum('receive');
        //     }
        //     if ($row->status == 1) {
        //         $GetAccountMomo[$i]['status_text'] = '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success" id="status_' . $row->id . '">Hoạt động</span>';
        //     } else if ($row->status == 2) {
        //         $GetAccountMomo[$i]['status_text'] = '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-danger-light text-danger" id="status_' . $row->id . '">Ẩn</span>';
        //     } else if ($row->status == 0) {
        //         $GetAccountMomo[$i]['status_text'] = '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-danger-light text-danger" id="status_' . $row->id . '">Bảo trì</span>';
        //     } else if ($row->status == 3) {
        //         $GetAccountMomo[$i]['status_text'] = '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-warning-light text-warning" id="status_' . $row->id . '">Đang xác thực</span>';
        //     } else if ($row->status == 4) {
        //         $GetAccountMomo[$i]['status_text'] = '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-warning-light text-warning" id="status_' . $row->id . '">Ngâm</span>';
        //     }
        //     $i++;

        // }
        // return view('dgaAdmin.sendMomo', compact('setting', 'GetAccountMomo')); 
        return view('dgaAdmin.empty', compact('setting'));
    }

    public function sendMomoV2()
    {
        $setting = Setting::first();
        $momo = Momo::get();
        $GetAccountMomo = [];
        $i = 0;
        foreach ($momo as $row) {
            $GetAccountMomo[$i] = $row;
            if ($row->status != 3) {
                $GetAccountMomo[$i]['name'] = json_decode($row->info)->Name;
                $GetAccountMomo[$i]['balance'] = json_decode($row->info)->balance;
                $GetAccountMomo[$i]['times'] = $row->times;
                $GetAccountMomo[$i]['amount'] = $row->amount;
                $GetAccountMomo[$i]['amountMonth'] = $row->amountMonth;
                // $GetAccountMomo[$i]['times'] = HistoryPlay::where(['phoneSend' => $row->phone, 'status' => 1])->whereDate('created_at', Carbon::today())->count();
                // $GetAccountMomo[$i]['amount'] = HistoryPlay::where(['phoneSend' => $row->phone, 'status' => 1])->whereDate('created_at', Carbon::today())->sum('receive');
                // $GetAccountMomo[$i]['amountMonth'] = HistoryPlay::where('phoneSend', $row->phone)->whereMonth('created_at', date('m'))->sum('receive');
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
        return view('dgaAdmin.sendMomo', compact('setting', 'GetAccountMomo'));
    }

    public function cashBack(Request $request)
    {
        $setting = Setting::first();
        $ratio = $setting->ratioHoan;
        $tranId = $request->tranId;
        $data = HistoryPlay::where('tranId', $tranId)->where('status', '!=', 4)->first();
        if (empty($data)) {
            return response()->json(array('status' => false, 'message' => 'Không tồn tại mã giao dịch này hoặc đã được hoàn'));
        } else {

            $token = Momo::where('phone', $data->phoneSend)->first()->token;
            $cmt = 'Hoàn tiền sai hạn mức: ' . $tranId;
            $amount =  $data->amount * $ratio;
            $res = $this->sendMoneyMomo($token, $amount, $cmt, $data->partnerId, $tranId);
            if ($res['status'] != 'success' || empty($res)) { // CHUYỂN TIỀN LỖI

                return response()->json(array('status' => false, 'message' => $res['message']));
            }
            $data->status = 4;
            $data->receive = $amount;
            $data->save();
            return response()->json(array('status' => true, 'message' => 'Đang được xử lý vui lòng đợi', 'token' => $token, 'ratio' => $ratio, 'cmt' => $cmt, 'customer' => $data->partnerId));
        }
    }


    public function listMomo()
    {
        $setting = Setting::first();
        $momo = Momo::get();
        $GetAccountMomo = [];
        $i = 0;
        $countBalance = 0;
        foreach ($momo as $row) {
            $GetAccountMomo[$i] = $row;
            if ($row->status != 3) {
                $info = json_decode($row->info);
                $GetAccountMomo[$i]['name'] = $info->Name;
                $GetAccountMomo[$i]['balance'] = $info->balance;
                $countBalance += $info->balance;
                $GetAccountMomo[$i]['times'] = $row->times;
                $GetAccountMomo[$i]['amount'] = $row->amount;
                $GetAccountMomo[$i]['amountMonth'] = $row->amountMonth;
                $GetAccountMomo[$i]['time_login'] = Carbon::createFromTimestamp($row->time_login)->format('H:m:s d-m-Y');
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
            } else if ($row->status == 5) {
                $GetAccountMomo[$i]['status_text'] = '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-warning-light text-info" id="status_' . $row->id . '">Treo lô đề</span>';
            }
            $i++;
        }
        $countBalance = number_format($countBalance);
        return view('dgaAdmin.listMomo', compact('setting', 'GetAccountMomo', 'countBalance'));
    }

    public function getOTP(Request $request)
    {
        die;
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:11',
            'min' => 'numeric|required',
            'max' => 'numeric|required',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(array('status' => 'error', 'message' => $validator->errors()->first()));
        }
        $device = Device::inRandomOrder()->first();
        $momo = new MomoApi();
        $data = array(
            'phone' => $request->phone,
            'device' => $device->device,
            'hardware' => $device->hardware,
            'facture' => $device->facture,
            'SECUREID' => $momo->get_SECUREID(),
            'MODELID' => $device->MODELID,
            'imei' => $momo->generateImei(),
            'rkey' => $momo->generateRandom(20),
            'AAID' => $momo->generateImei(),
            'TOKEN' => $momo->get_TOKEN(),
            'password' => $request->password,
            'proxy' => $request->proxy
        );
        $result = $momo->SendOTP($data);
        if ($result['status'] == "success") {
            $momo = Momo::where('phone', $request->phone)->first();
            if (!$momo) {
                Momo::create([
                    'token' => Str::random(64),
                    'phone' => $request->phone,
                    'time_login' => time(),
                    'info' => json_encode($data),
                    'min' => $request->min,
                    'max' => $request->max,
                    'status' => 3,
                    'try' => 0
                ]);
                return response()->json(array('status' => 'success', 'message' => 'Gửi mã OTP về ' . $request->phone . ' thành công'));
            } else {
                $momo->status = 3;
                $momo->info = json_encode($data);
                $momo->save();
                return response()->json(array('status' => 'success', 'message' => 'Gửi mã OTP về ' . $request->phone . ' thành công'));
            }
        } else {
            return response()->json(array('status' => 'success', 'message' => 'Lỗi vui lòng thực hiện lại sau'));
        }
    }

    public function verifyMomo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:11',
            'min' => 'numeric|required',
            'max' => 'numeric|required',
            'password' => 'required|string|min:6',
            'otp' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return back()->withErrors(array('status' => 'error', 'message' => $validator->errors()->first()));
        }
        $code = $request->otp;
        $dataMomo = Momo::where('phone', $request->phone)->first();
        $data_old = json_decode($dataMomo->info, true);
        $data = Arr::add($data_old, 'ohash', hash('sha256', $data_old["phone"] . $data_old["rkey"] . $code));
        $momo = new MomoApi();
        $result = $momo->REG_DEVICE_MSG($data);
        if ($result['errorCode'] != 0) {
            return back()->withErrors(['status' => 'error', 'message' => $result]);
        } else if ($result['errorCode'] == 0 || empty($result['errorCode'])) {

            $data_new = Arr::add($data, 'setupKey', $result["extra"]["setupKey"]);
            $data_new = Arr::add($data_new, 'setupKeyDecrypt', $momo->get_setupKey($result["extra"]["setupKey"], $data));

            $dataMomo->info = $data_new;
            $dataMomo->save();

            $result = $this->loginMomo($dataMomo->phone);
            if (isset($result['status']) && $result['status'] == 'success') {

                $dataMomo->status = 4;
                $dataMomo->info = $data_new;
                $dataMomo->save();
                return back()->withErrors(['status' => 'success', 'message' => 'Thêm tài khoản thành công']);
            } else {
                return back()->withErrors(['status' => 'success', 'message' => $result]);
            }
        }
    }

    public function loginMomo($phone)
    {
        $dataMomo = Momo::where('phone', $phone)->first();
        $data_old = json_decode($dataMomo->info, true);
        $data_new = Arr::add($data_old, 'agent_id', '');
        $data_new = Arr::add($data_new, 'sessionkey', '');
        $data_new = Arr::add($data_new, 'authorization', '');
        $momo = new MomoApi();
        $result = $momo->USER_LOGIN_MSG($data_new);
        if ($result['errorCode']) {
            $data_new = Arr::set($data_new, 'Name', $result['errorDesc']);
            $data_new = Arr::set($data_new, 'balance', 0);
            $dataMomo->status = 4;
            $dataMomo->info = $data_new;
            $dataMomo->save();
            return array(
                'author' => 'DUNGA',
                'status' => 'error',
                'message' => 'Thất bại',
                'data' => array(
                    'code' => $result['errorCode'],
                    'desc' => $result['errorDesc']
                )
            );
        } else {
            $bankVerifyPersonalid = isset($result['momoMsg']['bankVerifyPersonalid']) ? $result['momoMsg']['bankVerifyPersonalid'] : "0";
            $data_new = Arr::set($data_old, 'authorization', $result['extra']['AUTH_TOKEN']);
            $data_new = Arr::set($data_new, 'RSA_PUBLIC_KEY', $result['extra']['REQUEST_ENCRYPT_KEY']);
            $data_new = Arr::set($data_new, 'sessionkey', $result['extra']['SESSION_KEY']);
            $data_new = Arr::set($data_new, 'balance', $result['extra']['BALANCE']);
            $data_new = Arr::set($data_new, 'agent_id', $result['momoMsg']['agentId']);
            $data_new = Arr::set($data_new, 'BankVerify', $bankVerifyPersonalid);
            $data_new = Arr::set($data_new, 'Name', $result['momoMsg']['name']);
            $data_new = Arr::set($data_new, 'refreshToken', $result['extra']['REFRESH_TOKEN']);
            $dataMomo->info = $data_new;
            $dataMomo->save();
            return array(
                'status' => 'success',
                'message' => 'Đăng nhập thành công'
            );
        }
    }

    public function historyMomo($token)
    {
        $dataMomo = Momo::where('token', $token)->first();
        $data = json_decode($dataMomo->info, true);
        $momo = new MomoApi();
        $result = $momo->CheckHisNew(1, $data);
        return $result;
    }

    public function historyMomoV2($token)
    {
        $dataMomo = Momo::where('token', $token)->first();
        $data = json_decode($dataMomo->info, true);
        $momo = new MomoApi();
        $from = Carbon::today()->subDay(1)->format('d/m/Y');
        $to = Carbon::today()->format('d/m/Y');
        $limit = 10;
        $result = $momo->QUERY_TRAN_HIS_NEW($data, $from, $to, $limit);
        return $result;
    }

    public function getNewToken($token)
    {
        $dataMomo = Momo::where('token', $token)->first();
        if ($dataMomo->try == 5) {
            $dataMomo->status = 4;
            $dataMomo->save();
            return array('status' => 'error', 'message' => "Lỗi login nhiều lần không được", 'author' => 'DUNGA');
        }
        $data = json_decode($dataMomo->info, true);
        $momo = new MomoApi();
        $result = $momo->REFRESH_TOKEN_MSG($data);
        if ($result['errorCode'] == 0) {
            $data_old = json_decode($dataMomo->info, true);
            $data_new = Arr::set($data_old, 'authorization', $result['momoMsg']['accessToken']);
            // $data_new = Arr::set($data_new, 'RSA_PUBLIC_KEY', $result['extra']['REQUEST_ENCRYPT_KEY']);
            $dataMomo->try = 0;
            $dataMomo->info = $data_new;
            $dataMomo->save();
            return array('status' => 'success', 'message' => 'Thành công', 'author' => 'DUNGA');
        } else {
            $dataMomo->try = $dataMomo->try + 1;
            $dataMomo->save();
            return array('status' => 'error', 'message' => $result['errorDesc'], 'author' => 'DUNGA');
        }
    }

    public function getNewTokenV2($token)
    {
        $dataMomo = Momo::where('token', $token)->first();
        if ($dataMomo->try == 5) {
            $dataMomo->status = 4;
            $dataMomo->save();
            return array('status' => 'error', 'message' => "Lỗi login nhiều lần không được", 'author' => 'DUNGA');
        }
        $data = json_decode($dataMomo->info, true);
        $momo = new MomoApi();
        $result = $momo->USER_LOGIN_MSG($data);
        if ($result['errorCode'] == 0) {
            $data_old = json_decode($dataMomo->info, true);
            $data_new = Arr::set($data_old, 'authorization', $result['extra']['AUTH_TOKEN']);
            $data_new = Arr::set($data_new, 'RSA_PUBLIC_KEY', $result['extra']['REQUEST_ENCRYPT_KEY']);
            $dataMomo->try = 0;
            $dataMomo->info = $data_new;
            $dataMomo->save();
            return array('status' => 'success', 'message' => 'Thành công', 'author' => 'DUNGA');
        } else {
            $dataMomo->try = $dataMomo->try + 1;
            $dataMomo->save();
            return array('status' => 'error', 'message' => $result['errorDesc'], 'author' => 'DUNGA');
        }
    }

    public function checkMomo($phone, $receiver)
    {
        $dataMomo = Momo::where('phone', $phone)->first();
        $data = json_decode($dataMomo->info, true);
        $momo = new MomoApi();
        $result = $momo->CHECK_USER_PRIVATE($receiver, $data);
        if ($result == null) {
            return array('status' => 'error', 'message' => 'Tài khoản không tồn tại hoặc chưa đăng ký momo', 'author' => 'DUNGA');
        }
        if (!empty($result['errorCode'])) {
            return array('status' => 'success', 'message' => 'Thành công', 'author' => 'DUNGA', 'name' => 'Không xác định');
        } else {
            return array('status' => 'success', 'message' => 'Thành công', 'author' => 'DUNGA', 'name' => $result['extra']['NAME']);
        }
    }

    public function sendMoneyMomo($token, $amount, $cmt, $receiver, $tranId = 0)
    {
        $comment = $cmt;
        if ($comment == null) $comment = "";
        $dataMomo = Momo::where('token', $token)->first();
        $phone = $dataMomo->phone;
        if (!$dataMomo) {
            $json = array(
                "status" => "error",
                "code" => 2005,
                "message" => "Số không có trong hệ thống"
            );
            return $json;
        }
        $data = json_decode($dataMomo->info, true);
        $momo = new MomoApi();
        $name = $this->checkMomo($phone, $receiver);
        if ($name['status'] != 'success') {
            $json = array(
                "status" => "error",
                "code" => -5,
                "message" => "Đã xảy ra lỗi ở momo hoặc bạn đã hết hạn truy cập vui lòng đăng nhập lại"
            );
            HistoryBank::create([
                'phone' => $dataMomo->phone,
                'details' => json_encode($json),
                'status' => 0,
                'receiver_phone' => $receiver,
                'amount' => 0,
                'comment' => $comment,
                'tranId' =>  $tranId
            ]);
            return $json;
        } else {
            $partnerName = $name['name'];
        }
        $dataSend = array(
            'comment' => $comment,
            'amount' => $amount,
            'partnerName' => $partnerName,
            'receiver' => $receiver,
        );
        $result = $momo->M2MU_INIT($data, $dataSend);
        if (!empty($result["errorCode"]) && $result["errorDesc"] != "Lỗi cơ sở dữ liệu. Quý khách vui lòng thử lại sau") {
            $json = array(
                "status" => "error",
                "code" => $result["errorCode"],
                "message" => $result["errorDesc"]
            );
            HistoryBank::create([
                'phone' => $dataMomo->phone,
                'details' => json_encode($json),
                'status' => 0,
                'receiver_phone' => $receiver,
                'amount' => 0,
                'comment' => $comment,
                'tranId' =>  $tranId
            ]);
            return $json;
        } else if (is_null($result)) {
            $json = array(
                "status" => "error",
                "code" => -5,
                "message" => "Đã xảy ra lỗi ở momo hoặc bạn đã hết hạn truy cập vui lòng đăng nhập lại"
            );
            HistoryBank::create([
                'phone' => $dataMomo->phone,
                'details' => json_encode($json),
                'status' => 0,
                'receiver_phone' => $receiver,
                'amount' => 0,
                'comment' => $comment,
                'tranId' =>  $tranId
            ]);
            return $result;
        } else {
            $id = $result["momoMsg"]["replyMsgs"]["0"]["ID"];
            $result = $momo->M2MU_CONFIRM($id, $data, $dataSend);
            if (empty($result['errorCode'])) {
                $balance = $result["extra"]["BALANCE"];
                $tranHisMsg = $result["momoMsg"]["replyMsgs"]["0"]["tranHisMsg"];
                $data_new = Arr::set($data, 'balance', $balance);
                $dataMomo->info = $data_new;

                //update count
                $dataMomo->times = $dataMomo->times + 1;
                $dataMomo->amount = $dataMomo->amount + $amount;
                $dataMomo->amountMonth = $dataMomo->amountMonth + $amount;
                if ($dataMomo->amount >= 46000000 || $dataMomo->times >= 190) {
                    $dataMomo->status = 2;
                }

                $dataMomo->save();
                $json = array(
                    'status' => 'success',
                    'message' => 'Thành công',
                    'author' => 'DUNGA',
                    'code' => 0,
                    'data' => array(
                        "balance" => $balance,
                        "ID" => $tranHisMsg["ID"],
                        "tranId" => $tranHisMsg["tranId"],
                        "partnerId" => $tranHisMsg["partnerId"],
                        "partnerName" => $tranHisMsg["partnerName"],
                        "amount" => $tranHisMsg["amount"],
                        "comment" => (empty($tranHisMsg["comment"])) ? "" : $tranHisMsg["comment"],
                        "status" => $tranHisMsg["status"],
                        "desc" => $tranHisMsg["desc"],
                        "ownerNumber" => $tranHisMsg["ownerNumber"],
                        "ownerName" => $tranHisMsg["ownerName"],
                        "millisecond" => $tranHisMsg["finishTime"]
                    )
                );
                HistoryBank::create([
                    'phone' => $dataMomo->phone,
                    'details' => json_encode($json),
                    'status' => 1,
                    'receiver_phone' => $receiver,
                    'amount' => $amount,
                    'comment' => $comment,
                    'tranId' =>  $tranId

                ]);
                return $json;
            } else {
                $json = array(
                    'status' => 'error',
                    'author' => 'DUNGA',
                    "code" => $result["errorCode"],
                    "message" => $result["errorDesc"]
                );
                HistoryBank::create([
                    'phone' => $dataMomo->phone,
                    'details' => json_encode($json),
                    'status' => 0,
                    'receiver_phone' => $receiver,
                    'amount' => 0,
                    'comment' => $comment,
                    'tranId' =>  $tranId
                ]);
                return $json;
            }
        }
        dd($result);
    }

    // public function resetDay()
    // {
    //     try {
    //         //code...
    //         $momos = Momo::get();
    //         foreach ($momos as $row) {
    //             $row->times = 0;
    //             $row->amount = 0;
    //             $row->save();
    //         }
    //         return response()->json(array('status' => 'success', 'message' => 'Reset giao dịch ngày thành công'));
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //         return response()->json(array('status' => 'error', 'message' => 'Reset giao dịch ngày thất bại!'));
    //     }
    // }

    // public function resetMonth()
    // {
    //     try {
    //         //code...
    //         $momos = Momo::get();
    //         foreach ($momos as $row) {
    //             $row->times = 0;
    //             $row->amount = 0;
    //             $row->amountMonth = 0;
    //             $row->save();
    //         }
    //         return response()->json(array('status' => 'success', 'message' => 'Reset giao dịch tháng thành công'));
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //         return response()->json(array('status' => 'error', 'message' => 'Reset giao dịch tháng thất bại!'));
    //     }
    // }

    public function resetDaily(){
        $now = Carbon::now();
        if($now->hour ==0 && ($now->minute == 0 || $now->minute == 1)){
            $this->autoReset();
        }
    }

    public function autoReset()
    {
        try {
            $momos = Momo::get();
            foreach ($momos as $row) {
                $bank_today = HistoryBank::where('phone', $row->phone)->where('status', 1)->whereDate('created_at', Carbon::today());
                $row->times = $bank_today->count();
                $row->amount = $bank_today->sum('amount');
                if (Carbon::today()->day == 1)
                    $row->amountMonth = HistoryBank::where('phone', $row->phone)->where('status', 1)->whereMonth('created_at', date('m'))->sum('amount');

                $row->save();
            }
            return response()->json(array('status' => 'success', 'message' => 'Đếm lại giao dịch thành công'));
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(array('status' => 'error', 'message' => 'Đếm lại giao dịch thất bại!'));
        }
    }

    public function deleteMomo(Request $request)
    {
        $dataMomo = Momo::where('id', $request->phone)->first();
        if ($dataMomo) {
            $dataMomo->delete();
            return response()->json(array('status' => 'success', 'message' => 'Xóa số momo ' . $dataMomo->phone . ' thành công'));
        } else {
            return response()->json(array('status' => 'error', 'message' => 'Số momo không có trong hệ thống'));
        }
    }

    public function soakMomo(Request $request)
    {
        $dataMomo = Momo::where('id', $request->phone)->first();
        if ($dataMomo) {
            $dataMomo->status = 4;
            $dataMomo->save();
            return response()->json(array('status' => 'success', 'message' => 'Chỉnh trạng thái hoạt động số momo ' . $dataMomo->phone . ' thành công'));
        } else {
            return response()->json(array('status' => 'error', 'message' => 'Số momo không có trong hệ thống'));
        }
    }

    public function setLotteriaMomo(Request $request)
    {
        $dataMomo = Momo::where('id', $request->phone)->first();
        if ($dataMomo) {
            $dataMomo->status = 5;
            $dataMomo->save();
            $lotteriaSetting = LotteriaSettings::first();
            $lotteriaSetting->momo_receiver_phone = $dataMomo->phone;
            $lotteriaSetting->save();
            return response()->json(array('status' => 'success', 'message' => 'Treo lô đề số momo ' . $dataMomo->phone . ' thành công'));
        } else {
            return response()->json(array('status' => 'error', 'message' => 'Số momo không có trong hệ thống'));
        }
    }

    public function activeMomo(Request $request)
    {
        $dataMomo = Momo::where('id', $request->phone)->first();
        if ($dataMomo) {
            $dataMomo->status = 1;
            $dataMomo->save();
            return response()->json(array('status' => 'success', 'message' => 'Chỉnh trạng thái hoạt động số momo ' . $dataMomo->phone . ' thành công'));
        } else {
            return response()->json(array('status' => 'error', 'message' => 'Số momo không có trong hệ thống'));
        }
    }

    public function hideMomo(Request $request)
    {
        $dataMomo = Momo::where('id', $request->phone)->first();
        if ($dataMomo) {
            $dataMomo->status = 2;
            $dataMomo->save();
            return response()->json(array('status' => 'success', 'message' => 'Chỉnh trạng thái ẩn số momo ' . $dataMomo->phone . ' thành công'));
        } else {
            return response()->json(array('status' => 'error', 'message' => 'Số momo không có trong hệ thống'));
        }
    }

    public function maintenanceMomo(Request $request)
    {
        $dataMomo = Momo::where('id', $request->phone)->first();
        if ($dataMomo) {
            $dataMomo->status = 0;
            $dataMomo->save();
            return response()->json(array('status' => 'success', 'message' => 'Chỉnh trạng thái bảo trì số momo ' . $dataMomo->phone . ' thành công'));
        } else {
            return response()->json(array('status' => 'error', 'message' => 'Số momo không có trong hệ thống'));
        }
    }

    public function infoMomo(Request $request)
    {
        $dataMomo = Momo::where('id', $request->phone)->first();
        if ($dataMomo) {
            return response()->json([
                'status' => 'success',
                'message' => 'Thành công',
                'html' =>
                '<form action="' .
                    route("admin.editMomo") .
                    '" method="POST" class="form-validate is-alter" novalidate="novalidate"> <div  class="fv-row mb-7 fv-plugins-icon-container"> <input type="text" class="form-control" id="_token" name="_token" value="' .
                    csrf_token() .
                    '" hidden/> <label style="margin-top:10px" class="form-label" for="">Số MOMO</label> <input type="text" class="form-control" id="id" name="id" value="' .
                    $dataMomo->id .
                    '" hidden/> <input type="text" class="form-control" id="phone" name="phone" value="' .
                    $dataMomo->phone .
                    '"/> </div><div style="margin-top:10px" class="fv-row mb-7 fv-plugins-icon-container"> <label class="form-label" for="">Tối thiểu</label> <input type="text" class="form-control" id="min" name="min" value="' .
                    $dataMomo->min .
                    '"/> </div><div style="margin-top:10px" class="fv-row mb-7 fv-plugins-icon-container"> <label class="form-label" for="">Tối đa</label> <input type="text" class="form-control" id="max" name="max" value="' .
                    $dataMomo->max .
                    '"/> </div>
                    <div style="margin-top:10px" class="fv-row mb-7 fv-plugins-icon-container"> <label class="form-label" for="">Thứ tự hiển thị (cao nhất lên trên)</label> <input type="number" class="form-control" id="show_order" name="show_order" value="' .
                    $dataMomo->show_order .
                    '"/> </div>
                    <div style="margin-top:10px" class="fv-row mb-7 fv-plugins-icon-container"> <label class="form-label" for="">Group</label> <input style="margin-bottom:20px" type="text" class="form-control" id="user_group" name="user_group" value="' .
                    $dataMomo->user_group .
                    '"/> </div>
                    <div class="fv-row mb-7 fv-plugins-icon-container"> <div class="form-group"> <button type="submit" class="btn btn-lg btn-primary">Lưu thông tin</button> </div></div>
                    </form>',
            ]);
        } else {
            return response()->json(array('status' => 'error', 'message' => 'Số momo không có trong hệ thống'));
        }
    }

    public function editMomo(Request $request)
    {
        $dataMomo = Momo::where('id', $request->id)->first();
        if ($dataMomo) {
            $data = json_decode($dataMomo->info, true);
            $data_new = Arr::set($data, 'proxy', $request->proxy);
            $dataMomo->info = $data_new;
            $dataMomo->min = $request->min;
            $dataMomo->max = $request->max;
            $dataMomo->show_order = $request->show_order;
            $dataMomo->user_group = $request->user_group;
            $dataMomo->save();
            return back()->withErrors([
                'status' => 'success',
                'message' => 'Sửa thông tin số momo thành công',
            ]);
        } else {
            return back()->withErrors([
                'status' => 'danger',
                'message' => 'Số momo không có trong hệ thống',
            ]);
        }
    }

    public function loginAllMomo()
    {
        $momo = Momo::get();
        foreach ($momo as $row) {
            $dataMomo = Momo::where('id', $row->id)->first();
            if ($dataMomo->status == 3) {
                return response()->json(array('status' => 'error', 'message' => 'Số ' . $row->phone . ' chưa xác thực vui lòng xóa hoặc xác thực'));
            }
            $result = $this->loginMomo($row->phone);
            if ($result['status'] == 'error') {
                return response()->json(array('status' => 'error', 'message' => 'Số ' . $row->phone . ' ' . $result['data']['desc']));
            }
            $dataMomo->try = 0;
            $dataMomo->save();
        }
        return response()->json(array('status' => 'success', 'message' => 'Login lại tất cả thành công'));
    }

    public function checkStatusTransfer()
    {
        $momo = Momo::get();
        foreach ($momo as $row) {
            $dataMomo = Momo::where('id', $row->id)->first();
            if ($dataMomo->status == 3) {
                return response()->json(array('status' => 'error', 'message' => 'Số ' . $row->phone . ' chưa xác thực vui lòng xóa hoặc xác thực'));
            }
            $result = $this->historyMomo($row->token);
            if ($result['status'] == 'error' || $result == null) {
                return response()->json(array('status' => 'error', 'message' => 'Số ' . $row->phone . ' đã bị lỗi'));
            }
        }
        return response()->json(array('status' => 'success', 'message' => 'Trạng thái lịch sử ổn định'));
    }

    public function loginMomoOne(Request $request)
    {
        $dataMomo = Momo::where('id', $request->phone)->first();
        if ($dataMomo) {
            $result = $this->loginMomo($dataMomo->phone);
            if ($result['status'] == 'error') {
                return response()->json(array('status' => 'error', 'message' => 'Số ' . $dataMomo->phone . ' ' . $result['data']['desc']));
            } else {
                $dataMomo->try = 0;
                $dataMomo->save();
                return response()->json(array('status' => 'success', 'message' => 'Đăng nhập lại thành công'));
            }
        } else {
            return response()->json(array('status' => 'error', 'message' => 'Số momo không có trong hệ thống'));
        }
    }

    public function sendMoney(Request $request)
    {
        $phone = $request->phoneSend;
        $dataMomo = Momo::where('phone', $phone)->first();
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:11',
            'phoneSend' => 'required|string|max:11',
            'comment' => '',
            'amount' => 'numeric|required'
        ]);
        if ($validator->fails()) {
            return response()->json(array('status' => 'error', 'message' => $validator->errors()->first()));
        }
        if ($dataMomo) {
            if ($dataMomo->status == 3) {
                return back()->withErrors(['status' => 'danger', 'message' => 'Số momo đang được xác thực']);
            } else {
                $result = $this->sendMoneyMomo($dataMomo->token, $request->amount, $request->comment, $request->phone);
                if ($result['status'] == 'error') {
                    return back()->withErrors(['status' => 'danger', 'message' => $result['message']]);
                } else {
                    return back()->withErrors(['status' => 'success', 'message' => 'Chuyển tiền thành công( 
                    Số tiền: ' . $result['data']['amount'] . ' VNĐ , 
                    Người nhận: ' . $result['data']['partnerName'] . ' , 
                    Lời nhắn: ' . $result['data']['comment'] . ' ,
                    MGD: ' . $result['data']['tranId'] . ' )']);
                }
            }
        } else {
            return back()->withErrors(['status' => 'danger', 'message' => 'Số momo không có trong hệ thống']);
        }
    }

    public function refToken()
    {
        $momo = Momo::where('status', 1)->orWhere('status', 5)->get();
        $data = [];
        $i = 0;
        foreach ($momo as $row) {
            $dataMomo = Momo::where('id', $row->id)->first();
            if ($this->TimeSetup < (time() - $dataMomo->time_login)) {
                $response = $this->getNewToken($dataMomo->token);
                $data[$i]['status'] = $response['status'];
                $data[$i]['phone'] = $dataMomo['phone'];
                $data[$i]['message'] = $response['message'];
                $i++;
                $dataMomo->time_login = time();
                $dataMomo->save();
            } else {
                $data[$i]['status'] = 'success';
                $data[$i]['phone'] = $dataMomo['phone'];
                $data[$i]['message'] = 'Vui lòng đợi ' . ($this->TimeSetup - (time() - $dataMomo->time_login)) . ' giây nữa';
                $i++;
            }
        }
        die(json_encode(array('author' => 'DUNGA', 'data' => $data)));
    }

    public function checkBank($phone, $bankCode, $accountNo)
    {
        $dataMomo = Momo::where('phone', $phone)->first();
        $data = json_decode($dataMomo->info, true);
        $momo = new MomoApi();
        $checkBank = $momo->checkNameBank($bankCode, $accountNo, $data);

        // $sendBank = $momo->SendMoneyBank("970407", "19028995819018",1000, "HienCK" , $data);
        // $data_new = Arr::set($data_new, 'balance', $sendBank['tranDList']['balance']);
        // $dataMomo->info = $data_new;
        // $dataMomo->save();
        // dd($sendBank);
        return $checkBank;
    }

    public function sendBank()
    {
        // $dataMomo = Momo::where('phone', '0333782451')->first();
        // $data = json_decode($dataMomo->info, true);
        // $momo = new MomoApi();
        // $checkBank = $momo->checkNameBank("970407", "19028995819018", $data);

        // $sendBank = $momo->SendMoneyBank("970407", "19028995819018",1000, "HienCK" , $data);
        // $data_new = Arr::set($data_new, 'balance', $sendBank['tranDList']['balance']);
        // $dataMomo->info = $data_new;
        // $dataMomo->save();
        // dd($sendBank);
        $listBank = json_decode(Storage::get("list_bank.json"));
        $bankNapas = $listBank->napasBanks;
        // $gravatar = ($listBank);
        // dd($bankNapas);
        $setting = Setting::first();
        $momo = Momo::get();
        $GetAccountMomo = [];
        $i = 0;
        foreach ($momo as $row) {
            $GetAccountMomo[$i] = $row;
            if ($row->status != 3) {
                $GetAccountMomo[$i]['name'] = json_decode($row->info)->Name;
                $GetAccountMomo[$i]['balance'] = json_decode($row->info)->balance;
                $GetAccountMomo[$i]['times'] = $row->times;
                $GetAccountMomo[$i]['amount'] = $row->amount;
                $GetAccountMomo[$i]['amountMonth'] = $row->amountMonth;
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
        return view('dgaAdmin.sendBank', compact('setting', 'GetAccountMomo', 'bankNapas'));
    }

    public function editHistoryBank(Request $req)
    {
        $history = HistoryBank::where('tranId', $req->tranId)->first();
        $history->receiver_phone = $req->phone;
        $details = json_decode($history->details);
        $details->data->partnerName = $req->name;
        $details->data->partnerId = $req->phone;
        $history->details = json_encode(($details));
        $history->save();
    }

    public function checkStatus(Request $request)
    {
        $setting = Setting::first();
        if ($request->status == 1) {
            $history = HistoryBank::where('comment', '')->whereDate('created_at', Carbon::today()->toDateString())->orderBy('id', 'desc')->get();
        } else if ($request->status == 2) {
            $history = HistoryBank::where('tranId', 0)->whereDate('created_at', Carbon::today()->toDateString())->orderBy('id', 'desc')->get();
        } else if ($request->status == 3) {
            $history = HistoryBank::where('comment', '')->orderBy('id', 'desc')->get();
        } else if ($request->status == 4) {
            $history = HistoryBank::where('tranId', 0)->orderBy('id', 'desc')->get();
        } else if (isset($request->receiver_phone)) {
            $history = HistoryBank::where('receiver_phone', $request->receiver_phone)->orderBy('id', 'desc')->get();
        } else if (isset($request->partnerId)) {
            $history = HistoryPlay::where('partnerId', $request->partnerId)->orderBy('id', 'DESC')->get();
            return view('dgaAdmin.historyAll', compact('setting', 'history'));
        } else {
            return redirect()->back();
        }

        return view('dgaAdmin.historyBank', compact('setting', 'history'));
    }

    public function deleteHistoryBank(Request $req)
    {
        $history = HistoryBank::where('id', $req->id)->first();
        if ($history)
            $history->delete();
    }

    public function deleteHistoryPlay(Request $req)
    {
        $history = HistoryPlay::where('id', $req->id)->first();
        if ($history)
            $history->delete();
    }

    public function editHistoryPlay(Request $req)
    {
        $history = HistoryPlay::where('tranId', $req->tranId)->first();
        $history->comment = $req->comment;
        $history->save();
    }

    public function sendMoneyBank(Request $request)
    {
        $phone = $request->phoneSend;
        $dataMomo = Momo::where('phone', $phone)->first();
        $validator = Validator::make($request->all(), [
            'accountNo' => 'required|string|max:20',
            'bankCode' => 'required|string|max:11',
            'phoneSend' => 'required|string|max:11',
            'comment' => '',
            'amount' => 'numeric|required'
        ]);
        if ($validator->fails()) {
            // return response()->json(array('status' => 'error', 'message' => $validator->errors()->first()));
            return back()->withErrors(['status' => 'danger', 'message' => $validator->errors()->first()]);
        }
        if ($dataMomo) {
            if ($dataMomo->status == 3) {
                return back()->withErrors(['status' => 'danger', 'message' => 'Số momo đang được xác thực']);
            } else {
                // dd($request);
                // $dataMomo = Momo::where('phone', '0333782451')->first();
                $data = json_decode($dataMomo->info, true);
                $momo = new MomoApi();
                // $checkBank = $momo->checkNameBank("970407", "19028995819018", $data);

                $result = $momo->SendMoneyBank($request->bankCode, $request->accountNo, $request->amount, $request->comment, $data);
                // $data_new = Arr::set($data_new, 'balance', $sendBank['tranDList']['balance']);
                // $dataMomo->info = $data_new;
                // $dataMomo->save();
                // dd($result);
                if ($result['status'] == 'error') {
                    return back()->withErrors(['status' => 'danger', 'message' => $result['message']]);
                } else {
                    return back()->withErrors(['status' => 'success', 'message' => 'Chuyển tiền thành công( 
                    Số tiền: ' . $request->amount . ' VNĐ , 
                    Người nhận: ' . $request->accountNo . ' , 
                    Lời nhắn: ' . $request->comment . ')']);
                }
                // $result = $this->sendMoneyMomo($dataMomo->token, $request->amount, $request->comment, $request->phone);
                // if ($result['status'] == 'error') {
                //     return back()->withErrors(['status' => 'danger', 'message' => $result['message']]);
                // } else {
                //     return back()->withErrors(['status' => 'danger', 'message' => 'Chuyển tiền thành công( 
                //     Số tiền: ' . $result['data']['amount'] . ' VNĐ , 
                //     Người nhận: ' . $result['data']['partnerName'] . ' , 
                //     Lời nhắn: ' . $result['data']['comment'] . ' ,
                //     MGD: ' . $result['data']['tranId'] . ' )']);
                // }
            }
        } else {
            return back()->withErrors(['status' => 'danger', 'message' => 'Số momo không có trong hệ thống']);
        }
    }

    public function checkTran()
    {
        $setting = Setting::first();
        $momo = Zalopay::get();
        $GetAccountMomo = [];
        $i = 0;
        foreach ($momo as $row) {
            $GetAccountMomo[$i] = $row;
            if ($row->status != 3) {
                // $GetAccountMomo[$i]['name'] = json_decode($row->info)->Name;
                // $GetAccountMomo[$i]['balance'] = json_decode($row->info)->balance;
                $GetAccountMomo[$i]['times'] = $row->times;
                $GetAccountMomo[$i]['amount'] = $row->amount;
                $GetAccountMomo[$i]['amountMonth'] = $row->amountMonth;
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
        return view('dgaAdmin.checkTran', compact('setting', 'GetAccountMomo'));
    }
}
