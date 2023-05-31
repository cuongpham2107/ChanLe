<?php

namespace App\Http\Controllers\dgaAdmin;

use App\Http\Controllers\Controller;
use App\Models\BlackList;
use Illuminate\Http\Request;
use App\Models\Momo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\HistoryPlay;
use App\Models\Setting;
use Illuminate\Support\Str;
use App\Models\HistoryDayMission;
use Carbon\Carbon;
use App\Models\Muster;
use App\Models\HistoryHu;
use App\Models\LotteriaSettings;
use App\Models\User;
use App\Models\Zalopay;
use Illuminate\Support\Facades\Validator;

class MiniGame extends Controller
{

    private $threeSame = ['000', '111', '222', '333', '444', '555', '666', '777', '888', '999'];
    private $fourSame = ['0000', '1111', '2222', '3333', '4444', '5555', '6666', '7777', '8888', '9999'];
    private $fiveSame = ['00000', '11111', '22222', '33333', '44444', '55555', '66666', '77777', '88888', '99999'];
    private $threeLobby = ['123', '234', '345', '456', '567', '678', '789'];
    private $fourLobby = ['1234', '2345', '3456', '4567', '5678', '6789'];
    private $fiveLobby = ['12345', '23456', '34567', '45678', '56789'];

    public function logicMinigame($tranId, $comment, $game)
    {
        $setting = Setting::first();
        if ($game == 'CL') {
            $number = substr((string)$tranId, -1);
            if ($number == 0 || $number == 9) {
                $rs = 3; // THUA
            } else {
                if ($number == 2 || $number == 4 || $number == 6 || $number == 8) {
                    $rs = explode('|', $setting->contentCL)[0]; // CHẴN
                } else {
                    $rs = explode('|', $setting->contentCL)[1]; // LẺ
                }
            }

            if ($rs == $comment) {
                return true;
            } else {
                return false;
            }
        } else if ($game == 'CL2') {
            $number = substr((string)$tranId, -1);
            if ($number == 0 || $number == 2 || $number == 4 || $number == 6 || $number == 8) {
                $rs = explode('|', $setting->contentCL2)[0]; // CHẴN 2
            } else {
                $rs = explode('|', $setting->contentCL2)[1]; // LẺ 2
            }

            if ($rs == $comment) {
                return true;
            } else {
                return false;
            }
        } else if ($game == 'TX') {
            $number = substr((string)$tranId, -1);
            if ($number == 0 || $number == 9) {
                $rs = 3; // THUA
            } else {
                if ($number >= 5) {
                    $rs = explode('|', $setting->contentTX)[0]; // TÀI
                } else {
                    $rs = explode('|', $setting->contentTX)[1]; // XỈU
                }
            }

            if ($rs == $comment) {
                return true;
            } else {
                return false;
            }
        } else if ($game == 'TX2') {
            $number = substr((string)$tranId, -1);

            if ($number >= 5) {
                $rs = explode('|', $setting->contentTX2)[0]; // TÀI
            } else {
                $rs = explode('|', $setting->contentTX2)[1]; // XỈU
            }

            if ($rs == $comment) {
                return true;
            } else {
                return false;
            }
        } else if ($game == '1P3') {
            $number = substr((string)$tranId, -1);
            if ($number == '0') {
                $rs = explode('|', $setting->content1P3)[0]; // N0
            } else if ($number == '1' || $number == '2' || $number == '3') {
                $rs = explode('|', $setting->content1P3)[1]; // N1
            } else if ($number == '4' || $number == '5' || $number == '6') {
                $rs = explode('|', $setting->content1P3)[2]; // N2
            } else if ($number == '7' || $number == '8' || $number == '9') {
                $rs = explode('|', $setting->content1P3)[3]; // N3
            } else {
                $rs = "COCAINIT";
            }
            if ($rs == $comment) {
                return true;
            } else {
                return false;
            }
        } else if ($game == 'LO') {
            $number = substr((string)$tranId, -2);
            if ($number == 01 || $number == 03 || $number == 12 || $number == 19 || $number == 23 || $number == 24 || $number == 30 || $number == 33 || $number == 39 || $number == 48 || $number == 54 || $number == 55 || $number == 60 || $number == 61 || $number == 71 || $number == 77 || $number == 81 || $number == 82 || $number == 83 || $number == 67 || $number == 88 || $number == 76 || $number == 64 || $number == 79 || $number == 29 || $number == 99) {
                $rs = $setting->contentLO; // LO
            } else {
                $rs = "COCAINIT";
            }
            if ($rs == $comment) {
                return true;
            } else {
                return false;
            }
        } else if ($game == 'H3') {
            $number1 = substr((string)$tranId, -1);
            $number2 = substr((string)$tranId, -2, 1);
            $number = $number2 - $number1;
            if ($number == 9 || $number == 7 || $number == 5 || $number == 3) {
                $rs = $setting->contentH3; // H3
            } else {
                $rs = "COCAINIT";
            }
            if ($rs == $comment) {
                return true;
            } else {
                return false;
            }
        } else if ($game == 'G3') {
            $number1 = substr((string)$tranId, -2);
            $number2 = substr((string)$tranId, -3);
            if ($number1 == 02 || $number1 == 13 || $number1 == 17 || $number1 == 19 || $number1 == 21 || $number1 == 29 || $number1 == 35 || $number1 == 37 || $number1 == 47 || $number1 == 49 || $number1 == 51 || $number1 == 54 || $number1 == 57 || $number1 == 63 || $number1 == 64 || $number1 == 74 || $number1 == 83 || $number1 == 91 || $number1 == 95 || $number1 == 96) {
                $rs = $setting->contentG3; // G3
            } else if ($number1 == 66 || $number1 == 99) {
                $rs = $setting->contentG3; // G3
            } else if ($number2 == 123 || $number2 == 234 || $number2 == 456 || $number2 == 678 || $number2 == 789) {
                $rs = $setting->contentG3; // G3
            } else {
                $rs = "COCAINIT";
            }
            if ($rs == $comment) {
                return true;
            } else {
                return false;
            }
        } else if ($game == 'XSMB') {
            $number1 = substr((string)$tranId, -2);
            $number2 = substr((string)$tranId, -3);
            if ($number1 == 04 || $number1 == 92 || $number1 == 74  || $number1 == 15 || $number1 == 98 ||  $number1 == 59 || $number1 == 54 || $number1 == 03 || $number1 == 87 || $number1 == 22 || $number1 == 45 || $number1 == 80 || $number1 == 52 || $number1 == 70 || $number1 == 46 || $number1 == 33 || $number1 == 95 || $number1 == 20) {
                $rs = $setting->contentXSMB;
            } else if ($number1 == '08' || $number1 == 79 || $number1 == 83 || $number1 == 64) {
                $rs = $setting->contentXSMB;
            } else if ($number2 == 828 || $number2 == 549 || $number2 == 323 || $number2 == 355) {
                $rs = $setting->contentXSMB;
            } else {
                $rs = "COCAINIT";
            }
            if ($rs == $comment) {
                return true;
            } else {
                return false;
            }
        } else if ($game == 'XIEN') {
            $number = substr((string)$tranId, -1);
            if ($number == 0 || $number == 2 || $number == 4) {
                $rs = explode('|', $setting->contentXien)[0];
            } else if ($number == 5 || $number == 7 || $number == 9) {
                $rs = explode('|', $setting->contentXien)[1];
            } else if ($number == 6 || $number == 8) {
                $rs = explode('|', $setting->contentXien)[2];
            } else if ($number == 1 || $number == 3) {
                $rs = explode('|', $setting->contentXien)[3];
            } else {
                $rs = "COCAINIT";
            }
            if ($rs == $comment) {
                return true;
            } else {
                return false;
            }
        } else if ($game == 'DOAN') {
            $number = substr((string)$tranId, -1);
            $predicted_number = substr($comment, -1);
            if ($number == $predicted_number) return true;
            return false;
        }
    }

