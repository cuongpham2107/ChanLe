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
                        Lịch sử ghi LO - ĐỀ
                    </h2>
                </div>
                <div class="mt-3 mt-md-0 ms-md-3 space-x-1">
                    <form action="{{ route('admin.lotteriaHistoryPlayALL') }}" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-alt js-flatpickr" id="dga-datepicker"
                                data-date-format="yyyy-mm-dd" name="date"
                                value="@if (!empty($_GET['date'])) @php echo $_GET['date']@endphp@else{{ date('Y-m-d', time()) }} @endif">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search me-1"></i> Tìm
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-rounded">
                        <div class="card-body block-content-full">
                            <a onclick="autoPay()" class="btn btn-sm btn-info">Thanh toán tự động</a>
                            <div class="table-responsive">
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
                                        @foreach ($history as $row)
                                            <tr>
                                                <td class="text-center fs-sm">{{ $row->id }}</td>
                                                <td class="fw-semibold fs-sm"><a
                                                        href="{{ route('admin.infoTran', ['tran' => $row->tranId]) }}">{{ $row->tranId }}</a>
                                                </td>
                                                <td class="text-gray-600 fw-semibold">{{ $row->partnerId }}</td>
                                                <td class="text-gray-600 fw-semibold">{{ $row->partnerName }}</td>
                                                <td class="text-gray-600 fw-semibold">{{ number_format($row->amount) }}</td>
                                                <td class="text-gray-600 fw-semibold">{{ number_format($row->receive) }}
                                                </td>
                                                <td class="text-gray-600 fw-semibold">{{ $row->comment }}</td>
                                                <td class="fs-sm">
                                                    @if ($row->status == 1)
                                                        <span class="badge badge-success">Thắng</span>
                                                    @elseif ($row->status == 5)
                                                        <span class="badge badge-info">Chờ kết quả</span>
                                                    @elseif ($row->status == 4)
                                                        <span class="badge badge-success">Hoàn tiền</span>
                                                    @elseif ($row->status == 2)
                                                        <span class="badge badge-danger">Sai nội dung</span>
                                                    @elseif ($row->status == 3)
                                                        <span class="badge badge-danger">Sai hạn mức</span>
                                                    @else
                                                        <span class="badge badge-danger">Thua</span>
                                                    @endif
                                                </td>
                                                <td class="fw-semibold fs-sm">
                                                    @if ($row->pay == 1)
                                                        <span class="badge badge-success">Đã trả</span>
                                                    @elseif($row->pay == 100)
                                                        <span class="badge badge-danger">Chuyển lỗi</span>
                                                    @elseif($row->pay == 5)
                                                        <span class="badge badge-info">Chờ thanh toán</span>
                                                    @else
                                                        <span class="badge badge-danger">Chưa trả</span>
                                                    @endif
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
                                        {{-- {{ $history->links('pagination::bootstrap-4') }} --}}
                                    </div>
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
        function autoPay(){
            Swal.fire({
                text: "Hệ thống sẽ tự động chuyển tất cả các bill thắng thành trạng thái chưa trả.",
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
                        type: "GET",
                        url: "{{ route('admin.autoPayLotteriaBills') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                swal("Đã chỉnh trạng thái tất cả các bill lô đề thắng thành chưa trả.","success");
                                
                                
                            } else {
                                swal(data.message, "error");
                            }
                        },
                    });
                }
            });
        }
        $(document).ready(function() {
            $('#history-all').DataTable({
                order: [
                    [0, 'desc']
                ],
                pageLength: 50
            });
        });
        $(function() {
            $.fn.datepicker.dates['vi'] = {
                days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
                daysMin: ["CN", "T2", "T3", "T4", "T", "T5", "T6"],
                months: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8",
                    "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
                ],
                monthsShort: ["Th 1", "Th 2", "Th 3", "Th 4", "Th 5", "Th 6", "Th 7", "Th 8", "Th 9", "Th 10",
                    "Th 11", "Th 12"
                ],
                today: "Hôm nay",
                clear: "Xóa",
                format: "yyyy/mm/dd",
                titleFormat: "MM yyyy",
                /* Leverages same syntax as 'format' */
                weekStart: 0
            };
            $("#dga-datepicker").datepicker({
                language: "vi"
            });
        });
    </script>
@endsection
