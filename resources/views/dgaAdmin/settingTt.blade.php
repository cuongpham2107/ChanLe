@extends('dgaAdmin.app')
@section('main')
    <main id="main-container">
        <div class="content">
            <div
                class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
                <div class="flex-grow-1 mb-1 mb-md-0">
                    <h1 class="h3 fw-bold mb-2">
                        SETTING
                    </h1>
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
                    <form action="{{ route('admin.settingGamePost') }}" method="POST">
                        <div class="card card-rounded">
                            @csrf
                            
                        </div>
                        <div class="card block-rounded mt-3">
                            <div class="card-header block-header-default">
                                <h3 class="card-title">Nội Dung Chuyển</h3>
                                <div class="card-options mt-5">
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        Xác nhận
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center py-sm-3 py-md-5">
                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Nội dung trả
                                                thưởng</label>
                                            <input type="text" class="form-control form-control-alt" name="content"
                                                   value="{{ $setting->content }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Nội dung trả thưởng
                                                nhiệm vụ </label>
                                            <input type="text" class="form-control form-control-alt" name="content_day"
                                                   value="{{ $setting->content_day }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Nội dung trả thưởng
                                                tuần </label>
                                            <input type="text" class="form-control form-control-alt" name="content_week"
                                                   value="{{ $setting->content_week }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Nội dung trả điểm
                                                danh </label>
                                            <input type="text" class="form-control form-control-alt"
                                                   name="content_muster"
                                                   value="{{ $setting->content_muster }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Nội dung trả
                                                hũ </label>
                                            <input type="text" class="form-control form-control-alt" name="content_hu"
                                                   value="{{ $setting->content_hu }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Nội dung trả
                                                lô đề </label>
                                            <input type="text" class="form-control form-control-alt" name="content_lotteria"
                                                   value="{{ $setting->content_lotteria }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Nội dung hoàn
                                                tiền </label>
                                            <input type="text" class="form-control form-control-alt"
                                                   name="content_refund"
                                                   value="{{ $setting->content_refund }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Nội dung mã
                                                quà </label>
                                            <input type="text" class="form-control form-control-alt"
                                                   name="content_giftcode"
                                                   value="{{ $setting->content_giftcode }}">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('script')
    <script type="text/javascript">

        function update() {
            Swal.fire({
                title: "Bạn chắc chẵn muốn cập nhật phiên bản mới ?",
                showCancelButton: true,
                confirmButtonText: "Có",
                cancelButtonText: "Không",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: "{{ route('admin.updateVer') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
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
            });
        }

        $(document).ready(function () {
            $('.dga-select').select2();
        });
    </script>
@endsection
