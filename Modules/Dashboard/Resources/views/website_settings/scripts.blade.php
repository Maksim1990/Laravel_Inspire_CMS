<script>
    var token = '{{\Illuminate\Support\Facades\Session::token()}}';

    //-- Toggle Google maps key block based on Google map checkbox
    if ($('#website_google_map').is(":checked"))
    {
        ShowGoogleMapsKeyBlock();
    }else{
        HideGoogleMapsKeyBlock();
    }


    //-- Functionality to check allowed input values
    function checkInput(obj){
        var id=obj.id;
        $('#alert_'+id).text('');
        $('#save_'+id).prop('disabled',false);
        var arrInvalidCharacters=[" ","<",">"]
        for(var i=0;i<=arrInvalidCharacters.length;i++){
            if (obj.value.indexOf(arrInvalidCharacters[i]) > -1)
            {
                $('#alert_'+id).text('{{trans('messages.prohibited_symbol')}}');
                $('#save_'+id).prop('disabled',true);
            }
        }
    }

    $('#save_website_name').click(function () {
        var url = '{{ route('ajax_website_name_update') }}';
        var website_name = $('#website_name').val();
        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                website_name: website_name,
                _token: token
            }, beforeSend: function () {
                //-- Show loading image while execution of ajax request
                $("div#divLoading").addClass('show');
            },
            success: function (data) {
                if (data['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: '{{trans('dashboard::messages.website_name_updated')}}!'
                    }).show();
                }
                //-- Hide loading image
                $("div#divLoading").removeClass('show');
            }
        });
    });

    $('#website_email_form').click(function () {
        var url = '{{ route('ajax_website_email_form') }}';
        var website_email_form = "N";

        if ($(this).is(":checked"))
        {
            website_email_form="Y";
        }

        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                website_email_form: website_email_form,
                _token: token
            }, beforeSend: function () {
                //-- Show loading image while execution of ajax request
                $("div#divLoading").addClass('show');
            },
            success: function (data) {
                if (data['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: '{{trans('messages.website_settings_option_updated')}}!'
                    }).show();
                }
                //-- Hide loading image
                $("div#divLoading").removeClass('show');
            }
        });
    });

    $('#use_active_languages').click(function () {
        var url = '{{ route('ajax_use_active_languages') }}';
        var use_active_languages = "N";

        if ($(this).is(":checked"))
        {
            use_active_languages="Y";
        }

        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                use_active_languages: use_active_languages,
                _token: token
            }, beforeSend: function () {
                //-- Show loading image while execution of ajax request
                $("div#divLoading").addClass('show');
            },
            success: function (data) {
                if (data['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: '{{trans('messages.website_settings_option_updated')}}!'
                    }).show();
                }
                //-- Hide loading image
                $("div#divLoading").removeClass('show');
            }
        });
    });

    //-- Functionality for trigger go to the top button visibility
    $('#website_go_to_the_top').click(function () {
        var url = '{{ route('ajax_website_go_to_the_top') }}';
        var website_go_to_the_top = "N";

        if ($(this).is(":checked"))
        {
            website_go_to_the_top="Y";
        }

        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                website_go_to_the_top: website_go_to_the_top,
                _token: token
            }, beforeSend: function () {
                //-- Show loading image while execution of ajax request
                $("div#divLoading").addClass('show');
            },
            success: function (data) {
                if (data['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: '{{trans('messages.website_settings_option_updated')}}!'
                    }).show();
                }
                //-- Hide loading image
                $("div#divLoading").removeClass('show');
            }
        });
    });

    //-- Functionality for trigger posts page visibility
    $('#website_posts_page').click(function () {
        var url = '{{ route('ajax_website_posts_page') }}';
        var website_posts_page = "N";

        if ($(this).is(":checked"))
        {
            website_posts_page="Y";
        }

        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                website_posts_page: website_posts_page,
                _token: token
            }, beforeSend: function () {
                //-- Show loading image while execution of ajax request
                $("div#divLoading").addClass('show');
            },
            success: function (data) {
                if (data['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: '{{trans('messages.website_settings_option_updated')}}!'
                    }).show();
                }
                //-- Hide loading image
                $("div#divLoading").removeClass('show');
            }
        });
    });

    //-- Functionality for trigger Google maps visibility
    $('#website_google_map').click(function () {
        var url = '{{ route('ajax_website_google_map') }}';
        var website_google_map = "N";

        if ($(this).is(":checked"))
        {
            website_google_map="Y";
            ShowGoogleMapsKeyBlock();
        }else{
            HideGoogleMapsKeyBlock();
        }

        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                website_google_map: website_google_map,
                _token: token
            }, beforeSend: function () {
                //-- Show loading image while execution of ajax request
                $("div#divLoading").addClass('show');
            },
            success: function (data) {
                if (data['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: '{{trans('messages.website_settings_option_updated')}}!'
                    }).show();
                }
                //-- Hide loading image
                $("div#divLoading").removeClass('show');
            }
        });
    });

    function ShowGoogleMapsKeyBlock() {
        $('#google_maps_block').show();
    }

    function HideGoogleMapsKeyBlock() {
        $('#google_maps_block').hide();
    }

    //-- Functionality to update Google maps key
    $('#save_website_google_map_key').click(function () {
        var url = '{{ route('ajax_website_google_map_key') }}';
        var website_google_map_key = $('#website_google_map_key').val();
        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                website_google_map_key: website_google_map_key,
                _token: token
            }, beforeSend: function () {
                //-- Show loading image while execution of ajax request
                $("div#divLoading").addClass('show');
            },
            success: function (data) {
                if (data['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: '{{trans('dashboard::messages.website_google_maps_key_updated')}}!'
                    }).show();
                }
                //-- Hide loading image
                $("div#divLoading").removeClass('show');
            }
        });
    });

    //-- Functionality to update GitHub URL
    $('#save_github').click(function () {
        var url = '{{ route('ajax_website_settings_github') }}';
        var github = $('#github').val();

        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                github: github,
                _token: token
            }, beforeSend: function () {
                //-- Show loading image while execution of ajax request
                $("div#divLoading").addClass('show');
            },
            success: function (data) {
                if (data['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'GitHub URL {{trans('messages.was_updated')}}!'
                    }).show();
                }
                //-- Hide loading image
                $("div#divLoading").removeClass('show');
            }
        });
    });

    //-- Functionality to update Facebook URL
    $('#save_facebook').click(function () {
        var url = '{{ route('ajax_website_settings_facebook') }}';
        var facebook = $('#facebook').val();

        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                facebook: facebook,
                _token: token
            }, beforeSend: function () {
                //-- Show loading image while execution of ajax request
                $("div#divLoading").addClass('show');
            },
            success: function (data) {
                if (data['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'Facebook URL {{trans('messages.was_updated')}}!'
                    }).show();
                }
                //-- Hide loading image
                $("div#divLoading").removeClass('show');
            }
        });
    });

    //-- Functionality to update VK URL
    $('#save_vk').click(function () {
        var url = '{{ route('ajax_website_settings_vk') }}';
        var vk = $('#vk').val();

        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                vk: vk,
                _token: token
            }, beforeSend: function () {
                //-- Show loading image while execution of ajax request
                $("div#divLoading").addClass('show');
            },
            success: function (data) {
                if (data['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'VK URL {{trans('messages.was_updated')}}!'
                    }).show();
                }
                //-- Hide loading image
                $("div#divLoading").removeClass('show');
            }
        });
    });

    //-- Functionality to update LinkedIn URL
    $('#save_linkedin').click(function () {
        var url = '{{ route('ajax_website_settings_linkedin') }}';
        var linkedin = $('#linkedin').val();

        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                linkedin: linkedin,
                _token: token
            }, beforeSend: function () {
                //-- Show loading image while execution of ajax request
                $("div#divLoading").addClass('show');
            },
            success: function (data) {
                if (data['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'LinkedIn URL {{trans('messages.was_updated')}}!'
                    }).show();
                }
                //-- Hide loading image
                $("div#divLoading").removeClass('show');
            }
        });
    });

    //-- Functionality to update Line URL
    $('#save_line').click(function () {
        var url = '{{ route('ajax_website_settings_line') }}';
        var line = $('#line').val();

        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                line: line,
                _token: token
            }, beforeSend: function () {
                //-- Show loading image while execution of ajax request
                $("div#divLoading").addClass('show');
            },
            success: function (data) {
                if (data['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'Line URL {{trans('messages.was_updated')}}!'
                    }).show();
                }
                //-- Hide loading image
                $("div#divLoading").removeClass('show');
            }
        });
    });

    //-- Functionality to update Instagram URL
    $('#save_instagram').click(function () {
        var url = '{{ route('ajax_website_settings_instagram') }}';
        var instagram = $('#instagram').val();

        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                instagram: instagram,
                _token: token
            }, beforeSend: function () {
                //-- Show loading image while execution of ajax request
                $("div#divLoading").addClass('show');
            },
            success: function (data) {
                if (data['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'Instagram URL {{trans('messages.was_updated')}}!'
                    }).show();
                }
                //-- Hide loading image
                $("div#divLoading").removeClass('show');
            }
        });
    });

    //-- Functionality to update Pinterest URL
    $('#save_pinterest').click(function () {
        var url = '{{ route('ajax_website_settings_pinterest') }}';
        var pinterest = $('#pinterest').val();

        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                pinterest: pinterest,
                _token: token
            }, beforeSend: function () {
                //-- Show loading image while execution of ajax request
                $("div#divLoading").addClass('show');
            },
            success: function (data) {
                if (data['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'Pinterest URL {{trans('messages.was_updated')}}!'
                    }).show();
                }
                //-- Hide loading image
                $("div#divLoading").removeClass('show');
            }
        });
    });


    //-- Functionality to update Twitter URL
    $('#save_twitter').click(function () {
        var url = '{{ route('ajax_website_settings_twitter') }}';
        var twitter = $('#twitter').val();

        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                twitter: twitter,
                _token: token
            }, beforeSend: function () {
                //-- Show loading image while execution of ajax request
                $("div#divLoading").addClass('show');
            },
            success: function (data) {
                if (data['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'Twitter URL {{trans('messages.was_updated')}}!'
                    }).show();
                }
                //-- Hide loading image
                $("div#divLoading").removeClass('show');
            }
        });
    });

    //-- Functionality to update Google URL
    $('#save_google').click(function () {
        var url = '{{ route('ajax_website_settings_google') }}';
        var google = $('#google').val();

        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                google: google,
                _token: token
            }, beforeSend: function () {
                //-- Show loading image while execution of ajax request
                $("div#divLoading").addClass('show');
            },
            success: function (data) {
                if (data['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'Google URL {{trans('messages.was_updated')}}!'
                    }).show();
                }
                //-- Hide loading image
                $("div#divLoading").removeClass('show');
            }
        });
    });

</script>