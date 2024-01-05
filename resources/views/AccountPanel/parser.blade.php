@extends('Layouts.account_panel')
@section('content')


    <div class="container-fluid bg-white">
        <div class="row">

            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12 mx-auto">
                <div class="text-center mt-5 mb-3">
                    <i class="far fa-file-alt primary_text_color_default fa-3x"></i>
                </div>
                <div class="text-center border-bottom pb-3" style="border-color: #e8f3ed !important;">
                    <div class="h4">Select a File to Parse</div>
                </div>



                <div class="row mt-4">
                    <div class="col-12 col-sm-8 col-md-12 col-lg-10 col-xl-8 col-xxl-7 mx-auto">

                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-7 mx-auto">


                                <div>
                                    <div id="parser_form_message" class="text-center text-danger small" style="height: 30px;"></div>
                                    <form id="parser_form">
                                        <div class="mb-3">
                                            <input class="form-control" type="file" name="file" id="file">
                                        </div>

                                        <div class="row">
                                            <div class="col d-grid gap-2">
                                                <button type="submit" class="btn primary_btn_default pr-3 pl-3" id="parser_form_submit">
                                                    <span id="parser_form_submit_text">Parse</span>
                                                    <span id="parser_form_submit_processing" class="sr-only"><span class="spinner-grow spinner-grow-sm text-info" role="status" aria-hidden="true"></span>Processing...</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div style="height: 300px;"></div>

    </div>

    <script>


        $(document).on('submit', '#parser_form', function(event) {
            event.preventDefault();
            $('#parser_form_submit').addClass('disabled');
            $('#parser_form_submit_text').addClass('sr-only');
            $('#parser_form_submit_processing').removeClass('sr-only');
            $('#parser_form_message').empty();
            let formData = new FormData($('#parser_form')[0]);
            formData.append('_token', '{{ csrf_token() }}');
            $.ajax({
                method: 'post',
                url: '{{ url('account/panel/parser/parse') }}',
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                global: false,
                success: function (result) {
                    console.log(result);
                    $('#parser_form_submit').removeClass('disabled');
                    $('#parser_form_submit_text').removeClass('sr-only');
                    $('#parser_form_submit_processing').addClass('sr-only');
                    $('#parser_form')[0].reset();
                    window.location = '{{ asset('storage/download') }}/' + result.payload;
                },
                error: function (xhr) {
                    console.log(xhr);
                    $('#parser_form_submit').removeClass('disabled');
                    $('#parser_form_submit_text').removeClass('sr-only');
                    $('#parser_form_submit_processing').addClass('sr-only');
                    if (xhr.status === 500) {
                        $('#parser_form_message').text('Something went wrong! Please try again later.');
                    } else {
                        if (xhr.status === 422) {
                            $.each(xhr.responseJSON.errors, function (key, error) {
                                $('#parser_form_message').append('<div>' + error + '</div>');
                            });
                        } else {
                            $('#parser_form_message').text(xhr.responseJSON.message);
                        }
                    }
                }
            });
        });
    </script>
@endsection
