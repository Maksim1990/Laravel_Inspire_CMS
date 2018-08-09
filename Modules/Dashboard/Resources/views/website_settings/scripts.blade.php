<script>
    var token = '{{\Illuminate\Support\Facades\Session::token()}}';

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
            },
            success: function (data) {
                if (data['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'Website name was updated!'
                    }).show();
                }
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
            },
            success: function (data) {
                if (data['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'Website settings option was updated!'
                    }).show();
                }
            }
        });
    });
</script>