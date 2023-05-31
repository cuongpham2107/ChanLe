<!DOCTYPE html>
<html lang="en">

<head>
    <title>HỆ THỐNG QUẢN TRỊ CLMM CỦA {{ $setting->name }}</title>
    <meta name="description" content="Service Manager Account Run Web" />
    <meta name="keywords" content="Service Manager Account Run Web" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Service Manager Account Run Web" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="Service Manager Account Run Web" />
    <link rel="shortcut icon" href="/dgaAdmin/assets1/media/logos/favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="/dgaAdmin/assets1/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/dgaAdmin/assets1/css/style.bundle.css" rel="stylesheet" type="text/css" />
</head>

<body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    <script>
        localStorage.setItem('data-theme', 'dark')
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-theme-mode");
            } else {
                if (localStorage.getItem("data-theme") !== null) {
                    themeMode = localStorage.getItem("data-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-theme", themeMode);
        }
    </script>

    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <style>
            body {
                background-image: url('/upload/bg10-dark.jpg');
            }

            [data-theme="dark"] body {
                background-image: url('/upload/bg10-dark.jpg');
            }
        </style>
        <div class="d-flex flex-column flex-column-fluid flex-lg-row">
            <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
                <!--begin::Aside-->
                <div class="d-flex flex-center flex-lg-start flex-column">
                    <!--begin::Logo-->
                    <a href="/" class="mb-7">
                        <img alt="Logo" src="/upload/vsvn.png" height="60px" />
                    </a>
                    <!--end::Logo-->
                    <!--begin::Title-->
                    <h2 class="text-white fw-normal m-0">MSV.VN - VSVN.VN Best Services For You</h2>
                    <!--end::Title-->
                </div>
                <!--begin::Aside-->
            </div>
            <div class="d-flex flex-center w-lg-50 p-10">
                <div class="card rounded-3 w-md-550px">
                    <div class="card-body p-10 p-lg-20">

                        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    @foreach ($errors->all() as $error)
                                        <p class="mb-0">
                                            {{ $error }}
                                        </p>
                                    @endforeach
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <!--begin::Heading-->
                            <div class="text-center mb-11">
                                <!--begin::Title-->
                                <h1 class="text-dark fw-bolder mb-3">Đăng nhập</h1>
                                <!--end::Title-->
                                <!--begin::Subtitle-->
                                <div class="text-gray-500 fw-semibold fs-6">Xin chào đã quay lại, vui lòng đăng nhập.
                                </div>
                                <!--end::Subtitle=-->
                            </div>
                            <div class="alert alert-primary">
                                Chúng tôi luôn hỗ trợ bạn với những dịch vụ tốt nhất!
                            </div>
                            <div class="row g-3 mb-9">
                                <div class="col-md-6">
                                    <a href="#"
                                        class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                        <img alt="Logo" src="/assets/media/svg/google-icon.svg"
                                            class="h-15px me-3">Sign in with Google</a>
                                </div>
                                <div class="col-md-6">
                                    <a href="#"
                                        class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                        <img alt="Logo" src="/assets/media/svg/apple-black.svg"
                                            class="theme-light-show h-15px me-3">
                                        <img alt="Logo" src="/assets/media/svg/apple-black-dark.svg"
                                            class="theme-dark-show h-15px me-3">Sign in with Apple</a>
                                </div>
                            </div>
                            <div class="separator separator-content my-14">
                                <span class="w-125px text-gray-500 fw-semibold fs-7">Or with Account</span>
                            </div>
                            <!--begin::Heading-->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="text" placeholder="Username" id="login-username" name="username"
                                    class="form-control bg-transparent" />
                                <!--end::Email-->
                            </div>
                            <!--end::Input group=-->
                            <div class="fv-row mb-8">
                                <!--begin::Password-->
                                <input type="password" placeholder="Password" id="login-password" name="password"
                                    class="form-control bg-transparent" />
                                <!--end::Password-->
                            </div>
                            <input type="text" id="oauth" name="oauth" hidden>
                            <div class="fv-row mb-8" id="oauth-tem">
                                <!--begin::Email-->
                                <input type="text" placeholder="Mã xác thực 2fa" id="oauth-key" name="code"
                                    class="form-control bg-transparent" />
                                <!--end::Email-->
                            </div>
                            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                <div></div>
                                <a href="https://t.me/clmm2023a" class="link-primary">Forgot Password ?</a>
                            </div>
                            <!--end::Input group=-->
                            <!--begin::Wrapper-->
                            <!--end::Wrapper-->
                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <button type="button" class="btn btn-primary" id="btn_login">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Đăng nhập</span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    <!--end::Indicator progress-->
                                </button>
                            </div>
                            <div class="text-gray-500 text-center fw-semibold fs-6">Need support?
                                <a href="https://t.me/clmm2023a" class="link-primary">Click here</a>
                            </div>
                            <!--end::Submit button-->
                            <!--begin::Sign up-->

                            <!--end::Sign up-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var hostUrl = "assets/";
    </script>
    <script src="/dgaAdmin/assets1/plugins/global/plugins.bundle.js"></script>
    <script src="/dgaAdmin/assets1/js/scripts.bundle.js"></script>
    <script>
        $(document).ready(function() {
            $('#oauth-tem').hide();
            $('#btn_login').click(function() {
                var username = $('#login-username').val();
                var password = $('#login-password').val();
                if (username == '' || password == '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Vui lòng nhập đầy đủ thông tin!',
                    })
                } else {
                    $.ajax({
                        url: "{{ route('admin.login.post') }}",
                        type: 'POST',
                        
                        data: {
                            username: username,
                            password: password,
                            _token: '{{ csrf_token() }}',
                            oauth: $('#oauth').val(),
                            code: $('#oauth-key').val()
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                if (data.oauth == true) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: data.message,
                                    });
                                    $('#oauth').val('ON');
                                    $('#oauth-tem').show();
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Đăng nhập thành công!',
                                    })
                                    //reload page
                                    setTimeout(function() {
                                        window.location.href = "{{ route('admin.home') }}";
                                    }, 1000);
                                }
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: data.message,
                                })
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
