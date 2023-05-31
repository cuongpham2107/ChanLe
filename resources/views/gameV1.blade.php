<?php
use Carbon\Carbon;
use App\Models\HistoryPlay;
use App\Models\HistoryBank;
use App\Models\Setting;
?>
<div class="panel-body game" style="padding-top: 10px; padding-bottom: 20px;" game-tab="chanle2">
    <div class='text-left'>- <b>Chẵn lẻ 2</b> là một game tính kết quả bằng<b> 1 số cuối mã giao dịch</b>.</br><b>- Mỗi
            game có hạn mức khác nhau nên anh em chú ý</b></br>Cách chơi vô cùng đơn giản :</br>-Chuyển tiền vào một
        trong các tài khoản ở <code>danh sách số</code> bên dưới
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover text-center mb-0">
            <thead>
                <th class="text-center text-white bg-primary">Số điện thoại</th>
                <th class="text-center text-white bg-primary">Tối thiểu</th>
                <th class="text-center text-white bg-primary">Tối đa</th>
            </thead>
            <tbody aria-live="polite" aria-relevant="all" class="result-table-10" role="alert">
                @foreach ($momo as $row)
                    <tr>
                        <td id="mm_{{ $row->phone }}">
                            <b id="mln">
                                {{ $row->phone }} <b id="hmln" attr-name="amount">
                                    <font color="green">
                                        {{ number_format($row->amount) }}
                                    </font>/<font color="6861b1">
                                        46M</font>
                                </b>
                                <b id="hmln" class="hidden" attr-name="times">
                                    <font color="red">
                                        {{ $row->times }}
                                    </font>/<font color="6861b1">190 Giao dịch
                                    </font>
                                </b>
                            </b>
                            <span class="label label-success text-uppercase"
                                onclick="DUNGA.coppy('{{ $row->phone }}')"><i class="fa fa-clipboard"
                                    aria-hidden="true"></i></span>
                            {{-- <span class="label label-success text-uppercase"
                                onclick="DUNGA.play('{{ $row->phone }}')"><i class="fa fa-play"
                                    aria-hidden="true"></i></span> --}}
                        </td>
                        <td>{{ number_format($row->min) }} VNĐ</td>
                        <td>{{ number_format($row->max) }} VNĐ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center font-weight-bold">
        <b>Làm mới sau <span class="text-danger coundown-time">0</span> s</b>
    </div>
    <p class="mt-3">
        - Nội dung chuyển: <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-chan"></span><span
                class="fa-stack-1x text-white">{{ explode('|', $setting->contentCL2)[0] }}</span></span> hoặc
        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-le"></span><span
                class="fa-stack-1x text-white">{{ explode('|', $setting->contentCL2)[1] }}</span></span> (nếu đuôi mã
        giao dịch có các số sau)
       
    </p>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover text-center">
            <thead>
                <th class="text-center text-white bg-primary">Nội dung</th>
                <th class="text-center text-white bg-primary">1 Số cuối</th>
                <th class="text-center text-white bg-primary">Tiền nhận</th>
            </thead>
            <tbody aria-live="polite" aria-relevant="all" class="" id="result-table" role="alert">
                <tr>
                    <td>
                        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-chan"> </span> <span
                                class="fa-stack-1x text-white comment-chan">{{ explode('|', $setting->contentCL2)[0] }}</span></span>
                    </td>
                    <td><code>0</code> - <code>2</code> - <code>4</code> - <code>6</code> - <code>8</code></td>
                    <td><b>{{ $setting->ratioCL2 }}</b></td>
                </tr>
                <tr>
                    <td>
                        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-le"> </span><span
                                class="fa-stack-1x text-white comment-le">{{ explode('|', $setting->contentCL2)[1] }}</span></span>
                    </td>
                    <td><code>1</code> - <code>3</code> - <code>5</code> - <code>7</code> - <code>9</code></td>
                    <td><b>{{ $setting->ratioCL2 }}</b></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="text-left"> - Tiền thắng sẽ = <b>Tiền cược*{{ $setting->ratioCL2 }}</b><br> <b style="color:red">- Lưu
            ý :</b> Mức cược mỗi số khác nhau, nếu chuyển sai hạn mức hoặc sai nội dung sẽ không được hoàn tiền.<br>-
        Đặc biệt: bạn có <b style="color:blue">10%</b> cơ hội được trả thưởng 2 lần <img src="/upload/hot.gif"
            width="35px">
    </div>
</div> 
{{-- End chanle2 --}}


