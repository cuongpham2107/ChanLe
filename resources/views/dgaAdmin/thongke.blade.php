@extends('dgaAdmin.app')
@section('main')
    <main id="main-container">
        <div class="content">
            <div
                class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center py-2 text-center text-md-start">
                <div class="flex-grow-1 mb-1 mb-md-0">
                    <h1 class="h3  mb-2">
                        Thống kê
                    </h1>
                </div>
            </div>
        </div>
        <div class="content">
                <div class="row g-xl-8">
                <div class="col-xl-4">
                    <div class="card bg-danger hoverable card-xl-stretch mb-xl-8">
                    <div class="card-body">
                        <div>
                            <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg></span>
                            <span class=" text-white fs-3">Hôm nay</span>
                        </div>
                        <div class=" text-white fs-5">Tổng nhận: {{ number_format($total['amountALLDay']) }} đ</div>
                        <div class=" text-white fs-5">Tổng trừ: {{ number_format($total['amountSendALLDay']) }} đ</div>
                        <div class=" text-white fs-5">Doanh thu: {{ number_format($total['today']) }} đ</div>
                    </div>
                </div>
                </div> 
                <div class="col-xl-4">
                    <div class="card bg-primary hoverable card-xl-stretch mb-xl-8">
                    <div class="card-body">
                        <div>
                            <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg></span>
                            <span class=" text-white fs-3">Hôm qua</span>
                        </div>
                        <div class=" text-white fs-5">Tổng nhận: {{ number_format($total['amountLastDay']) }} đ</div>
                        <div class=" text-white fs-5">Tổng trừ: {{ number_format($total['sendLastDay']) }} đ</div>
                        <div class=" text-white fs-5">Doanh thu: {{ number_format($total['lastDay']) }} đ</div>
                    </div>
                </div>
                </div>    
                <div class="col-xl-4">
                    <div class="card bg-success hoverable card-xl-stretch mb-xl-8">
                    <div class="card-body">
                        <div>
                            <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg></span>
                            <span class=" text-white fs-3">Tổng</span>
                        </div>
                        <div class=" text-white fs-5">Tổng nhận: {{ number_format($total['amount']) }} đ</div>
                        <div class=" text-white fs-5">Tổng trừ: {{ number_format($total['amountTra']) }} đ</div>
                        <div class=" text-white fs-5">Doanh thu: {{ number_format($total['amountDT']) }} đ</div>
                    </div>
                </div>
                </div>
            </div>
        
        </div>
    </main>
@endsection
@section('script')

<script src="/assets1/js/chart/echart/esl.js"></script>
<script src="/assets1/js/chart/echart/config.js"></script>
<script src="/assets1/js/chart/echart/pie-chart/facePrint.js"></script>
<script src="/assets1/js/chart/echart/pie-chart/testHelper.js"></script>
<script src="/assets1/js/chart/echart/pie-chart/custom-transition-texture.js"></script>
<script src="/assets1/js/chart/echart/data/symbols.js"></script>
<script src="/assets1/js/chart/echart/custom.js"></script>
@endsection