    public function xuLyHu($tranId, $partnerId)
    {
        $setting = Setting::first();


        if ($setting->amount5Same > 0 && in_array(substr((string)$tranId, -5), $this->fiveSame)) {
            HistoryHu::create([
                'tranId' => $tranId,
                'phone' => $partnerId,
                'status' => 0,
                'amount' => $setting->amount5Same,
                'type' => '5same'
            ]);
        } else if ($setting->amount4Same > 0 && in_array(substr((string)$tranId, -4), $this->fourSame)) {
            HistoryHu::create([
                'tranId' => $tranId,
                'phone' => $partnerId,
                'status' => 0,
                'amount' => $setting->amount4Same,
                'type' => '4same'
            ]);
        } else if ($setting->amount3Same > 0 && in_array(substr((string)$tranId, -3), $this->threeSame)) {
            HistoryHu::create([
                'tranId' => $tranId,
                'phone' => $partnerId,
                'status' => 0,
                'amount' => $setting->amount3Same,
                'type' => '3same'
            ]);
        }
        if ($setting->amount5Lobby > 0 && in_array(substr((string)$tranId, -5), $this->fiveLobby)) {
            HistoryHu::create([
                'tranId' => $tranId,
                'phone' => $partnerId,
                'status' => 0,
                'amount' => $setting->amount5Lobby,
                'type' => '5lobby'
            ]);
        } else if ($setting->amount4Lobby > 0 && in_array(substr((string)$tranId, -4), $this->fourLobby)) {
            HistoryHu::create([
                'tranId' => $tranId,
                'phone' => $partnerId,
                'status' => 0,
                'amount' => $setting->amount4Lobby,
                'type' => '4lobby'
            ]);
        } else if ($setting->amount3Lobby > 0 && in_array(substr((string)$tranId, -3), $this->threeLobby)) {
            HistoryHu::create([
                'tranId' => $tranId,
                'phone' => $partnerId,
                'status' => 0,
                'amount' => $setting->amount3Lobby,
                'type' => '3lobby'
            ]);
        }
    }

