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
                        Lịch sử chuyển tiền MOMO
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
                                LỊCH SỬ CHUYỂN TIỀN
                            </h3>
                        </div>
                        <div class="card-body block-content-full">
                            <div class="table-responsive">
                            <table class="table table-row-bordered gy-5" id="showdata">
                                <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th style="width: 10%;">Số MOMO</th>
                                    <th style="width: 10%;">Mã GD</th>
                                    <th>Số tiền/Lỗi</th>
                                    <th>Số Khách</th>
                                    <th>Tên Khách</th>
                                    <th>Lời nhắn</th>
                                    <th>Trạng thái</th>
                                    <th style="width: 10%;">Ngày chuyển</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($history as $row)
                                    <tr>
                                        <td class="text-center fs-sm">{{ $row->id }}</td>
                                        <td class="fw-semibold fs-sm">{{ $row->phone }}</td>
                                        <td class="fw-semibold fs-sm">
                                            @if (json_decode($row->details)->status == 'success')
                                                <b class="fw-semibold fs-sm">
                                                @php echo (json_decode($row->details)->data->tranId) 
                                                @endphp 
                                                </b>
                                            @endif
                                        </td>
                                        <td class="fs-sm">@if (json_decode($row->details)->status == 'success') 
                                         <b class="fw-semibold fs-sm">
                                             @php echo number_format(json_decode($row->details)->data->amount) 
                                             @endphp 
                                             </b> VND 
                                              @elseif(!empty(json_decode($row->details)->message)) 
                                               @php echo json_decode($row->details)->message 
                                               @endphp 
                                              @endif</td>
                                        <td class="fw-semibold fs-sm"> @if (json_decode($row->details)->status == 'success')
                                         <b class="fw-semibold fs-sm">
                                            @php echo (json_decode($row->details)->data->partnerId) 
                                             @endphp 
                                            @endif</td>
                                         <td class="fw-semibold fs-sm"> @if (json_decode($row->details)->status == 'success')
                                         <b class="fw-semibold fs-sm">
                                            @php echo (json_decode($row->details)->data->partnerName) 
                                             @endphp 
                                            @endif</td>
                                         <td class="fw-semibold fs-sm"> @if (json_decode($row->details)->status == 'success')
                                         <b class="fw-semibold fs-sm">
                                            @php echo (json_decode($row->details)->data->comment) 
                                             @endphp 
                                            @endif</td>
                                        <td class="fw-semibold fs-sm">
                                            @if ($row->status == 1) <span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-success-light text-success">Thành công</span> 
                                             @else <span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill bg-danger-light text-danger">Thất bại</span> 
                                            @endif</td>
                                        <td>
                                            <span class="text-muted fs-sm">{{ $row->created_at }}</span>
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
        $(document).ready(function () {
            $('#showdata').DataTable({
                order: [[0, 'desc']],
                pageLength: 100
            });
        });
    </script>
@endsection