<div class="panel-body game" style="padding-top: 10px; padding-bottom: 20px;" game-tab="chanle">
    <div class='text-left'>- <b>Chẵn lẻ</b> là một game tính kết quả bằng<b> 1 số cuối mã giao dịch</b>.</br><b>- Mỗi
            game có hạn mức khác nhau nên anh em chú ý</b></br>Cách chơi vô cùng đơn giản :</br>-Chuyển tiền vào một
        trong các tài khoản ở <code>danh sách số</code> bên dưới
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover text-center mb-0">
            <thead>
                <th class="text-center text-white bg-primary">Số điện thoại</th>
                <th class="text-center text-white bg-primary">Tối thiểu</th>
                <th class="text-center text-white bg-primary">Tối đa</th>
            </thead>
            <tbody aria-live="polite" aria-relevant="all" class="result-table-10" role="alert">
                @foreach ($momo as $row)
                    <tr>
                        <td id="mm_{{ $row->phone }}">
                            <b id="mln">
                                {{ $row->phone }} <b id="hmln" attr-name="amount">
                                    <font color="green">
                                        {{ number_format($row->amount) }}
                                    </font>/<font color="6861b1">
                                        46M</font>
                                </b>
                                <b id="hmln" class="hidden" attr-name="times">
                                    <font color="red">
                                        {{ $row->times }}
                                    </font>/<font color="6861b1">190 Giao dịch
                                    </font>
                                </b>
                            </b>
                            <span class="label label-success text-uppercase"
                                onclick="DUNGA.coppy('{{ $row->phone }}')"><i class="fa fa-clipboard"
                                    aria-hidden="true"></i></span>
                            {{-- <span class="label label-success text-uppercase"
                                onclick="DUNGA.play('{{ $row->phone }}')"><i class="fa fa-play"
                                    aria-hidden="true"></i></span> --}}
                        </td>
                        <td>{{ number_format($row->min) }} VNĐ</td>
                        <td>{{ number_format($row->max) }} VNĐ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center font-weight-bold">
        <b>Làm mới sau <span class="text-danger coundown-time">0</span> s</b>
    </div>
    <p class="mt-3">
        - Nội dung chuyển: <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-chan"></span><span
                class="fa-stack-1x text-white">{{ explode('|', $setting->contentCL)[0] }}</span></span> hoặc
        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-le"></span><span
                class="fa-stack-1x text-white">{{ explode('|', $setting->contentCL)[1] }}</span></span> (nếu đuôi mã
        giao dịch có các số sau)
       
    </p>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover text-center">
            <thead>
                <th class="text-center text-white bg-primary">Nội dung</th>
                <th class="text-center text-white bg-primary">1 Số cuối</th>
                <th class="text-center text-white bg-primary">Tiền nhận</th>
            </thead>
            <tbody aria-live="polite" aria-relevant="all" class="" id="result-table" role="alert">
                <tr>
                    <td>
                        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-chan"> </span> <span
                                class="fa-stack-1x text-white comment-chan">{{ explode('|', $setting->contentCL)[0] }}</span></span>
                    </td>
                    <td><code>2</code> - <code>4</code> - <code>6</code> - <code>8</code></td>
                    <td><b>{{ $setting->ratioCL }}</b></td>
                </tr>
                <tr>
                    <td>
                        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-le"> </span><span
                                class="fa-stack-1x text-white comment-le">{{ explode('|', $setting->contentCL)[1] }}</span></span>
                    </td>
                    <td><code>1</code> - <code>3</code> - <code>5</code> - <code>7</code></td>
                    <td><b>{{ $setting->ratioCL }}</b></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="text-left"> - Tiền thắng sẽ = <b>Tiền cược*{{ $setting->ratioCL }}</b><br> <b style="color:red">- Lưu
            ý :</b> Mức cược mỗi số khác nhau, nếu chuyển sai hạn mức hoặc sai nội dung sẽ không được hoàn tiền.<br>-
        Đặc biệt: bạn có <b style="color:blue">10%</b> cơ hội được trả thưởng 2 lần <img src="/upload/hot.gif"
            width="35px">
    </div>
</div>
{{-- End chanle --}}

<div class="panel-body game" style="padding-top: 10px; padding-bottom: 20px;" game-tab="taixiu2">
    <div class='text-left'>- <b>Tài Xỉu 2</b> là một game tính kết quả bằng<b> 1 số cuối mã giao dịch</b>.</br><b>- Mỗi
            game có hạn mức khác nhau nên anh em chú ý</b></br>Cách chơi vô cùng đơn giản :</br>-Chuyển tiền vào một
        trong các tài khoản ở <code>danh sách số</code> bên dưới
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover text-center mb-0">
            <thead>
                <th class="text-center text-white bg-primary">Số điện thoại</th>
                <th class="text-center text-white bg-primary">Tối thiểu</th>
                <th class="text-center text-white bg-primary">Tối đa</th>
            </thead>
            <tbody aria-live="polite" aria-relevant="all" class="result-table-10" role="alert">
                @foreach ($momo as $row)
                    <tr>
                        <td id="mm_{{ $row->phone }}">
                            <b id="mln">
                                {{ $row->phone }} <b id="hmln" attr-name="amount">
                                    <font color="green">
                                        {{ number_format($row->amount) }}
                                    </font>/<font color="6861b1">
                                        46M</font>
                                </b>
                                <b id="hmln" class="hidden" attr-name="times">
                                    <font color="red">
                                        {{ $row->times }}
                                    </font>/<font color="6861b1">190 Giao dịch
                                    </font>
                                </b>
                            </b>
                            <span class="label label-success text-uppercase"
                                onclick="DUNGA.coppy('{{ $row->phone }}')"><i class="fa fa-clipboard"
                                    aria-hidden="true"></i></span>
                            {{-- <span class="label label-success text-uppercase"
                                onclick="DUNGA.play('{{ $row->phone }}')"><i class="fa fa-play"
                                    aria-hidden="true"></i></span> --}}
                        </td>
                        <td>{{ number_format($row->min) }} VNĐ</td>
                        <td>{{ number_format($row->max) }} VNĐ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center font-weight-bold">
        <b>Làm mới sau <span class="text-danger coundown-time">0</span> s</b>
    </div>
    <p class="mt-3">
        - Nội dung chuyển: <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-tai"></span><span
                class="fa-stack-1x text-white">{{ explode('|', $setting->contentTX2)[0] }}</span></span> hoặc
        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-xiu"></span><span
                class="fa-stack-1x text-white">{{ explode('|', $setting->contentTX2)[1] }}</span></span> (nếu đuôi mã
        giao dịch có các số sau)
       
    </p>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover text-center">
            <thead>
                <th class="text-center text-white bg-primary">Nội dung</th>
                <th class="text-center text-white bg-primary">1 Số cuối</th>
                <th class="text-center text-white bg-primary">Tiền nhận</th>
            </thead>
            <tbody aria-live="polite" aria-relevant="all" class="" id="result-table" role="alert">
                <tr>
                    <td>
                        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-tai"> </span>
                            <span
                                class="fa-stack-1x text-white comment-tai">{{ explode('|', $setting->contentTX2)[0] }}</span></span>
                    </td>
                    <td><code>5</code> - <code>6</code> - <code>7</code> - <code>8</code> - <code>9</code></td>
                    <td><b>{{ $setting->ratioTX2 }}</b></td>
                </tr>
                <tr>
                    <td>
                        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-xiu"> </span><span
                                class="fa-stack-1x text-white comment-xiu">{{ explode('|', $setting->contentTX2)[1] }}</span></span>
                    </td>
                    <td><code>0</code> - <code>1</code> - <code>2</code> - <code>3</code> - <code>4</code></td>
                    <td><b>{{ $setting->ratioTX2 }}</b></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="text-left"> - Tiền thắng sẽ = <b>Tiền cược*{{ $setting->ratioTX2 }}</b><br> <b style="color:red">-
            Lưu ý :</b> Mức cược mỗi số khác nhau, nếu chuyển sai hạn mức hoặc sai nội dung sẽ không được hoàn
        tiền.<br>- Đặc biệt: bạn có <b style="color:blue">10%</b> cơ hội được trả thưởng 2 lần <img
            src="/upload/hot.gif" width="35px">
    </div>
