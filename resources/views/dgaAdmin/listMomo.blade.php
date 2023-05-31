@extends('dgaAdmin.app')
@section('main')
    <main id="main-container">
        <div class="content">
            <div
                class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
                <div class="flex-grow-1 mb-1 mb-md-0">
                    <h1 class="h3 fw-bold mb-2">
                        MOMO
                    </h1>
                    <h2 class="h6 fw-medium fw-medium text-muted mb-0">
                        Danh sách MoMo
                    </h2>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-4">
                        <button onclick="loginAllMomo()" class="btn btn-pill btn-outline-primary btn-lg fw-semibold w-100">Đăng nhập lại tất cả
                            Momo</button>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-4">
                        <button onclick="checkStatusTransfer()" class="btn btn-pill btn-outline-primary btn-lg fw-semibold w-100">Kiểm tra trạng
                            thái all Momo
                        </button>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-4">
                        <button onclick="count()" class="btn btn-pill btn-outline-primary btn-lg fw-semibold w-100">Đếm lại giao dịch
                        </button>
                    </div>
                </div>
                
                <div class="col-md-12">
                    @if ($errors->has('status'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <p class="mb-0">
                                {{ $errors->first('message') }}
                            </p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif


                    <div class="card card-rounded mt-3">
                        <div class="card-header block-header-default">
                            <div class="card-options d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_tutorial">

                                    Hướng Dẫn Thêm Momo
                                </button>
                                <div class="modal fade" id="kt_modal_tutorial" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered mw-650px">
                                        <div class="modal-content">
                                            <div class="modal-header" id="kt_modal_tutorial_header">
                                                <h6 class="fw-bold">Hướng Dẫn</h6>

                                            </div>
                                            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                                <div>
                                                    <span class="mt-5">Bước 1: login vô app MoMo trước rồi gửi mã về, lưu ý
                                                        không được nhập mã vừa gửi về vô app<br><br>
                                                        Bước 2: chờ 30s xong quay trở lại web thêm thông tin rồi bấm gửi
                                                        OTP<br><br>
                                                        Bước 3: Lấy mã OTP khi đăng nhập vào web gửi về nhập vô rồi thêm
                                                        Momo<br><br>
                                                        Bước 4: Enjoy the momment!<br><br>
                                                        Không hiểu chỗ nào có thể ib Admin để hỏi, có call hướng dẫn chi
                                                        tiết!</span>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" data-bs-original-title="" title="">Close</button>
                          </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-start">
                                <p class="card-title">Tổng tiền momo : {{ $countBalance }}</p>
                            </div>
                        </div>
                        <div class="card-body block-content-full">
                            <div class="table-responsive">
                            <table id="showdata" class="table table-row-bordered gy-5" style="padding-top: 100px" >
                                <thead>
                                    <tr class="text-gray-600 fw-semibold">

                                        <th>ID</th>
                                        <th style="width: 15%;">Tên MOMO</th>
                                        <th>Số MOMO</th>
                                        <th>Số dư</th>
                                        <th>Lần chuyển</th>
                                        <th>Hạn mức ngày</th>
                                        <th>Hạn mức tháng</th>
                                        <th>Trạng thái</th>
                                        <th>Đăng nhập lúc</th>
                                        <th>Ngày tạo</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($GetAccountMomo as $row)
                                        <tr id="td_{{ $row->id }}">
                                            <td class="text-gray-600 fw-semibold align-middle">{{ $row->id }}</td>
                                            <td class="fw-semibold fs-sm align-middle">
                                                <div class="text-gray-800 text-hover-primary fw-bold">{{ $row->name }}
                                                </div>
                                            </td>
                                            <td class="text-gray-600 fw-semibold align-middle">{{ $row->phone }}</td>
                                            <td class="text-gray-600 fw-semibold align-middle">{{ number_format($row->balance) }} VND
                                            </td>
                                            <td class="text-gray-600 fw-semibold align-middle">{{ number_format($row->times) }}</td>
                                            <td class="text-gray-600 fw-semibold align-middle">{{ number_format($row->amount) }}</td>
                                            <td class="text-gray-600 fw-semibold align-middle">{{ number_format($row->amountMonth) }}</td>
                                            <td>
                                                {!! $row->status_text !!}
                                            </td>
                                            <td>
                                                {{ $row->time_login }}
                                            </td>
                                            <td>
                                                {{ $row->created_at->format('H:m:s d-m-Y') }}
                                            </td>
                                            <td class="text-left">
                                                
                                              <div class="dropup-basic dropdown-basic" >
                                                <div class="dropup dropdown">
                                                  <button class="dropbtn btn-primary" type="button">Chọn <span><i class="icofont icofont-arrow-up"></i></span></button>
                                                  <div class="dropup-content dropdown-content" >
                                                      
                                                       
                                                        <div class="menu-item px-3">
                                                            <a onclick="activeMomo({{ $row->id }})"
                                                                class="menu-link px-3">Hoạt Động</a>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a onclick="hideMomo({{ $row->id }})"
                                                                class="menu-link px-3">Ẩn Momo</a>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a onclick="maintenanceMomo({{ $row->id }})"
                                                                class="menu-link px-3">Bảo Trì</a>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a onclick="soakMomo({{ $row->id }})"
                                                                class="menu-link px-3">Ngâm MoMo</a>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a onclick="loginOneMomo({{ $row->id }})"
                                                                class="menu-link px-3">Đăng Nhập</a>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a onclick="deleteMomo({{ $row->id }})"
                                                                class="menu-link px-3">Xóa MoMo</a>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a onclick="setLotteria({{ $row->id }})"
                                                                class="menu-link px-3">Treo lô đề</a>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a onclick="infoMomo({{ $row->id }})"
                                                                class="menu-link px-3">Cài Đặt</a>
                                                        </div>
                                                      </div>
                                                </div>
                                              </div>
                        </td>
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
    </main>
    <div class="modal fade" id="infoMomo" tabindex="-1" role="dialog" aria-labelledby="infoMomo"
        aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered mw-650px" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="modal-header" id="infoMomo">
                        <h2 class="fw-bold">Thông Tin Momo</h2>
                    </div>
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7" id="showInfo">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deleteMomo(phone) {
            Swal.fire({
                text: "Bạn chắc chẵn muốn xóa số momo này ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Xóa",
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
                        url: "{{ route('admin.deleteMomo') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            phone: phone,
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                swal(data.message, "success");
                                document.getElementById("td_" + phone).remove();
                            } else {
                                swal(data.message, "error");
                            }
                        },
                    });
                }
            });
        }

        function soakMomo(phone) {
            Swal.fire({
                text: "Bạn chắc chẵn muốn ngâm momo này ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Chắc chắn",
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
                        url: "{{ route('admin.soakMomo') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            phone: phone,
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                swal(data.message, "success");
                                $("#status_" + phone).className =
                                    'fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-warning-light text-warning';
                                $("#status_" + phone).innerHTML = 'Ngâm';
                            } else {
                                swal(data.message, "error");
                            }
                        },
                    });
                }
            });
        }

        function setLotteria(phone){
            Swal.fire({
                text: "Bạn chắc chẵn muốn treo lô đề momo này ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Chắc chắn",
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
                        url: "{{ route('admin.setLotteriaMomo') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            phone: phone,
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                swal(data.message, "success");
                                $("#status_" + phone).className =
                                    'fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-warning-light text-info';
                                $("#status_" + phone).innerHTML = 'Treo lô đề';
                            } else {
                                swal(data.message, "error");
                            }
                        },
                    });
                }
            });
        }

        function loginAllMomo() {

            Swal.fire({
                text: "Bạn chắc chẵn muốn đăng nhập lại toàn bộ momo ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Xác nhận",
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
                        url: "{{ route('admin.loginAllMomo') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                swal(data.message, "success");
                                setTimeout(function() {
                                    location.reload();
                                }, 3000);
                            } else {
                                swal(data.message, "error");
                            }
                        },
                    });
                }
            });
        }

        function checkStatusTransfer() {
            Swal.fire({
                text: "Bạn muốn kiểm tra trạng thái lịch sử ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Xác nhận",
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
                        url: "{{ route('admin.checkStatusTransfer') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                swal(data.message, "success");
                                setTimeout(function() {
                                    location.reload();
                                }, 3000);
                            } else {
                                swal(data.message, "error");
                            }
                        },
                    });
                }
            });
        }

        function count(){
            $.ajax({
                type: "GET",
                url: "{{ route('admin.autoReset') }}",
                success: function(data) {
                    if (data.status == "success") {
                        swal(data.message, "success");
                    } else {
                        swal(data.message, "error");
                    }
                },
            });
        }

        function infoMomo(phone) {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "{{ route('admin.infoMomo') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    phone: phone,
                },
                success: function(data) {
                    if (data.status == "success") {
                        $('#showInfo').html(data.html)
                    } else {
                        swal(data.message, "error");
                    }
                },
            });
            $('#infoMomo').modal('show');
        }

        function activeMomo(phone) {
            Swal.fire({
                text: "Bạn chắc chẵn muốn chỉnh trạng thái hoạt động số momo này ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Xác nhận",
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
                        url: "{{ route('admin.activeMomo') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            phone: phone,
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                swal(data.message, "success");
                                $("#status_" + phone).className =
                                    'fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success';
                                $("#status_" + phone).innerHTML = 'Hoạt động';
                            } else {
                                swal(data.message, "error");
                            }
                        },
                    });
                }
            });
        }

        function loginOneMomo(phone) {
            Swal.fire({
                text: "Bạn chắc chẵn muốn đăng nhập lại số momo này ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Xác nhận",
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
                        url: "{{ route('admin.loginMomoOne') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            phone: phone,
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                swal(data.message, "success");
                                $("#status_" + phone).className =
                                    'fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success';
                                $("#status_" + phone).innerHTML = 'Hoạt động';
                            } else {
                                swal(data.message, "error");
                            }
                        },
                    });
                }
            });
        }

        function hideMomo(phone) {
            Swal.fire({
                text: "Bạn chắc chẵn muốn chỉnh trạng thái ẩn số momo này ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Xác nhận",
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
                        url: "{{ route('admin.hideMomo') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            phone: phone,
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                swal(data.message, "success");
                                $("#status_" + phone).className =
                                    'fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-danger-light text-danger';
                                $("#status_" + phone).innerHTML = 'Ẩn';
                            } else {
                                swal(data.message, "error");
                            }
                        },
                    });
                }
            });
        }

        function maintenanceMomo(phone) {
            Swal.fire({
                text: "Bạn chắc chẵn muốn chỉnh trạng thái bảo trì số momo này ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Xác nhận",
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
                        url: "{{ route('admin.maintenanceMomo') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            phone: phone,
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                swal(data.message, "success");
                                $("#status_" + phone).className =
                                    'fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-danger-light text-danger';
                                $("#status_" + phone).innerHTML = 'Bảo trì';
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
        $('#showdata').dataTable({
            order: [[7, 'asc']],
            pageLength: 100
        });

    </script>
@endsection
