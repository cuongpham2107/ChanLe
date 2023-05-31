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
                        Kết quả xổ số theo ngày
                    </h2>
                </div>
                <div class="mt-3 mt-md-0 ms-md-3 space-x-1">
                    <form action="{{ route('admin.lotteriaResult') }}" method="get">
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
                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <p class="mb-0">
                                    {{ $errors->first() }}
                                </p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                            <div style="flex-direction: :row; margin-bottom:20px">
                                <a href="{{ route('admin.getLotteriaResults',['type_region'=>0]) }}" class="btn btn-sm btn-success" style="margin-right:20px">Lấy KQXS Miền Nam</a>
                                <a href="{{ route('admin.getLotteriaResults',['type_region'=>1]) }}" class="btn btn-sm btn-success" style="margin-right:20px">Lấy KQXS Miền Trung</a>
                                <a href="{{ route('admin.getLotteriaResults',['type_region'=>2]) }}" class="btn btn-sm btn-success">Lấy KQXS Miền Bắc</a>
                            </div>

                            <div class="table-responsive">
                                <table id="history-all" class="table table-row-bordered gy-5">
                                    <thead>
                                        <tr class="text-gray-600 fw-semibold">
                                            <th class="text-center">#</th>
                                            <th style="">Tỉnh</th>
                                            <th style="">Giải</th>
                                        
                                            <th style="">Ngày xổ</th>
                                            <th style="">Ngày tạo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($history as $row)
                                            <tr>
                                                <td class="text-center fs-sm">{{ $row->id }}</td>
                                                <td class="fw-semibold fs-sm">
                                                    {{$row->province->name}}
                                                </td>
                                                <td class="text-gray-600 fw-semibold">
                                                    <span class="text-danger"> <b>Đặc biệt: {{ $row->jackpot}}</b> </span> <br />
                                                    <span> Giải nhất: {{ $row->g1}} </span><br />
                                                    <span> Giải nhì: {{ $row->g2}} </span><br />
                                                    <span> Giải ba: {{ $row->g3}} </span><br />
                                                    <span> Giải tư: {{ $row->g4}} </span><br />
                                                    <span> Giải năm: {{ $row->g5}} </span><br />
                                                    <span> Giải sáu: {{ $row->g6}} </span><br />
                                                    <span> Giải bảy: {{ $row->g7}} </span><br />
                                                    @if ($row->g8 )
                                                    <span> Giải tám: {{ $row->g8}} </span>
                                                    @endif
                                                </td>
                                                <td class="text-gray-600 fw-semibold">
                                                    {{ $row->date }}
                                                </td>
                                                <td class="text-gray-600 fw-semibold">
                                                    {{ $row->created_at }}
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
