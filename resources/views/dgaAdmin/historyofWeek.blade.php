@extends('dgaAdmin.app')
@section('main')
    <main id="main-container">
        <div class="content">
            <div
                class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
                <div class="flex-grow-1 mb-1 mb-md-0">
                    <h1 class="h3 fw-bold mb-2">
                        Thống kê
                    </h1>
                </div>
            </div>
        </div>
        <div class="content">
             
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-rounded">
                        <div class="card-header block-header-default">
                            <h3 class="card-title">
                                LỊCH SỬ CHƠI TUẦN NÀY
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                           <table id="kt_datatable_zero_configuration" class="table table-row-bordered gy-5">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-muted">
                                    <th class="text-center">#</th>
                                    <th style="width: 10%;">Số MOMO</th>
                                    <th>Tổng chơi (VND)</th>
                                    <th>Số lần chơi</th>
                                    <th>Tổng tiền trả (VND)</th>
                                    <th>Doanh thu Web (VND)</th>
                                    </tr>
                                    </thead>
                                <tbody>
                                @php $i = 1; @endphp

                                @foreach($historyNew as $row)
                                    <tr>
                                        <td class="text-center fs-sm">{{ $i++ }}</td>
                                        <td class="fw-semibold fs-sm">{{ $row->partnerId }}</td>
                                        <td class="fw-semibold fs-sm">{{ number_format($row->amountAll) }}</td>
                                        <td class="fw-semibold fs-sm">{{ $row->turnAll }}</td>
                                        <td class="fw-semibold fs-sm">{{ number_format($row->amountWin) }}</td>
                                        <td class="fw-semibold fs-sm">{{ number_format($row->revenue) }}</td>
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
    $(document).ready(function(){
        $("#kt_datatable_zero_configuration").DataTable({
            order: [[5, 'desc']],
            pageLength: 100
        });
    })
</script>
    {{-- <script>
        $(function () {
            $.fn.datepicker.dates['vi'] = {
                days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
                daysMin: ["CN", "T2", "T3", "T4", "T", "T5", "T6"],
                months: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
                monthsShort: ["Th 1", "Th 2", "Th 3", "Th 4", "Th 5", "Th 6", "Th 7", "Th 8", "Th 9", "Th 10", "Th 11", "Th 12"],
                today: "Hôm nay",
                clear: "Xóa",
                format: "yyyy/mm/dd",
                titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
                weekStart: 0
            };
            $("#dga-datepicker").datepicker({
                language: "vi"
            });
        });
        let i = document.getElementById("dga-chart");
        let n = {
            labels: ["{{ $day[7] }}", "{{ $day[6] }}", "{{ $day[5] }}", "{{ $day[4] }}", "{{ $day[3] }}", "{{ $day[2] }}", "{{ $day[1] }}"],
            datasets: [{
                label: "Tiền chơi",
                fill: !0,
                backgroundColor: "rgba(171, 227, 125, .5)",
                borderColor: "rgba(171, 227, 125, 1)",
                pointBackgroundColor: "rgba(171, 227, 125, 1)",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "rgba(171, 227, 125, 1)",
                data: [{{ $moneyDay[7] }}, {{ $moneyDay[6] }}, {{ $moneyDay[5] }}, {{ $moneyDay[4] }}, {{ $moneyDay[3] }}, {{ $moneyDay[2] }}, {{ $moneyDay[1] }}]
            }, {
                label: "Tiền thắng",
                fill: !0,
                backgroundColor: "#F47C7C",
                borderColor: "rgba(0, 0, 0, .3)",
                pointBackgroundColor: "rgba(0, 0, 0, .3)",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "rgba(0, 0, 0, .3)",
                data: [{{ $receiveDay[7] }}, {{ $receiveDay[6] }}, {{ $receiveDay[5] }}, {{ $receiveDay[4] }}, {{ $receiveDay[3] }}, {{ $receiveDay[2] }}, {{ $receiveDay[1] }}]
            }, {
                label: "Tiền lãi",
                fill: !0,
                backgroundColor: "#FFE3A9",
                borderColor: "rgba(0, 0, 0, .3)",
                pointBackgroundColor: "rgba(0, 0, 0, .3)",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "rgba(0, 0, 0, .3)",
                data: [{{ $interestDay[7] }}, {{ $interestDay[6] }}, {{ $interestDay[5] }}, {{ $interestDay[4] }}, {{ $interestDay[3] }}, {{ $interestDay[2] }}, {{ $interestDay[1] }}]
            }]
        };
        new Chart(i, {
            type: "bar",
            data: n
        });
    </script> --}}
@endsection
