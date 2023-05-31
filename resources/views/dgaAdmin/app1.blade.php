<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HỆ THỐNG QUẢN TRỊ CLMM CỦA {{ $setting->name}}</title>
    <link rel="shortcut icon" href="{{ $setting->favicon }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" id="css-main" href="/dgaAdmin/assets/css/oneui.min-5.2.css">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
    <link rel="stylesheet" href="/dgaAdmin/assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="/dgaAdmin/assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="/dgaAdmin/assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="/dgaAdmin/assets/js/plugins/select2/css/select2.min.css">
</head>
<body>
<div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">
    <nav id="sidebar" aria-label="Main Navigation">
        <div class="content-header">
            <a class="fw-semibold text-dual" href="{{ route('admin.home') }}">
      <span class="smini-visible">
        <i class="fa fa-circle-notch text-primary"></i>
      </span>
                <span class="smini-hide fs-5 tracking-wider">CL<span class="fw-normal">MM</span></span>
            </a>
            <div>
                <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="layout" data-action="dark_mode_toggle">
                    <i class="far fa-moon"></i>
                </button>
                <a class="d-lg-none btn btn-sm btn-alt-secondary ms-1" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                    <i class="fa fa-fw fa-times"></i>
                </a>
            </div>
        </div>
        <div class="js-sidebar-scroll">
            <div class="content-side">
                <ul class="nav-main">
                    <li class="nav-main-item">
                        <a class="nav-main-link active" href="{{ route('admin.home') }}">
                            <i class="nav-main-link-icon si si-speedometer"></i>
                            <span class="nav-main-link-name">Thống kê</span>
                        </a>
                    </li>
                    <li class="nav-main-heading">Quản lí API</li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('admin.addMomo') }}">
                            <i class="nav-main-link-icon si si-phone"></i>
                            <span class="nav-main-link-name">Quản lí SĐT</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('admin.historyPlayALL') }}">
                            <i class="nav-main-link-icon si si-refresh"></i>
                            <span class="nav-main-link-name">Lịch sử chơi game</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('admin.historyBank') }}">
                            <i class="nav-main-link-icon si si-refresh"></i>
                            <span class="nav-main-link-name">Lịch sử chuyền tiền</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" <link href="{{ url('') }}/xu-ly-pay-error" rel="stylesheet" />
                            <i class="nav-main-link-icon si si-refresh"></i>
                            <span class="nav-main-link-name">Tự động thanh toán bill lỗi</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                            <i class="nav-main-link-icon si si-refresh"></i>
                            <span class="nav-main-link-name">Lịch sử Event</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="{{ route('admin.historyDayMission') }}">
                                    <span class="nav-main-link-name">Nhiệm vụ ngày</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="{{ route('admin.historyMuster') }}">
                                    <span class="nav-main-link-name">Lịch sử điểm danh</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="{{ route('admin.historyHu') }}">
                                    <span class="nav-main-link-name">Lịch sử thắng event</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="{{ route('admin.historyBankEvent') }}">
                                    <span class="nav-main-link-name">Lịch sử thanh toán event</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                            <i class="nav-main-link-icon fa fa-gifts"></i>
                            <span class="nav-main-link-name">Cài đặt Giftcode</span>
                        </a>
                        <ul class="nav-main-submenu">
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="{{ route('admin.giftcode') }}">
                                    <span class="nav-main-link-name">Mã quà</span>
                                </a>
                            </li>
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="{{ route('admin.historyGiftCode') }}">
                                    <span class="nav-main-link-name">Lịch sử</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('admin.weekTop') }}">
                            <i class="nav-main-link-icon fa fa-arrow-trend-up"></i>
                            <span class="nav-main-link-name">Top tuần - ngày - tháng</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('admin.blackList') }}">
                            <i class="nav-main-link-icon si si-lock"></i>
                            <span class="nav-main-link-name">Danh sách đen</span>
                        </a>
                    </li>
                    <li class="nav-main-heading">Cài đặt Website</li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('admin.changePass') }}">
                            <i class="nav-main-link-icon si si-user"></i>
                            <span class="nav-main-link-name">Đổi mật khẩu</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('admin.setting') }}">
                            <i class="nav-main-link-icon si si-settings"></i>
                            <span class="nav-main-link-name">Cài đặt chung</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('admin.settingGame') }}">
                            <i class="nav-main-link-icon si si-settings"></i>
                            <span class="nav-main-link-name">Cài đặt game</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="{{ route('admin.support') }}">
                            <i class="nav-main-link-icon si si-support"></i>
                            <span class="nav-main-link-name">Link hỗ trợ</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <header id="page-header">
        <div class="content-header">
            <div class="d-flex align-items-center">
                <button type="button" class="btn btn-sm btn-alt-secondary me-2 d-lg-none" data-toggle="layout" data-action="sidebar_toggle">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
                <button type="button" class="btn btn-sm btn-alt-secondary me-2 d-none d-lg-inline-block" data-toggle="layout" data-action="sidebar_mini_toggle">
                    <i class="fa fa-fw fa-ellipsis-v"></i>
                </button>
                <button type="button" class="btn btn-sm btn-alt-secondary d-md-none" data-toggle="layout" data-action="header_search_on">
                    <i class="fa fa-fw fa-search"></i>
                </button>
                <form class="d-none d-md-inline-block" action="be_pages_generic_search.html" method="POST">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control form-control-alt" placeholder="Search.." id="page-header-search-input2" name="page-header-search-input2">
                        <span class="input-group-text border-0">
            <i class="fa fa-fw fa-search"></i>
          </span>
                    </div>
                </form>
            </div>
            <div class="d-flex align-items-center">
                <div class="dropdown d-inline-block ms-2">
                    <button type="button" class="btn btn-sm btn-alt-secondary d-flex align-items-center" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle" src="https://i.imgur.com/U4kvmYv.png" alt="Header Avatar" style="width: 21px;">
                        <span class="d-none d-sm-inline-block ms-2">{{ $setting->name}}</span>
                        <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block opacity-50 ms-1 mt-1"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0" aria-labelledby="page-header-user-dropdown">
                        <div class="p-3 text-center bg-body-light border-bottom rounded-top">
                            <img class="img-avatar img-avatar48 img-avatar-thumb" src="https://i.imgur.com/U4kvmYv.png" alt="">
                            <p class="mt-2 mb-0 fw-medium">{{ $setting->name}}</p>
                            <p class="mb-0 text-muted fs-sm fw-medium">Web Developer</p>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-alt-secondary ms-2" data-toggle="layout" data-action="side_overlay_toggle">
                    <i class="fa fa-fw fa-list-ul fa-flip-horizontal"></i>
                </button>
            </div>
        </div>
        <div id="page-header-loader" class="overlay-header bg-body-extra-light">
            <div class="content-header">
                <div class="w-100 text-center">
                    <i class="fa fa-fw fa-circle-notch fa-spin"></i>
                </div>
            </div>
        </div>
    </header>
