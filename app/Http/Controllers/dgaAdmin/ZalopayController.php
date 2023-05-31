<?php

namespace App\Http\Controllers\dgaAdmin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\dgaAdmin\MomoApi;
use App\Http\Controllers\dgaAdmin\ZalopayApi;
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

class ZalopayController extends Controller
{

    private $TimeSetup = 3600;

    public function addZalo()
    {
        $setting = Setting::first();
        $momo = Momo::get();
        $GetAccountMomo = [];
        $i = 0;
        return view('dgaAdmin.addZalopay', compact('setting', 'GetAccountMomo'));
    }

    public function sendZalo()
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

            $token = Zalopay::where('phone', $data->phoneSend)->first()->token;
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


    public function listZalo()
    {
        $setting = Setting::first();
        $zaloPayList = Zalopay::get();
        $GetAccountMomo = [];
        $i = 0;
        $countBalance = 0;
        foreach ($zaloPayList as $row) {
        //     $GetAccountMomo[$i] = $row;
        //     if ($row->status != 3) {
        //         $info = json_decode($row->info);
        //         // $GetAccountMomo[$i]['name'] = $info->display_name;
        //         // $GetAccountMomo[$i]['balance'] = $info->balance;
                $countBalance += $row->balance;
        //         $GetAccountMomo[$i]['times'] = $row->times;
        //         $GetAccountMomo[$i]['amount'] = $row->amount;
        //         $GetAccountMomo[$i]['amountMonth'] = $row->amountMonth;
        //         $GetAccountMomo[$i]['time_login'] = Carbon::createFromTimestamp($row->time)->format('H:m:s d-m-Y');
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
        //     } else if ($row->status == 5) {
        //         $GetAccountMomo[$i]['status_text'] = '<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-warning-light text-info" id="status_' . $row->id . '">Treo lô đề</span>';
        //     }
        //     $i++;
        }
        $countBalance = number_format($countBalance);
        return view('dgaAdmin.listZalopay', compact('setting', 'zaloPayList', 'countBalance'));
    }

    public function getOTPZalo(Request $request)
    {
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
        $zalo = new ZalopayApi();
        $zalo->phone = $request->phone;
        $zalo->password = $request->password;  
        $zalo->deviceid = $zalo->generateImei();  
        $time = time();
        // $zalo->generateImei();
        // $data = array(
        //     'phone' => $request->phone,
        //     'deviceid' => $zalo->generateImei()
        // );
        // $zalo->send_otp_token = $zalo->get_otp_token();
        $zalo->send_otp_token = json_decode($zalo->get_otp_token(),true)['data']['send_otp_token'];  

        $result = $zalo->get_otp();
        // echo "<pre>";
        // print_r($result);die;

        // $result = $momo->SendOTP($data);
        if (isset($result['data']) && $result['data']['verify_otp_token'] != "") {
            $momo = Zalopay::where('phone', $request->phone)->first();
            if (!$momo) {
                Zalopay::create([
                    'phone' => $request->phone,
                    'password' => $zalo->password,
                    'time_login' => $time,
                    'token' => md5($time.mt_rand(10000,99999)),
                    'deviceId' => $zalo->deviceid,
                    'status' => 3,
                    'min' => $request->min,
                    'max' => $request->max,
                    'amount' => 0,
                    'amountMonth' => 0,
                    'show_order' => 0,
                    'try' => 0
                ]);
                return response()->json(array('status' => 'success', 'message' => 'Gửi mã OTP về ' . $request->phone . ' thành công', 'verify_otp_token' => $result['data']['verify_otp_token']));
            } else {
                // $momo->status = 3;
                // $momo->info = json_encode($data);
                // $momo->save();
                return response()->json(array('status' => 'success', 'message' => 'Gửi mã OTP về ' . $request->phone . ' thành công'));
            }
        } else {
            return response()->json(array('status' => 'error', 'message' => $result['error']['details']['localized_message']['message']));
        }
    }

