@extends('Layouts.front_panel')
@section('content')

    <style>
        .btn-google {
            color: #fff;
            background-color: #dd4b39;
            border-color: #dd4b39;
        }
        .btn-facebook {
            color: #fff;
            background-color: #3b5998;
            border-color: #3b5998;
        }
        .btn-twitter {
            color: #fff;
            background-color: #00aced;
            border-color: #00aced;
        }

        .btn-icon--2 {
            position: relative;
            padding-left: 40px !important;
        }
        .btn-styled {

            letter-spacing: 0;

            padding: 0.6rem 1.5rem;
        }

        .btn {
            position: relative;
            font-size: 0.875rem;
            font-family: "Open Sans", sans-serif;
            font-style: normal;
            text-align: center;
            border-radius: 2px;
            outline: none;
            -webkit-transition: all 0.2s linear;
            transition: all 0.2s linear;
        }
        .btn-block {
            display: block;
            width: 100%;
        }

        .btn-icon--2 .icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            left: 0;
            top: 0;
            width: 40px;
            height: 100%;
            background: rgba(0, 0, 0, 0.2);
        }
    </style>
    <div class="container-fluid bg-white">
        <div class="row">

            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mx-auto">
                <div class="text-center mt-5 mb-3">
                    <i class="fas fa-sign-in-alt primary_text_color_default fa-3x"></i>
                </div>
                <div class="text-center border-bottom pb-3" style="border-color: #e8f3ed !important;">
                    <div class="h4">Log in to Parser</div>
                </div>



                <div class="row mt-4">
                    <div class="col-12 col-sm-8 col-md-12 col-lg-10 col-xl-8 col-xxl-7 mx-auto">

                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-7 mx-auto">


                                <div>
                                    <div id="login_form_message" class="text-center text-danger small" style="height: 30px;"></div>
                                    <form id="login_form">
                                        <div class="form-floating mb-4">
                                            <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                                            <label for="sign_in_id">Email</label>
                                        </div>
                                        <div class="form-floating mb-4">
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                            <label for="password">Password</label>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="remember_me">
                                                    <label class="form-check-label" for="remember_me">
                                                        Remember me
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col text-end" style="font-size: 14px;">
                                                <a href="javascript:void(0)" class="text-decoration-none" style="color: #636363;">Forgot Password?</a>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col d-grid gap-2">
                                                <button type="submit" class="btn primary_btn_default pr-3 pl-3" id="login_form_submit">
                                                    <span id="login_form_submit_text">Sign in</span>
                                                    <span id="login_form_submit_processing" class="sr-only"><span class="spinner-grow spinner-grow-sm text-info" role="status" aria-hidden="true"></span>Processing...</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>



                                <div class="">
                                    <div class="mt-3">Or, Sign in with</div>

                                    <div class="row mt-4">
                                        <div class="col">
                                            <a href="javascript:void(0)" class="btn btn-styled btn-block btn-google btn-icon--2 btn-icon-left px-2">
                                                <i class="icon fab fa-google"></i> Google
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a href="javascript:void(0)" class="btn btn-styled btn-block btn-facebook btn-icon--2 btn-icon-left px-2">
                                                <i class="icon fab fa-facebook-f"></i> Facebook
                                            </a>
                                        </div>
                                        <div class="col">
                                            <a href="javascript:void(0)" class="btn btn-styled btn-block btn-twitter btn-icon--2 btn-icon-left px-2">
                                                <i class="icon fab fa-twitter"></i> Twitter
                                            </a>
                                        </div>
                                    </div>






                                </div>

                            </div>



                        </div>


                        <div class="row my-5">
                            <div class="col text-center">
                                <span class="me-3" style="font-size: 14px;">Need an account with GoodGross?</span>
                                <a class="btn btn-outline-info" href="javascript:void(0)" style="color: #328C59;">Register</a>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>
    <div style="height: 25px;"></div>
    <script>


        $(document).on('submit', '#login_form', function(event) {
            event.preventDefault();
            $('#login_form_submit').addClass('disabled');
            $('#login_form_submit_text').addClass('sr-only');
            $('#login_form_submit_processing').removeClass('sr-only');
            $('#login_form_message').empty();
            let formData = new FormData($('#login_form')[0]);
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('remember_me', $('#remember_me').prop('checked') ? 1 : 0);
            $.ajax({
                method: 'post',
                url: '{{ url('account/panel/login') }}',
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                global: false,
                success: function (result) {
                    console.log(result);
                    $('#login_form_submit').removeClass('disabled');
                    $('#login_form_submit_text').removeClass('sr-only');
                    $('#login_form_submit_processing').addClass('sr-only');
                    location = '{{ url('account/panel/parser') }}';
                },
                error: function (xhr) {
                    console.log(xhr);
                    $('#login_form_submit').removeClass('disabled');
                    $('#login_form_submit_text').removeClass('sr-only');
                    $('#login_form_submit_processing').addClass('sr-only');
                    if (xhr.status === 500) {
                        $('#login_form_message').text('Something went wrong! Please try again later.');
                    } else {
                        if (xhr.status === 422) {
                            $('#login_form_message').text('Unauthorized access!');
                        } else {
                            $('#login_form_message').text(xhr.responseJSON.message);
                        }
                    }

                }
            });
        });
    </script>
@endsection
