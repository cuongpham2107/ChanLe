
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Service Manager Account Run Web" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="Service Manager Account Run Web" />
    
    <link rel="shortcut icon" href="/dgaAdmin/assets1/media/logos/favicon.ico" />
    <title>HỆ THỐNG QUẢN TRỊ CLMM CỦA {{ $setting->name }}</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/assets1/css/font-awesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="/assets1/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="/assets1/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="/assets1/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="/assets1/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="/assets1/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="/assets1/css/style.css">
    <link id="color" rel="stylesheet" href="/assets1/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="/assets1/css/responsive.css">
  </head>
  <body>
    <!-- login page start-->
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-7"><img class="bg-img-cover bg-center" src="/assets1/images/login/2.jpg" alt="looginpage"></div>
        <div class="col-xl-5 p-0">
          <div class="login-card">
            <div>
              <div></div>
              <div class="login-main"> 
                <form class="theme-form">
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
                  <h4>Sign in to account</h4>
                  <p>Enter your email & password to login</p>
                  <div class="form-group">
                    <label class="col-form-label">Tài khoản</label>
                    <input class="form-control" type="text" placeholder="Nhập tên tài khoản" id="login-username" name="username">
                  </div>
                  <div class="form-group">
                    <label class="col-form-label">Password</label>
                    <div class="form-input position-relative">
                      <input class="form-control" type="password" name="password" id="login-password" placeholder="*********">
                      <div class="show-hide"><span class="show">                         </span></div>
                    </div>
                  </div>
                  
                            <input type="text" id="oauth" name="oauth" hidden>
                  <div class="form-group" id="oauth-tem">
                    <label class="col-form-label">Mã xác thực</label>
                    <div class="form-input position-relative">
                      <input type="text" placeholder="Mã xác thực 2fa" id="oauth-key" name="code"
                                    class="form-control" />
                    </div>
                  </div>
                  
                  <div class="form-group mb-0">
                    <div class="checkbox p-0">
                      <input id="checkbox1" type="checkbox">
                      <label class="text-muted" for="checkbox1">Remember password</label>
                    </div>
                    <button class="btn btn-primary btn-block w-100" type="button" id="btn_login">Đăng nhập</button>
                  </div>
                  <h6 class="text-muted mt-4 or">Or Sign in with</h6>
                  <div class="social mt-4">
                    <div class="btn-showcase"><a class="btn btn-light" href="https://www.linkedin.com/login" target="_blank"><i class="txt-linkedin" data-feather="linkedin"></i> LinkedIn </a><a class="btn btn-light" href="https://twitter.com/login?lang=en" target="_blank"><i class="txt-twitter" data-feather="twitter"></i>twitter</a><a class="btn btn-light" href="https://www.facebook.com/" target="_blank"><i class="txt-fb" data-feather="facebook"></i>facebook</a></div>
                  </div>
                  <p class="mt-4 mb-0 text-center">Don't have account?<a class="ms-2" href="sign-up.html">Create Account</a></p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- latest jquery-->
      <script src="/assets1/js/jquery-3.5.1.min.js"></script>
      <!-- Bootstrap js-->
      <script src="/assets1/js/bootstrap/bootstrap.bundle.min.js"></script>
      <!-- feather icon js-->
      <script src="/assets1/js/icons/feather-icon/feather.min.js"></script>
      <script src="/assets1/js/icons/feather-icon/feather-icon.js"></script>
      <!-- scrollbar js-->
      <!-- Sidebar jquery-->
      <script src="/assets1/js/config.js"></script>
      <!-- Plugins JS start-->
      <!-- Plugins JS Ends-->
      <!-- Theme js-->
      <script src="/assets1/js/script.js"></script>
      <!-- login js-->
      <!-- Plugin used-->
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    </div>
  </body>
</html>