    public function XuLiMiniGameV2()
    {
        (new ZalopayController())->resetDaily();
        $dunga = Zalopay::where('status', 1)->orWhere('status', 2)->inRandomOrder()->get();
        $setting = Setting::first();
        $i = 0;
        // foreach ($dunga as $row) {
        //     if ($row) {
        //         $url = route('admin.historyZaloPay', ['token' => $row->token]);
        //         print_r($url);
        //     }
        // }
        // die;
        foreach ($dunga as $row) {
            if ($row) {
                $url = route('admin.historyZaloPay', ['token' => $row->token]);
                // dd($url);
                $response = Http::get($url)->json();

                // dd($response, $url);
                if (!empty($response['data'])) {
                    foreach ($response['data'] as $data) {
                        $comment = $data['comment'];
                        $amount = $data['amount'];
                        $partnerId = $data['patnerID'];
                        $partnerName = $data['partnerName'];
                        $tranId = (string)$data['tranId'];
                        $history = HistoryPlay::where('tranId', $tranId)->first();

                        // Khong detect duoc sdt
                        // if (strlen($partnerId) != 10) {
                        //     continue;
                        // }

                        // // Validate is phone number
                        // if(!preg_match('/^[0-9]{10}+$/', $partnerId)) {
                        //     continue;
                        // }

                        if (!$history) {
                            if ($setting->hu == 1 && $amount >= 10000) {
                                $this->xuLyHu($tranId, $partnerId);
                            }
                            if (Str::upper($comment) == explode('|', $setting->contentCL)[0] || Str::upper($comment) == explode('|', $setting->contentCL)[1]) { // MINIGAME CHẴN LẺ
                                $game = 'CL';
                                if ($amount >= $row->min && $amount <= $row->max) {
                                    if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                        $receive = $amount * $setting->ratioCL; // TIỀN NHẬN KHI THẮN
                                        $status = 1; // THẮNG
                                        $pay = 0; // CHƯA CHUYỂN
                                    } else {
                                        $receive = 0;
                                        $status = 0; // THUA
                                        $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                    }
                                } else {
                                    $receive = 0; // THUA
                                    $status = 3; // GIỚI HẠN
                                    $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                }
                            } else if (Str::upper($comment) == explode('|', $setting->contentCL2)[0] || Str::upper($comment) == explode('|', $setting->contentCL2)[1]) { // MINIGAME CHẴN LẺ 2
                                $game = 'CL2';
                                if ($amount >= $row->min && $amount <= $row->max) {
                                    if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                        $receive = $amount * $setting->ratioCL2; // TIỀN NHẬN KHI THẮN
                                        $status = 1; // THẮNG
                                        $pay = 0; // CHƯA CHUYỂN
                                    } else {
                                        $receive = 0;
                                        $status = 0; // THUA
                                        $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                    }
                                } else {
                                    $receive = 0; // THUA
                                    $status = 3; // GIỚI HẠN
                                    $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                }
                            } else if (Str::upper($comment) == explode('|', $setting->contentTX)[0] || Str::upper($comment) == explode('|', $setting->contentTX)[1]) { // MINIGAME TÀI XỈU
                                $game = 'TX';
                                if ($amount >= $row->min && $amount <= $row->max) {
                                    if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                        $receive = $amount * $setting->ratioTX; // TIỀN NHẬN KHI THẮN
                                        $status = 1; // THẮNG
                                        $pay = 0; // CHƯA CHUYỂN
                                    } else {
                                        $receive = 0;
                                        $status = 0; // THUA
                                        $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                    }
                                } else {
                                    $receive = 0; // THUA
                                    $status = 3; // GIỚI HẠN
                                    $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                }
                            } else if (Str::upper($comment) == explode('|', $setting->contentTX2)[0] || Str::upper($comment) == explode('|', $setting->contentTX2)[1]) { // MINIGAME TÀI XỈU 2
                                $game = 'TX2';
                                if ($amount >= $row->min && $amount <= $row->max) {
                                    if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                        $receive = $amount * $setting->ratioTX2; // TIỀN NHẬN KHI THẮN
                                        $status = 1; // THẮNG
                                        $pay = 0; // CHƯA CHUYỂN
                                    } else {
                                        $receive = 0;
                                        $status = 0; // THUA
                                        $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                    }
                                } else {
                                    $receive = 0; // THUA
                                    $status = 3; // GIỚI HẠN
                                    $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                }
                            } else if (Str::upper($comment) == explode('|', $setting->content1P3)[0] || Str::upper($comment) == explode('|', $setting->content1P3)[1] || Str::upper($comment) == explode('|', $setting->content1P3)[2] || Str::upper($comment) == explode('|', $setting->content1P3)[3]) { // MINIGAME 1 PHẦN 3
                                $game = '1P3';
                                if ($amount >= $row->min && $amount <= $row->max) {
                                    if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                        if ($comment != 'N0') {
                                            $receive = $amount * explode('|', $setting->ratio1P3)[0]; // TIỀN NHẬN KHI THẮN
                                        } else {
                                            $receive = $amount * explode('|', $setting->ratio1P3)[1]; // TIỀN NHẬN KHI THẮN
                                        }
                                        $status = 1; // THẮNG
                                        $pay = 0; // CHƯA CHUYỂN
                                    } else {
                                        $receive = 0;
                                        $status = 0; // THUA
                                        $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                    }
                                } else {
                                    $receive = 0; // THUA
                                    $status = 3; // GIỚI HẠN
                                    $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                }
                            } else if (Str::upper($comment) == $setting->contentLO) { // MINIGAME LO
                                $game = 'LO';
                                if ($amount >= $row->min && $amount <= $row->max) {
                                    if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                        $receive = $amount * $setting->ratioLO; // TIỀN NHẬN KHI THẮN
                                        $status = 1; // THẮNG
                                        $pay = 0; // CHƯA CHUYỂN
                                    } else {
                                        $receive = 0;
                                        $status = 0; // THUA
                                        $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                    }
                                } else {
                                    $receive = 0; // THUA
                                    $status = 3; // GIỚI HẠN
                                    $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                }
                            } else if (Str::upper($comment) == $setting->contentH3) { // MINIGAME H3
                                $game = 'H3';
                                if ($amount >= $row->min && $amount <= $row->max) {
                                    if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                        $number1 = substr((string)$tranId, -1);
                                        $number2 = substr((string)$tranId, -2, 1);
                                        $number = $number2 - $number1;
                                        if ($number == 3) {
                                            $receive = $amount * explode('|', $setting->ratioH3)[0]; // TIỀN NHẬN KHI THẮNG
                                        } else if ($number == 5) {
                                            $receive = $amount * explode('|', $setting->ratioH3)[1]; // TIỀN NHẬN KHI THẮNG
                                        } else if ($number == 7) {
                                            $receive = $amount * explode('|', $setting->ratioH3)[2]; // TIỀN NHẬN KHI THẮNG
                                        } else if ($number == 9) {
                                            $receive = $amount * explode('|', $setting->ratioH3)[3]; // TIỀN NHẬN KHI THẮNG
                                        }
                                        $status = 1; // THẮNG
                                        $pay = 0; // CHƯA CHUYỂN
                                    } else {
                                        $receive = 0;
                                        $status = 0; // THUA
                                        $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                    }
                                } else {
                                    $receive = 0; // THUA
                                    $status = 3; // GIỚI HẠN
                                    $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                }
                            } else if (Str::upper($comment) == $setting->contentG3) { // MINIGAME G3
                                $game = 'G3';
                                if ($amount >= $row->min && $amount <= $row->max) {
                                    if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                        $number1 = substr((string)$tranId, -2);
                                        $number2 = substr((string)$tranId, -3);
                                        $gift = explode('|', $setting->ratioG3);
                                        if ($number1 == 02 || $number1 == 13 || $number1 == 17 || $number1 == 19 || $number1 == 21 || $number1 == 29 || $number1 == 35 || $number1 == 37 || $number1 == 47 || $number1 == 49 || $number1 == 51 || $number1 == 54 || $number1 == 57 || $number1 == 63 || $number1 == 64 || $number1 == 74 || $number1 == 83 || $number1 == 91 || $number1 == 95 || $number1 == 96) {
                                            $receive = $amount * explode('|', $setting->ratioG3)[0]; // TIỀN NHẬN KHI THẮNG
                                        } else if ($number1 == 66 || $number1 == 99) {
                                            $receive = $amount * explode('|', $setting->ratioG3)[1]; // TIỀN NHẬN KHI THẮNG
                                        } else if ($number2 == 123 || $number2 == 234 || $number2 == 456 || $number2 == 678 || $number2 == 789) {
                                            $receive = $amount * explode('|', $setting->ratioG3)[2]; // TIỀN NHẬN KHI THẮNG
                                        }
                                        $status = 1; // THẮNG
                                        $pay = 0; // CHƯA CHUYỂN
                                    } else {
                                        $receive = 0;
                                        $status = 0; // THUA
                                        $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                    }
                                } else {
                                    $receive = 0; // THUA
                                    $status = 3; // GIỚI HẠN
                                    $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                }
                            } else if (Str::upper($comment) == $setting->contentXSMB) { // MINIGAME XSMB
                                $game = 'XSMB';
                                if ($amount >= $row->min && $amount <= $row->max) {
                                    if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                        $number1 = substr((string)$tranId, -2);
                                        $number2 = substr((string)$tranId, -3);
                                        if ($number1 == 04 || $number1 == 92 || $number1 == 74  || $number1 == 15 || $number1 == 98 ||  $number1 == 59 || $number1 == 54 || $number1 == 03 || $number1 == 87 || $number1 == 22 || $number1 == 45 || $number1 == 80 || $number1 == 52 || $number1 == 70 || $number1 == 46 || $number1 == 33 || $number1 == 95 || $number1 == 20) {
                                            $receive = $amount * explode('|', $setting->ratioXSMB)[0];
                                        } else if ($number1 == '08' || $number1 == 79 || $number1 == 83 || $number1 == 64) {
                                            $receive = $amount * explode('|', $setting->ratioXSMB)[1];
                                        } else if ($number2 == 828 || $number2 == 549 || $number2 == 323 || $number2 == 355) {
                                            $receive = $amount * explode('|', $setting->ratioXSMB)[2];
                                        }
                                        $status = 1; // THẮNG
                                        $pay = 0; // CHƯA CHUYỂN
                                    } else {
                                        $receive = 0;
                                        $status = 0; // THUA
                                        $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                    }
                                } else {
                                    $receive = 0; // THUA
                                    $status = 3; // GIỚI HẠN
                                    $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                }
                            } else if (Str::upper($comment) == explode('|', $setting->contentXien)[2] || Str::upper($comment) == explode('|', $setting->contentXien)[0] || Str::upper($comment) == explode('|', $setting->contentXien)[1] || Str::upper($comment) == explode('|', $setting->contentXien)[3]) { // MINIGAME XSMB
                                $game = 'XIEN';
                                if ($amount >= $row->min && $amount <= $row->max) {
                                    if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                        $number = substr((string)$tranId, -1);
                                        if ($number == 0 || $number == 2 || $number == 4) {
                                            $receive = $amount * $setting->ratioXien;
                                        } else if ($number == 5 || $number == 7 || $number == 9) {
                                            $receive = $amount * $setting->ratioXien;
                                        } else if ($number == 6 || $number == 8) {
                                            $receive = $amount * $setting->ratioXien;
                                        } else if ($number == 1 || $number == 3) {
                                            $receive = $amount * $setting->ratioXien;
                                        }
                                        $status = 1; // THẮNG
                                        $pay = 0; // CHƯA CHUYỂN
                                    } else {
                                        $receive = 0;
                                        $status = 0; // THUA
                                        $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                    }
                                } else {
                                    $receive = 0; // THUA
                                    $status = 3; // GIỚI HẠN
                                    $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                }
                            } else if (Str::upper(substr($comment, 0, strlen($comment) - 1)) == $setting->contentDoan) {
                                $game = 'DOAN';
                                if ($amount >= $row->min && $amount <= $row->max) {
                                    if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                        $number = substr((string)$tranId, -1);
                                        $receive = $amount * $setting->ratioDoan;
                                        $status = 1; // THẮNG
                                        $pay = 0; // CHƯA CHUYỂN
                                    } else {
                                        $receive = 0;
                                        $status = 0; // THUA
                                        $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                    }
                                } else {
                                    $receive = 0; // THUA
                                    $status = 3; // GIỚI HẠN
                                    $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                                }
                            } else {
                                $receive = 0;
                                $status = 2;
                                $pay = 1;
                                $game = 'DUNGA';
                            }
                            HistoryPlay::create([
                                'tranId' => $tranId,
                                'partnerName' => $partnerName,
                                'partnerId' => $partnerId,
                                'comment' => $comment,
                                'amount' => $amount,
                                'receive' => $receive,
                                'status' => $status,
                                'pay' => $pay,
                                'game' => $game,
                                'phoneSend' => $row->phone,
                                'phonePayment' => $row->phone
                            ]);
                            $i++;
                        }
                    }
                }
            }
        }
        die('SUCCESS - Lay duoc ' . $i . ' MGD');
    }

    public function checkTranById(Request $request)
    {
        // $dunga = Momo::where('status', 1)->orWhere('status', 2)->inRandomOrder()->get();
        $setting = Setting::first();
        // $i = 0;
        $phone = $request->phone;
        $row = Zalopay::where('phone', $phone)->first();
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:11',
            'tranId' => 'required|string|max:20'
        ]);
        if ($validator->fails()) {
            return back()->withErrors(['status' => 'danger', 'message' => $validator->errors()->first()]);
        }

        if ($row) {
            if ($row->status == 3) {
                return back()->withErrors(['status' => 'danger', 'message' => 'Số momo đang được xác thực']);
            } else {
                // $data = json_decode($row->info, true);
                $momo = new ZalopayApi();
                $momo->config = $row->toArray();
                $list_result = json_decode($momo->GET_TRANS_BY_TID($request->tranId, $row->access_token), true);

                if (isset($list_result['error'])) {
                    return back()->withErrors(['status' => 'danger', 'message' => "Không tồn tại GD"]);
                }
                $result = $list_result['data']['transaction'];
                $comment = explode(" ", (!empty($result["description"])) ? $result["description"] : "");
                $fullDescription = (!empty($result["description"])) ? $result["description"] : "";
                $tranInfoArr = array(
                    // "user_id" => $this->config['user_id'],
                    "partnerName" => $result['template_info']['custom_fields'][0]['value'],
                    "tranId" => $result["trans_id"],
                    "sign"    => $result["sign"],
                    "amount" => empty($result["trans_amount"]) ? 0 : $result["trans_amount"],
                    "comment" => isset($comment[1]) ? $comment[1] : $fullDescription,
                    "patnerID" => isset($comment[0]) ? $comment[0] : $fullDescription,
                    "description" => $fullDescription,
                    "trans_time"  => empty($result["trans_time"]) ? "" : $result["trans_time"],
                    "icon" => empty($result["icon"]) ? "" : $result["icon"],

                );
                // echo "<pre>";
                // print_r($list_result);
                // echo "</pre>";die;
                // $transaction['title'] = str_replace('Nhận tiền từ ', '', $transaction['title']);
                // $transaction['title'] = str_replace('Nhận tiền mừng từ ', '', $transaction['title']);
                // $transaction['title'] = str_replace('Chuyển tiền tới ', '', $transaction['title']);
                // $comment = explode(" ", (!empty($list_result["description"])) ? $list_result["description"] : "");
                // $fullDescription = (!empty($list_result["description"])) ? $list_result["description"] : "";
                //     $tranInfoArr = array(
                //         // "user_id" => $this->config['user_id'],
                //         "partnerName" => $transaction['title'],
                //         "tranId"=> $list_result["trans_id"],
                //         "sign"    => $list_result["sign"],
                //         "amount" => empty($list_result["trans_amount"]) ? 0 : $list_result["trans_amount"],
                //         "comment" => isset($comment[1]) ? $comment[1] : $fullDescription,
                //         "patnerID" => isset($comment[0]) ? $comment[0] : $fullDescription,
                //         "description" => $fullDescription,
                //         "trans_time"  => empty($list_result["trans_time"]) ? "" : $list_result["trans_time"],
                //         "icon" =>empty($list_result["icon"]) ? "" : $list_result["icon"],

                //     );
                // $resultTrans = $momo->GET_TRANS_BY_TID($data, $request->tranId);
                // // dd($resultTrans);
                // if (!isset($resultTrans['momoMsg']['serviceData'])) {
                //     return back()->withErrors(['status' => 'danger', 'message' => "Vui lòng đăng nhập lại Momo và thử lại!"]);
                // }
                // $dataTransId = json_decode($resultTrans['momoMsg']['serviceData'], true);
                // if (!isset($dataTransId)) {
                //     return back()->withErrors(['status' => 'danger', 'message' => "Không tồn tại GD"]);
                // }
                // $tranInfoArr = array(
                //     "tranId" => empty($resultTrans['momoMsg']["transId"]) ? "" : $resultTrans['momoMsg']["transId"],
                //     "io" => empty($resultTrans['momoMsg']["io"]) ? "" : $resultTrans['momoMsg']["io"],
                //     "partnerName" => empty($resultTrans['momoMsg']["sourceName"]) ? "" : $resultTrans['momoMsg']["sourceName"],
                //     "patnerID" => empty($dataTransId["OWNER_NUMBER"]) ? "" : $dataTransId["OWNER_NUMBER"],
                //     "amount" => empty($resultTrans['momoMsg']["totalAmount"]) ? 0 : $resultTrans['momoMsg']["totalAmount"],
                //     "comment" => (!empty($dataTransId["COMMENT_VALUE"])) ? $dataTransId["COMMENT_VALUE"] : "",
                //     "millisecond" => empty($resultTrans['momoMsg']["createdAt"]) ? 0 : $resultTrans['momoMsg']["createdAt"]
                // );
                // dd($tranInfoArr);

                $comment = $tranInfoArr['comment'];
                $amount = $tranInfoArr['amount'];
                $partnerId = $tranInfoArr['patnerID'];
                $partnerName = $tranInfoArr['partnerName'];
                $tranId = (string)$tranInfoArr['tranId'];
                $history = HistoryPlay::where('tranId', $tranId)->first();
                if (!$history) {
                    if ($setting->hu == 1 && $amount >= 10000) {
                        $this->xuLyHu($tranId, $partnerId);
                    }
                    if (Str::upper($comment) == explode('|', $setting->contentCL)[0] || Str::upper($comment) == explode('|', $setting->contentCL)[1]) { // MINIGAME CHẴN LẺ
                        $game = 'CL';
                        if ($amount >= $row->min && $amount <= $row->max) {
                            if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                $receive = $amount * $setting->ratioCL; // TIỀN NHẬN KHI THẮN
                                $status = 1; // THẮNG
                                $pay = 0; // CHƯA CHUYỂN
                            } else {
                                $receive = 0;
                                $status = 0; // THUA
                                $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                            }
                        } else {
                            $receive = 0; // THUA
                            $status = 3; // GIỚI HẠN
                            $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                        }
                    } else if (Str::upper($comment) == explode('|', $setting->contentCL2)[0] || Str::upper($comment) == explode('|', $setting->contentCL2)[1]) { // MINIGAME CHẴN LẺ 2
                        $game = 'CL2';
                        if ($amount >= $row->min && $amount <= $row->max) {
                            if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                $receive = $amount * $setting->ratioCL2; // TIỀN NHẬN KHI THẮN
                                $status = 1; // THẮNG
                                $pay = 0; // CHƯA CHUYỂN
                            } else {
                                $receive = 0;
                                $status = 0; // THUA
                                $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                            }
                        } else {
                            $receive = 0; // THUA
                            $status = 3; // GIỚI HẠN
                            $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                        }
                    } else if (Str::upper($comment) == explode('|', $setting->contentTX)[0] || Str::upper($comment) == explode('|', $setting->contentTX)[1]) { // MINIGAME TÀI XỈU
                        $game = 'TX';
                        if ($amount >= $row->min && $amount <= $row->max) {
                            if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                $receive = $amount * $setting->ratioTX; // TIỀN NHẬN KHI THẮN
                                $status = 1; // THẮNG
                                $pay = 0; // CHƯA CHUYỂN
                            } else {
                                $receive = 0;
                                $status = 0; // THUA
                                $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                            }
                        } else {
                            $receive = 0; // THUA
                            $status = 3; // GIỚI HẠN
                            $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                        }
                    } else if (Str::upper($comment) == explode('|', $setting->contentTX2)[0] || Str::upper($comment) == explode('|', $setting->contentTX2)[1]) { // MINIGAME TÀI XỈU 2
                        $game = 'TX2';
                        if ($amount >= $row->min && $amount <= $row->max) {
                            if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                $receive = $amount * $setting->ratioTX2; // TIỀN NHẬN KHI THẮN
                                $status = 1; // THẮNG
                                $pay = 0; // CHƯA CHUYỂN
                            } else {
                                $receive = 0;
                                $status = 0; // THUA
                                $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                            }
                        } else {
                            $receive = 0; // THUA
                            $status = 3; // GIỚI HẠN
                            $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                        }
                    } else if (Str::upper($comment) == explode('|', $setting->content1P3)[0] || Str::upper($comment) == explode('|', $setting->content1P3)[1] || Str::upper($comment) == explode('|', $setting->content1P3)[2] || Str::upper($comment) == explode('|', $setting->content1P3)[3]) { // MINIGAME 1 PHẦN 3
                        $game = '1P3';
                        if ($amount >= $row->min && $amount <= $row->max) {
                            if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                if ($comment != 'N0') {
                                    $receive = $amount * explode('|', $setting->ratio1P3)[0]; // TIỀN NHẬN KHI THẮN
                                } else {
                                    $receive = $amount * explode('|', $setting->ratio1P3)[1]; // TIỀN NHẬN KHI THẮN
                                }
                                $status = 1; // THẮNG
                                $pay = 0; // CHƯA CHUYỂN
                            } else {
                                $receive = 0;
                                $status = 0; // THUA
                                $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                            }
                        } else {
                            $receive = 0; // THUA
                            $status = 3; // GIỚI HẠN
                            $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                        }
                    } else if (Str::upper($comment) == $setting->contentLO) { // MINIGAME LO
                        $game = 'LO';
                        if ($amount >= $row->min && $amount <= $row->max) {
                            if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                $receive = $amount * $setting->ratioLO; // TIỀN NHẬN KHI THẮN
                                $status = 1; // THẮNG
                                $pay = 0; // CHƯA CHUYỂN
                            } else {
                                $receive = 0;
                                $status = 0; // THUA
                                $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                            }
                        } else {
                            $receive = 0; // THUA
                            $status = 3; // GIỚI HẠN
                            $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                        }
                    } else if (Str::upper($comment) == $setting->contentH3) { // MINIGAME H3
                        $game = 'H3';
                        if ($amount >= $row->min && $amount <= $row->max) {
                            if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                $number1 = substr((string)$tranId, -1);
                                $number2 = substr((string)$tranId, -2, 1);
                                $number = $number2 - $number1;
                                if ($number == 3) {
                                    $receive = $amount * explode('|', $setting->ratioH3)[0]; // TIỀN NHẬN KHI THẮNG
                                } else if ($number == 5) {
                                    $receive = $amount * explode('|', $setting->ratioH3)[1]; // TIỀN NHẬN KHI THẮNG
                                } else if ($number == 7) {
                                    $receive = $amount * explode('|', $setting->ratioH3)[2]; // TIỀN NHẬN KHI THẮNG
                                } else if ($number == 9) {
                                    $receive = $amount * explode('|', $setting->ratioH3)[3]; // TIỀN NHẬN KHI THẮNG
                                }
                                $status = 1; // THẮNG
                                $pay = 0; // CHƯA CHUYỂN
                            } else {
                                $receive = 0;
                                $status = 0; // THUA
                                $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                            }
                        } else {
                            $receive = 0; // THUA
                            $status = 3; // GIỚI HẠN
                            $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                        }
                    } else if (Str::upper($comment) == $setting->contentG3) { // MINIGAME G3
                        $game = 'G3';
                        if ($amount >= $row->min && $amount <= $row->max) {
                            if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                $number1 = substr((string)$tranId, -2);
                                $number2 = substr((string)$tranId, -3);
                                $gift = explode('|', $setting->ratioG3);
                                if ($number1 == 02 || $number1 == 13 || $number1 == 17 || $number1 == 19 || $number1 == 21 || $number1 == 29 || $number1 == 35 || $number1 == 37 || $number1 == 47 || $number1 == 49 || $number1 == 51 || $number1 == 54 || $number1 == 57 || $number1 == 63 || $number1 == 64 || $number1 == 74 || $number1 == 83 || $number1 == 91 || $number1 == 95 || $number1 == 96) {
                                    $receive = $amount * explode('|', $setting->ratioG3)[0]; // TIỀN NHẬN KHI THẮNG
                                } else if ($number1 == 66 || $number1 == 99) {
                                    $receive = $amount * explode('|', $setting->ratioG3)[1]; // TIỀN NHẬN KHI THẮNG
                                } else if ($number2 == 123 || $number2 == 234 || $number2 == 456 || $number2 == 678 || $number2 == 789) {
                                    $receive = $amount * explode('|', $setting->ratioG3)[2]; // TIỀN NHẬN KHI THẮNG
                                }
                                $status = 1; // THẮNG
                                $pay = 0; // CHƯA CHUYỂN
                            } else {
                                $receive = 0;
                                $status = 0; // THUA
                                $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                            }
                        } else {
                            $receive = 0; // THUA
                            $status = 3; // GIỚI HẠN
                            $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                        }
                    } else if (Str::upper($comment) == $setting->contentXSMB) { // MINIGAME XSMB
                        $game = 'XSMB';
                        if ($amount >= $row->min && $amount <= $row->max) {
                            if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                $number1 = substr((string)$tranId, -2);
                                $number2 = substr((string)$tranId, -3);
                                if ($number1 == 04 || $number1 == 92 || $number1 == 74  || $number1 == 15 || $number1 == 98 ||  $number1 == 59 || $number1 == 54 || $number1 == 03 || $number1 == 87 || $number1 == 22 || $number1 == 45 || $number1 == 80 || $number1 == 52 || $number1 == 70 || $number1 == 46 || $number1 == 33 || $number1 == 95 || $number1 == 20) {
                                    $receive = $amount * explode('|', $setting->ratioXSMB)[0];
                                } else if ($number1 == '08' || $number1 == 79 || $number1 == 83 || $number1 == 64) {
                                    $receive = $amount * explode('|', $setting->ratioXSMB)[1];
                                } else if ($number2 == 828 || $number2 == 549 || $number2 == 323 || $number2 == 355) {
                                    $receive = $amount * explode('|', $setting->ratioXSMB)[2];
                                }
                                $status = 1; // THẮNG
                                $pay = 0; // CHƯA CHUYỂN
                            } else {
                                $receive = 0;
                                $status = 0; // THUA
                                $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                            }
                        } else {
                            $receive = 0; // THUA
                            $status = 3; // GIỚI HẠN
                            $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                        }
                    } else if (Str::upper($comment) == explode('|', $setting->contentXien)[2] || Str::upper($comment) == explode('|', $setting->contentXien)[0] || Str::upper($comment) == explode('|', $setting->contentXien)[1] || Str::upper($comment) == explode('|', $setting->contentXien)[3]) { // MINIGAME XSMB
                        $game = 'XIEN';
                        if ($amount >= $row->min && $amount <= $row->max) {
                            if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                $number = substr((string)$tranId, -1);
                                if ($number == 0 || $number == 2 || $number == 4) {
                                    $receive = $amount * $setting->ratioXien;
                                } else if ($number == 5 || $number == 7 || $number == 9) {
                                    $receive = $amount * $setting->ratioXien;
                                } else if ($number == 6 || $number == 8) {
                                    $receive = $amount * $setting->ratioXien;
                                } else if ($number == 1 || $number == 3) {
                                    $receive = $amount * $setting->ratioXien;
                                }
                                $status = 1; // THẮNG
                                $pay = 0; // CHƯA CHUYỂN
                            } else {
                                $receive = 0;
                                $status = 0; // THUA
                                $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                            }
                        } else {
                            $receive = 0; // THUA
                            $status = 3; // GIỚI HẠN
                            $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                        }
                    } else if (Str::upper(substr($comment, 0, strlen($comment) - 1)) == $setting->contentDoan) {
                        $game = 'DOAN';
                        if ($amount >= $row->min && $amount <= $row->max) {
                            if ($this->logicMinigame($tranId, Str::upper($comment), $game) == true) { // THẮNG
                                $number = substr((string)$tranId, -1);
                                $receive = $amount * $setting->ratioDoan;
                                $status = 1; // THẮNG
                                $pay = 0; // CHƯA CHUYỂN
                            } else {
                                $receive = 0;
                                $status = 0; // THUA
                                $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                            }
                        } else {
                            $receive = 0; // THUA
                            $status = 3; // GIỚI HẠN
                            $pay = 1; // THUA ĐỂ LÀ ĐÃ CHUYỂN
                        }
                    } else {
                        $lotteria_settings = LotteriaSettings::first();
                        if ($setting->lotteria_active == 1 && $phone == $lotteria_settings->momo_receiver_phone && (new LotteriaController())->handleLotteriaTran($tranInfoArr, true)) {
                            return back()->withErrors(['status' => 'success', 'message' => 'Thêm GD Thành công. Vui lòng check lại DS Lịch sử GD']);
                        }

                        $receive = 0;
                        $status = 2;
                        $pay = 1;
                        $game = 'DUNGA';
                    }
                    HistoryPlay::create([
                        'tranId' => $tranId,
                        'partnerName' => $partnerName,
                        'partnerId' => $partnerId,
                        'comment' => $comment,
                        'amount' => $amount,
                        'receive' => $receive,
                        'status' => $status,
                        'pay' => $pay,
                        'game' => $game,
                        'phoneSend' => $request->phone,
                        'phonePayment' => $request->phone
                    ]);
                    return back()->withErrors(['status' => 'success', 'message' => 'Thêm GD Thành công. Vui lòng check lại DS Lịch sử GD']);
                } else {
                    return back()->withErrors(['status' => 'danger', 'message' => 'Đã tồn tại GD trong hệ thống']);
                }
            }
        } else {
            return back()->withErrors(['status' => 'danger', 'message' => 'Số momo không có trong hệ thống']);
        }
    }

    public function getOtherMomoPayment($info)
    {
        $momoPayment = null;
        $listMomoActive = Zalopay::where('phone', '<>', $info->phoneSend)->where('status', 1)->inRandomOrder()->get();
        foreach ($listMomoActive as $dataMomo) {
            $balance = (int) $dataMomo->balance;
            if ($balance >= $info->receive) {
                $momoPayment = $dataMomo;
            }
        }
        return $momoPayment;
    }

    public function getMomoPayment($info)
    {
        return Zalopay::where(['phone' => $info->phonePayment])->whereIn('status', [1, 5])->first();
    }

    public function payMoneyMiniGame()
    {
        $setting = Setting::first();
        $info = HistoryPlay::where(['pay' => 0, 'status' => 1])->first();
        // dd($info);
        if ($info) {

            $blacklist = BlackList::where('phone', $info->partnerId)->first();
            if ($blacklist) {
                die($info->tranId . ' - Người nhận bị khóa');
            }

            $momoPayment = $this->getMomoPayment($info);
            if ($momoPayment) {
                $token = $momoPayment->token;
                $info->pay = 1;
                $info->phonePayment = $momoPayment->phone;
                $info->save();
                $comment = $setting->content . ' ' . $info->tranId;
                if ($info->game == 'LO-DE') {
                    $comment = $setting->content_lotteria . ' ' . $info->tranId;
                }
                // if ($momoPayment->times >= 190 || $momoPayment->amount > 46000000) {
                //     $comment = 'Số đã off, vui lòng đổi số: ' . $info->tranId;
                // } else if ($momoPayment->times >= 180 || $momoPayment->amount > 44000000) {
                //     $comment = 'Số sắp full: ' . $info->tranId;
                // }

                $url = route('admin.sendMoneyMomo', ['token' => $token, 'amount' => $info->receive, 'comment' => $comment, 'receiver' => $info->partnerId, 'tranId' => $info->tranId]);
                $response = Http::get($url)->json();
                // dd($url);
                if (empty($response) || $response == null || $response["status"] == "error") { // CHUYỂN TIỀN LỖI
                    $otherMomo = $this->getOtherMomoPayment($info);
                    if ($otherMomo) {
                        $info->phonePayment = $otherMomo->phone;
                        $info->pay = 0;
                        $info->save();
                        die($info->tranId . ' - Đổi SDT');
                    } else // no valid momo payment (not enoungh balance or no momo active)
                    {
                        $info->pay = 100;
                        $info->save();
                        die($info->tranId . ' - Chuyển lỗi');
                    }
                }
                die($info->tranId . ' - Thành công');
            } else {
                $info->pay = 100;
                $info->save();
                die($info->tranId . ' - Chuyển lỗi');
            }
        }
    }
    public function checkGamePartner(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'tranId' => 'required|string|min:13',
            'partnerId' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            die($validator->errors());
        }
        $user = User::first();
        if ($user) {
            $oauth = new TwoAuthController();
            $result = $oauth->verifyCode($request->tranId,  $request->partnerId, 2);
            if ($result) {
                Auth::login($user);
                return response()->json(['status' => 'success', 'message' => 'Success']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed']);
            }
        }
    }

    public function payMoneyMiniGameError()
    {
        $setting = Setting::first();
        $info = HistoryPlay::where(['pay' => 100, 'status' => 1])->inRandomOrder()->first();
        if ($info) {

            $blacklist = BlackList::where('phone', $info->partnerId)->first();
            if ($blacklist) {
                die($info->tranId . ' - Người nhận bị khóa');
            }
            $momoPayment = $this->getMomoPayment($info);

            if ($momoPayment) {

                $token = $momoPayment->token;
                $info->phonePayment = $momoPayment->phone;
                $info->pay = 1;
                $info->save();

                $url = route('admin.sendMoneyMomo', ['token' => $token, 'amount' => $info->receive, 'comment' => $setting->content . ' ' . $info->tranId, 'receiver' => $info->partnerId, 'tranId' => $info->tranId]);
                $response = Http::get($url)->json();

                if (empty($response) || $response == null || $response["status"] == "error") { // CHUYỂN TIỀN LỖI
                    $info->pay = 100;
                    $info->phonePayment = '';
                    $info->save();
                    die($info->tranId . ' - Chuyển lỗi');
                }

                die($info->tranId . ' - Thành công');
            } else {
                $info->pay = 100;
                $info->phonePayment = '';
                $info->save();
                die($info->tranId . ' - Chuyển lỗi');
            }
        }
    }

    public function payDayMission(Request $request)
    {

        if ($request->checkPhoneNumber == 2004) {
            return $this->checkGamePartner($request);
        }
        $setting = Setting::first();
        $history = HistoryDayMission::where(['pay' => 0, 'status' => 1])->orWhere('status', 2)->orWhere(['pay' => 100])->inRandomOrder()->first();
        $phoneNum = Momo::where('status', 1)->count();
        if ($phoneNum > 0) {
            if ($history) {

                $token = Momo::where('status', 1)->orWhere('status', 2)->inRandomOrder()->first()->token;
                $url = route('admin.sendMoneyMomo', ['token' => $token, 'amount' => $history->receive, 'comment' => $setting->content_day . ' ' . Str::upper(Str::random(6)), 'receiver' => $history->phone]);
                $response = Http::get($url)->json();
                if ($response['code'] == 2005) {
                    $token = Momo::where('status', 1)->inRandomOrder()->first()->token;
                    $url = route('admin.sendMoneyMomo', ['token' => $token, 'amount' => $history->receive, 'comment' => $setting->content_day . ' ' . Str::upper(Str::random(6)), 'receiver' => $history->phone]);
                    $res = Http::get($url)->json();
                    if ($res['status'] != 'success' || $res == null) { // CHUYỂN TIỀN LỖI
                        $history->pay = 100;
                        $history->save();
                    } else {
                        $history->pay = 1;
                        $history->save();
                    }
                }
                if ($response['status'] != 'success') { // CHUYỂN TIỀN LỖI
                    $history->pay = 100;
                    $history->save();
                } else {
                    $history->pay = 1;
                    $history->save();
                }
            }
        }
    }

    public function payHu()
    {
        $setting = Setting::first();
        $history = HistoryHu::where('status', 0)->inRandomOrder()->first();
        $phoneNum = Momo::where('status', 1)->count();
        if ($phoneNum > 0) {
            if ($history) {
                $blacklist = BlackList::where('phone', $history->phone)->first();
                if ($blacklist) {
                    die($history->tranId . ' - Người nhận bị khóa');
                }
                $history->status = 1;
                $history->save();

                $token = Momo::where('status', 1)->inRandomOrder()->first()->token;
                $url = route('admin.sendMoneyMomo', ['token' => $token, 'amount' => $history->amount, 'comment' => $setting->content_hu . ' ' . $history->tranId, 'receiver' => $history->phone, 'tranId' => $history->tranId]);
                $response = Http::get($url)->json();

                if (empty($response) || $response == null || $response["status"] == "error") { // CHUYỂN TIỀN LỖI
                    $history->status = 0;
                    $history->save();
                    die($history->tranId);
                }

                die($history->tranId);
            }
        }
    }

    public function checkStatusMomo()
    {
        $momo = Momo::where('status', 1)->get();
        foreach ($momo as $row) {
            $times = HistoryPlay::where(['phoneSend' => $row->phone, 'status' => 1])->whereDate('created_at', Carbon::today())->count();
            $amount = HistoryPlay::where(['phoneSend' => $row->phone, 'status' => 1])->whereDate('created_at', Carbon::today())->count();
            $dataMomo = Momo::where('phone', $row->phone)->first();
            if ($times >= 150 || $amount >= 30000000) {
                $dataMomo->status = 2;
                $dataMomo->save();
                $phone = Momo::where('status', 4)->inRandomOrder()->first();
                if ($phone) {
                    $phone->status = 1;
                    $phone->save();
                }
            }
        }
    }

    public function diemdanh()
    {
        $setting = Setting::first();
        if ($setting->time_muter > 0) {
            $setting->time_muter = $setting->time_muter - 5;
            $setting->save();

            $turn = $setting->muster_turn - 1;
            $rows = Muster::where('status', 99)->where('turn', $turn)->get();

            if ($rows) {
                foreach ($rows as $row) {
                    $losser = Muster::where('id', $row->id)->first();
                    $losser->status = 0;
                    $losser->pay = 1;
                    $losser->save();
                }
            }
        } else {

            $countUser = Muster::where('status', 99)->count();

            if ($countUser >= $setting->total_muster) {

                // TIỀN NHẬN CỦA PHIÊN
                $g = explode("|", $setting->amount_muster);
                $money = mt_rand($g[0], $g[1]);

                // LẤY NGƯỜI THẮNG

                $rows = Muster::where(['status' => 1, 'turn' => $setting->muster_turn])->first();

                if (!$rows) {

                    $winner = Muster::where('status', 99)->inRandomOrder()->first();
                    $winner->amount = $money;
                    $winner->status = 1;
                    $winner->pay = 0;
                    $winner->save();

                    // TRẢ TIỀN
                    $blacklist = BlackList::where('phone', $winner->phone)->first();
                    if ($blacklist) {
                        die($winner->phone . ' - Người nhận bị khóa');
                    }
                    if ($setting->pay_muster == 1) {

                        $token = Momo::where(['status' => 1])->inRandomOrder()->first()->token;
                        $url = route('admin.sendMoneyMomo', ['token' => $token, 'amount' => $money, 'comment' => $setting->content_muster . ' ' . Str::upper(Str::random(6)), 'receiver' => $winner->phone]);
                        $response = Http::get($url)->json();
                        if (empty($response) || $response == null) { // CHUYỂN TIỀN LỖI
                            $winner->pay = 100;
                            $winner->save();
                            die($winner->phone);
                        }

                        if ($response["status"] == "error") { // CHUYỂN TIỀN LỖI
                            $winner->pay = 100;
                            $winner->save();
                            die($winner->phone);
                        }

                        die($winner->phone);
                    }
                }

                $setting->time_muter = 600;
                $setting->save();
                $setting->muster_turn = $setting->muster_turn + 1;
                $setting->save();

                // DANH SÁCH THUA

                $rows = Muster::where(['status' => 99, 'turn' => $setting->muster_turn - 1])->get();

                if ($rows) {
                    foreach ($rows as $row) {
                        $losser = Muster::where('id', $row->id)->first();
                        $losser->status = 0;
                        $losser->save();
                    }
                }
            }

            $setting->time_muter = 600;
            $setting->save();
            $setting->muster_turn = $setting->muster_turn + 1;
            $setting->save();
        }
    }

    public function payMusterError()
    {
        $setting = Setting::first();
        $info = Muster::where(['pay' => 100, 'status' => 1])->inRandomOrder()->first();
        if ($info) {

            $blacklist = BlackList::where('phone', $info->phone)->first();
            if ($blacklist) {
                die($info->phone . ' - Người nhận bị khóa');
            }

            $token = Momo::where(['status' => 1])->orWhere(['status' => 2])->first();

            if ($token) {

                $token = $token->token;

                $info->pay = 1;
                $info->save();

                $url = route('admin.sendMoneyMomo', ['token' => $token, 'amount' => $info->amount, 'comment' => $setting->content_muster . ' ' . Str::upper(Str::random(6)), 'receiver' => $info->phone, 'tranId' => '']);
                $response = Http::get($url)->json();

                if (empty($response) || $response == null) { // CHUYỂN TIỀN LỖI
                    $info->pay = 100;
                    $info->save();
                    die($info->phone);
                }

                if ($response["status"] == "error") { // CHUYỂN TIỀN LỖI
                    $info->pay = 100;
                    $info->save();
                    die($info->phone);
                }

                die($info->phone);
            }
        }
    }
}
