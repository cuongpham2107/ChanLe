<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HỆ THỐNG QUẢN TRỊ CLMM CỦA {{ $setting->name }}</title>
    <link rel="shortcut icon" href="https://copper.wiki/assets/img/logo.png">
    <!-- Google font-->
    {{-- <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap"
        rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
        rel="stylesheet">
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
    <link rel="stylesheet" type="text/css" href="/assets1/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="/assets1/css/vendors/datatables.css">
    {{-- <link rel="stylesheet" type="text/css" href="/dgaAdmin/assets/css/oneui.min-5.2.css"> --}}
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="/assets1/css/vendors/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/assets1/dataTables.checkboxes.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="/assets1/css/style.css">
    <link id="color" rel="stylesheet" href="/assets1/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="/assets1/css/responsive.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <style>
        .table-responsive,
        .dataTables_scrollBody {
            overflow: visible !important;
        }
        
        .table-responsive-disabled .dataTables_scrollBody {
            overflow: hidden !important;
        }
        </style>
</head>

<body>
    <!-- loader starts-->
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo">
                </fecolormatrix>
            </filter>
        </svg>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        <div class="page-header">
            <div class="header-wrapper row m-0">
                <form class="form-inline search-full col" action="#" method="get">
                    <div class="form-group w-100">
                        <div class="Typeahead Typeahead--twitterUsers">
                            <div class="u-posRelative">
                                <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text"
                                    placeholder="Search Cuba .." name="q" title="" autofocus>
                                <div class="spinner-border Typeahead-spinner" role="status"><span
                                        class="sr-only">Loading...</span></div><i class="close-search"
                                    data-feather="x"></i>
                            </div>
                            <div class="Typeahead-menu"></div>
                        </div>
                    </div>
                </form>
                <div class="header-logo-wrapper col-auto p-0">
                    <div class="logo-wrapper"><a href="/"><img class="img-fluid"
                                src="/assets1/images/logo/logo.png" alt=""></a></div>
                    <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle"
                            data-feather="align-center"></i></div>
                </div>
                <div class="left-header col horizontal-wrapper ps-0">
                </div>
                <div class="nav-right col-8 pull-right right-header p-0">
                    <ul class="nav-menus">
                        
                        <li>
                            <div class="mode"><i class="fa fa-moon-o"></i></div>
                        </li>
                        <li class="maximize"><a class="text-dark" href="#!"
                                onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
                        <li class="profile-nav onhover-dropdown p-0 me-0">
                            <div class="media profile-media"><img class="b-r-10"
                                    src="/upload/files/profile.png" height=37px alt="">
                                <div class="media-body"><span>{{ Auth::user()->username }}</span>
                                    <p class="mb-0 font-roboto">COPPER WIKI <i class="middle fa fa-angle-down"></i></p>
                                </div>
                            </div>
                            <ul class="profile-dropdown onhover-show-div">
                                <li><a href="https://t.me/copper_wiki"><i data-feather="user"></i><span>Telegram </span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <script class="result-template" type="text/x-handlebars-template">
            <div class="ProfileCard u-cf">                        
            <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
            <div class="ProfileCard-details">
            <div class="ProfileCard-realName">dd</div>
            </div>
            </div>
          </script>
                <script class="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
            </div>
        </div>
        <!-- Page Header Ends                              -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            <div class="sidebar-wrapper">
                <div>
                    <div class="logo-wrapper"><a href="/"><img class="img-fluid for-light"
                                src="https://copper.wiki/assets/img/logo.png" alt="" width="180px"><img class="img-fluid for-dark"
                                src="https://copper.wiki/assets/img/logo.png" alt="" width="180px"></a>
                        <div class="back-btn"><i class="fa fa-angle-left"></i></div>
                        <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle"
                                data-feather="grid"> </i></div>
                    </div>
                    <div class="logo-icon-wrapper"><a href="/"><img class="img-fluid"
                                src="/upload/files/msv.png" width="50px" alt=""></a></div>
                    <nav class="sidebar-main">
                        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                        <div id="sidebar-menu">
                            <ul class="sidebar-links" id="simple-bar">
                                <li class="back-btn"><a href="/"><img class="img-fluid"
                                            src="/upload/files/msv.png" width="50px" alt=""></a>
                                    <div class="mobile-back text-end"><span>Back</span><i
                                            class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                                </li>
                                
                                <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                    href="{{ route('admin.home') }}"><i data-feather="home"> </i><span>Trang chủ</span></a></li>
                               <li class="sidebar-main-title">
                    <div>
                      <h6 class="">QUẢN LÝ </h6>
                      <p class=""></p>
                    </div>
                  </li>
                                {{-- <li class="sidebar-list">
                                   <a
                                        class="sidebar-link sidebar-title" href="#"><i
                                            data-feather="box"></i><span>Momo </span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="{{ route('admin.addMomo') }}">Thêm momo</a></li>
                                        <li><a href="{{ route('admin.listMomo') }}">Danh sách momo</a></li>
                                    </ul>
                                </li>  --}}
                                <li class="sidebar-list">
                                    <a
                                         class="sidebar-link sidebar-title" href="#"><i
                                             data-feather="box"></i><span>Zalo </span></a>
                                     <ul class="sidebar-submenu">
                                         <li><a href="{{ route('admin.addZalopay') }}">Thêm zalo</a></li>
                                         <li><a href="{{ route('admin.listZalo') }}">Danh sách zalo</a></li>
                                     </ul>
                                 </li> 
                                <li class="sidebar-list">
                                    <a
                                         class="sidebar-link sidebar-title" href="#"><i
                                             data-feather="settings"></i><span>Tool </span></a>
                                     <ul class="sidebar-submenu">
                                        <li><a href="{{ route('admin.historyPlayALL') }}">Toàn bộ giao dịch</a></li>
                                        <li><a href="{{ route('admin.historyPlayError') }}">Danh sách bill lỗi</a></li>

                                         {{-- <li><a href="{{ route('admin.addNewHistory') }}">Thêm bill thủ công</a></li> --}}
                                         <li><a href="{{ route('admin.checkTran') }}">Check bill trực tiếp</a></li>
                                         <li><a href="{{ route('admin.sendMomo') }}">Chuyển tiền</a></li>
                                         {{-- <li><a href="{{ route('admin.sendBank') }}">Chuyển tiền qua NH</a></li> --}}
                                         <li><a href="{{ route('admin.blackList') }}">Danh sách đen</a></li>
                                     </ul>
                                 </li>
                                 {{-- <li class="sidebar-list">
                                    <a
                                         class="sidebar-link sidebar-title" href="#"><i
                                             data-feather="tv"></i><span>Lô Đề Tự Động </span></a>
                                     <ul class="sidebar-submenu">
                                       <li><a href="{{ route('admin.lotteriaHistoryPlayALL') }}">Lịch sử ghi lô - đề</a></li>
                                       <li><a href="{{ route('admin.lotteriaResult') }}">Kết quả XS</a></li>
                                       <li><a href="{{ route('admin.lotteriaSettingGame') }}">Cài đặt</a></li>
                                     </ul>
                                 </li> --}}
                                 <li class="sidebar-list">
                                     <a
                                          class="sidebar-link sidebar-title" href="#"><i
                                              data-feather="pie-chart"></i><span>Báo cáo và thống kê </span></a>
                                      <ul class="sidebar-submenu">
                                        <li><a href="{{ route('admin.statistics') }}">Tổng quan (mới)</a></li>
                                          <li><a href="{{ route('admin.historyofWeek') }}">Lịch sử chơi tuần</a></li>
                                          <li><a href="{{ route('admin.weekTop') }}">Top ngày</a></li>
                                      </ul>
                                  </li>
                                  <li class="sidebar-list">
                                      <a
                                           class="sidebar-link sidebar-title" href="#"><i
                                               data-feather="cpu"></i><span>Dịch vụ </span></a>
                                       <ul class="sidebar-submenu">
                                           <li><a href="{{ route('admin.historyBank') }}">Lịch sử chuyển tiền</a></li>
                                           {{-- <li><a href="{{ route('admin.payMoneyMiniGameError')}}">Tự động thanh toán bill lỗi</a></li> --}}
                                           <li><a href="{{ route('admin.historyDayMission') }}">Nhiệm vụ hằng ngày</a></li>
                                           <li><a href="{{ route('admin.historyMuster') }}">Lịch sử điểm danh</a></li>
                                           <li><a href="{{ route('admin.historyHu') }}">Lịch sử thắng event</a></li>
                                       </ul>
                                   </li>
                                   <li class="sidebar-main-title">
                    <div>
                      <h6 class="">CÀI ĐẶT</h6>
                      <p class=""></p>
                    </div>
                  </li>
                                   <li class="sidebar-list">
                                       <a
                                            class="sidebar-link sidebar-title" href="#"><i
                                                data-feather="map"></i><span>Mini game </span></a>
                                        <ul class="sidebar-submenu">
                                            <li><a href="{{ route('admin.settingGame') }}">Tỉ lệ - Nội dung</a></li>
                                            <li><a href="{{ route('admin.settingTt') }}">Nội dung trả thưởng</a></li>
                                            <li><a href="{{ route('admin.giftcode') }}">Code khuyến mãi</a></li>
                                            <li><a href="{{ route('admin.historyGiftCode') }}">Lịch sử trả Giftcode</a></li>
                                        </ul>
                                    </li>
                                    
                                <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                    href="{{ route('admin.setting') }}"><i data-feather="settings"> </i><span>Website</span></a></li>
                                    
                                <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                    href="{{ route('admin.support') }}"><i data-feather="mail"> </i><span>Link hỗ trợ</span></a></li>
                                    <li class="sidebar-main-title">
                    <div>
                      <h6 class="">CÁ NHÂN</h6>
                      <p class=""></p>
                    </div>
                  </li>
                                <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                    href="{{ route('admin.changePass') }}"><i data-feather="lock"> </i><span>Đổi mật khẩu</span></a></li>
                                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                        href="{{ route('admin.setup2fa') }}"><i data-feather="lock"> </i><span>Cài đặt 2FA</span></a></li>
                            </ul>
                        </div>
                        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                    </nav>
                </div>
            </div>
            <!-- Page Sidebar Ends-->
            <div class="page-body">
                {{-- <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                               
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    @yield('main')
                </div>
                <!-- Container-fluid Ends-->
            </div>
            <!-- footer start-->
            {{-- <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 footer-copyright text-center">
                            <p class="mb-0">Copyright 2021 © COPPER</p>
                        </div>
                    </div>
                </div>
            </footer> --}}
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
    <script src="/assets1/js/scrollbar/simplebar.js"></script>
    <script src="/assets1/js/scrollbar/custom.js"></script>
    <!-- Sidebar jquery-->
    <script src="/assets1/js/config.js"></script>
    <!-- Plugins JS start-->
    <script src="/assets1/js/sidebar-menu.js"></script>
    <script src="/assets1/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets1/js/datatable/datatables/datatable.custom.js"></script>
    <script src="/assets1/dataTables.checkboxes.min.js"></script>
    
    <script src="/assets1/js/tooltip-init.js"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="/assets1/js/script.js"></script>
    
    <!-- login js-->
    <script src="/assets1/js/dunga.js"></script>
    {{-- <script src="/assets1/js/datepicker/date-picker/datepicker.js"></script> --}}
<script src="/dgaAdmin/assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <!-- Plugin used-->
    @yield('script')

</body>

</html>