</div>
{{-- End taixiu2 --}}

<div class="panel-body game" style="padding-top: 10px; padding-bottom: 20px;" game-tab="taixiu">
    <div class='text-left'>- <b>Tài Xỉu</b> là một game tính kết quả bằng<b> 1 số cuối mã giao dịch</b>.</br><b>- Mỗi
            game có hạn mức khác nhau nên anh em chú ý</b></br>Cách chơi vô cùng đơn giản :</br>-Chuyển tiền vào một
        trong các tài khoản ở <code>danh sách số</code> bên dưới
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover text-center mb-0">
            <thead>
                <th class="text-center text-white bg-primary">Số điện thoại</th>
                <th class="text-center text-white bg-primary">Tối thiểu</th>
                <th class="text-center text-white bg-primary">Tối đa</th>
            </thead>
            <tbody aria-live="polite" aria-relevant="all" class="result-table-10" role="alert">
                @foreach ($momo as $row)
                    <tr>
                        <td id="mm_{{ $row->phone }}">
                            <b id="mln">
                                {{ $row->phone }} <b id="hmln" attr-name="amount">
                                    <font color="green">
                                        {{ number_format($row->amount) }}
                                    </font>/<font color="6861b1">
                                        46M</font>
                                </b>
                                <b id="hmln" class="hidden" attr-name="times">
                                    <font color="red">
                                        {{ $row->times }}
                                    </font>/<font color="6861b1">190 Giao dịch
                                    </font>
                                </b>
                            </b>
                            <span class="label label-success text-uppercase"
                                onclick="DUNGA.coppy('{{ $row->phone }}')"><i class="fa fa-clipboard"
                                    aria-hidden="true"></i></span>
                            {{-- <span class="label label-success text-uppercase"
                                onclick="DUNGA.play('{{ $row->phone }}')"><i class="fa fa-play"
                                    aria-hidden="true"></i></span> --}}
                        </td>
                        <td>{{ number_format($row->min) }} VNĐ</td>
                        <td>{{ number_format($row->max) }} VNĐ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center font-weight-bold">
        <b>Làm mới sau <span class="text-danger coundown-time">0</span> s</b>
    </div>
    <p class="mt-3">
        - Nội dung chuyển: <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-tai"></span><span
                class="fa-stack-1x text-white">{{ explode('|', $setting->contentTX)[0] }}</span></span> hoặc
        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-xiu"></span><span
                class="fa-stack-1x text-white">{{ explode('|', $setting->contentTX)[1] }}</span></span> (nếu đuôi mã
        giao dịch có các số sau)
       
    </p>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover text-center">
            <thead>
                <th class="text-center text-white bg-primary">Nội dung</th>
                <th class="text-center text-white bg-primary">1 Số cuối</th>
                <th class="text-center text-white bg-primary">Tiền nhận</th>
            </thead>
            <tbody aria-live="polite" aria-relevant="all" class="" id="result-table" role="alert">
                <tr>
                    <td>
                        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-tai"> </span>
                            <span
                                class="fa-stack-1x text-white comment-tai">{{ explode('|', $setting->contentTX)[0] }}</span></span>
                    </td>
                    <td><code>5</code> - <code>6</code> - <code>7</code> - <code>8</code></td>
                    <td><b>{{ $setting->ratioTX }}</b></td>
                </tr>
                <tr>
                    <td>
                        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-xiu"> </span><span
                                class="fa-stack-1x text-white comment-xiu">{{ explode('|', $setting->contentTX)[1] }}</span></span>
                    </td>
                    <td><code>1</code> - <code>2</code> - <code>3</code> - <code>4</code></td>
                    <td><b>{{ $setting->ratioTX }}</b></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="text-left"> - Tiền thắng sẽ = <b>Tiền cược*{{ $setting->ratioTX }}</b><br> <b style="color:red">- Lưu
            ý :</b> Mức cược mỗi số khác nhau, nếu chuyển sai hạn mức hoặc sai nội dung sẽ không được hoàn tiền.<br>-
        Đặc biệt: bạn có <b style="color:blue">10%</b> cơ hội được trả thưởng 2 lần <img src="/upload/hot.gif"
            width="35px">
    </div>
</div>
{{-- End taixiu --}}

