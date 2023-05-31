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
                        Danh sách - thêm momo.
                    </h2>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="row mt-3">
                <div class="col-md-12">
                    @if ($errors->has('status'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <p class="mb-0">
                                {{ $errors->first('message') }}
                            </p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="card block-rounded">
                        <div class="card-header block-header-default">
                            <h3 class="card-title">Thêm Mã Quà</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.giftcodePost') }}" method="POST">
                                @csrf
                                <div class="row push">
                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="">Mã quà</label>
                                            <input type="text" class="form-control" id="code"
                                                   name="code" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="">Số lượt dùng</label>
                                            <input type="text" class="form-control" id="used"
                                                   name="used" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="">Số tiền nhận</label>
                                            <input type="text" class="form-control" id="amount"
                                                   name="amount" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-4">
                                            <button type="submit" class="btn btn-primary fw-semibold w-100">Thêm</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card block-rounded mt-3">
                        <div class="card-header block-header-default">
                            <h3 class="card-title">
                                DANH SÁCH HỖ TRỢ
                            </h3>
                        </div>
                        <div class="card-body block-content-full"><div class="table-responsive">
                            <table
                                class="table table-row-bordered gy-5" id="showdata">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Mã quà</th>
                                    <th>Còn lại</th>
                                    <th>Nhận</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($giftcode as $row)
                                    <tr data-id="{{ $row->id }}">
                                        <td data-field="id" class="text-center fs-sm">{{ $row->id }}</td>
                                        <td data-field="code" class="fw-semibold fs-sm">{{ $row->code }}</td>
                                        <td data-field="used" class="fs-sm">{{ $row->used }}</td>
                                        <td data-field="amount" class="fs-sm">{{ number_format($row->amount) }}</td>
                                        <td class="fw-semibold fs-sm">@if ($row->status == 1 && $row->used > 0) <span
                                                class="badge badge-success">Đang sử dụng</span> @else
                                                <span
                                                    class="badge badge-danger">Hết hạn</span> @endif
                                        </td>
                                        <td>
                                            <span class="text-muted fs-sm">{{ $row->created_at }}</span>
                                        </td>
                                        <td class="" >
                                            <div class="dropup-basic dropdown-basic">
                                                <div class="dropup dropdown">
                                                  <button class="dropbtn btn-primary" type="button">Chọn <span><i class="icofont icofont-arrow-up"></i></span></button>
                                                  <div class="dropup-content dropdown-content">
                                
                                                        <div class="menu-item px-3">
                                                            <a onclick="statusGiftcode({{ $row->id }}, 'delete', 'Bạn chắc chắn muốn xóa ?')" class="menu-link px-3">Xóa</a>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a onclick="statusGiftcode({{ $row->id }}, 'show', 'Bạn chắc chặn muốn cho sử dụng tiếp ?')" class="menu-link px-3">Sử dụng</a>
                                                        </div>
                                                        <div class="menu-item px-3">
                                                            <a onclick="statusGiftcode({{ $row->id }}, 'hidden', 'Bạn chắc chặn muốn hết hạn ?')" class="menu-link px-3">Hết hạn</a>
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

@endsection
@section('script')
    <script>
        $(function () {
            var e = {};
            $(".dga-edits tr").editable({
                dropdowns: {
                    status: ["Hiện", "Ẩn"]
                },
                edit: function (t) {
                    $(".edit i", this).removeClass("fa-pencil-alt").addClass("fa-save").attr("title", "Save")
                },
                save: function (t) {
                    $(".edit i", this).removeClass("fa-save").addClass("fa-pencil-alt").attr("title", "Edit"), this in e && (e[this].destroy(), delete e[this])
                    saveGiftcode(t.id, t.code, t.used, t.amount);
                },
                cancel: function (t) {
                    $(".edit i", this).removeClass("fa-save").addClass("fa-pencil-alt").attr("title", "Edit"), this in e && (e[this].destroy(), delete e[this])
                }
            })
        });

        function saveGiftcode(id, code, used, amount) {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "{{ route('admin.giftcodeEdit') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    code: code,
                    used: used,
                    amount: amount
                },
                success: function (data) {
                    if (data.status == "success") {
                        swal(data.message, "success");
                    } else {
                        swal(data.message, "error");
                    }
                },
            });
        }

        function statusGiftcode(id, type, mess) {
            Swal.fire({
                text: mess,
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
                        url: "{{ route('admin.giftcodeStatus') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
                            type: type
                        },
                        success: function (data) {
                            if (data.status == "success") {
                                swal(data.message, "success");
                                setTimeout(function() {
                                    location.reload();
                                }, 2000)
                            } else {
                                swal(data.message, "error");
                            }
                        },
                    });
                }
            });
        }
    </script>
    <script>
        $(document).ready(function () {
            $('#showdata').DataTable();
        });
    </script>
@endsection
