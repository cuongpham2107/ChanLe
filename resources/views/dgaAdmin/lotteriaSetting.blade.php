@extends('dgaAdmin.app')
@section('main')
    <main id="main-container">
        <div class="content">
            <div
                class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
                <div class="flex-grow-1 mb-1 mb-md-0">
                    <h1 class="h3 fw-bold mb-2">
                        {{-- SETTING LÔ ĐỀ TỰ ĐỘNG --}}
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
                    <form action="{{ route('admin.lotteriaSettingGame') }}" method="POST">
                        <div class="card card-rounded">
                            @csrf
                            <div class="card-header block-header-default">
                                <h1 class="h3 fw-bold mb-2">
                                    SETTING LÔ ĐỀ TỰ ĐỘNG
                                </h1>
                                <h3 class="card-title">Tỉ lệ / Nội dung</h3>
                                <div class="row card-options mt-5">
                                    <div class="col-sm-7">
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            Xác nhận
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center py-sm-3 py-md-5">
                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Số điện thoại nhận lô đề</label>
                                            <input type="text" class="form-control form-control-alt" name="momo_receiver_phone" disabled
                                                   value="{{ $setting->momo_receiver_phone }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Cược tối thiểu</label>
                                            <input type="text" class="form-control form-control-alt" name="min"
                                                   value="{{ $setting->min }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Cược tối đa</label>
                                            <input type="text" class="form-control form-control-alt" name="max"
                                                   value="{{ $setting->max }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Cú pháp LÔ</label>
                                            <input type="text" class="form-control form-control-alt" name="syntax_lo"
                                                   value="{{ $setting->syntax_lo }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Cú pháp ĐỀ</label>
                                            <input type="text" class="form-control form-control-alt" name="syntax_de"
                                                   value="{{ $setting->syntax_de }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Web url (đường link của web)</label>
                                            <input type="text" class="form-control form-control-alt" name="web_url"
                                                   value="{{ $setting->web_url }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Mật khẩu sync</label>
                                            <input type="password" class="form-control form-control-alt" name="sync_password"
                                                   value="{{ $setting->sync_password }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Server crawl</label>
                                            <input type="text" class="form-control form-control-alt" name="crawl_url"
                                                   value="{{ $setting->crawl_url }}">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row justify-content-center py-sm-3 py-md-5">
                                    
                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Tỉ lệ lô Miền Bắc 2 số</label>
                                            <input type="text" class="form-control form-control-alt" name="northern_lo_x2"
                                                   value="{{ $setting->northern_lo_x2 }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Tỉ lệ lô Miền Bắc 3 càng </label>
                                            <input type="text" class="form-control form-control-alt" name="northern_lo_x3"
                                                   value="{{ $setting->northern_lo_x3 }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Tỉ lệ lô Miền Bắc 4 càng</label>
                                            <input type="text" class="form-control form-control-alt" name="northern_lo_x4"
                                                   value="{{ $setting->northern_lo_x4 }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Tỉ lệ đề Miền Bắc 2 số</label>
                                            <input type="text" class="form-control form-control-alt" name="northern_de_x2"
                                                   value="{{ $setting->northern_de_x2 }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Tỉ lệ đề Miền Bắc 3 càng </label>
                                            <input type="text" class="form-control form-control-alt" name="northern_de_x3"
                                                   value="{{ $setting->northern_de_x3 }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Tỉ lệ đề Miền Bắc 4 càng</label>
                                            <input type="text" class="form-control form-control-alt" name="northern_de_x4"
                                                   value="{{ $setting->northern_de_x4 }}">
                                        </div>
                                    </div>

                                    {{-- <div class="col-sm-3">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Tiền nhận Hũ </label>
                                            <input type="text" class="form-control form-control-alt" name="ratioHu"
                                                   value="{{ $setting->ratioHu }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Tổng tiền nhận
                                                Hũ </label>
                                            <input type="text" class="form-control form-control-alt" name="amount_hu"
                                                   value="{{ $setting->amount_hu }}">
                                        </div>
                                    </div> --}}

                                    

                                </div>
                                <hr>
                                <div class="row justify-content-center py-sm-3 py-md-5">
                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Tỉ lệ lô Tỉnh lẻ 2 số</label>
                                            <input type="text" class="form-control form-control-alt" name="province_lo_x2"
                                                   value="{{ $setting->province_lo_x2 }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Tỉ lệ lô Tỉnh lẻ 3 càng </label>
                                            <input type="text" class="form-control form-control-alt" name="province_lo_x3"
                                                   value="{{ $setting->province_lo_x3 }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Tỉ lệ lô Tỉnh lẻ 4 càng</label>
                                            <input type="text" class="form-control form-control-alt" name="province_lo_x4"
                                                   value="{{ $setting->province_lo_x4 }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Tỉ lệ đề Tỉnh lẻ 2 số</label>
                                            <input type="text" class="form-control form-control-alt" name="province_de_x2"
                                                   value="{{ $setting->province_de_x2 }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Tỉ lệ đề Tỉnh lẻ 3 càng </label>
                                            <input type="text" class="form-control form-control-alt" name="province_de_x3"
                                                   value="{{ $setting->province_de_x3 }}">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="mb-4">
                                            <label class="form-label" for="block-form1-username"> Tỉ lệ đề Tỉnh lẻ 4 càng</label>
                                            <input type="text" class="form-control form-control-alt" name="province_de_x4"
                                                   value="{{ $setting->province_de_x4 }}">
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
