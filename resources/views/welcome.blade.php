@extends('master')
@section('main')
    {{-- <style>
        .tet {
            display: scroll;
            position: fixed;
            top: 0px;
            z-index: 999;
            width: 160px;
        }

        .tet-left {
            left: 0;
        }

        .tet-right {
            right: 0;
        }

        @media (max-width:500px) {
            .tet {
                width: 60px;
            }
        }

        @media (max-width:820px) {
            .tet {
                width: 100px;
            }
        }
    </style>
    <img class='tet tet-left' src='https://i.imgur.com/fm6ce5S.png' />
    <img class='tet tet-right' src='https://i.imgur.com/ajfAX6c.png' /> --}}

    <input type="hidden" name="main_session">
    <div class="mainbar">
        <div class="container">
            <a href="/" class="text-center">
                <div class="hidden-xs ">
                    <img src="{{ $setting->logo }}" height="120px" alt="Logo">
                </div>
                <div class="visible-xs ">
                    <img src="{{ $setting->logo }}" height="60px" alt="Logo">
                </div>
            </a>
        </div>

        <body class="" style="">
            <marquee width="100%" behavior="scroll"
                style="display: block;
            position: fixed;
            bottom: 70 px;
            left: 15 px;
            z-index: 1000;
            cursor: pointer;
            width: 100%;">
                <font color="white" style="text-shadow: 0 0 0.2em #ff0000, 0 0 0.2em #ff0000,  0 0 0.2em #ff0000">
                    <b>{{ $setting->ads }}</b>
                </font>
                </font>
            </marquee>
    </div>
    </a>
    </div>
    </div>
    </div>
    <div class="container">
        <div class="content">
            <div class="content-container">
                <div class="py-5" style="min-height: 80px !important;">
                    <div class="output" id="output">
                        <h3 class="cursor">
                            Hệ Thống Mini Game Zalopay Tự Động Siêu Ngon </h3>
                        <h4> Uy Tín, giao dịch tự động 24/7 </h4>
                        <strong class="text-primary-2">Mỗi Lần Chơi AE Chú Ý Load Lại WEB Lấy Số Chơi Nhá</strong>
                    </div>
                </div>
                {{-- @if ($setting->lotteria_active == 1)
                    <a class="btn btn-warning mt-1" href="{{ route('lottery.index') }}" target="_blank"><i class="fa fa-star"
                                            aria-hidden="true"></i> LÔ ĐỀ MIỀN BẮC <i class="fa fa-star" aria-hidden="true"></i></a>
                @endif --}}
                <div class="text-center mt-5">
                    <button class="btn btn-primary mt-1" data-game="chanle">Chẵn Lẻ</button>
                    <button class="btn btn-default mt-1" data-game="chanle2">Chẵn Lẻ 2</button>
                    <button class="btn btn-default mt-1" data-game="taixiu">Tài xỉu</button>
                    <button class="btn btn-default mt-1" data-game="taixiu2">Tài xỉu 2</button>
                    <button class="btn btn-default mt-1" data-game="lo">Lô</button>
                    <button class="btn btn-default mt-1" data-game="x3">1 phần 3</button>
                    <button class="btn btn-default mt-1" data-game="hieu2so">Hiệu</button>
                    <button class="btn btn-default mt-1" data-game="xien">Xiên</button>
                    <button class="btn btn-default mt-1" data-game="xsmb">XSMB</button>
                    <button class="btn btn-default mt-1" data-game="doanso">Đoán số</button>
                </div>
                <div class="text-center mt-5" role="group">
                    {{-- <button class="btn btn-primary mt-1 p-3" data-minigame="day_mission" style="position: relative;">
                        Nhiệm Vụ Ngày
                        <b class="text-danger"
                            style="position: absolute; margin-left: auto; margin-right: auto; text-align: center; left: 0px; right: 0px; top: 35px; font-size: 9px;">
                            <font color="red">(NEW)</font>
                        </b>
                    </button> --}}
                    <button class="btn btn-primary mt-1 p-3" data-toggle="modal" data-target="#exampleModal"
                        style="position: relative;">
                        Nhập CODE Khuyến Mãi
                        <b class="text-danger"
                            style="position: absolute; margin-left: auto; margin-right: auto; text-align: center; left: 0px; right: 0px; top: 35px; font-size: 9px;">
                            <font color="red">(NEW)</font>
                        </b>
                    </button>
                </div>
                <div class="row justify-content-md-center box-cl">
                    <div class="col-md-6 mt-3 cl">
                        <div class="panel panel-primary">
                            <div class="panel-heading text-center" id="play">
                                CÁCH CHƠI
                            </div>
                            <div class="play-rules">
                            </div>
                            <div class="minigame-rules">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3 cl">
                        <div class="panel panel-primary">
                            <div class="panel-heading text-center">
                                TRẠNG THÁI MOMO
                            </div>

                            <div class="panel-body text-center">
                                <div class="text-left">Lưu ý: Khi đạt 190 GD hoặc 40 triệu sẽ tự đổi số.</div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover text-center">
                                        <thead>
                                            <tr class="bg-primary" role="row">
                                                <th class="text-center text-white">
                                                    Số điện thoại
                                                </th>
                                                <th class="text-center text-white">
                                                    Trạng thái
                                                </th>
                                                <th class="text-center text-white">
                                                    Giao dịch
                                                </th>
                                                <th class="text-center text-white">
                                                    Hạn mức
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="momo-status">
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center">
                                    <div class="form-group">
                                        <label for="tran_id">Nhập mã giao dịch</label>
                                        <input type="number" class="form-control" name="tran_id"
                                            placeholder="Mã giao dịch: Ví dụ 11223344556">
                                        <small id="checkHelp" class="form-text text-muted">Nhập mã giao dịch của bạn
                                            để
                                            kiểm tra.</small>
                                    </div>
                                    <button class="btn btn-primary mb-2 check-tran"
                                        onclick="DUNGA.check_tranid()">Kiểm tra</button>
                                    <div class="hidden more_infomation">
                                        <div class="mt-3">
                                            <small class="form-text text-danger">
                                                Vui lòng nhập thêm thông tin để kiểm tra:
                                            </small>
                                            <input type="text" class="form-control" name="receiver"
                                                placeholder="Số điện thoại hệ thống">
                                            <small class="form-text text-muted">Số điện thoại của <b
                                                    class="text-danger">Hệ thống</b> bạn chuyển tiền vào. <b
                                                    class="text-danger">Không</b> phải số của bạn.</small>
                                        </div>
                                        <button class="btn btn-primary mb-2 check-tran-2"
                                            onclick="DUNGA.check_tranid2()">Tiếp tục</button>
                                    </div>
                                    <div id="result-check" style="margin-top: 5px;">
                                    </div>
                                </div>
                                <div>
                                    <div class="alert alert-info text-center">
                                        <style= "display: block">
                                            Nếu quá 10' chưa nhận được tiền vui lòng dán mã vào đây kiểm tra.
                                    </div>
                                    <div id="contact" class="mt-5">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 text-center panel panel-primary">
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <div class="text-center mb-3">
                                <h3 class="text-uppercase">
                                    LỊCH SỬ THẮNG
                                </h3>
                            </div>
                            <div class="text-center font-weight-bold m-3"><b>Làm mới sau <span
                                        class="text-danger coundown-time">0</span> s</b></div>
                            <center class="" style="width: 76%;margin: auto;">
                                <marquee>
                                    <b id="msg_history_hu"></b>
                                </marquee>
                            </center>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover text-center">
                                    <thead>
                                        <tr class="bg-primary" role="row">
                                            <th class="text-center text-white">
                                                Mã định danh
                                            </th>
                                            <th class="text-center text-white">
                                                Tiền đặt
                                            </th>
                                            <th class="text-center text-white">
                                                Tiền thắng
                                            </th>
                                            <th class="text-center text-white">
                                                Nội dung
                                            </th>
                                            <th class="text-center text-white">
                                                Trạng thái
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="history">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary week_top hidden">
                    <div class="panel-heading text-center">
                        <h4>TOP TUẦN</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover text-center">
                                <thead>
                                    <tr role="row" class="bg-primary">
                                        <th class="text-center text-white">TOP</th>
                                        <th class="text-center text-white">Mã định danh</th>
                                        <th class="text-center text-white">Số tiền</th>
                                        <th class="text-center text-white">Phần thưởng</th>
                                    </tr>
                                </thead>
                                <tbody role="alert" aria-live="polite" aria-relevant="all" id="week_top"
                                    class="text-center">
                                </tbody>
                            </table>
                            <div class="text-center">
                                <b class="text-danger">Phần thưởng TOP sẽ dược trao vào 23:59 Chủ Nhật hàng tuần.</b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5 panel panel-primary">
            </div>
            <div id="hu-left-display"
                style="position: fixed; bottom: 15px; left: 15px; z-index: 1000; cursor: pointer; width: 15%;"
                class="hidden">
                <div onclick="$('#hu-left-display').hide()" class="" style="left: 100%; position: absolute;">
                    <font color="red">
                        <big><b>[X]</b></big>
                    </font>
                </div>
                <b onclick="DUNGA.hu_click()">
                    <center><img class="jackpot" src="/upload/jackpot.gif" width="100%"
                            style="max-height: 130px;max-width: 150px;min-height: 50px; min-width:80px;" /></center>
                    <div class="text-center">
                        <p
                            style="border-top-right-radius: 30px; border-top-left-radius: 30px; border-radius: 30px; background: aquamarine; margin-top:10px; color:red; font-size: 20px">
                            Event hot</p>
                    </div>
                </b>
            </div>
        </div>
    </div>
    </div>
    
    <div class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="noteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="noteModalLabel">Thông báo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="note_modal">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đã hiểu</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="hu-info" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h3 class="modal-title"></h3>
                    <h2 class="text-danger"><b>JACKPOT</b></h2>
                </div>
                <div class="modal-body" id="result_hu">
                    <center><img class="jackpot" src="/upload/jackpot.gif" width="30%" style="" /></center>
                    <h6><strong>CÁCH CHƠI</strong></h6>
                    @if ($setting->amount5Same > 0)
                        <p>- Nếu bạn có đuôi số mã giao dịch là 5 số giống nhau như: <br>
                            <span>
                                <strong class="text-danger">11111,</strong>
                                <strong class="text-danger">22222,</strong>
                                <strong class="text-danger">33333,</strong>
                                <strong class="text-danger">44444,</strong>
                                <strong class="text-danger">55555,</strong>
                                <strong class="text-danger">66666,</strong>
                                <strong class="text-danger">77777,</strong>
                                <strong class="text-danger">88888,</strong>
                                <strong class="text-danger">99999</strong>
                            </span> thì bạn sẽ nhận được
                            <strong
                                class="text-danger"><span>{{ number_format($setting->amount5Same) }}đ</span></strong>
                        </p>
                    @endif
                    @if ($setting->amount4Same > 0)
                        <p>- Nếu bạn có đuôi số mã giao dịch là 4 số giống nhau như: <br>
                            <span>
                                <strong class="text-danger">1111,</strong>
                                <strong class="text-danger">2222,</strong>
                                <strong class="text-danger">3333,</strong>
                                <strong class="text-danger">4444,</strong>
                                <strong class="text-danger">5555,</strong>
                                <strong class="text-danger">6666,</strong>
                                <strong class="text-danger">7777,</strong>
                                <strong class="text-danger">8888,</strong>
                                <strong class="text-danger">9999</strong>
                            </span> thì bạn sẽ nhận được
                            <strong
                                class="text-danger"><span>{{ number_format($setting->amount4Same) }}đ</span></strong>
                        </p>
                    @endif
                    @if ($setting->amount3Same > 0)
                        <p>- Nếu bạn có đuôi số mã giao dịch là 3 số giống nhau như: <br>
                            <span>
                                <strong class="text-danger">111,</strong>
                                <strong class="text-danger">222,</strong>
                                <strong class="text-danger">333,</strong>
                                <strong class="text-danger">444,</strong>
                                <strong class="text-danger">555,</strong>
                                <strong class="text-danger">666,</strong>
                                <strong class="text-danger">777,</strong>
                                <strong class="text-danger">888,</strong>
                                <strong class="text-danger">999</strong>
                            </span> thì bạn sẽ nhận được
                            <strong
                                class="text-danger"><span>{{ number_format($setting->amount3Same) }}đ</span></strong>
                        </p>
                    @endif
                    @if ($setting->amount5Lobby > 0)
                        <p>- Nếu bạn có đuôi số mã giao dịch là sảnh 5 như: <br>
                            <span>
                                <strong class="text-danger">12345,</strong>
                                <strong class="text-danger">23456,</strong>
                                <strong class="text-danger">34567,</strong>
                                <strong class="text-danger">45678,</strong>
                                <strong class="text-danger">56789</strong>
                            </span> thì bạn sẽ nhận được
                            <strong
                                class="text-danger"><span>{{ number_format($setting->amount5Lobby) }}đ</span></strong>
                        </p>
                    @endif
                    @if ($setting->amount4Lobby > 0)
                        <p>- Nếu bạn có đuôi số mã giao dịch là sảnh 4 như: <br>
                            <span>
                                <strong class="text-danger">1234,</strong>
                                <strong class="text-danger">2345,</strong>
                                <strong class="text-danger">3456,</strong>
                                <strong class="text-danger">4567,</strong>
                                <strong class="text-danger">5678,</strong>
                                <strong class="text-danger">6789</strong>
                            </span> thì bạn sẽ nhận được
                            <strong
                                class="text-danger"><span>{{ number_format($setting->amount4Lobby) }}đ</span></strong>
                        </p>
                        @endif @if ($setting->amount3Lobby > 0)
                            <p>- Nếu bạn có đuôi số mã giao dịch là sảnh 3 như: <br>
                                <span>
                                    <strong class="text-danger">123,</strong>
                                    <strong class="text-danger">234,</strong>
                                    <strong class="text-danger">345,</strong>
                                    <strong class="text-danger">456,</strong>
                                    <strong class="text-danger">567,</strong>
                                    <strong class="text-danger">678,</strong>
                                    <strong class="text-danger">789</strong>
                                </span> thì bạn sẽ nhận được
                                <strong
                                    class="text-danger"><span>{{ number_format($setting->amount3Lobby) }}đ</span></strong>
                            </p>
                        @endif
                        <p>- Nếu bạn nổ hũ, tiền thưởng sẽ tự động trả đến bạn. Nếu sau 15 phút chưa nhận được tiền vui
                            lòng liên hệ admin.</p>
                        <p>(Lưu ý trương trình chỉ áp dụng trong ngày, qua ngày sẽ không được tính)</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" style="border-radius: 0;"
                        data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <div id="player" class="hidden"></div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="text-center">
                        <p style="line-height: 0.8;"></p>
                        <p style="modal-title text-center text-bold text-success"><b>CODE KHUYẾN MẠI</b></p>
                        <div class="form-group" id="non_query"
                            style="background-color:#f5f5f5 ; border-color: #ad4105; padding: 20px;">
                            <label for="partnerId">Mã code:</label>
                            <input type="text" class="form-control" name="giftcode" id="giftcode"
                                placeholder="ABCXYZ" />
                            <label for="partnerId" style="margin-top: 10px;">Số điện thoại:</label>
                            <input type="text" class="form-control" name="phoneCode" id="phoneCode"
                                placeholder="094xxxxxxx" />
                            <small id="partnerId" class="form-text text-muted" style="color: #ff0000">Nhập số điện
                                thoại của
                                bạn để kiểm tra và
                                nhận
                                thưởng.</small> <br />
                            <button class="btn btn-success check-day-mission" onclick="check_Giftcode()">Kiểm
                                Tra</button>
                        </div>
                        <div class="form-group" id="query_done" style="display: none;"></div>
                        <div class="form-group bg-warning" id="day_mission_querying" style="display: none;">Vui lòng
                            chờ...
                        </div>
                        <div class="occho" id="muc_huongdan">
                            1. Một số điện thoại chỉ được nhập 1 mã/ngày. <br>
                            2. Mã code khuyến mại sẽ tùy vào điều kiện để sử dụng, có thời hạn. <br>
                            3. Mã code khuyến mại sẽ được cấp theo các chương trình khuyến mại của hệ thống của chúng
                            tôi. <br>
                            4. Vui lòng liên hệ chát CSKH để biết thêm chi tết khi bạn nhận được CODE. <br>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    @endsection