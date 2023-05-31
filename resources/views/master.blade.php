<!DOCTYPE html>
<html class="no-js" lang="vi">

<head>
    <title>{{ $setting->title }}</title>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="{{ $setting->title }}" name="title">
    <meta content="{{ $setting->description }}" name="description">
    <meta content="{{ $setting->keywords }}" name="keywords">
    <meta content="/" property="og:url" />
    <meta content="article" property="og:type" />
    <meta content="{{ $setting->title }}" property="og:title" />
    <meta content="{{ $setting->description }}" property="og:description" />
    <meta content="{{ $setting->background }}" property="og:image" />
    <link href="{{ $setting->favicon }}" rel="apple-touch-icon" />
    <link href="{{ $setting->favicon }}" rel="shortcut icon" type="image/x-icon" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.css" rel="stylesheet" />
    <link href="{{ url('') }}/themes/css/bootstrap.min.css?v1" rel="stylesheet" />
    <link href="{{ url('') }}/themes/css/bootstrap-social.css" rel="stylesheet" />
    <link href="{{ url('') }}/themes/css/style.css?ver=1" rel="stylesheet" />
    <link href="{{ url('') }}/themes/css/custom.1.css?ver=28" rel="stylesheet" />
    <link href="{{ url('') }}/themes/css/wheel.css?ver=1651368768" rel="stylesheet" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.4/dist/simple-notify.min.css" />
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-169824433-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-VMC0K2P4H3');
    </script>
    <style>
        .aa:hover,
        .aa:focus {
            background: #ad4105;
            border-radius: 5px
        }

        .coffer-box {
            display: block;
            position: fixed;
            bottom: 90px;
            right: 15px;
            width: 15%;
            z-index: 1000;
            cursor: pointer;
            /*background: #ad410569;*/
            border-radius: 10px;
            text-align: center;
            padding: 15px;
        }

        @media (max-width: 767px) {
            .coffer-box {
                background: unset;
                width: 50%;
                bottom: 20px;
            }
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mt-100 {
            margin-top: 100px;
        }

        .mainbar {
            padding: 0px !important;
        }

        .panel-heading {
            background-color: {{ $setting->color }} !important;
            border-color: {{ $setting->color }} !important;
        }

        .panel-primary {
            /*background-color: {{ $setting->color }} !important;*/
            border-color: {{ $setting->color }} !important;
        }

        .navbar {
            background-color: {{ $setting->color }} !important;

        }

        .navbar .navbar-collapse {
            background-color: {{ $setting->color }} !important;
        }

        .table .bg-primary {
            background-color: {{ $setting->color }} !important;
        }

        .footer {
            background-color: {{ $setting->color }};
            border-top: {{ $setting->color }} !important;
        }

        .mainbar {
            background-color: {{ $setting->color }};
        }

        .btn-info:hover,
        .btn-info:focus,
        .btn-info:active,
        .btn-info.active,
        .open .dropdown-toggle.btn-info {
            color: #fff;
            /*background-color: {{ $setting->color }} !important;*/
            border-color: {{ $setting->color }} !important;
        }

        .btn-info {
            color: #fff;
            /*background-color: {{ $setting->color }} !important;*/
            border-color: {{ $setting->color }} !important;
        }

        .label-success {
            background: linear-gradient(to bottom right, #62fb62, #21a544) !important;
        }

        .label-danger {
            background: linear-gradient(to bottom right, #ff0000 0%, #990000 100%);
        }
        .panel-primary {
            border-color: {{ $setting->color }}        }

        .panel-primary>.panel-heading {
            color: #fff;
            background-color: {{ $setting->color }};
            border-color: {{ $setting->color }}        }
        
        .panel-primary>.panel-heading+.panel-collapse .panel-body {
            border-top-color: {{ $setting->color }}        }

        .panel-primary>.panel-footer+.panel-collapse .panel-body {
            border-bottom-color: {{ $setting->color }}        }
        .aa:hover,.aa:focus {
            background: {{ $setting->color }};
            border-radius: 5px
        }
        .bg-primary {
            color: #fff ;
            background-color: {{ $setting->color }} !important;
        }
        
        .navbar {
          position:relative;
          /* z-index:501; */
          min-height:60px;
          margin-bottom:0;
          background-color:{{ $setting->color }};
          border:none;
          border-top-right-radius:0;
          border-top-left-radius:0;
          border-bottom-right-radius:0;
          border-bottom-left-radius:0;
        }
        .bg-grad-2 {
          background-color:{{ $setting->color }};
          box-shadow: 1px 2px 0px #a7002b;
        }
        .coffer-box {
            display: block;
            position: fixed;
            bottom: 90px;
            right: 15px;
            width: 15%;
            z-index: 1000;
            cursor: pointer;
            /*background: #ad410569;*/
            border-radius: 10px;
            text-align: center;
            padding: 15px;
        }
        @media (max-width: 767px) {
            .coffer-box {
                background: unset;
                width: 50%;
                bottom: 20px;
            }
        }
        .mb-0 {
            margin-bottom: 0;
        }
        .dot-text-1 {
            color: #f0ad4e
        }
        .dot-text-2 {
            color: #5bc0de
        }
        .dot-text-3 {
            color: #5cb85c
        }
        .dot-text-4 {
            color: #d9534f
        }
        
        .dot-text-6 {
            color: #5bc0de
        }
        .dot-text-7 {
            color: #5cb85c
        }
        .dot-text-8 {
            color: #d9534f
        }
        .dot-text-9 {
            color: #f0ad4e
        }
        
        .dot-text-11 {
            color: #5cb85c
        }
        .dot-text-12 {
            color: #d9534f
        }
        .dot-text-13 {
            color: #f0ad4e
        }
        .dot-text-14 {
            color: #5bc0de
        }
        
        .dot-text-16 {
            color: #d9534f
        }
        .dot-text-17 {
            color: #f0ad4e
        }
        .dot-text-18 {
            color: #5bc0de
        }
        .dot-text-19 {
            color: #5cb85c
        }
    </style>
</head>

<body>
    @yield('main')
    <footer class="footer">
        <div class="container text-center">
            <div class="row">
                <div class="col-xs-12 text-white ">
                    Copyright 2023 © {{ $setting->name }} | <a href="https://t.me/copper_wiki" target="_blank"
                        style="color:red;">COPPER WIKI</a> All rights reserved
                </div>
                <center>
                    <img src="{{ $setting->logo }}" height="60px" alt="Logo">
                </center>
            </div>
    </footer>
</body>
<script type="text/javascript" src="https://js.pusher.com/7.0/pusher.min.js" id="pusher-js"></script>
<script src="{{ url('') }}/themes/js/wheel.min.js?V2"></script>
<script src="{{ url('') }}/themes/js/jquery-1.10.1.min.js"></script>
<script src="{{ url('') }}/themes/js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="{{ url('') }}/themes/js/bootstrap.min.js"></script>
<script src="{{ url('') }}/themes/js/moment.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.4/dist/simple-notify.min.js"></script>
<script src="{{ url('') }}/themes/js/script.js?ver=1"></script>
<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        $('[data-toggle="tooltip"]').tooltip();
        $('.cash-format').each(function(index) {
            $(this).html(parseInt($(this).text()).toLocaleString('it-IT', {
                style: 'currency',
                currency: 'VND'
            }));
        });
        $('button[data-game]').click(function() {
            let button = $(this);
            let game = button.attr('data-game');
            game_active = game;
            $('.game').removeClass('active');
            $(`.game[game-tab=${game}]`).addClass('active').removeClass("hidden");
            $("button[data-game]").removeClass("btn-info").addClass("btn-primary");
            $("[data-minigame]").removeClass("btn-success");
            button.removeClass("btn-primary").addClass("btn-info");
        });
        $('button[data-minigame]').click(function() {
            let button = $(this);
            let game = button.attr('data-minigame');
            game_active = "minigame";
            $('.game').removeClass('active');
            $(`.game[game-tab=${game}]`).addClass('active').removeClass("hidden");
            $("[data-minigame]").removeClass("btn-success");
            $("[data-game]").removeClass("btn-success").addClass("btn-primary");
            button.addClass("btn-success");
        });
    });
</script>
<style>
    .jackpot {
        wiggle 1.3s linear infinite
    }
</style>
@yield('scripts')
</html>
