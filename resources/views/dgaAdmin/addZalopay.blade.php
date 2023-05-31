@extends('dgaAdmin.app')
@section('main')
    <main id="main-container">
        <div class="content">
            <div
                class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
                <div class="flex-grow-1 mb-1 mb-md-0">
                    <h1 class="h3 fw-bold mb-2">
                        ZALOPAY 
                    </h1>
                    <h2 class="h6 fw-medium fw-medium text-muted mb-0">
                        Thêm ZALOPAY  
                    </h2>
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
                    <div class="card card-rounded">
                        <div class="card-header card-header-default">
                            <h3 class="card-title">THÊM SỐ ZALOPAY</h3>
                            
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.verifyZalopay') }}" method="POST">
                                @csrf
                                <div class="row push">
                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="">Số ZALOPAY</label>
                                            <input type="text" class="form-control" id="phone"
                                                   name="phone" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="">Mã OTP</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="otp" name="otp"
                                                       placeholder="" maxlength="6">
                                                <button type="button" class="btn btn-primary" id="btnGETOTP">Lấy OTP
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="">Mật khẩu</label>
                                            <input type="password" class="form-control" id="password" maxlength="6"
                                                   name="password" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="">Tối thiểu</label>
                                            <input type="text" class="form-control" id="min"
                                                   name="min" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="">Tối đa</label>
                                            <input type="text" class="form-control" id="max"
                                                   name="max" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-4">
                                            <label class="form-label" for=""> (Nhập đầy đủ thông tin rồi hẵn lấy OTP và
                                                thêm) </label>
                                            <button class="btn btn-primary fw-semibold w-100">Thêm ZALOPAY</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
                        <h3 class="block-title">THÔNG TIN ZALO</h3>
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
     $("#btnGETOTP").click(function () {
            var phone = $("#phone").val();
            var password = $("#password").val();
            var min = $("#min").val();
            var max = $("#max").val();
            var proxy = $("#proxy").val();
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "{{ route('admin.getOTPZalo') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    phone: phone,
                    password: password,
                    min: min,
                    max: max,
                    proxy: proxy
                },
                success: function (data) {
                    if (data.status == "success") {
                        swal(data.message, "success");
                    } else {
                        swal(data.message, "error");
                    }
                },
            });
        });
</script>
@endsection