<div class="panel-body game" style="padding-top: 10px; padding-bottom: 20px;" game-tab="x3">
    <div class='text-left'>- <b>1 Phần 3</b> là một game tính kết quả bằng<b> 1 số cuối mã giao dịch</b>.</br><b>- Mỗi
            game có hạn mức khác nhau nên anh em chú ý</b></br>Cách chơi vô cùng đơn giản :</br>-Chuyển tiền vào một
        trong các tài khoản ở <code>danh sách số</code> bên dưới
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover text-center mb-0">
            <thead>
                <th class="text-center text-white bg-primary">Số điện thoại</th>
                <th class="text-center text-white bg-primary">Tối thiểu</th>
                <th class="text-center text-white bg-primary">Tối đa</th>
            </thead>
            <tbody aria-live="polite" aria-relevant="all" class="result-table-10" role="alert">
                @foreach ($momo as $row)
                    <tr>
                        <td id="mm_{{ $row->phone }}">
                            <b id="mln">
                                {{ $row->phone }} <b id="hmln" attr-name="amount">
                                    <font color="green">
                                        {{ number_format($row->amount) }}
                                    </font>/<font color="6861b1">
                                        46M</font>
                                </b>
                                <b id="hmln" class="hidden" attr-name="times">
                                    <font color="red">
                                        {{ $row->times }}
                                    </font>/<font color="6861b1">190 Giao dịch
                                    </font>
                                </b>
                            </b>
                            <span class="label label-success text-uppercase"
                                onclick="DUNGA.coppy('{{ $row->phone }}')"><i class="fa fa-clipboard"
                                    aria-hidden="true"></i></span>
                            {{-- <span class="label label-success text-uppercase"
                                onclick="DUNGA.play('{{ $row->phone }}')"><i class="fa fa-play"
                                    aria-hidden="true"></i></span> --}}
                        </td>
                        <td>{{ number_format($row->min) }} VNĐ</td>
                        <td>{{ number_format($row->max) }} VNĐ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center font-weight-bold">
        <b>Làm mới sau <span class="text-danger coundown-time">0</span> s</b>
    </div>
    <p class="mt-3">
        - Nội dung chuyển: <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-chan"></span><span
                class="fa-stack-1x text-white comment-n1">{{ explode('|', $setting->content1P3)[1] }}</span></span>
        hoặc
        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-le"> </span><span
                class="fa-stack-1x text-white comment-n2">{{ explode('|', $setting->content1P3)[2] }}</span></span>
        hoặc
        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-tai"> </span><span
                class="fa-stack-1x text-white comment-n3">{{ explode('|', $setting->content1P3)[3] }}</span></span></span>
        (nếu đuôi mã giao dịch có các số sau)
       
    </p>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover text-center">
            <thead>
                <tr class="bg-primary" role="row">
                    <th class="text-center text-white">Nội dung</th>
                    <th class="text-center text-white">1 Số cuối</th>
                    <th class="text-center text-white">Tiền nhận</th>
                </tr>
            </thead>
            <tbody aria-live="polite" aria-relevant="all" class="" id="result-table" role="alert">
                <tr>
                    <td>
                        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-chan">
                            </span><span class="fa-stack-1x text-white"
                                id="">{{ explode('|', $setting->content1P3)[1] }}</span></span>
                    </td>
                    <td><code>1</code> - <code>2</code> - <code>3</code></td>
                    <td><b>{{ explode('|', $setting->ratio1P3)[0] }}</b></td>
                </tr>
                <tr>
                    <td>
                        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-le"> </span><span
                                class="fa-stack-1x text-white"
                                id="">{{ explode('|', $setting->content1P3)[2] }}</span></span>
                    </td>
                    <td><code>4</code> - <code>5</code> - <code>6</code></td>
                    <td><b>{{ explode('|', $setting->ratio1P3)[0] }}</b></td>
                </tr>
                <tr>
                    <td>
                        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-tai"> </span><span
                                class="fa-stack-1x text-white"
                                id="">{{ explode('|', $setting->content1P3)[3] }}</span></span>
                    </td>
                    <td><code>7</code> - <code>8</code> - <code>9</code></td>
                    <td><b>{{ explode('|', $setting->ratio1P3)[0] }}</b></td>
                </tr>

            </tbody>
        </table>
    </div>
    <div class="text-left">- Nếu mã giao dịch có số cuối trùng với 1 trong 4 số trên, bạn sẽ chiến thắng.<br>
        <b style="color:red">- Lưu ý :</b> Mức cược mỗi số khác nhau, nếu chuyển sai hạn mức hoặc sai nội dung sẽ không
        được hoàn tiền.<br>- Đặc biệt: bạn có <b style="color:blue">10%</b> cơ hội được trả thưởng 2 lần <img
            src="/upload/hot.gif" width="35px">
    </div>
</div>
{{-- End x3 --}}

<div class="panel-body game" style="padding-top: 10px; padding-bottom: 20px;" game-tab="hieu2so">
    <div class="text-left"> -<b>Hiệu</b> là một game tính kết quả bằng <b>hiệu 2 số cuối mã giao dịch</b> </br><b>- Mỗi
            game có hạn mức khác nhau nên anh em chú ý</b> </br>Cách chơi vô cùng đơn giản:</br>-Chuyển tiền vào một
        trong các tài khoản ở <code>danh sách số</code> bên dưới
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover text-center mb-0">
            <thead>
                <th class="text-center text-white bg-primary">Số điện thoại</th>
                <th class="text-center text-white bg-primary">Tối thiểu</th>
                <th class="text-center text-white bg-primary">Tối đa</th>
            </thead>
            <tbody aria-live="polite" aria-relevant="all" class="result-table-10" role="alert">
                @foreach ($momo as $row)
                    <tr>
                        <td id="mm_{{ $row->phone }}">
                            <b id="mln">
                                {{ $row->phone }} <b id="hmln" attr-name="amount">
                                    <font color="green">
                                        {{ number_format($row->amount) }}
                                    </font>/<font color="6861b1">
                                        46M</font>
                                </b>
                                <b id="hmln" class="hidden" attr-name="times">
                                    <font color="red">
                                        {{ $row->times }}
                                    </font>/<font color="6861b1">190 Giao dịch
                                    </font>
                                </b>
                            </b>
                            <span class="label label-success text-uppercase"
                                onclick="DUNGA.coppy('{{ $row->phone }}')"><i class="fa fa-clipboard"
                                    aria-hidden="true"></i></span>
                            {{-- <span class="label label-success text-uppercase"
                                onclick="DUNGA.play('{{ $row->phone }}')"><i class="fa fa-play"
                                    aria-hidden="true"></i></span> --}}
                        </td>
                        <td>{{ number_format($row->min) }} VNĐ</td>
                        <td>{{ number_format($row->max) }} VNĐ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center font-weight-bold">
        <b>Làm mới sau <span class="text-danger coundown-time">0</span> s</b>
    </div>
    <p class="mt-3">
        - Nội dung chuyển : <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-chan"></span><span
                class="fa-stack-1x text-white comment-n1">{{ $setting->contentH3 }}</span></span>
               
    </p>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover text-center">
            <thead>
                <tr class="bg-primary" role="row">
                    <th class="text-center text-white">Nội dung</th>
                    <th class="text-center text-white">Hiệu 2 Số cuối bằng</th>
                    <th class="text-center text-white">Tiền nhận</th>
                </tr>
            </thead>
            <tbody aria-live="polite" aria-relevant="all" class="" id="result-table" role="alert">
                <tr>
                    <td>
                        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-chan">
                            </span><span class="fa-stack-1x text-white"
                                id="">{{ $setting->contentH3 }}</span></span>
                    </td>
                    <td><code>9</code></td>
                    <td><b>{{ explode('|', $setting->ratioH3)[3] }}</b></td>
                </tr>
                <tr>
                    <td>
                        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-chan">
                            </span><span class="fa-stack-1x text-white"
                                id="">{{ $setting->contentH3 }}</span></span>
                    </td>
                    <td><code>7</code></td>
                    <td><b>{{ explode('|', $setting->ratioH3)[2] }}</b></td>
                </tr>
                <tr>
                    <td>
                        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-chan">
                            </span><span class="fa-stack-1x text-white"
                                id="">{{ $setting->contentH3 }}</span></span>
                    </td>
                    <td><code>5</code></td>
                    <td><b>{{ explode('|', $setting->ratioH3)[1] }}</b></td>
                </tr>
                <tr>
                    <td>
                        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-chan">
                            </span><span class="fa-stack-1x text-white"
                                id="">{{ $setting->contentH3 }}</span></span>
                    </td>
                    <td><code>3</code></td>
                    <td><b>{{ explode('|', $setting->ratioH3)[0] }}</b></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="text-left">- Nếu mã giao dịch có số cuối trùng với 1 trong 3 số trên, bạn sẽ chiến thắng.<br>
        <b style="color:red">- Lưu ý :</b> Mức cược mỗi số khác nhau, nếu chuyển sai hạn mức hoặc sai nội dung sẽ không
        được hoàn tiền.<br>- Đặc biệt: bạn có <b style="color:blue">10%</b> cơ hội được trả thưởng 2 lần <img
            src="/upload/hot.gif" width="35px">
    </div>