@yield('main')
    <footer id="page-footer" class="bg-body-light">
        <div class="content py-3">
            <div class="row fs-sm">
                <div class="col-sm-6 order-sm-2 py-1 text-center text-sm-end">
                    Crafted with <i class="fa fa-heart text-danger"></i> by <a class="fw-semibold"
                                                                               href="https://1.envato.market/ydb"
                                                                               target="_blank">{{ $setting->name}}</a>
                </div>
                <div class="col-sm-6 order-sm-1 py-1 text-center text-sm-start">
                    <a class="fw-semibold" href="#" target="_blank">{{ $setting->name }}</a> &copy;
                    <span data-toggle="year-copy"></span>
                </div>
            </div>
        </div>
    </footer>
</div>
<script src="/dgaAdmin/assets/js/oneui.app.min-5.2.js"></script>
<script src="/dgaAdmin/assets/js/plugins/chart.js/chart.min.js"></script>
<script src="/dgaAdmin/assets/js/pages/be_pages_dashboard.min.js"></script>
<script src="/dgaAdmin/assets/js/lib/jquery.min.js"></script>
<script src="/dgaAdmin/assets/js/dunga.js"></script>
<script src="/dgaAdmin/assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="/dgaAdmin/assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/dgaAdmin/assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="/dgaAdmin/assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/dgaAdmin/assets/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
<script src="/dgaAdmin/assets/js/plugins/datatables-buttons/dataTables.buttons.min.js"></script>
<script src="/dgaAdmin/assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
<script src="/dgaAdmin/assets/js/plugins/datatables-buttons-jszip/jszip.min.js"></script>
<script src="/dgaAdmin/assets/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js"></script>
<script src="/dgaAdmin/assets/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js"></script>
<script src="/dgaAdmin/assets/js/plugins/datatables-buttons/buttons.print.min.js"></script>
<script src="/dgaAdmin/assets/js/plugins/datatables-buttons/buttons.html5.min.js"></script>
<script src="/dgaAdmin/assets/js/pages/be_tables_datatables.min.js"></script>
<script src="/dgaAdmin/assets/js/plugins/editable/editable.js"></script>
<script src="/dgaAdmin/assets/js/plugins/ckeditor/ckeditor.js"></script>
<script src="https://cdn.tiny.cloud/1/2fmm6ia2vlt4f1qqaebsnhb5rhguo3u8vc6h17h3quk8oup8/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script src="/dgaAdmin/assets/js/plugins/select2/js/select2.full.min.js"></script>
@yield('script')
</body>
</html>
