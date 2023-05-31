@extends('dgaAdmin.app')
@section('main')
    <main id="main-container">
        <div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-xl-8">
                <div class="card flex-grow-1 bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100">
                    <div class="card-body d-flex justify-content-between flex-column ps-xl-18">
                        <div class="mb-20 pt-xl-13">
                           <div class="greeting-user">
                          <h2 class="f-w-600 font-primary" id="greeting">COPPER WIKI</h2>
                         
                          
<h4>Chào, <span class="text-danger">{{ Auth::user()->username }}</span> thân mến!</h4>
<h4>Thắc mắc vui lòng liên hệ admin.</h4>
<h4>Chúc server ăn to thắng lớn !</h4>

                        </div>
                        
                    </div>
                        <div class="mb-xl-10 mb-3">
                            <a href="https://t.me/copper_wiki" target="_blank" class="btn btn-primary fw-semibold mt-2">Telegram Admin</a>
                            <a class="btn btn-success fw-semibold mt-2" type="button" data-bs-toggle="modal" data-bs-target="#thongbao" data-bs-original-title="" title="">Thông Báo</a>
                            <div class="modal fade show" id="thongbao" tabindex="-1" aria-labelledby="thongbao" style="display: none;" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Thông báo</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>
                          </div>
                          <div class="modal-body">
                            <p>Chúng tôi là COPPER WIKI</p>
                            <p>Chúng tôi cam kết sẽ đem những dịch vụ tốt nhất dành cho bạn</p>
                            {{-- <p>Thiết kế logo: <a href="https://t.me/copper_wiki">COPPER</a></p> --}}
                            {{-- <p>Mua sim Momo: <a href="https://t.me/copper_wiki">COPPER</a></p> --}}
                          </div>
                          <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" data-bs-original-title="" title="">Đóng.</button>
                          </div>
                        </div>
                      </div>
                    </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4">
                <div class="card h-md-100">
                    <div class="card-body d-flex flex-column flex-center">
                        <div class="mb-2">
                            
                            <div class="py-10 text-center">
                                <div class="cartoon"><img class="img-fluid" src="../assets1/images/dashboard/cartoon.png" alt=""></div>
                            </div>
                        </div>
                        <div class="text-center mb-1">
                            <a href="https://t.me/copper_wiki" target="_blank" class="btn btn-sm btn-primary me-2">Liên hệ</a>
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
    $(document).ready(function(){
        $("#kt_datatable_zero_configuration").DataTable();
    })
</script>
    
    <script>
var countDownDate = new Date("Jan 02, 2022 00:00:00").getTime();
var x = setInterval(function() {
var now = new Date().getTime();
var distance = countDownDate - now;
 var days = Math.floor(distance / (1000 * 60 * 60 * 24));
document.getElementById("time").innerHTML = days + " ";
if (distance < 0) {
    clearInterval(x);
    document.getElementById("time").innerHTML = "EXPIRED";
  }
}, 1000);
</script>
@endsection