</div>
{{-- End hieuso2 --}}
<div class="panel-body game" style="padding-top: 10px; padding-bottom: 20px;" game-tab="lo">
    <div class="text-left"> -<b>Lô</b> là một game tính kết quả bằng <b> 2 số cuối mã giao dịch</b> </br><b>- Mỗi game
            có hạn mức khác nhau nên anh em chú ý</b> </br>Cách chơi vô cùng đơn giản:</br>-Chuyển tiền vào một trong
        các tài khoản ở <code>danh sách số</code> bên dưới
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover text-center mb-0">
            <thead>
                <th class="text-center text-white bg-primary">Số điện thoại</th>
                <th class="text-center text-white bg-primary">Tối thiểu</th>
                <th class="text-center text-white bg-primary">Tối đa</th>
            </thead>
            <tbody aria-live="polite" aria-relevant="all" class="result-table-10" role="alert">
                @foreach ($momo as $row)
                    <tr>
                        <td id="mm_{{ $row->phone }}">
                            <b id="mln">
                                {{ $row->phone }} <b id="hmln" attr-name="amount">
                                    <font color="green">
                                        {{ number_format($row->amount) }}
                                    </font>/<font color="6861b1">
                                        46M</font>
                                </b>
                                <b id="hmln" class="hidden" attr-name="times">
                                    <font color="red">
                                        {{ $row->times }}
                                    </font>/<font color="6861b1">190 Giao dịch
                                    </font>
                                </b>
                            </b>
                            <span class="label label-success text-uppercase"
                                onclick="DUNGA.coppy('{{ $row->phone }}')"><i class="fa fa-clipboard"
                                    aria-hidden="true"></i></span>
                            {{-- <span class="label label-success text-uppercase"
                                onclick="DUNGA.play('{{ $row->phone }}')"><i class="fa fa-play"
                                    aria-hidden="true"></i></span> --}}
                        </td>
                        <td>{{ number_format($row->min) }} VNĐ</td>
                        <td>{{ number_format($row->max) }} VNĐ</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center font-weight-bold">
        <b>Làm mới sau <span class="text-danger coundown-time">0</span> s</b>
    </div>
    <p class="mt-3">
        - Nội dung chuyển : <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-chan"></span><span
                class="fa-stack-1x text-white comment-n1">{{ $setting->contentLO }}</span></span>
       
    </p>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover text-center table-responsive">
            <thead>
                <tr class="bg-primary" role="row">
                    <th class="text-center text-white">Nội dung</th>
                    <th class="text-center text-white">2 Số cuối</th>
                    <th class="text-center text-white">Tiền nhận</th>
                </tr>
            </thead>
            <tbody aria-live="polite" aria-relevant="all" class="" id="result-table" role="alert">
                <tr>
                    <td>
                        <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-chan">
                            </span><span class="fa-stack-1x text-white"
                                id="">{{ $setting->contentLO }}</span></span>
                    </td>
                    <td>
                        <code>01</code> - <code>03</code> - <code>12</code> - <code>19</code> - <code>23</code> -
                        <code>24</code> - <code>30</code> - <code>33</code> - <code>39</code> - <code>48</code> -
                        <code>54</code> - <code>55</code> -
                        <code>60</code> - <code>61</code> - <code>71</code> - <code>77</code> - <code>81</code> -
                        <code>82</code> - <code>83</code> - <code>67</code> - <code>88</code> - <code>76</code> -
                        <code>64</code> - <code>79</code> -
                        <code>29</code> - <code>99</code>
                    </td>
                    <td><b>{{ $setting->ratioLO }}</b></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="text-left">- Nếu mã giao dịch có 2 số cuối trùng với 1 trong các số trên, bạn sẽ chiến thắng.<br>
        <b style="color:red">- Lưu ý :</b> Mức cược mỗi số khác nhau, nếu chuyển sai hạn mức hoặc sai nội dung sẽ không
        được hoàn tiền.<br>- Đặc biệt: bạn có <b style="color:blue">10%</b> cơ hội được trả thưởng 2 lần <img
            src="/upload/hot.gif" width="35px">
    </div>
