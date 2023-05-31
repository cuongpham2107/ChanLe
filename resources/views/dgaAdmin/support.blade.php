@extends('dgaAdmin.app')
@section('main')
    <main id="main-container">
        <div class="content">
            <div
                class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
                <div class="flex-grow-1 mb-1 mb-md-0">
                    <h1 class="h3 fw-bold mb-2">
                        SUPPORT
                    </h1>
                    <h2 class="h6 fw-medium fw-medium text-muted mb-0">
                        Danh sách hỗ trợ.
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
                    <div class="card block-rounded">
                        <div class="card-header block-header-default">
                            <h3 class="card-title">Thêm Hỗ Trợ</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.supportPost') }}" method="POST">
                                @csrf
                                <div class="row push">
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <label class="form-label" for="">Tên</label>
                                            <input type="text" class="form-control" id="name"
                                                   name="name" placeholder="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <label class="form-label" for="">Link</label>
                                            <input type="text" class="form-control" id="href"
                                                   name="href" placeholder="">
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
                                    <th style="width: 5%;" class="text-center">#</th>
                                    <th style="width: 15%;">Tên</th>
                                    <th>Link</th>
                                    <th>Trạng thái</th>
                                    <th style="width: 15%;">Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($support as $row)
                                    <tr data-id="{{ $row->id }}">
                                        <td data-field="id" class="text-center fs-sm">{{ $row->id }}</td>
                                        <td data-field="name" class="fw-semibold fs-sm">{{ $row->name }}</td>
                                        <td data-field="href" class="fs-sm">{{ $row->href }}</td>
                                        <td class="fw-semibold fs-sm">@if ($row->status == 1) <span
                                                class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success">Hiện thị</span> @else
                                                <span
                                                    class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-danger-light text-danger">Bị Ẩn</span> @endif
                                        </td>
                                        <td>
                                            <span class="text-muted fs-sm">{{ $row->created_at }}</span>
                                        </td>
                                        
                                            <td class="text-left" >
                                                
                                              <div class="dropup-basic dropdown-basic">
                                                <div class="dropup dropdown">
                                                  <button class="dropbtn btn-primary" type="button">Chọn <span><i class="icofont icofont-arrow-up"></i></span></button>
                                                  <div class="dropup-content dropdown-content">
                                                       <div class="menu-item px-3">
                                                    <a onclick="statusContact({{ $row->id }}, 'delete', 'Bạn chắc chắn muốn xóa ?')" class="menu-link px-3">Xóa</a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a onclick="statusContact({{ $row->id }}, 'show', 'Bạn chắc chặn muốn hiện ?')" class="menu-link px-3">Hiện</a>
                                                </div>
                                                <div class="menu-item px-3">
                                                    <a onclick="statusContact({{ $row->id }}, 'hidden', 'Bạn chắc chặn muốn ẩn ?')" class="menu-link px-3">Ẩn</a>
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
                    saveContact(t.id, t.name, t.href);
                },
                cancel: function (t) {
                    $(".edit i", this).removeClass("fa-save").addClass("fa-pencil-alt").attr("title", "Edit"), this in e && (e[this].destroy(), delete e[this])
                }
            })
        });

        function saveContact(id, name, href) {
            $.ajax({
                type: "POST",
                dataType: "JSON",
                url: "{{ route('admin.supportEdit') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    name: name,
                    href: href
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

        function statusContact(id, type, mess) {
            Swal.fire({
                title: mess,
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
                        url: "{{ route('admin.supportStatus') }}",
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

        $('#showdata').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "lengthMenu": "Hiển thị _MENU_ dòng",
                "zeroRecords": "Không có dữ liệu",
                "info": "Hiển thị trang _PAGE_ của _PAGES_",
                "infoEmpty": "Không có dữ liệu",
                "infoFiltered": "(Tìm kiếm trong _MAX_ dòng)",
                "search": "Tìm kiếm",
                "paginate": {
                    "first": "Đầu",
                    "last": "Cuối",
                    "next": "Sau",
                    "previous": "Trước"
                },
            }
        });
    </script>
    
@endsection
