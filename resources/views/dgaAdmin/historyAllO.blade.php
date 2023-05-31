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
                        Lịch sử chơi game MOMO
                    </h2>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-rounded">
                        <div class="card-header block-header-default">
                            <h3 class="card-title">
                                LỊCH SỬ CHƠI GAME
                            </h3>
                        </div>
                        <div class="card-body block-content-full">
                            <table id="history-all" class="table table-row-bordered gy-5">
                                <thead>
                                <tr class="text-gray-600 fw-semibold"> 
                                    <th class="text-center">#</th>
                                    <th style="width: 5%;">Mã GD</th>
                                    <th style="width: 10%;">Số MOMO</th>
                                    <th>Người chuyển</th>
                                    <th>Số tiền</th>
                                    <th>Tiền nhận</th>
                                    <th>Nội dung</th>
                                    <th>Trạng thái</th>
                                    <th>Trả</th>
                                    <th>Số chuyển</th>
                                    <th style="width: 10%;">Ngày chơi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($history as $row)
                                    <tr>
                                        <td class="text-center fs-sm">{{ $row->id }}</td>
                                        <td class="fw-semibold fs-sm"><a href="{{ route('admin.infoTran', ['tran' => $row->tranId]) }}">{{ $row->tranId }}</a></td>
                                        <td class="text-gray-600 fw-semibold">{{ $row->partnerId }}</td>
                                        <td class="text-gray-600 fw-semibold">{{ $row->partnerName }}</td>
                                        <td class="text-gray-600 fw-semibold">{{ number_format($row->amount) }}</td>
                                        <td class="text-gray-600 fw-semibold">{{ number_format($row->receive) }}</td>
                                        <td class="text-gray-600 fw-semibold">{{ $row->comment }}</td>
                                        <td class="fs-sm">
                                            @if ($row->status == 1) <span
                                                class="badge badge-success">Thắng</span>
                                            @elseif ($row->status == 4)
                                                <span
                                                    class="badge badge-success">Hoàn tiền</span>
                                            @elseif ($row->status == 3)
                                                <span
                                                    class="badge badge-danger">Sai hạn mức</span>
                                            @elseif ($row->status == 2)
                                                <span
                                                    class="badge badge-danger">Sai nội dung</span>
                                            @else
                                                <span
                                                    class="badge badge-danger">Thua</span>
                                            @endif
                                        </td>
                                        <td class="fw-semibold fs-sm">@if ($row->pay == 1) <span
                                                class="badge badge-success">Đã trả</span> @elseif($row->pay == 100)
                                                <span
                                                    class="badge badge-danger">Chuyển lỗi</span> @else
                                                <span
                                                    class="badge badge-danger">Chưa trả</span> @endif
                                        </td>
                                        <td class="text-gray-600 fw-semibold">{{ $row->phoneSend }}</td>
                                        <td>
                                            <span class="text-gray-600 fw-semibold">{{ $row->created_at }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                <div class="navpre">
                                    {{ $history->links() }}
                                </div>
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
        $(document).ready(function () {
            /* $('#history-all').DataTable({
                "order": [[0, "desc"]],
                "language": {
                    "lengthMenu": "Hiển thị _MENU_ dòng mỗi trang",
                    "zeroRecords": "Không tìm thấy dữ liệu",
                    "info": "Hiển thị trang _PAGE_ của _PAGES_",
                    "infoEmpty": "Không có dữ liệu",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search": "Tìm kiếm:",
                    "paginate": {
                        "first": "Đầu",
                        "last": "Cuối",
                        "next": "Sau",
                        "previous": "Trước"
                    },
                }
            }); */
        });
    </script>
@endsection