</div>
    <div class="panel-body game" style="padding-top: 10px; padding-bottom: 20px;" game-tab="gap3">
        <p>- <b>Gấp 3</b> là một game tính kết quả bằng <b>nhiều số cuối mã giao dịch</b>.</p>
        <p>- Cách chơi vô cùng đơn giản:</p>
        <p>- Chuyển tiền vào một trong các tài khoản:</p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover text-center mb-0">
                <thead>
                    <th class="text-center text-white bg-primary">Số điện thoại</th>
                    <th class="text-center text-white bg-primary">Tối thiểu</th>
                    <th class="text-center text-white bg-primary">Tối đa</th>
                </thead>
                <tbody aria-live="polite" aria-relevant="all" class="result-table-10" role="alert">
                    @foreach ($momo as $row)
                        <tr>
                            <td id="mm_{{ $row->phone }}">
                                <b id="mln">
                                    {{ $row->phone }} <b id="hmln" attr-name="amount">
                                        <font color="green">
                                            {{ number_format($row->amount) }}
                                        </font>/<font color="6861b1">
                                            46M</font>
                                    </b>
                                    <b id="hmln" class="hidden" attr-name="times">
                                        <font color="red">
                                            {{ $row->times }}
                                        </font>/<font color="6861b1">190 Giao dịch
                                        </font>
                                    </b>
                                </b>
                                <span class="label label-success text-uppercase"
                                    onclick="DUNGA.coppy('{{ $row->phone }}')"><i class="fa fa-clipboard"
                                        aria-hidden="true"></i></span>
                                <span class="label label-success text-uppercase"
                                    onclick="DUNGA.play('{{ $row->phone }}')"><i class="fa fa-play"
                                        aria-hidden="true"></i></span>
                            </td>
                            <td>{{ number_format($row->min) }} VNĐ</td>
                            <td>{{ number_format($row->max) }} VNĐ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-center font-weight-bold">
            - Nội dung chuyển: <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-tai"></span><span
                    class="fa-stack-1x text-white">{{ $setting->contentG3 }}</span></span>(nếu đuôi mã giao dịch có
            các số sau)
            </p>
            <b>Làm mới sau <span class="text-danger coundown-time">0</span> s</b>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover text-center">
                <thead>
                    <tr class="bg-primary" role="row">
                        <th class="text-center text-white">Nội dung</th>
                        <th class="text-center text-white">Các số cuối</th>
                        <th class="text-center text-white">Tiền nhận</th>
                    </tr>
                </thead>
                <tbody aria-live="polite" aria-relevant="all" class="" id="result-table" role="alert">
                    <tr>
                        <td>
                            <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-tai">
                                </span><span class="fa-stack-1x text-white"
                                    id="">{{ $setting->contentG3 }}</span></span>
                        </td>
                        <td>
                            <code>02</code> - <code>13</code> - <code>17</code> - <code>19</code> - <code>21</code> -
                            <code>29</code> - <code>35</code> - <code>37</code> - <code>47</code> - <code>49</code> -
                            <code>51</code> - <code>54</code> -
                            <code>57</code> - <code>63</code> - <code>64</code> - <code>74</code> - <code>83</code> -
                            <code>91</code> - <code>95</code> - <code>96</code>
                        </td>
                        <td><b>{{ explode('|', $setting->ratioG3)[0] }}</b></td>
                    </tr>
                    <tr>
                        <td>
                            <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-xiu">
                                </span><span class="fa-stack-1x text-white"
                                    id="">{{ $setting->contentG3 }}</span></span>
                        </td>
                        <td><code>66</code> - <code>99</code></td>
                        <td><b>{{ explode('|', $setting->ratioG3)[1] }}</b></td>
                    </tr>
                    <tr>
                        <td>
                            <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-chan">
                                </span><span class="fa-stack-1x text-white"
                                    id="">{{ $setting->contentG3 }}</span></span>
                        </td>
                        <td><code>123</code> - <code>234</code> - <code>456</code> - <code>678</code> - <code>789</code>
                        </td>
                        <td><b>{{ explode('|', $setting->ratioG3)[2] }}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <b>- Lưu ý : Mức cược mỗi số khác nhau, nếu chuyển sai hạn mức hoặc sai nội dung vui lòng "liên hệ ADMIN" để
            được xử lí</b>
    </div>
    {{-- End gap3 --}}


    <div class="panel-body game" style="padding-top: 10px; padding-bottom: 20px;" game-tab="xien">
        <p>- <b>Xiên</b> là một game tính kết quả bằng <b>1 số cuối mã giao dịch</b>.</p>
        <p>-Cách chơi vô cùng đơn giản :</p>
        <p>- Chuyển tiền vào một trong các tài khoản:</p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover text-center mb-0">
                <thead>
                    <th class="text-center text-white bg-primary">Số điện thoại</th>
                    <th class="text-center text-white bg-primary">Tối thiểu</th>
                    <th class="text-center text-white bg-primary">Tối đa</th>
                </thead>
                <tbody aria-live="polite" aria-relevant="all" class="result-table-10" role="alert">
                    @foreach ($momo as $row)
                        <tr>
                            <td id="mm_{{ $row->phone }}">
                                <b id="mln">
                                    {{ $row->phone }} <b id="hmln" attr-name="amount">
                                        <font color="green">
                                            {{ number_format($row->amount) }}
                                        </font>/<font color="6861b1">
                                            46M</font>
                                    </b>
                                    <b id="hmln" class="hidden" attr-name="times">
                                        <font color="red">
                                            {{ $row->times }}
                                        </font>/<font color="6861b1">190 Giao dịch
                                        </font>
                                    </b>
                                </b>
                                <span class="label label-success text-uppercase"
                                    onclick="DUNGA.coppy('{{ $row->phone }}')"><i class="fa fa-clipboard"
                                        aria-hidden="true"></i></span>
                                <span class="label label-success text-uppercase"
                                    onclick="DUNGA.play('{{ $row->phone }}')"><i class="fa fa-play"
                                        aria-hidden="true"></i></span>
                            </td>
                            <td>{{ number_format($row->min) }} VNĐ</td>
                            <td>{{ number_format($row->max) }} VNĐ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-center font-weight-bold">
            <b>Làm mới sau <span class="text-danger coundown-time">0</span> s</b>
        </div>
        <p class="mt-3">
            - Nội dung chuyển: <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-tai"></span><span
                    class="fa-stack-1x text-white"
                    id="">{{ explode('|', $setting->contentXien)[0] }}</span></span>
            <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-xiu">
                </span><span class="fa-stack-1x text-white"
                    id="">{{ explode('|', $setting->contentXien)[1] }}</span></span>
            <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-chan">
                </span><span class="fa-stack-1x text-white"
                    id="">{{ explode('|', $setting->contentXien)[2] }}</span></span>
            <span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-le">
                </span><span class="fa-stack-1x text-white"
                    id="">{{ explode('|', $setting->contentXien)[3] }}</span></span>
            (nếu đuôi mã giao dịch có các số sau)
           
        </p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover text-center">
                <thead>
                    <tr class="bg-primary" role="row">
                        <th class="text-center text-white">Nội dung</th>
                        <th class="text-center text-white">Các số cuối</th>
                        <th class="text-center text-white">Tiền nhận</th>
                    </tr>
                </thead>
                <tbody aria-live="polite" aria-relevant="all" class="" id="result-table" role="alert">
                    <tr>
                        <td><span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-tai">
                                </span><span class="fa-stack-1x text-white"
                                    id="">{{ explode('|', $setting->contentXien)[0] }}</span></span>
                        </td>
                        <td><code>0</code> <code>2</code> <code>4</code></td>
                        <td><b>{{ $setting->ratioXien }}</b></td>
                    </tr>
                    <tr>
                        <td><span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-xiu">
                                </span><span class="fa-stack-1x text-white"
                                    id="">{{ explode('|', $setting->contentXien)[1] }}</span></span></td>
                        <td><code>5</code> <code>7</code> <code>9</code></td>
                        <td><b>{{ $setting->ratioXien }}</b></td>
                    </tr>
                    <tr>
                        <td><span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-chan">
                                </span><span class="fa-stack-1x text-white"
                                    id="">{{ explode('|', $setting->contentXien)[2] }}</span></span></td>
                        <td><code>6</code> <code>8</code></td>
                        <td><b>{{ $setting->ratioXien }}</b></td>
                    </tr>
                    <tr>
                        <td><span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-le">
                                </span><span class="fa-stack-1x text-white"
                                    id="">{{ explode('|', $setting->contentXien)[3] }}</span></span></td>
                        <td><code>1</code> <code>3</code></td>
                        <td><b>{{ $setting->ratioXien }}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="text-left">- Nếu mã giao dịch có số cuối trùng với 1 trong các số trên, bạn sẽ chiến thắng.<br>
            <b style="color:red">- Lưu ý :</b> Mức cược mỗi số khác nhau, nếu chuyển sai hạn mức hoặc sai nội dung sẽ
            không được hoàn tiền.<br>- Đặc biệt: bạn có <b style="color:blue">10%</b> cơ hội được trả thưởng 2 lần <img
                src="/upload/hot.gif" width="35px">
        </div>
    </div>
    {{-- End chanle2 --}}
    
    <div class="panel-body game" style="padding-top: 10px; padding-bottom: 20px;" game-tab="xsmb">
        <p>- <b>XSMB</b> là một game tính kết quả bằng <b>2 hoặc mã giao dịch</b>. Kết quả được lấy từ XSMB truyền thống
            thay đổi vào 19h00 hằng ngày.</p>
        <p>- Dữ liệu ngày <b style="color:blue" id="date-xsmb">08-08-2022</b> </p>
        <p>- Cách chơi vô cùng đơn giản:</p>
        <p>- Chuyển tiền vào một trong các tài khoản:</p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover text-center mb-0">
                <thead>
                    <th class="text-center text-white bg-primary">Số điện thoại</th>
                    <th class="text-center text-white bg-primary">Tối thiểu</th>
                    <th class="text-center text-white bg-primary">Tối đa</th>
                </thead>
                <tbody aria-live="polite" aria-relevant="all" class="result-table-10" role="alert">
                    @foreach ($momo as $row)
                        <tr>
                            <td id="mm_{{ $row->phone }}">
                                <b id="mln">
                                    {{ $row->phone }} <b id="hmln" attr-name="amount">
                                        <font color="green">
                                            {{ number_format($row->amount) }}
                                        </font>/<font color="6861b1">
                                            46M</font>
                                    </b>
                                    <b id="hmln" class="hidden" attr-name="times">
                                        <font color="red">
                                            {{ $row->times }}
                                        </font>/<font color="6861b1">190 Giao dịch
                                        </font>
                                    </b>
                                </b>
                                <span class="label label-success text-uppercase"
                                    onclick="DUNGA.coppy('{{ $row->phone }}')"><i class="fa fa-clipboard"
                                        aria-hidden="true"></i></span>
                                <span class="label label-success text-uppercase"
                                    onclick="DUNGA.play('{{ $row->phone }}')"><i class="fa fa-play"
                                        aria-hidden="true"></i></span>
                            </td>
                            <td>{{ number_format($row->min) }} VNĐ</td>
                            <td>{{ number_format($row->max) }} VNĐ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-center font-weight-bold">
            <b>Làm mới sau <span class="text-danger coundown-time">0</span> s</b>
        </div>
        <p class="mt-3">- Nội dung chuyển : {{ $setting->contentXSMB }} (nếu đuôi mã giao dịch có các số sau)
            <br /><b style="color:red">LƯU Ý:</b> NỘI DUNG CHƠI ĐÃ ĐƯỢC THAY ĐỔI THÀNH SĐT + ND ( SĐT VÀ ND CÁCH NHAU BẰNG PHÍM CÁCH ) ! <img src="/upload/hot.gif"
            width="35px">
        </p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover text-center">
                <thead>
                    <tr class="bg-primary" role="row">
                        <th class="text-center text-white">Nội dung</th>
                        <th class="text-center text-white">Các số cuối</th>
                        <th class="text-center text-white">Tiền nhận</th>
                    </tr>
                </thead>
                <tbody aria-live="polite" aria-relevant="all" class="" id="result-table" role="alert">
                    <tr>
                        <td>{{ $setting->contentXSMB }}</td>
                        <td>
                            <code>04</code> - <code>92</code> - <code>74</code> - <code>15</code> - <code>98</code> - <code>59</code> - <code>54</code> - <code>03</code> - <code>87</code> -
                            <code>22</code> - <code>45</code> -
                            <code>80</code> - <code>52</code> - <code>70</code> - <code>46</code> -
                            <code>33</code> - <code>95</code> - <code>20</code>
                        </td>
                        <td><b>{{ explode('|', $setting->ratioXSMB)[0] }}</b></td>
                    </tr>
                    <tr>
                        <td>{{ $setting->contentXSMB }}</td>
                        <td><code>08</code> - <code>79</code> - <code>83</code> - <code>64</code></td>
                        <td><b>{{ explode('|', $setting->ratioXSMB)[1] }}</b></td>
                    </tr>
                    <tr>
                        <td>{{ $setting->contentXSMB }}</td>
                        <td><code>828</code> - <code>549</code> - <code>323</code> - <code>355</code>
                        </td>
                        <td><b>{{ explode('|', $setting->ratioXSMB)[2] }}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <b>- Lưu ý : Mức cược mỗi số khác nhau, nếu chuyển sai hạn mức hoặc sai nội dung vui lòng "liên hệ ADMIN" để
            được xử lí</b>
    </div>

    <div class="panel-body game" style="padding-top: 10px; padding-bottom: 20px;" game-tab="doanso">
        <p>- <b>Đoán số</b> là một game tính kết quả bằng <b>1 số cuối mã giao dịch</b>.</p>
        <p>-Cách chơi vô cùng đơn giản :</p>
        <p>- Chuyển tiền vào một trong các tài khoản:</p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover text-center mb-0">
                <thead>
                    <th class="text-center text-white bg-primary">Số điện thoại</th>
                    <th class="text-center text-white bg-primary">Tối thiểu</th>
                    <th class="text-center text-white bg-primary">Tối đa</th>
                </thead>
                <tbody aria-live="polite" aria-relevant="all" class="result-table-10" role="alert">
                    @foreach ($momo as $row)
                        <tr>
                            <td id="mm_{{ $row->phone }}">
                                <b id="mln">
                                    {{ $row->phone }} <b id="hmln" attr-name="amount">
                                        <font color="green">
                                            {{ number_format($row->amount) }}
                                        </font>/<font color="6861b1">
                                            46M</font>
                                    </b>
                                    <b id="hmln" class="hidden" attr-name="times">
                                        <font color="red">
                                            {{ $row->times }}
                                        </font>/<font color="6861b1">190 Giao dịch
                                        </font>
                                    </b>
                                </b>
                                <span class="label label-success text-uppercase"
                                    onclick="DUNGA.coppy('{{ $row->phone }}')"><i class="fa fa-clipboard"
                                        aria-hidden="true"></i></span>
                                <span class="label label-success text-uppercase"
                                    onclick="DUNGA.play('{{ $row->phone }}')"><i class="fa fa-play"
                                        aria-hidden="true"></i></span>
                            </td>
                            <td>{{ number_format($row->min) }} VNĐ</td>
                            <td>{{ number_format($row->max) }} VNĐ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-center font-weight-bold">
            <b>Làm mới sau <span class="text-danger coundown-time">0</span> s</b>
        </div>
        <p class="mt-3">
            - Nội dung chuyển: 
           
        </p>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover text-center">
                <thead>
                    <tr class="bg-primary" role="row">
                        <th class="text-center text-white">Nội dung</th>
                        <th class="text-center text-white">Số cuối</th>
                        <th class="text-center text-white">Tiền nhận</th>
                    </tr>
                </thead>
                <tbody aria-live="polite" aria-relevant="all" class="" id="result-table" role="alert">
                    <tr>
                        <td><span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-tai">
                                </span><span class="fa-stack-1x text-white"
                                    id="">{{  $setting->contentDoan.'0' }}</span></span>
                        </td>
                        <td><code>0</code></td>
                        <td>x<b>{{ $setting->ratioDoan }}</b></td>
                    </tr>
                    <tr>
                        <td><span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-tai">
                                </span><span class="fa-stack-1x text-white"
                                    id="">{{  $setting->contentDoan.'1' }}</span></span>
                        </td>
                        <td><code>1</code></td>
                        <td>x<b>{{ $setting->ratioDoan }}</b></td>
                    </tr>
                    <tr>
                        <td><span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-tai">
                                </span><span class="fa-stack-1x text-white"
                                    id="">{{  $setting->contentDoan.'2' }}</span></span>
                        </td>
                        <td><code>2</code></td>
                        <td>x<b>{{ $setting->ratioDoan }}</b></td>
                    </tr>
                    <tr>
                        <td><span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-tai">
                                </span><span class="fa-stack-1x text-white"
                                    id="">{{  $setting->contentDoan.'3' }}</span></span>
                        </td>
                        <td><code>3</code></td>
                        <td>x<b>{{ $setting->ratioDoan }}</b></td>
                    </tr>
                    <tr>
                        <td><span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-tai">
                                </span><span class="fa-stack-1x text-white"
                                    id="">{{  $setting->contentDoan.'4' }}</span></span>
                        </td>
                        <td><code>4</code></td>
                        <td>x<b>{{ $setting->ratioDoan }}</b></td>
                    </tr>
                    <tr>
                        <td><span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-tai">
                                </span><span class="fa-stack-1x text-white"
                                    id="">{{  $setting->contentDoan.'5' }}</span></span>
                        </td>
                        <td><code>5</code></td>
                        <td>x<b>{{ $setting->ratioDoan }}</b></td>
                    </tr>
                    <tr>
                        <td><span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-tai">
                                </span><span class="fa-stack-1x text-white"
                                    id="">{{  $setting->contentDoan.'6' }}</span></span>
                        </td>
                        <td><code>6</code></td>
                        <td>x<b>{{ $setting->ratioDoan }}</b></td>
                    </tr>
                    <tr>
                        <td><span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-tai">
                                </span><span class="fa-stack-1x text-white"
                                    id="">{{  $setting->contentDoan.'7' }}</span></span>
                        </td>
                        <td><code>7</code></td>
                        <td>x<b>{{ $setting->ratioDoan }}</b></td>
                    </tr>
                    <tr>
                        <td><span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-tai">
                                </span><span class="fa-stack-1x text-white"
                                    id="">{{  $setting->contentDoan.'8' }}</span></span>
                        </td>
                        <td><code>8</code></td>
                        <td>x<b>{{ $setting->ratioDoan }}</b></td>
                    </tr>
                    <tr>
                        <td><span class="fa-stack"><span class="fa fa-circle fa-stack-2x dot-text-tai">
                                </span><span class="fa-stack-1x text-white"
                                    id="">{{  $setting->contentDoan.'9' }}</span></span>
                        </td>
                        <td><code>9</code></td>
                        <td>x<b>{{ $setting->ratioDoan }}</b></td>
                    </tr>
                
                </tbody>
            </table>
        </div>
        <div class="text-left">- Nếu mã giao dịch có số cuối trùng với 1 trong các số trên, bạn sẽ chiến thắng.<br>
            <b style="color:red">- Lưu ý :</b> Mức cược mỗi số khác nhau, nếu chuyển sai hạn mức hoặc sai nội dung sẽ
            không được hoàn tiền.<br>- Đặc biệt: bạn có <b style="color:blue">10%</b> cơ hội được trả thưởng 2 lần <img
                src="/upload/hot.gif" width="35px">
        </div>
    </div>