    public function verifyZalopay(Request $request)
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
        // $code = $request->otp;
        $dataMomo = Zalopay::where('phone', $request->phone)->first();
        // // $data_old = json_decode($dataMomo->info, true);
        // // $data = Arr::add($data_old, 'ohash', hash('sha256', $data_old["phone"] . $data_old["rkey"] . $code));
        $zalo = new ZalopayApi();
        $zalo->phone = $request->phone;  
        $zalo->password = $request->password;  
        $zalo->otp = $request->otp;
        $check_otp =  $zalo->xac_thuc_otp();
        if(isset($check_otp['error'])){  
            return back()->withErrors(['status' => 'error', 'message' => '' . $check_otp['error']['details']['localized_message']['message'] . '']);
        }

        $zalo->deviceid = $dataMomo->deviceId;  
        $zalo->public_key = json_decode($zalo->get_public_key(),true)['data']['public_key'];  
        $zalo->salt = json_decode($zalo->get_salt(),true)['data']['salt'];  
        $zalo->token =  $zalo->xac_thuc_otp()['data']['phone_verified_token'];
        $login =  $zalo->ZaloLogin();
        if(isset($login['error'])){  
            return back()->withErrors(['status' => 'error', 'message' => '' . $login['error']['details']['localized_message']['message'] . '']);
        }
        $dataMomo->salt = $zalo->salt;
        $dataMomo->public_key = $zalo->public_key;
        $dataMomo->otp = $zalo->otp;
        $dataMomo->session_id = $login['data']['session_id'];
        $dataMomo->display_name = $login['data']['display_name'];
        $dataMomo->access_token = $login['data']['access_token'];
        $dataMomo->zalo_id = $login['data']['zalo_id'];
        $dataMomo->user_id = $login['data']['user_id'];
        $dataMomo->profile_level = $login['data']['profile_level'];
        $dataMomo->status = 4;
        $dataMomo->save();
        $zalo->config = $dataMomo->toArray();
        $balanceResult = $zalo->getBalance();
        if ($balanceResult['data'] && $balanceResult['data']['balance']) {
            $dataMomo->balance = $balanceResult['data']['balance'];
            $dataMomo->save();
        }
        return back()->withErrors(['status' => 'success', 'message' => 'Thêm tài khoản thành công']);
    }

    public function getBalanceZalopay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(array('status' => 'error', 'message' => $validator->errors()->first()));
        }
        $dataMomo = Zalopay::where('id', $request->id)->first();
        $zalo = new ZalopayApi();
        $zalo->phone = $request->phone;
        $zalo->config = $dataMomo->toArray();

        $result = $zalo->getBalance();
        if ($result['data'] && $result['data']['balance']) {
            $dataMomo->balance = $result['data']['balance'];
            $dataMomo->save();
            return response()->json(array('status' => 'success', 'message' => 'Get số dư thành công'));
            
        }
        return response()->json(array('status' => 'error', 'message' => 'Get số dư không thành công'));
    }

    public function loginMomo($phone)
    {
        $dataMomo = Zalopay::where('phone', $phone)->first();
        // $data_old = json_decode($dataMomo->info, true);
        // $data_new = Arr::add($data_old, 'agent_id', '');
        // $data_new = Arr::add($data_new, 'sessionkey', '');
        // $data_new = Arr::add($data_new, 'authorization', '');
        $zalo = new ZalopayApi();
        $zalo->phone = $dataMomo->phone;
        $zalo->password = $dataMomo->password;
        $zalo->config = $dataMomo->toArray();
        $zalo->deviceid = $dataMomo->deviceId;  
        $zalo->public_key = json_decode($zalo->get_public_key(),true)['data']['public_key'];  
        $zalo->salt = json_decode($zalo->get_salt(),true)['data']['salt'];  
        // $zalo->token =  $zalo->xac_thuc_otp()['data']['phone_verified_token'];
        $result = $zalo->ZaloLogin();
        // echo "<pre>";
        // print_r($zalo->xac_thuc_otp());

        // print_r($result);
        // echo "</pre>";
        // $result = $momo->USER_LOGIN_MSG($data_new);
        if (isset($result['error'])) {
            // $data_new = Arr::set($data_new, 'Name', $result['errorDesc']);
            // $data_new = Arr::set($data_new, 'balance', 0);
            $dataMomo->display_name = $result['error']['details']['localized_message']['message'];
            $dataMomo->status = 4;
            // $dataMomo->info = $data_new;
            $dataMomo->save();
            return array(
                'author' => 'DUNGA',
                'status' => 'error',
                'message' => 'Thất bại',
                'data' => array(
                    'code' => $result['error']['code'],
                    'desc' => $result['error']['details']['localized_message']['message']
                )
            );
        } else {
            
            $dataMomo->display_name = $result['data']['display_name'];
            $dataMomo->access_token = $result['data']['access_token'];
            $dataMomo->session_id = $result['data']['session_id'];
            $dataMomo->time_login = time();
            $dataMomo->save();
            $zalo->config = $dataMomo->toArray();
            $getBalance = $zalo->getBalance();
            
            if ($getBalance['data'] && $getBalance['data']['balance']) {
                $dataMomo->balance = $getBalance['data']['balance'];
                $dataMomo->save();
            }
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

    public function historyZaloPay($token)
    {
        // echo $token;die;
        $dataMomo = Zalopay::where('token', $token)->first();
        // $data = json_decode($dataMomo->info, true);
        $zalo = new ZalopayApi();
        $zalo->config = $dataMomo->toArray();
        $result = $zalo->checkHistory($dataMomo->access_token);
        // dd('123');
        // dd($result);
        // $from = Carbon::today()->subDay(1)->format('d/m/Y');
        // $to = Carbon::today()->format('d/m/Y');
        // $limit = 10;
        // $result = $momo->QUERY_TRAN_HIS_NEW($data, $from, $to, $limit);
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
        $dataMomo = Zalopay::where('phone', $phone)->first();
        $data = json_decode($dataMomo->info, true);
        $momo = new ZalopayApi();
        $momo->config = $dataMomo->toArray();

        // if (preg_match('/^[0-9]{10}+$/', $receiver)) {
        //     dd("123123");
        // } else {
        //     dd('0000');
        // }
        $result = $momo->get_info($receiver);
        // dd($result);
        // echo "<pre>";
        // print_r($result);die;
        // if ($result == null) {
        //     return array('status' => 'error', 'message' => 'Tài khoản không tồn tại hoặc chưa đăng ký Zalopay', 'author' => 'DUNGA');
        // }
        if (isset($result['islocked']) && $result['islocked'] == true) {
            return array('status' => 'error', 'message' => "Tài khoản người nhận bị khóa!", 'author' => 'DUNGA', 'name' =>'');
        }
        if (isset($result['displayname'])) {
            return array('status' => 'success', 'message' => 'Thành công', 'author' => 'DUNGA', 'name' => $result['displayname'], 'userid' => isset($result['userid']) ? $result['userid'] : $receiver);
            
        } else {
            return array('status' => 'error', 'message' => $result['returnmessage'], 'author' => 'DUNGA', 'name' =>'');
        }
    }

    public function sendMoneyMomo($token, $amount, $cmt, $receiver, $tranId = 0)
    {
        $comment = $cmt;
        if ($comment == null) $comment = "";
        $dataMomo = Zalopay::where('token', $token)->first();
        $phone = $dataMomo->phone;
        if (!$dataMomo) {
            $json = array(
                "status" => "error",
                "code" => 2005,
                "message" => "Số không có trong hệ thống"
            );
            return $json;
        }
        $zaloPay = new ZalopayApi();
        $zaloPay->phone = $dataMomo->phone;
        $zaloPay->password = $dataMomo->password;
        $zaloPay->config = $dataMomo->toArray(); 
        $checkBalance = $zaloPay->getBalance(); 
        $balance = $checkBalance['data']['balance'];

        if($balance < $amount) 
        {
            $json = array(
                "status" => "error",
                "code" => -5,
                "message" => "Tài khoản không đủ tiền"
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
            // dd($zaloPay->config);
            // $result = $zaloPay->giaodich3($receiver,$amount,$comment); 
            $result = $zaloPay->payMent($receiver,$amount,$comment); 
            // dd($result);
            if(!empty($result['data']['order_token'])){ 
                // sleep(3); 
                $res1 = ($zaloPay->GET_TRANS_BY_TID($result['data']['zp_trans_id'],$dataMomo->access_token)); 
                $res = json_decode($res1, true);
                // dd($res, $result);
                // exit(json_encode(array( 
                //     "status" => "200",  
                //     "msg" => "Chuyển tiền thành công",  
                //     "trans_id" => $res['data']['transaction']['trans_id'], 
                //     "description" => $res['data']['transaction']['description'], 
                //     "trans_amount" => $res['data']['transaction']['trans_amount'], 
                //     "partnerId" => $phone, 
                //     "partnerName" => $res['data']['transaction']['template_info']['custom_fields'][0]['value'], 
                //     "trans_time" => trim(str_replace(['Z','T'],' ',$res['data']['transaction']['trans_time'])), 
                // ), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)); 
                if (isset($res['data']) && $res['data']['transaction']['status_info']['status'] == 1) {
                    //update count
                    $dataMomo->balance = $res['data']['transaction']['balance_snapshot'];
                    $dataMomo->times = $dataMomo->times + 1;
                    $dataMomo->amount = $dataMomo->amount + $amount;
                    $dataMomo->amountMonth = $dataMomo->amountMonth + $amount;
                    if ($dataMomo->amount >= 46000000) {
                        $dataMomo->status = 2;
                    }

                    $dataMomo->save();

                    $json = array(
                        'status' => 'success',
                        'message' => 'Thành công',
                        'author' => 'DUNGA',
                        'code' => 0,
                        'data' => array(
                            "balance" => $res['data']['transaction']['balance_snapshot'],
                            "ID" => $res['data']['transaction']['trans_id'],
                            "tranId" => $res['data']['transaction']['trans_id'],
                            "partnerId" => $receiver,
                            "partnerName" => $res['data']['transaction']['template_info']['custom_fields'][0]['value'],
                            "amount" => $res['data']['transaction']['trans_amount'],
                            "comment" => $res['data']['transaction']['description'],
                            "status" => 1,
                            "desc" => $res['data']['transaction']['description'],
                            "ownerNumber" => $dataMomo->display_name,
                            "ownerName" => $dataMomo->phone,
                            "millisecond" => $res['data']['transaction']['trans_time']
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
                } else {

                    $json = array(
                        "status" => "error",
                        "code" => -5,
                        "message" => $res['error']['details']['localized_message']['message']
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

                
                return $json;
            } else {
                $json = array(
                    "status" => "error",
                    "code" => -5,
                    "message" => $result['error']['details']['localized_message']['message']
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
        // $data = json_decode($dataMomo->info, true);
        // $momo = new MomoApi();
        // $name = $this->checkMomo($phone, $receiver);
        // if ($name['status'] != 'success') {
        //     $json = array(
        //         "status" => "error",
        //         "code" => -5,
        //         "message" => "Đã xảy ra lỗi ở momo hoặc bạn đã hết hạn truy cập vui lòng đăng nhập lại"
        //     );
        //     HistoryBank::create([
        //         'phone' => $dataMomo->phone,
        //         'details' => json_encode($json),
        //         'status' => 0,
        //         'receiver_phone' => $receiver,
        //         'amount' => 0,
        //         'comment' => $comment,
        //         'tranId' =>  $tranId
        //     ]);
        //     return $json;
        // } else {
        //     $partnerName = $name['name'];
        // }
        // $dataSend = array(
        //     'comment' => $comment,
        //     'amount' => $amount,
        //     'partnerName' => $partnerName,
        //     'receiver' => $receiver,
        // );
        // $result = $momo->M2MU_INIT($data, $dataSend);
        // if (!empty($result["errorCode"]) && $result["errorDesc"] != "Lỗi cơ sở dữ liệu. Quý khách vui lòng thử lại sau") {
        //     $json = array(
        //         "status" => "error",
        //         "code" => $result["errorCode"],
        //         "message" => $result["errorDesc"]
        //     );
        //     HistoryBank::create([
        //         'phone' => $dataMomo->phone,
        //         'details' => json_encode($json),
        //         'status' => 0,
        //         'receiver_phone' => $receiver,
        //         'amount' => 0,
        //         'comment' => $comment,
        //         'tranId' =>  $tranId
        //     ]);
        //     return $json;
        // } else if (is_null($result)) {
        //     $json = array(
        //         "status" => "error",
        //         "code" => -5,
        //         "message" => "Đã xảy ra lỗi ở momo hoặc bạn đã hết hạn truy cập vui lòng đăng nhập lại"
        //     );
        //     HistoryBank::create([
        //         'phone' => $dataMomo->phone,
        //         'details' => json_encode($json),
        //         'status' => 0,
        //         'receiver_phone' => $receiver,
        //         'amount' => 0,
        //         'comment' => $comment,
        //         'tranId' =>  $tranId
        //     ]);
        //     return $result;
        // } else {
        //     $id = $result["momoMsg"]["replyMsgs"]["0"]["ID"];
        //     $result = $momo->M2MU_CONFIRM($id, $data, $dataSend);
        //     if (empty($result['errorCode'])) {
        //         $balance = $result["extra"]["BALANCE"];
        //         $tranHisMsg = $result["momoMsg"]["replyMsgs"]["0"]["tranHisMsg"];
        //         $data_new = Arr::set($data, 'balance', $balance);
        //         $dataMomo->info = $data_new;

        //         //update count
        //         $dataMomo->times = $dataMomo->times + 1;
        //         $dataMomo->amount = $dataMomo->amount + $amount;
        //         $dataMomo->amountMonth = $dataMomo->amountMonth + $amount;
        //         if ($dataMomo->amount >= 46000000 || $dataMomo->times >= 190) {
        //             $dataMomo->status = 2;
        //         }

        //         $dataMomo->save();
        //         $json = array(
        //             'status' => 'success',
        //             'message' => 'Thành công',
        //             'author' => 'DUNGA',
        //             'code' => 0,
        //             'data' => array(
        //                 "balance" => $balance,
        //                 "ID" => $tranHisMsg["ID"],
        //                 "tranId" => $tranHisMsg["tranId"],
        //                 "partnerId" => $tranHisMsg["partnerId"],
        //                 "partnerName" => $tranHisMsg["partnerName"],
        //                 "amount" => $tranHisMsg["amount"],
        //                 "comment" => (empty($tranHisMsg["comment"])) ? "" : $tranHisMsg["comment"],
        //                 "status" => $tranHisMsg["status"],
        //                 "desc" => $tranHisMsg["desc"],
        //                 "ownerNumber" => $tranHisMsg["ownerNumber"],
        //                 "ownerName" => $tranHisMsg["ownerName"],
        //                 "millisecond" => $tranHisMsg["finishTime"]
        //             )
        //         );
        //         HistoryBank::create([
        //             'phone' => $dataMomo->phone,
        //             'details' => json_encode($json),
        //             'status' => 1,
        //             'receiver_phone' => $receiver,
        //             'amount' => $amount,
        //             'comment' => $comment,
        //             'tranId' =>  $tranId

        //         ]);
        //         return $json;
        //     } else {
        //         $json = array(
        //             'status' => 'error',
        //             'author' => 'DUNGA',
        //             "code" => $result["errorCode"],
        //             "message" => $result["errorDesc"]
        //         );
        //         HistoryBank::create([
        //             'phone' => $dataMomo->phone,
        //             'details' => json_encode($json),
        //             'status' => 0,
        //             'receiver_phone' => $receiver,
        //             'amount' => 0,
        //             'comment' => $comment,
        //             'tranId' =>  $tranId
        //         ]);
        //         return $json;
        //     }
        // }
        // dd($result);
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
            $momos = Zalopay::get();
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

    public function deleteZlp(Request $request)
    {
        $dataMomo = Zalopay::where('id', $request->phone)->first();
        if ($dataMomo) {
            $dataMomo->delete();
            return response()->json(array('status' => 'success', 'message' => 'Xóa số zalopay ' . $dataMomo->phone . ' thành công'));
        } else {
            return response()->json(array('status' => 'error', 'message' => 'Số zalopay không có trong hệ thống'));
        }
    }

    public function soakZlp(Request $request)
    {
        $dataMomo = Zalopay::where('id', $request->phone)->first();
        if ($dataMomo) {
            $dataMomo->status = 4;
            $dataMomo->save();
            return response()->json(array('status' => 'success', 'message' => 'Chỉnh trạng thái hoạt động số zalopay ' . $dataMomo->phone . ' thành công'));
        } else {
            return response()->json(array('status' => 'error', 'message' => 'Số zalopay không có trong hệ thống'));
        }
    }

    public function activeZlp(Request $request)
    {
        $dataMomo = Zalopay::where('id', $request->phone)->first();
        if ($dataMomo) {
            $dataMomo->status = 1;
            $dataMomo->save();
            return response()->json(array('status' => 'success', 'message' => 'Chỉnh trạng thái hoạt động số zalopay ' . $dataMomo->phone . ' thành công'));
        } else {
            return response()->json(array('status' => 'error', 'message' => 'Số zalopay không có trong hệ thống'));
        }
    }

    public function hideZlp(Request $request)
    {
        $dataMomo = Zalopay::where('id', $request->phone)->first();
        if ($dataMomo) {
            $dataMomo->status = 2;
            $dataMomo->save();
            return response()->json(array('status' => 'success', 'message' => 'Chỉnh trạng thái ẩn số zalopay ' . $dataMomo->phone . ' thành công'));
        } else {
            return response()->json(array('status' => 'error', 'message' => 'Số zalopay không có trong hệ thống'));
        }
    }

    public function maintenanceZlp(Request $request)
    {
        $dataMomo = Zalopay::where('id', $request->phone)->first();
        if ($dataMomo) {
            $dataMomo->status = 0;
            $dataMomo->save();
            return response()->json(array('status' => 'success', 'message' => 'Chỉnh trạng thái bảo trì số zalopay ' . $dataMomo->phone . ' thành công'));
        } else {
            return response()->json(array('status' => 'error', 'message' => 'Số zalopay không có trong hệ thống'));
        }
    }

    public function infoZlp(Request $request)
    {
        $dataMomo = Zalopay::where('id', $request->phone)->first();
        if ($dataMomo) {
            return response()->json([
                'status' => 'success',
                'message' => 'Thành công',
                'html' =>
                '<form action="' .
                    route("admin.editZlp") .
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
            return response()->json(array('status' => 'error', 'message' => 'Số zalopay không có trong hệ thống'));
        }
    }

    public function editZlp(Request $request)
    {
        $dataMomo = Zalopay::where('id', $request->id)->first();
        if ($dataMomo) {
            // $data = json_decode($dataMomo->info, true);
            // $data_new = Arr::set($data, 'proxy', $request->proxy);
            // $dataMomo->info = $data_new;
            $dataMomo->min = $request->min;
            $dataMomo->max = $request->max;
            $dataMomo->show_order = $request->show_order;
            $dataMomo->save();
            return back()->withErrors([
                'status' => 'success',
                'message' => 'Sửa thông tin số zalopay thành công',
            ]);
        } else {
            return back()->withErrors([
                'status' => 'danger',
                'message' => 'Số zalopay không có trong hệ thống',
            ]);
        }
    }

    public function loginAllZlp()
    {
        $momo = Zalopay::get();
        foreach ($momo as $row) {
            $dataMomo = Zalopay::where('id', $row->id)->first();
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
        $momo = Zalopay::get();
        foreach ($momo as $row) {
            $dataMomo = Zalopay::where('id', $row->id)->first();
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

    public function loginZalopayOne(Request $request)
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
            return response()->json(array('status' => 'error', 'message' => 'Số zalopay không có trong hệ thống'));
        }
    }

    public function sendMoney(Request $request)
    {
        $phone = $request->phoneSend;
        $dataMomo = Zalopay::where('phone', $phone)->first();
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:20',
            'phoneSend' => 'required|string|max:10',
            'zalopay_id' => 'required|string|max:50',
            'comment' => '',
            'amount' => 'numeric|required'
        ]);
        // dd($request->all());
        if ($validator->fails()) {
            return back()->withErrors(array('status' => 'error', 'message' => $validator->errors()->first()));
        }
        if ($dataMomo) {
            if ($dataMomo->status == 3) {
                return back()->withErrors(['status' => 'danger', 'message' => 'Số zalopay đang được xác thực']);
            } else {
                $result = $this->sendMoneyMomo($dataMomo->token, $request->amount, $request->comment, $request->zalopay_id);
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
            return back()->withErrors(['status' => 'danger', 'message' => 'Số zalopay không có trong hệ thống']);
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
                return back()->withErrors(['status' => 'danger', 'message' => 'Số zalopay đang được xác thực']);
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
            return back()->withErrors(['status' => 'danger', 'message' => 'Số zalopay không có trong hệ thống']);
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
