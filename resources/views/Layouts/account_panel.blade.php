<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | {{ env('APP_NAME') }}</title>
    <link rel="shortcut icon" href="{{ asset('storage/images/favicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
    <style>
        body {
            color: #636363;
            background-color: #f8f8f8;
        }

        .col-xxl-12 {
            max-width: 1750px !important;
        }

        label {
            color: #636363;
            font-size: 14px;
        }

        .form-control {
            color: #636363;
            font-size: 14px;
        }

        .form-select {
            color: #636363;
            font-size: 14px;
        }

        input[type="text"]:focus, input[type="password"]:focus, select:focus, textarea:focus {
            border-color: rgba(82, 168, 236, 0.8);
            outline: none !important;
            -webkit-box-shadow: none !important;
            -moz-box-shadow: none !important;
            box-shadow: none !important;
        }

        .form-floating>.form-select {
            padding-top: 1.625rem;
            padding-bottom: .25rem;
            color: #636363;
        }

        .primary_text_color_default  {
            color: #06e1ffba;
        }

        .secondary_text_color_default  {
            color: #e9f5f2;
        }

        .primary_background_color_default {
            background-color: #06e1ffba;
        }

        .secondary_background_color_default {
            background-color: #e9f5f2;
        }

        .primary_btn_default {
            background-color: #06e1ffba;
            color: #d30c0c;
            border-radius: 2px;
        }

        .secondary_btn_default {
            background-color: #e9f5f2;
            color: #ffffff;
            border-radius: 2px;
        }

        /*////////////////////////////////////Left Menu////////////////////////////////////*/
        .without_arrow::after {
            background-image: none;
        }

        .accordion-button::after {
            width: 1rem;
            height: 1rem;
            background-size: 1rem;
        }

        .active_main {
            border-right: 2px solid green !important;
        }

        .active_text {
            color: rgba(46, 158, 176, 0.73);
        }

    </style>
</head>
<body>

<div class="container-fluid primary_background_color_default">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mx-auto">
            <div class="row pt-4 pb-4">
                <div class="col-12 col-sm-6">
                    <a href="{{ url('/') }}"><span style="cursor: pointer; height: 30px;"><img src="{{ asset('storage/images/logo.png') }}" height="60"></span></a>
                    <span style="color: #1a202c; font-size: large;">The Parser</span>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="mt-2 small text-end">Welcome! {{ auth()->user()->name }}</div>
                    <div class="mt-1 small text-end"><a href="{{ url('account/panel/logout') }}" class="text-decoration-none text-danger small"><i class="fas fa-power-off"></i> Log out</a></div>
                </div>
            </div>
        </div>
    </div>
</div>

@yield('content')

<div class="container-fluid" style="background-color: #f8f8f8;">
    <div class="row py-5">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mx-auto">
            <div class="row mt-3">
                <div class="col text-center small">
                    <span class="small text-muted">&copy; 2016-{{ date('Y') }} The Banking Financial Statement Parser</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    #ajax_loading{
        position: fixed;
        top: 0;
        z-index: 100;
        width: 100%;
        height:100%;
        display: none;
        background: rgba(0,0,0,0.6);
    }
    .ajax_loading_spinner {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .loading_spinner {
        width: 40px;
        height: 40px;
        border: 4px #ddd solid;
        border-top: 4px #2e93e6 solid;
        border-radius: 50%;
        animation: sp-anime 0.8s infinite linear;
    }
    @keyframes sp-anime {
        100% {
            transform: rotate(360deg);
        }
    }
</style>

<div id="ajax_loading">
    <div class="ajax_loading_spinner">
        <span class="loading_spinner"></span>
    </div>
</div>




<script type="text/javascript">
    $(document).ajaxStart(function() {
        $("#ajax_loading").fadeIn(0);
    });

    $(document).ajaxStop(function () {
        $("#ajax_loading").fadeOut(300);
    });
</script>

</body>
</html>
