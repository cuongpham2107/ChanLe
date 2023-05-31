@extends('master')
@section('main')
    <input type="hidden" name="main_session">
    <div class="navbar">
        <marquee width="100%" behavior="scroll"
            style="display: block;
            position: fixed;
            top: 70px;
            left: 15px;
            z-index: 1000;
            cursor: pointer;
            width: 100%;">
            <font color="white" style="text-shadow: 0 0 0.2em #ff0000, 0 0 0.2em #ff0000,  0 0 0.2em #ff0000">
                <b>{{ $setting->ads }}</b>
            </font>
        </marquee>
        <div class="container">
            <a class="navbar-brand navbar-brand-image" href="{{url('/')}}">
                <div class="hidden-xs">
                    <img src="{{ $setting->logo }}"
                        style="margin-top: 10px;
                        margin-bottom: 10px;
                        width: 180px;"
                        alt="chan le momo">
                </div>
                <div class="visible-xs">
                    <img src="{{ $setting->logo }}"
                        style="margin-top: 10px;
                        /* margin: 13px; */
                        width: 150px;"
                        alt="chan le momo">
                </div>
            </a>
        </div>
    </div>
    <div class="mainbar hidden-xs">
        <div class="container">
        </div>
    </div>

    <body class="" style="">
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
                            <h3 class="">Hệ Thống Lô Đề MoMo Tự Động Siêu Ngon</h3>
                            <h4 class="cursor">Đẳng Cấp Trả Thưởng Siêu Tốc !</h4>
                        </div>
                        <div class="text-center mt-5">
                        </div>
                    </div>
                    <div class="row justify-content-md-center box-cl">
                        <div class="col-md-6 mt-3 cl">
                            <div class="panel panel-primary">
                                <div class="panel-heading text-center">
                                    LÔ ĐỀ MIỀN BẮC
                                </div>
                                <div class="panel-body">
                                    <p>Hướng dẫn chơi Lô Đề tại {{ $setting->name }}:</p>
                                    <p>Kết quả trò chơi tính theo <b>Xổ Số Miền Bắc VN</b> được xổ vào 18:00 hằng ngày.</p>
                                    <h4>Cách chơi:</h4>
                                    <p>* Tương tự cách ghi lô đề truyền thống, bạn chọn số và đặt cược theo cú pháp ở phía
                                        dưới.</p>
                                    <p><b style="color:red;">* Lưu ý quan trọng:</b><br />
                                        Vui lòng ghi số trước 18:00, sau thời gian này số sẽ được tính vào ngày hôm
                                        sau.<br />
                                        <b style="color:blue;">* Tiền thắng sẽ tự động thanh toán vào 18:45 cùng
                                            ngày!</b><br />
                                    </p>
                                    <hr>
                                    <p style="color:blue;" class="text-center"><big><b><a
                                                    href="https://www.minhngoc.net.vn/ket-qua-xo-so/mien-bac.html"
                                                    target="_blank">Kết Quả Xổ Số Ngày : <b
                                                        id="date_now">nay</b></a></b></big></p><br />
                                    <div style="width:100%;text-align:center;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($lotteria->momo_receiver_phone != '')
                    <div class="row justify-content-md-center box-cl">
                        <div class="col-md-3 mt-3 text-center cl">
                            <div class="panel panel-primary">
                                <div class="panel-heading text-center">
                                    Cách chơi ĐÁNH LÔ Miền Bắc
                                </div>
                                <div class="panel-body">
                                    <div class="body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover text-center">
                                                <thead>
                                                    <tr role="row" class="bg-primary2">
                                                        <th class="text-center text-white bg-primary">Trò Chơi</th>
                                                        <th class="text-center text-white bg-primary">Cú Pháp</th>
                                                        <th class="text-center text-white bg-primary">2 số</th>
                                                        <th class="text-center text-white bg-primary">3 càng</th>
                                                        <th class="text-center text-white bg-primary">4 càng</th>
                                                    </tr>
                                                </thead>
                                                <tbody role="alert" aria-live="polite" aria-relevant="all" id="cuphap_lo"
                                                    class="">
                                                    <tr>
                                                        <td>LÔ</td>
                                                        <td>{{ $lotteria->syntax_lo }}</td>
                                                        <td>x{{ $lotteria->northern_lo_x2 }}</td>
                                                        <td>x{{ $lotteria->northern_lo_x3 }}</td>
                                                        <td>x{{ $lotteria->northern_lo_x4 }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <p><b style="color:blue;">* Chi tiết:</b><br />
                                            <b>Tỉ lệ cược đề 1:1 (cược tối thiếu {{ number_format($lotteria->min) }}đ)</b><br />
                                            Bạn đánh LÔ con 96, cú pháp như sau: <b
                                                style="color:red;">{{ $lotteria->syntax_lo }}_96</b>, cú pháp
                                            3 càng và 4 càng tương tự: <b
                                                style="color:red;">{{ $lotteria->syntax_lo }}_699</b>, <b
                                                style="color:red;">{{ $lotteria->syntax_lo }}_6999</b><br />
                                                Ví dụ bạn đánh Lô con 69 với 50,000đ, nếu bạn thắng 2 nháy sẽ nhận : 2 x 50,000 x {{$lotteria->northern_lo_x2}} =
                                                {{ number_format($lotteria->northern_lo_x2 * 50000 * 2) }}đ.
                                        </p>
                                        <hr>
                                        <table class="table table-striped table-bordered table-hover text-center">
                                            <thead>
                                                <tr role="row" class="bg-primary2">
                                                    <th class="text-center text-white bg-primary">Số điện thoại</th>
                                                    <th class="text-center text-white bg-primary">Trạng thái</th>
                                                    <th class="text-center text-white bg-primary">Tối thiểu</th>
                                                    <th class="text-center text-white bg-primary">Tối đa</th>
                                                </tr>
                                            </thead>
                                            <tbody role="alert" aria-live="polite" aria-relevant="all"
                                                id="phone-active-de" class="">
                                                <td id="p_27">
                                                    <b>{{ $lotteria->momo_receiver_phone }}</b> 
                                                    <span class="label label-success text-uppercase"
                                                        onclick="DUNGA.coppy('{{ $lotteria->momo_receiver_phone }}')"><i class="fa fa-clipboard"
                                                            aria-hidden="true"></i></span>
                                                    <span class="label label-success text-uppercase"
                                                        onclick="DUNGA.play('{{ $lotteria->momo_receiver_phone }}')"><i class="fa fa-play"
                                                            aria-hidden="true"></i></span>
                                                </td>
                                                <td><span class="label label-success text-uppercase">Hoạt động</span></td>
                                                <td>{{ number_format($lotteria->min) }}đ</td>
                                                <td>{{ number_format($lotteria->max) }}đ</td>
                                            </tbody>
                                            <h5 style="text-align:center;font-weight: bold;" id="timer3">Cập nhật liên tục
                                                <img src="https://img.upanh.tv/2022/09/26/loading_ab.gif" width="25px">
                                            </h5>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mt-3 text-center cl">
                            <div class="panel panel-primary">
                                <div class="panel-heading text-center">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            🍀 Cách chơi ĐÁNH ĐỀ Miền Bắc 🍭
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover text-center">
                                            <thead>
                                                <tr role="row" class="bg-primary2">
                                                    <th class="text-center text-white bg-primary">Trò Chơi</th>
                                                    <th class="text-center text-white bg-primary">Cú Pháp</th>
                                                    <th class="text-center text-white bg-primary">2 số</th>
                                                    <th class="text-center text-white bg-primary">3 càng</th>
                                                    <th class="text-center text-white bg-primary">4 càng</th>
                                                </tr>
                                            </thead>
                                            <tbody role="alert" aria-live="polite" aria-relevant="all" id="cuphap_de"
                                                class="">
                                                <tr>
                                                    <td>ĐỀ</td>
                                                    <td>{{ $lotteria->syntax_de }}</td>
                                                    <td>x{{ $lotteria->northern_de_x2 }}</td>
                                                    <td>x{{ $lotteria->northern_de_x3 }}</td>
                                                    <td>x{{ $lotteria->northern_de_x4 }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p><b style="color:blue;">* Chi tiết:</b><br />
                                        <b>Tỉ lệ cược đề 1:1 (cược tối thiếu {{ number_format($lotteria->min) }}đ)</b><br />
                                        Bạn đánh ĐỀ con 38, cú pháp như sau: <b
                                            style="color:red;">{{ $lotteria->syntax_de }}_38</b>, cú pháp 3
                                        càng và 4 càng tương tự: <b style="color:red;">{{ $lotteria->syntax_de }}_369</b>,
                                        <b style="color:red;">{{ $lotteria->syntax_de }}_3696</b><br />
                                        Ví dụ bạn đánh Đề con 69 với 50,000đ, nếu bạn thắng 1 nháy sẽ nhận : 50,000 x {{$lotteria->northern_de_x2}} =
                                        {{ number_format($lotteria->northern_de_x2 * 50000) }}đ.
                                    </p>
                                    <hr>
                                    <table class="table table-striped table-bordered table-hover text-center">
                                        <thead>
                                            <tr role="row" class="bg-primary2">
                                                <th class="text-center text-white bg-primary">Số điện thoại</th>
                                                <th class="text-center text-white bg-primary">Trạng thái</th>
                                                <th class="text-center text-white bg-primary">Tối thiểu</th>
                                                <th class="text-center text-white bg-primary">Tối đa</th>
                                            </tr>
                                        </thead>
                                        <tbody role="alert" aria-live="polite" aria-relevant="all"
                                            id="phone-active-de" class="">
                                            <td id="p_27">
                                                <b>{{ $lotteria->momo_receiver_phone }}</b> 
                                                <span class="label label-success text-uppercase"
                                                    onclick="DUNGA.coppy('{{ $lotteria->momo_receiver_phone }}')"><i class="fa fa-clipboard"
                                                        aria-hidden="true"></i></span>
                                                <span class="label label-success text-uppercase"
                                                    onclick="DUNGA.play('{{ $lotteria->momo_receiver_phone }}')"><i class="fa fa-play"
                                                        aria-hidden="true"></i></span>
                                            </td>
                                            <td><span class="label label-success text-uppercase">Hoạt động</span></td>
                                            <td>{{ number_format($lotteria->min) }}đ</td>
                                            <td>{{ number_format($lotteria->max) }}đ</td>
                                        </tbody>
                                        <h5 style="text-align:center;font-weight: bold;" id="timer3">Cập nhật liên tục
                                            <img src="https://img.upanh.tv/2022/09/26/loading_ab.gif" width="25px">
                                        </h5>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary week_top">
                                <div class="panel-heading text-center">
                                    <h4>LÔ ĐỀ XỔ SỐ TỈNH</h4>
                                </div>
                                <div class="panel-body">
                                    <p>Hướng dẫn chơi Lô Đề tại {{ $setting->name }}:</p>
                                    <p>Kết quả trò chơi tính theo <b>Xổ số kiến thiết các tỉnh VN</b> được xổ vào 16:30 -> 17:30 hằng ngày.</p>
                                    <h4>Cách chơi:</h4>
                                    <p>* Tương tự cách ghi lô đề truyền thống, bạn chọn số và đặt cược theo cú pháp ở phía
                                        dưới.</p>
                                    <p><b style="color:red;">* Lưu ý quan trọng:</b><br />
                                        Các tỉnh miền Trung lòng ghi số trước 17:00, sau thời gian này số sẽ được tính vào ngày hôm
                                        sau.<br />
                                        Các tỉnh miền Nam lòng ghi số trước 16:00, sau thời gian này số sẽ được tính vào ngày hôm
                                        sau.<br />
                                        <b style="color:blue;">* Tiền thắng sẽ tự động thanh toán vào 18:45 cùng
                                            ngày!</b><br />
                                    </p>
                                    <hr>
                                    <p style="color:blue;" class="text-center"><big><b><a
                                                    href="https://www.minhngoc.net.vn/ket-qua-xo-so/mien-trung.html"
                                                    target="_blank">Kết Quả Xổ Số Ngày : <b
                                                        id="date_now">nay (Miền Trung)</b></a></b></big></p><br />
                                    <p style="color:blue;" class="text-center"><big><b><a
                                        href="https://www.minhngoc.net.vn/ket-qua-xo-so/mien-nam.html"
                                        target="_blank">Kết Quả Xổ Số Ngày : <b
                                            id="date_now">nay (Miền Nam)</b></a></b></big></p><br />
                                    <div style="width:100%;text-align:center;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-md-center box-cl">
                        <div class="col-md-3 mt-3 text-center cl">
                            <div class="panel panel-primary">
                                <div class="panel-heading text-center">
                                    Cách chơi ĐÁNH LÔ TỈNH
                                </div>
                                <div class="panel-body">
                                    <div class="body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover text-center">
                                                <thead>
                                                    <tr role="row" class="bg-primary2">
                                                        <th class="text-center text-white bg-primary">Trò Chơi</th>
                                                        <th class="text-center text-white bg-primary">Cú Pháp</th>
                                                        <th class="text-center text-white bg-primary">2 số</th>
                                                        <th class="text-center text-white bg-primary">3 càng</th>
                                                        <th class="text-center text-white bg-primary">4 càng</th>
                                                    </tr>
                                                </thead>
                                                <tbody role="alert" aria-live="polite" aria-relevant="all"
                                                    id="cuphap_lo" class="">
                                                    <tr>
                                                        <td>LÔ</td>
                                                        <td>{{ $lotteria->syntax_lo }}_Tỉnh_Mã-Cược</td>
                                                        <td>x{{ $lotteria->province_lo_x2 }}</td>
                                                        <td>x{{ $lotteria->province_lo_x3 }}</td>
                                                        <td>x{{ $lotteria->province_lo_x4 }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <p><b style="color:blue;">* Chi tiết:</b><br />
                                            <b>Tỉ lệ cược đề 1:1 (cược tối thiếu {{ number_format($lotteria->min) }}đ)</b><br />
                                            Bạn đánh LÔ con 96 tỉnh HỒ CHÍ MINH , cú pháp như sau: <b
                                                style="color:red;">{{ $lotteria->syntax_lo }}_HCM_96</b>, cú pháp 3 càng
                                            và 4 càng tương tự: <b
                                                style="color:red;">{{ $lotteria->syntax_lo }}_HCM_699</b>, <b
                                                style="color:red;">{{ $lotteria->syntax_lo }}_HCM_6999</b><br />
                                                Ví dụ bạn đánh Lô con 96 với 50,000đ, nếu bạn thắng 2 nháy sẽ nhận : 2 x 50,000 x {{$lotteria->province_lo_x2}} =
                                                {{ number_format($lotteria->province_lo_x2 * 50000 * 2) }}đ.
                                        </p>
                                        <hr>
                                        <table class="table table-striped table-bordered table-hover text-center">
                                            <thead>
                                                <tr role="row" class="bg-primary2">
                                                    <th class="text-center text-white bg-primary">Số điện thoại</th>
                                                    <th class="text-center text-white bg-primary">Trạng thái</th>
                                                    <th class="text-center text-white bg-primary">Tối thiểu</th>
                                                    <th class="text-center text-white bg-primary">Tối đa</th>
                                                </tr>
                                            </thead>
                                            <tbody role="alert" aria-live="polite" aria-relevant="all"
                                                id="phone-active-de" class="">
                                                <td id="p_27">
                                                    <b>{{ $lotteria->momo_receiver_phone }}</b> 
                                                    <span class="label label-success text-uppercase"
                                                        onclick="DUNGA.coppy('{{ $lotteria->momo_receiver_phone }}')"><i class="fa fa-clipboard"
                                                            aria-hidden="true"></i></span>
                                                    <span class="label label-success text-uppercase"
                                                        onclick="DUNGA.play('{{ $lotteria->momo_receiver_phone }}')"><i class="fa fa-play"
                                                            aria-hidden="true"></i></span>
                                                </td>
                                                <td><span class="label label-success text-uppercase">Hoạt động</span></td>
                                                <td>{{ number_format($lotteria->min) }}đ</td>
                                                <td>{{ number_format($lotteria->max) }}đ</td>
                                            </tbody>
                                            <h5 style="text-align:center;font-weight: bold;" id="timer3">Cập nhật liên tục
                                                <img src="https://img.upanh.tv/2022/09/26/loading_ab.gif" width="25px">
                                            </h5>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mt-3 text-center cl">
                            <div class="panel panel-primary">
                                <div class="panel-heading text-center">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            🍀 Cách chơi ĐÁNH ĐỀ TỈNH 🍭
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover text-center">
                                            <thead>
                                                <tr role="row" class="bg-primary2">
                                                    <th class="text-center text-white bg-primary">Trò Chơi</th>
                                                    <th class="text-center text-white bg-primary">Cú Pháp</th>
                                                    <th class="text-center text-white bg-primary">2 số</th>
                                                    <th class="text-center text-white bg-primary">3 càng</th>
                                                    <th class="text-center text-white bg-primary">4 càng</th>
                                                </tr>
                                            </thead>
                                            <tbody role="alert" aria-live="polite" aria-relevant="all" id="cuphap_de"
                                                class="">
                                                <tr>
                                                    <td>ĐỀ</td>
                                                    <td>{{ $lotteria->syntax_de }}_Tỉnh_SỐ-CƯỢC</td>
                                                    <td>x{{ $lotteria->province_de_x2 }}</td>
                                                    <td>x{{ $lotteria->province_de_x3 }}</td>
                                                    <td>x{{ $lotteria->province_de_x4 }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p><b style="color:blue;">* Chi tiết:</b><br />
                                        <b>Tỉ lệ cược đề 1:1 (cược tối thiếu {{ number_format($lotteria->min) }}đ)</b><br />
                                        Bạn đánh ĐỀ TỈNH HỒ CHÍ MINH con 38, cú pháp như sau: <b
                                            style="color:red;">{{ $lotteria->syntax_de }}_HCM_38</b>, cú pháp 3 càng và 4
                                        càng tương tự: <b style="color:red;">{{ $lotteria->syntax_de }}_HCM_369</b>, <b
                                            style="color:red;">{{ $lotteria->syntax_de }}_HCM_3696</b><br />
                                            Ví dụ bạn đánh Đề con 38 với 50,000đ, nếu bạn thắng 1 nháy sẽ nhận : 50,000 x {{$lotteria->province_de_x2}} =
                                            {{ number_format($lotteria->province_de_x2 * 50000) }}đ.
                                    </p>
                                    <hr>
                                    <table class="table table-striped table-bordered table-hover text-center">
                                        <thead>
                                            <tr role="row" class="bg-primary2">
                                                <th class="text-center text-white bg-primary">Số điện thoại</th>
                                                <th class="text-center text-white bg-primary">Trạng thái</th>
                                                <th class="text-center text-white bg-primary">Tối thiểu</th>
                                                <th class="text-center text-white bg-primary">Tối đa</th>
                                            </tr>
                                        </thead>
                                        <tbody role="alert" aria-live="polite" aria-relevant="all"
                                            id="phone-active-de" class="">
                                            <td id="p_27">
                                                <b>{{ $lotteria->momo_receiver_phone }}</b> 
                                                <span class="label label-success text-uppercase"
                                                    onclick="DUNGA.coppy('{{ $lotteria->momo_receiver_phone }}')"><i class="fa fa-clipboard"
                                                        aria-hidden="true"></i></span>
                                                <span class="label label-success text-uppercase"
                                                    onclick="DUNGA.play('{{ $lotteria->momo_receiver_phone }}')"><i class="fa fa-play"
                                                        aria-hidden="true"></i></span>
                                            </td>
                                            <td><span class="label label-success text-uppercase">Hoạt động</span></td>
                                            <td>{{ number_format($lotteria->min) }}đ</td>
                                            <td>{{ number_format($lotteria->max) }}đ</td>
                                        </tbody>
                                        <h5 style="text-align:center;font-weight: bold;" id="timer3">Cập nhật liên tục
                                            <img src="https://img.upanh.tv/2022/09/26/loading_ab.gif" width="25px">
                                        </h5>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <br />
                    
                    @if (count($history_win) > 0)
                    <div class="row justify-content-md-center box-cl">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading text-center">
                                    <h4>Lịch sử thắng</h4>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-striped table-bordered table-hover text-center">
                                        <thead>
                                            <tr role="row" class="bg-primary2">
                                                <th class="text-center text-white bg-primary">Thời gian</th>
                                                <th class="text-center text-white bg-primary">Số điện thoại</th>
                                                <th class="text-center text-white bg-primary">Trò chơi</th>
                                                <th class="text-center text-white bg-primary">Số</th>
                                                <th class="text-center text-white bg-primary">Đài</th>
                                                <th class="text-center text-white bg-primary">Tiền cược</th>
                                                <th class="text-center text-white bg-primary">Tiền thắng</th>
                                            </tr>
                                        </thead>
                                        <tbody role="alert" aria-live="polite" aria-relevant="all" id="phone-active-de" class="">
                                            @foreach ($history_win as $item)
                                            @if ($item->lotteriaGame && $item->lotteriaGame->province)
                                            <tr>
                                                <td>{{$item->created_at->format('H:i:s d/m/Y')}}</td>
                                                <td>{{Str::substr($item->partnerId, 0, -4).'****'}}</td>
                                                <td>{{$item->lotteriaGame->type == 'lo' ? 'Lô' : 'Đề'}}</td>
                                                <td>{{$item->lotteriaGame->predicted_number }}</td>
                                                <td>{{$item->lotteriaGame->province->name }}</td>
                                                <td>{{number_format($item->amount). 'đ' }}</td>
                                                <td>{{number_format($item->receive). 'đ' }}</td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                            @endif
                            @if (count($history_play) > 0)
                            <div class="row justify-content-md-center box-cl">
                                <div class="col-md-12">
                            <div class="panel panel-primary week_top">
                                <div class="panel-heading text-center">
                                    <h4>Lịch sử chơi</h4>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-striped table-bordered table-hover text-center">
                                        <thead>
                                            <tr role="row" class="bg-primary2">
                                                <th class="text-center text-white bg-primary">Thời gian</th>
                                                <th class="text-center text-white bg-primary">Số điện thoại</th>
                                                <th class="text-center text-white bg-primary">Trò chơi</th>
                                                <th class="text-center text-white bg-primary">Số</th>
                                                <th class="text-center text-white bg-primary">Đài</th>
                                                <th class="text-center text-white bg-primary">Tiền cược</th>
                                            </tr>
                                        </thead>
                                        <tbody role="alert" aria-live="polite" aria-relevant="all" id="phone-active-de" class="">
                                            @foreach ($history_play as $item)
                                            @if ($item->historyPlay && $item->province)
                                            <tr>
                                                <td>{{$item->created_at->format('H:i:s d/m/Y')}}</td>
                                                <td>{{Str::substr($item->historyPlay->partnerId, 0, -4).'****'}}</td>
                                                <td>{{$item->type == 'lo' ? 'Lô' : 'Đề'}}</td>
                                                <td>{{$item->predicted_number }}</td>
                                                <td>{{$item->province->name }}</td>
                                                <td>{{number_format($item->historyPlay->amount). 'đ' }}</td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                            @endif
                    <div class="row justify-content-md-center box-cl">
                        <div class="col-md-12">
                            <div class="panel panel-primary week_top">
                                <div class="panel-heading text-center">
                                    <h4>DANH SÁCH MÃ TỈNH</h4>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-striped table-bordered table-hover text-center">
                                        <thead>
                                            <tr role="row" class="bg-primary2">
                                                <th class="text-center text-white bg-primary">STT</th>
                                                <th class="text-center text-white bg-primary">Tên</th>
                                                <th class="text-center text-white bg-primary">Mã tỉnh thành</th>
                                            </tr>
                                        </thead>
                                        <tbody role="alert" aria-live="polite" aria-relevant="all" id="phone-active-de" class="">
                                            @foreach ($listProvince as $item)
                                            <tr>
                                                <td>{{$item->id}}</td>
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->key_word}}</td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                .grecaptcha-badge {
                    visibility: hidden;
                }

                .my-element {
                    --animate-repeat: 20000;
                }

                center.solid {
                    border-style: solid;
                }
            </style>
        </div>
        <script src="gd/js/jquery-1.10.1.min.js"></script>
        <script src="gd/js/cc.js"></script>
        <script src="gd/js/bootstrap.min.js"></script>
        <script src="gd/js/moment.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.4/dist/simple-notify.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#modal_thongbao').modal('show')
                socket()
                $('[data-toggle="tooltip"]').tooltip()
            });

            initAjax = (data_ajax) => {
                $.ajax(data_ajax);
            }

            function getmomo() {
                initAjax({
                    url: "/get/momo",
                    method: "POST",
                    success: function(data) {
                        $(".return-momo").html(data);
                    }
                });
            }

            function trangthai() {
                initAjax({
                    url: "/get/momo",
                    data: {
                        id: "trangthai",
                    },
                    method: "post",
                    success: function(data) {
                        $("#phone-table2").html(data);
                    }
                });
            }


            function hu_click() {
                $("#hu-info").modal("show");
            }

            function socket() {
                getmomo();
                trangthai();
                initAjax({
                    url: "/get/history",
                    method: "POST",
                    success: function(data) {
                        $("#load_data_play").html(data);
                    }
                });
                initAjax({
                    url: "/get/top",
                    method: "POST",
                    success: function(data) {
                        $("#week_top").html(data);
                    }
                });
            }

            function check_tranid() {
                var tran_id = document.getElementById("tran_id").value;
                initAjax({
                    url: "/api/checkhis",
                    data: {
                        id: tran_id,
                        get: "his",
                    },
                    method: "GET",
                    success: function(data) {
                        $("#result-check").html(data);
                    }
                })
            };

            function check_even(id) {
                var phone = document.getElementById("phoneCode").value;
                initAjax({

                    url: "/api/checkeven",
                    data: {
                        id: id,
                        phone: phone,
                    },
                    method: "GET",
                    beforeSend: function() {
                        $("#query_done").show();
                        $("#non_query").hide();
                    },
                    success: function(data) {


                        $("#result-gifcode").html(data);
                        $("#query_done").hide();
                        $("#non_query").show();
                    }
                })
            };


            function refund() {

                alert("Chức năng bảo trì !! IBOX AD");
            }

            function number_format(_0x90f8x4) {
                var _0x90f8x20 = String(_0x90f8x4);
                var _0x90f8x21 = _0x90f8x20['length'];
                var _0x90f8x22 = 0;
                var _0x90f8x23 = '';
                var _0x90f8xa;
                for (_0x90f8xa = _0x90f8x21 - 1; _0x90f8xa >= 0; _0x90f8xa--) {
                    _0x90f8x22 += 1;
                    aa = _0x90f8x20[_0x90f8xa];
                    if (_0x90f8x22 % 3 == 0 && _0x90f8x22 != 0 && _0x90f8x22 != _0x90f8x21) {
                        _0x90f8x23 = '.' + aa + _0x90f8x23
                    } else {
                        _0x90f8x23 = aa + _0x90f8x23
                    }
                };
                return _0x90f8x23
            }

            $(document).ready(function() {
                function isJsonString(str) {
                    try {
                        JSON.parse(str);
                    } catch (e) {
                        return false;
                    }
                    return true;
                }

                $('button[server-action=change]').click(function() {
                    let button = $(this);
                    let id = button.attr('data-game');

                    selection_server = id;
                    selection_rate = button.attr('server-rate');
                    $('.game').removeClass('active');
                    $(`.game[game-tab=${id}]`).addClass('active');
                    $('.momo').removeClass('return-momo');
                    $(`.momo[game-tab=${id}]`).addClass('return-momo');
                    $('button[server-action=change]').attr('class', 'btn btn-default');
                    button.attr('class', 'btn btn-info');
                    getmomo();
                });
                $('button[data-game=CLTX]').click();
            });

            function copyStringToClipboard(str) {
                // Create new element
                var el = document.createElement('textarea');
                // Set value (string to be copied)
                el.value = str;
                // Set non-editable to avoid focus and move outside of view
                el.setAttribute('readonly', '');
                el.style = {
                    position: 'absolute',
                    left: '-9999px'
                };
                document.body.appendChild(el);
                // Select text inside element
                el.select();
                // Copy text to clipboard
                document.execCommand('copy');
                // Remove temporary element
                document.body.removeChild(el);
            }

            function play(str) {
                window.open(`https://nhantien.momo.vn/${str}`, '_blank')
            }
            number_format = (number) => {
                return parseInt(number).toLocaleString('it-IT', {});
            }

            function coppy(text, min, max) {
                copyStringToClipboard(text);
                alert('Đã sao chép số điện thoại: ' + text + '. Chỉ chơi từ: ' + number_format(min) + ' VNĐ đến ' +
                    number_format(max) +
                    ' VNĐ chúc bạn may mắn ');

            }


            function hihi() {
                const element = document.getElementById("content");
                element.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }

            function typeWriter(id, ar) {
                var element = $("#" + id),
                    aString = ar[a],
                    eHeader = element.children("h2"),
                    eParagraph = element.children("h4");
                if (!isBackspacing) {
                    if (i < aString.length) {
                        if (aString.charAt(i) == "|") {
                            isParagraph = true;
                            eHeader.removeClass("cursor");
                            eParagraph.addClass("cursor");
                            i++;
                            setTimeout(function() {
                                typeWriter(id, ar);
                            }, speedBetweenLines);
                        } else {
                            if (!isParagraph) {
                                eHeader.text(eHeader.text() + aString.charAt(i));
                            } else {
                                eParagraph.text(eParagraph.text() + aString.charAt(i));
                            }
                            i++;
                            setTimeout(function() {
                                typeWriter(id, ar);
                            }, speedForward);
                        }
                    } else if (i == aString.length) {
                        isBackspacing = true;
                        setTimeout(function() {
                            typeWriter(id, ar);
                        }, speedWait);
                    }
                } else {
                    if (eHeader.text().length > 0 || eParagraph.text().length > 0) {
                        if (eParagraph.text().length > 0) {
                            eParagraph.text(eParagraph.text().substring(0, eParagraph.text().length - 1));
                        } else if (eHeader.text().length > 0) {
                            eParagraph.removeClass("cursor");
                            eHeader.addClass("cursor");
                            eHeader.text(eHeader.text().substring(0, eHeader.text().length - 1));
                        }
                        setTimeout(function() {
                            typeWriter(id, ar);
                        }, speedBackspace);
                    } else {
                        isBackspacing = false;
                        i = 0;
                        isParagraph = false;
                        a = (a + 1) % ar.length;
                        setTimeout(function() {
                            typeWriter(id, ar);
                        }, 50);
                    }
                }
            }
            $(document).ready(function() {
                function Timer(fn, t) {
                    var timerObj = setInterval(fn, t);
                    this.stop = function() {
                        if (timerObj) {
                            clearInterval(timerObj);
                            timerObj = null;
                        }
                        return this;
                    }
                    this.start = function() {
                        if (!timerObj) {
                            this.stop();
                            timerObj = setInterval(fn, t);
                        }
                        return this;
                    }
                    this.reset = function(newT = t) {
                        t = newT;
                        return this.stop().start();
                    }
                }
                var timeleft = 5;
                var downloadTimer = new Timer(function() {
                    if (timeleft <= 0) {
                        socket();
                        downloadTimer.stop();
                        const elements = document.querySelectorAll('.coundown-time');
                        elements.forEach(el => {
                            el.innerHTML = 0;
                        });
                        $.when(function(xhr) {}, ).then(function() {
                            const elements2 = document.querySelectorAll('.coundown-time');
                            elements2.forEach(el => {
                                el.innerHTML = 5;
                            });
                            timeleft = 5;
                            downloadTimer.start();
                        });
                    } else {
                        const elements3 = document.querySelectorAll('.coundown-time');
                        elements3.forEach(el => {
                            el.innerHTML = timeleft;
                        });
                    }
                    timeleft -= 1;
                }, 500);
            });
            day_limit = function() {
                let times = $("#hmln[attr-name=times]").toggleClass("hidden");
                let amount = $("#hmln[attr-name=amount]").toggleClass("hidden");
            }
            setInterval(day_limit, 5000);
        </script>
        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = 'https://embed.tawk.to/6300fbb854f06e12d88fc4bc/1gatteigo';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>
    @endsection
