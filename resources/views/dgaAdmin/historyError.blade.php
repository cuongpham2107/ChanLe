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
                        <div class="card-body block-content-full">
                            @if ($errors->any())
                            <div class="alert alert-{{ $errors->first('status') == 'success' ? "success" : "danger"}} alert-dismissible" role="alert">
                                <p class="mb-0">
                                    {{ $errors->first('message') }}
                                </p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                            <form action="{{ route('admin.submitPayError') }}" method="POST" id="payForm">
                                @csrf
                                <div class="card-body p-9">
                                    <div class="row mb-8">
                                        <div class="col-xl-3">
                                            <div class="fs-6 fw-semibold mt-2 mb-3" for="example-select">Chọn tài khoản
                                                thanh toán</div>
                                        </div>
                                        <div class="col-xl-9 fv-row">
                                            <select class="form-select" id="phoneSend" name="phoneSend">
                                                @foreach ($GetAccountMomo as $row)
                                                    <option value="{{ $row->phone }}">{{ $row->phone }} -
                                                        {{ number_format($row->balance) }} đ</option>
                                                @endforeach
                                            </select></span>
                                            {{-- <input id="cuentasSeleccionadas" name="cuentasSeleccionadas" /> --}}
                                            <input type="hidden" name="histories" class="form-control" value="" id="histories_arr" />
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <input type='button' value='Thanh toán' onClick='submitDetailsForm()' />
                                    {{-- <button type="submit" class="btn btn-primary">Thanh toán</button> --}}
                                </div>
                                {{-- <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button type="button" class="btn btn-primary" id="btnCheck">Kiểm tra</button>
                                </div> --}}
                            </form>
                            <div class="table-responsive">
                            <table id="history-all" class="table table-row-bordered gy-5">
                                <thead>
                                <tr class="text-gray-600 fw-semibold"> 
                                    <th>
                                    </th>
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
                                        <td></td>
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
                                            @elseif ($row->status == 2)
                                                <span
                                                    class="badge badge-danger">Sai nội dung</span>
                                            @elseif ($row->status == 3)
                                                <span
                                                    class="badge badge-danger">Sai hạn mức</span>
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
                            {{-- <table id="example" class="datatable table striped hovered cell-hovered border bordered" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Số Điện Thoại</th>
                                        <th>Student Id</th>
                                        <th>Name</th>
                                        <th>Class</th>
                                        <th>Instructor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td>New York</td>
                                        <td>22621</td>
                                        <td>John</td>
                                        <td>ENC 101</td>
                                        <td>Dr. Doe</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Chicago</td>
                                        <td>22621</td>
                                        <td>John</td>
                                        <td>MAT 101</td>
                                        <td>Dr. Smith</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Miami</td>
                                        <td>21176</td>
                                        <td>Mike</td>
                                        <td>PSY 101</td>
                                        <td>Dr. Staff</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>New York</td>
                                        <td>22621</td>
                                        <td>John</td>
                                        <td>ENC 101</td>
                                        <td>Dr. Doe</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Chicago</td>
                                        <td>22621</td>
                                        <td>John</td>
                                        <td>MAT 101</td>
                                        <td>Dr. Smith</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>Miami</td>
                                        <td>21176</td>
                                        <td>Mike</td>
                                        <td>PSY 101</td>
                                        <td>Dr. Staff</td>
                                    </tr>
                                </tbody>
                            </table> --}}
                            
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
        $(document).ready(function () {
    //         let history = $('#history-all').DataTable({
    //             columnDefs: [{
    //                 orderable: false,
    //                 className: 'select-checkbox',
    //                 targets: 0
    //             }],
    //             select: {
    //                 style: 'os',
    //                 selector: 'td:first-child'
    //             },
    //             // order: [[0, 'desc']],
    //             pageLength: 50
    //         });
    //         history.on("click", "th.select-checkbox", function() {
    //         if ($("th.select-checkbox").hasClass("selected")) {
    //             example.rows().deselect();
    //             $("th.select-checkbox").removeClass("selected");
    //         } else {
    //             example.rows().select();
    //             $("th.select-checkbox").addClass("selected");
    //         }
    //     }).on("select deselect", function() {
    //         ("Some selection or deselection going on")
    //         if (history.rows({
    //                 selected: true
    //             }).count() !== history.rows().count()) {
    //             $("th.select-checkbox").removeClass("selected");
    //         } else {
    //             $("th.select-checkbox").addClass("selected");
    //         }
    //     });


    //     let myTable = $('#example').DataTable({
    //     columnDefs: [{
    //         orderable: false,
    //         className: 'select-checkbox',
    //         targets: 0,
    //     }],
    //     select: {
    //         style: 'multi', // 'single', 'multi', 'os', 'multi+shift'
    //         selector: 'td:first-child',
    //     },
    //     order: [
    //         [1, 'asc'],
    //     ],
    // });

    // $('#MyTableCheckAllButton2').click(function() {
    //     if (history.rows({
    //             selected: true
    //         }).count() > 0) {
    //             history.rows().deselect();
    //         return;
    //     }

    //     history.rows().select();
    // });



        });

        var tbl;
$(document).ready(function (){
          tbl = $('#history-all').DataTable({
            columnDefs: [{
                targets: 0,
                data: 1,
                'checkboxes': {
                    'selectRow': true
                }
            },
            { "visible": false, "targets": 1 }],
            select: {
                style: 'multi'
            },
            order: [[1, 'asc']],
            // iDisplayLength: 10,
            // drawCallback: function () {
            //     var api = this.api();
            //     var rows = api.rows({ page: 'current' }).nodes();
            //     var last = null;

            //     api.column(1, { page: 'current' }).data().each(function (group, i) {
            //         if (last !== group) {
            //             $(rows).eq(i).before(
            //                 '<tr class="group"><td colspan="6">' + group + '</td></tr>'
            //             );
            //             last = group;
            //         }
            //     });
            // }
        });
});
function getSelected(){
	var selectedIds = tbl.columns().checkboxes.selected()[0];
    console.log(tbl.columns().checkboxes.selected());
	console.log(selectedIds)
 
	selectedIds.forEach(function(selectedId) {
    alert(selectedId);
	});
}
function submitDetailsForm() {
    var selectedIds = tbl.columns().checkboxes.selected()[0];
    console.log(tbl.columns().checkboxes.selected());
	console.log(selectedIds)
        $('#histories_arr').val(selectedIds);
       $("#payForm").submit();
    }
    </script>
@endsection