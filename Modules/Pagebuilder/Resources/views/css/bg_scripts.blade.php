<script>
    @if(Session::has('background_change'))
    new Noty({
        type: '{{session('background_change')['type']}}',
        layout: '{{session('background_change')['position']}}',
        text: '{{session('background_change')['message']}}'
    }).show();
        @endif

    var token = '{{\Illuminate\Support\Facades\Session::token()}}';

    ToggleBackgroundType();

    $('#save_bg_color').click(function () {
        var url = '{{ route('ajax_bg_color_update') }}';
        var bg_color = $('#bg_color').val();
        var block_id = $('#block_id').val();
        var background_type = $('#background_type').val();

        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                bg_color: bg_color,
                block_id: block_id,
                background_type: background_type,
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
                        text: '{{trans('pagebuilder::messages.background_updated')}}!'
                    }).show();
                }
                //-- Hide loading image
                $("div#divLoading").removeClass('show');
            }
        });
    });

    $('#background_image').click(function () {
        ChangeBackgroundType();
    });

    //-- Toggle upload background image form
    $('#upload_image').click(function () {
        $('#background_image_upload_block').toggle();
    });

    //-- Functionality for toggle background type
    function ToggleBackgroundType() {
        if ($('#background_image').is(":checked"))
        {
            $('#background_color_block').hide();
            $('#background_image_block').show();
            $('#background_type').val('image');
        }else{
            $('#background_color_block').show();
            $('#background_image_block').hide();
            $('#background_type').val('color');
        }
    }

    function ChangeBackgroundType() {
        if ($('#background_image').is(":checked"))
        {
           $('#background_color_block').hide();
           $('#background_image_block').show();
            $('#background_type').val('image');
        }else{
            $('#background_color_block').show();
            $('#background_image_block').hide();
            $('#background_type').val('color');
        }

        var block_id = $('#block_id').val();
        var background_type = $('#background_type').val();
        var url = '{{ route('ajax_bg_type_update') }}';
        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                block_id: block_id,
                background_type: background_type,
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
                        text: '{{trans('pagebuilder::messages.background_type_updated')}}!'
                    }).show();
                }

                //-- Hide loading image
                $("div#divLoading").removeClass('show');
            }
        });

    }


    $('.insert_image').click(function () {
        var imagePath=$(this).data('path');

        var selectedImage= "<img src=\"{{custom_asset("storage")}}/"+imagePath+"\" class=\"w3-border w3-hover-opacity\" style=\"width:100%\">";
        $('#used_block_image').html(selectedImage);
        var block_id = $('#block_id').val();
        var background_type = $('#background_type').val();
        var url = '{{ route('ajax_bg_image_update') }}';

        //-- Close modal with images
        $('#image_modal').modal('toggle');

        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                block_id: block_id,
                background_type: background_type,
                imagePath: imagePath,
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
                        text: '{{trans('pagebuilder::messages.background_image_updated')}}!'
                    }).show();

                    $('#delete_image_button').css('display','inline');
                }

                //-- Hide loading image
                $("div#divLoading").removeClass('show');
            }
        });
    });

</script>