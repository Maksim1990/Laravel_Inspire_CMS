<script>
    var token = '{{\Illuminate\Support\Facades\Session::token()}}';

    //-- RESET CACHE
    $('#save_reset_cache').click(function () {
        var url = '{{ route('ajax_admin_settings_reset_cache') }}';
        var user_id = $('#reset_cache').val();
        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                user_id: user_id,
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
                        text: 'Cache was reset for user '+data['name']+'!'
                    }).show();
                }else{
                    new Noty({
                        type: 'error',
                        layout: 'bottomLeft',
                        text: data['error']
                    }).show();
                }

                //-- Hide loading image
                $("div#divLoading").removeClass('show');
            }
        });
    });

    //-- Update App version
    $('#save_app_version').click(function () {
        var url = '{{ route('ajax_admin_settings_app_version') }}';
        var app_version = $('#app_version').val();
        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                app_version: app_version,
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
                        text: 'App version was updated!'
                    }).show();
                }else{
                    new Noty({
                        type: 'error',
                        layout: 'bottomLeft',
                        text: data['error']
                    }).show();
                }

                //-- Hide loading image
                $("div#divLoading").removeClass('show');
            }
        });
    });

</script>