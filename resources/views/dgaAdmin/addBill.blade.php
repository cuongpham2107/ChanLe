@extends('dgaAdmin.app')
@section('main')
<main id="main-container">
    <div class="content">
        <div class="card">
            @if ($errors->has('status'))
                <div class="alert alert-danger " >
                    <p class="mb-0">
                        {{ $errors->first('message') }}
                    </p>                        
                </div>
            @endif
            
            <div class="card-header">
                <div class="card-title fs-3 fw-bold">Thêm bill</div>
            </div>
            <form action="{{ route('admin.insertNewHistory') }}" method="POST">
                @csrf
                <div class="card-body p-9">
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3" for="example-select">Chọn tài khoản nhận</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <select class="form-select" id="phoneSend" name="phoneSend">
                                @foreach ($momo as $row)
                                    <option value="{{ $row->phone }}">{{ $row->phone }}</option>
                                @endforeach
                            </select></span>
                        </div>
                    </div>
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Mã giao dịch</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <input type="text" class="form-control form-control-solid" id="tranId"
                                name="tranId" placeholder="Nhập mã giao dịch">
                        </div>
                    </div>
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Số điện thoại người chơi</div>
                        </div>
                        <div class="col-xl-7 fv-row">
                            <input type="text" class="form-control form-control-solid" id="partnerId"
                                name="partnerId" placeholder="SĐT">
                        </div>
                        <div class="col-xl-2 fv-row">
                            <button type="button" class="btn btn-outline-info w-100" id="btnCheck">Kiểm tra</button>
                        </div>
                    </div>
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Họ tên Người chơi</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <input type="text" class="form-control form-control-solid" id="partnerName"
                                name="partnerName" placeholder="Họ tên" disabled>
                        </div>
                    </div>
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Số tiền</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <input type="number" class="form-control form-control-solid" id="amount"
                                name="amount" placeholder="VNĐ">
                        </div>
                    </div>
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3" for="example-select">Chọn game</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <select class="form-select" id="game" name="game">
                                @foreach ($game as $row)
                                    <option value={{ $row }}>{{ $row }} - Tỷ lệ: {{$setting['ratio'.$row]}}</option>
                                @endforeach
                            </select></span>
                        </div>
                    </div>
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Số tiền thắng</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <input type="text" class="form-control form-control-solid" id="receive"
                                name="receive" placeholder="VNĐ">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Nội dung</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <input type="text" class="form-control form-control-solid" id="comment"
                                name="comment" placeholder="Nội dung chơi">
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
                
            </form>
        </div>
    </div>
</main>
@endsection
@section('script')
<script>
    $("#btnCheck").click(function(e) {
            e.preventDefault();
            var phoneSend = $("#phoneSend").val();
            var receiver = $("#partnerId").val();
            var url = "{{ route('admin.checkMomo', ['phone' => ":phone", 'receiver' => ":receiver"]) }}";
            url = url.replace(':phone', phoneSend);
            url = url.replace(':receiver', receiver);
            $.ajax({
                type: "GET",
                dataType: "JSON",
                url: url,
                success: function(data) {
                    if (data.status == "success") {
                        swal(data.message, "success");
                        $("#partnerName").val(data.name);
                    } else {
                        swal(data.message, "error");
                    }
                },
                error: function(data) {
                    swal("Đã xảy ra lỗi. Vui lòng kiểm tra lại thông tin.", "error");
                }
            });
        });
</script>
@endsection