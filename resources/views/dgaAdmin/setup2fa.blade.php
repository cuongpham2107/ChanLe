@extends('dgaAdmin.app')
@section('main')
    <main id="main-container">
        <div class="content">
            <div
                class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
                <div class="flex-grow-1 mb-1 mb-md-0">
                    <h1 class="h3 fw-bold mb-2">
                        Cài đặt 2fa
                    </h1>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="container">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Ứng dụng xác thực</h4>
                            </div>
                            @if (Auth::user()->$w == false)
                                <div class="card-body">
                                    <span class=text-gray-500 fw-semibold fs-6 mb-10>Sử dụng 1 trong các ứng dụng sau <a
                                            href="https://support.google.com/accounts/answer/1066447?hl=en"
                                            target="_blank">Google Authenticator</a>, <a
                                            href="https://www.microsoft.com/en-us/account/authenticator">Microsoft
                                            Authenticator</a>,<a href="Microsoft Authenticator"> Authy</a>, hoặc<a
                                            href="https://support.1password.com/one-time-passwords/"> 1Password</a>,
                                        để
                                        quét mã QR code. It will generate a 6 digit code for you to enter below.</span>
                                    <div class="mt-5 text-center">
                                        <img src="{{ $qr }}" alt="">
                                    </div>
                                    <div class="mt-5">
                                        
                                            <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"></rect>
                                <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor"></rect>
                                <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"></rect>
                            </svg>
                        </span>
                        
                                           <div class="d-flex flex-stack flex-grow-1">
                            <div class=text-gray-500 fw-semibold fs-6 mb-10>
                                <span class=text-gray-500 fw-semibold fs-6 mb-10>Nếu bạn gặp sự cố khi sử dụng mã QR, hãy chọn mục nhập thủ công trên ứng dụng của bạn, rồi nhập tên người dùng và mã của bạn:
                                    <span style=color:#7366ff>{{ $secret }}</span>
                                </span>
                            </div>
                        </div>
                   
                                    <div class="mt-5 text-center">
                                        <form action="">
                                            <input type="text" name="type" value="ON" hidden>
                                            <input type="text" name="secret" value="{{ $secret }}" hidden>
                                            <div class="form-group">
                                                <label for="" class="form-label">Mã xác thực</label>
                                                <input type="text" class="form-control" name="code"
                                                    placeholder="Nhập mã xác thực của key">
                                            </div>
                                            <div class="form-group mt-3 text-center">
                                                <button class="btn btn-primary" id="btn_send">Gửi mã xác thực</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @else
                            <div class="card-body">
                                <span class="text-gray-600 fw-semibold">Sử dụng 1 trong các ứng dụng sau <a
                                        href="https://support.google.com/accounts/answer/1066447?hl=en"
                                        target="_blank">Google Authenticator</a>, <a
                                        href="https://www.microsoft.com/en-us/account/authenticator">Microsoft
                                        Authenticator</a>,<a href="Microsoft Authenticator"> Authy</a>, hoặc<a
                                        href="https://support.1password.com/one-time-passwords/"> 1Password</a>,
                                    để
                                    quét mã QR code. It will generate a 6 digit code for you to enter below.</span>
                                <div class="mt-5">
                                    <div class="alert alert-success">
                                        Bạn đã bật 2fa
                                    </div>
                                </div>
                                <div class="mt-5 text-center">
                                    <form action="">
                                        <input type="text" name="type" value="OFF" hidden>
                                        <div class="form-group mt-3 text-center">
                                            <button class="btn btn-primary" id="btn_send">Tắt 2fa</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#btn_send').click(function(e) {
                e.preventDefault();
                var code = $('input[name="code"]').val();
                var secret = $('input[name="secret"]').val();
                var type = $('input[name="type"]').val();
                $.ajax({
                    url: "{{ route('admin.setup2faPost') }}",
                    type: "POST",
                    data: {
                        code: code,
                        secret: secret,
                        _token: "{{ csrf_token() }}",
                        type: type
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công',
                                text: data.message,
                            }).then(function() {
                                //reload page
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Thất bại',
                                text: data.message,
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
