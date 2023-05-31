@extends('dgaAdmin.app')
@section('main')
    <main id="main-container">
        <div class="content">
            <div
                class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
                <div class="flex-grow-1 mb-1 mb-md-0">
                    <h1 class="h3 fw-bold mb-2">
                        SETTING
                    </h1>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    @if ($errors->has('status'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <p class="mb-0">
                                {{ $errors->first('message') }}
                            </p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{ route('admin.infoTranEdit', ['tran' => $tran]) }}" method="POST">
                        <div class="block block-rounded">
                            <div class="block-header block-header-default">
                                <h3 class="block-title">#INFO {{ $tran }}</h3>
                                <div class="block-options">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        Lưu ngay
                                    </button>
                                   @if ($info->status == 3 && $isWin )
                                   <button onclick="onPressCashBack({{$tran}})" type="button" class="btn btn-sm btn-secondary offset-xl-1">
                                        Hoàn tiền
                                    </button>
                                    @endif

                                </div>
                            </div>
                            <div class="block-content">
                                <div class="row justify-content-center py-sm-3 py-md-5">
                                    @csrf
                                    @if ($isDisabled === '')
                                    <div class="col-sm-12">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username">Mã giao dịch</label>
                                            <input type="text" class="form-control form-control-lg form-control-solid" name="tranId"
                                                   value="{{ $info->tranId }}">
                                        </div>
                                    </div>
                                    @endif

                                    <div class="col-sm-6">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username">Người chuyển</label>
                                            <input type="text" class="form-control form-control-lg form-control-solid" name="partnerName"
                                                   value="{{ $info->partnerName }}" {{ $isDisabled }}>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username">Số chuyển</label>
                                            <input type="text" class="form-control form-control-lg form-control-solid" name="partnerId"
                                                   value="{{ $info->partnerId }}" {{ $isDisabled }}>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username">Số tiền chơi</label>
                                            <input type="text" class="form-control form-control-lg form-control-solid" name="amount"
                                                   value="{{ $info->amount }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username">Số tiền nhận</label>
                                            <input type="text" class="form-control form-control-lg form-control-solid" name="receive"
                                                   value="{{ $info->receive }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username">Trò chơi</label>
                                            <input type="text" class="form-control form-control-lg form-control-solid" name="game"
                                                   value="{{ $info->game }}" {{ $isDisabled }}>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username">Tỉ lệ</label>
                                            <input type="text" class="form-control form-control-lg form-control-solid" name="ratio"
                                                   value="{{ $ratio }}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username">Trạng thái</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="{{ $info->status }}">@if ($info->status == 1) Thắng (Hiện
                                                    tại) @elseif($info->status == 5) Chờ kết quả (Hiện
                                                    tại)
                                                    @elseif($info->status == 4) Đã hoàn tiền (Hiện
                                                    tại) @elseif($info->status == 3) Sai hạn mức (Hiện
                                                    tại) @elseif($info->status == 2) Sai nội dung (Hiện tại)
                                                    @elseif($info->status == 6) Chờ hoàn tiền (Hiện tại)  
                                                    @else Thua
                                                    (Hiện tại) @endif</option>

                                                <option value="1">Thắng</option>
                                                <option value="3">Sai hạn mức</option>
                                                <option value="2">Sai nội dung</option>
                                                <option value="4">Đã hoàn tiền</option>
                                                <option value="5">Chờ kết quả</option>
                                                <option value="6">Chờ hoàn tiền</option>
                                                <option value="0">Thua</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username">Trả</label>
                                            <select class="form-select" id="pay" name="pay" {{ $info->pay == 1 ? 'disabled' : '' }}>
                                                <option value="{{ $info->pay }}">@if ($info->pay == 1) Đã trả (Hiện
                                                    tại) @elseif($info->pay == 100) Chuyển lỗi (Hiện tại) @elseif($info->pay == 5) Chờ thanh toán (Hiện tại) @else Chưa trả
                                                    (Hiện tại) @endif</option>
                                                <option value="1">Đã trả</option>
                                                <option value="100">Chuyển lỗi</option>
                                                <option value="0">Chưa trả</option>
                                                <option value="5">Chờ thanh toán</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-sm-6">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username">Số nhận</label>
                                            <select class="form-select" id="phoneSend" name="phoneSend" {{ $isDisabled }}>
                                                <option value="{{ $infoPhoneReceive->phone }}">{{ $infoPhoneReceive->phone }} (Hiện tại)
                                                    - {{  number_format($infoPhoneReceive->balance) }} VND
                                                </option>
                                                @foreach($momo as $row) {
                                                <option value="{{ $row->phone }}">{{ $row->phone }}
                                                    - {{  number_format($row->balance) }} VND
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @if ($infoPhonePayment != null)
                                    <div class="col-sm-6">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username">Số trả</label>
                                            <select class="form-select" id="phoneSend" name="phoneSend" {{ $isDisabled }}>
                                                <option value="{{ $infoPhonePayment->phone }}">{{ $infoPhonePayment->phone }} (Hiện tại)
                                                    - {{  number_format($infoPhoneReceive->balance) }} VND
                                                </option>
                                                @foreach($momo as $row) {
                                                <option value="{{ $row->phone }}">{{ $row->phone }}
                                                    - {{  number_format($row->balance) }} VND
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endif


                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script>
        function onPressCashBack(tranId) {     
            Swal.fire({
                text: `Bạn chắc chắn muốn hoàn tiền cho giao dịch ${tranId} không?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Có",
                cancelButtonText: "Không",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-warning"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: "{{ route('admin.cashBack') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            tranId: tranId,
                        },
                        success: function(data) {
                            if (data.status == true) {
                                Swal.fire({text: data.message,icon: "success",
                                confirmButtonText: "OK",
                                customClass: {
                                confirmButton: "btn btn-primary"}}).then((result)=> {
                                    location.reload();
                                });
                            } else {
                                swal(data.message, "error");
                            }
                        },
                    });
                }
            });
        }
       

    </script>
@endsection
