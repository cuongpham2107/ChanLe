@extends('dgaAdmin.app')
@section('main')
    <main id="main-container">
        <div class="content">
            <div class="row">
                <div id="kt_app_content" class="app-content flex-column-fluid">
                    <div id="kt_app_content_container" class="app-container container-xxl">
                        @if ($errors->has('status'))
                            <div class="alert alert-{{ $errors->first('status') == 'success' ? "success" : "danger"}} alert-dismissible" role="alert">
                                <p class="mb-0">
                                    {{ $errors->first('message') }}
                                </p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title fs-3 fw-bold">Chuyển tiền</div>
                            </div>

                            <form action="{{ route('admin.sendMoney') }}" method="POST">
                                @csrf
                                <div class="card-body p-9">
                                    <div class="row mb-8">
                                        <div class="col-xl-3">
                                            <div class="fs-6 fw-semibold mt-2 mb-3" for="example-select">Chọn tài khoản
                                                chuyển</div>
                                        </div>
                                        <div class="col-xl-9 fv-row">
                                            <select class="form-select" id="phoneSend" name="phoneSend">
                                                @foreach ($GetAccountMomo as $row)
                                                    <option value="{{ $row->phone }}">{{ $row->phone }} -
                                                        {{ number_format($row->balance) }} đ</option>
                                                @endforeach
                                            </select></span>
                                        </div>
                                    </div>
                                    <div class="row mb-8">
                                        <div class="col-xl-3">
                                            <div class="fs-6 fw-semibold mt-2 mb-3">Số điện thoại nhận</div>
                                        </div>
                                        <div class="col-xl-7 fv-row">
                                            <input type="text" class="form-control form-control-solid" id="phone"
                                                name="phone" placeholder="SĐT">
                                        </div>
                                        <div class="col-xl-2 fv-row">
                                            <button type="button" class="btn btn-outline-info w-100" id="btnCheck">Kiểm tra</button>
                                        </div>
                                    </div>
                                    <div class="row mb-8">
                                        <div class="col-xl-3">
                                            <div class="fs-6 fw-semibold mt-2 mb-3">Họ tên Người nhận</div>
                                        </div>
                                        <div class="col-xl-9 fv-row">
                                            <input type="text" class="form-control form-control-solid" id="receiver_name"
                                                name="receiver_name" placeholder="Họ tên" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-8">
                                        <div class="col-xl-3">
                                            <div class="fs-6 fw-semibold mt-2 mb-3">Zalopay ID</div>
                                        </div>
                                        <div class="col-xl-9 fv-row">
                                            <input type="text" class="form-control form-control-solid" id="zalopay_id"
                                                name="zalopay_id" placeholder="Zalopay ID">
                                        </div>
                                    </div>
                                    <div class="row mb-8">
                                        <div class="col-xl-3">
                                            <div class="fs-6 fw-semibold mt-2 mb-3">Số tiền</div>
                                        </div>
                                        <div class="col-xl-9 fv-row">
                                            <input type="text" class="form-control form-control-solid" id="amount"
                                                name="amount" placeholder="VNĐ">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <div class="fs-6 fw-semibold mt-2 mb-3">Nội dung</div>
                                        </div>
                                        <div class="col-xl-9 fv-row">
                                            <input type="text" class="form-control form-control-solid" id="comment"
                                                name="comment" placeholder="Không cần">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button type="submit" class="btn btn-primary">Chuyển tiền</button>
                                </div>
                                {{-- <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button type="button" class="btn btn-primary" id="btnCheck">Kiểm tra</button>
                                </div> --}}
                            </form>
                            <!--end:Form-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="modal" id="infoMomo" tabindex="-1" role="dialog" aria-labelledby="infoMomo" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">THÔNG TIN MOMO</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm" id="showInfo">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $("#btnGETOTP").click(function() {
            var phone = $("#phone").val();
            var password = $("#password").val();
            var min = $("#min").val();
            var max = $("#max").val();
            var proxy = $("#proxy").val();
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "{{ route('admin.getOTP') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    phone: phone,
                    password: password,
                    min: min,
                    max: max,
                    proxy: proxy
                },
                success: function(data) {
                    if (data.status == "success") {
                        swal(data.message, "success");
                    } else {
                        swal(data.message, "error");
                    }
                },
            });
        });
        $("#btnCheck").click(function(e) {
            e.preventDefault();
            var phoneSend = $("#phoneSend").val();
            var receiver = $("#phone").val();
            var url = "{{ route('admin.checkMomo', ['phone' => ":phone", 'receiver' => ":receiver"]) }}";
            url = url.replace(':phone', phoneSend);
            url = url.replace(':receiver', receiver);
            $.ajax({
                type: "GET",
                dataType: "JSON",
                url: url,
                success: function(data) {
                    if (data.status == "success") {
                        swal(data.message, "success");
                        $("#receiver_name").val(data.name);
                        $("#zalopay_id").val(data.userid);
                    } else {
                        swal(data.message, "error");
                    }
                },
                error: function(data) {
                    swal("Đã xảy ra lỗi. Vui lòng kiểm tra lại thông tin.", "error");
                }
            });
        });
    </script>
@endsection
