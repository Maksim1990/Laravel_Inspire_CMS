<script>
    var token = '{{\Illuminate\Support\Facades\Session::token()}}';
    //-- Toggle Google maps key block based on Google map checkbox
    if ($('#use_remote_server').is(":checked"))
    {
        ShowRemoteServerInput();
    }else{
        HideRemoteServerInput();
    }

    if ($('#use_elasticsearch').is(":checked"))
    {
        ShowElasticSearchInput();
    }else{
        HideElasticSearchInput();
    }


    //-- RESET CACHE
    $('#save_reset_cache').click(function () {
        //-- Hide alert block
        $('#alert_settings').css('display','none');

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
                        text: '{{trans('messages.cache_was_reset_for_user')}}'+' '+data['name']+'!'
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

    //-- Update remote server
    $('#save_remote_server').click(function () {
        //-- Hide alert block
        $('#alert_settings').css('display','none');

        var url = '{{ route('ajax_admin_settings_remote_server') }}';
        var remote_server = $('#remote_server').val();
        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                remote_server: remote_server,
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
                        text: '{{trans('dashboard::messages.remote_server_was_updated')}}'+'!'
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

    //-- Functionality for trigger Google maps visibility
    $('#use_remote_server').click(function () {
        var url = '{{ route('ajax_use_remote_server_update') }}';
        var use_remote_server = "N";

        if ($(this).is(":checked"))
        {
            use_remote_server="Y";
            ShowRemoteServerInput();
        }else{
            HideRemoteServerInput();
        }

        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                use_remote_server: use_remote_server,
                _token: token
            },
            success: function (data) {
                var srtNotification='{{trans('dashboard::messages.remote_server_activated')}}';
                if(use_remote_server=="N"){
                    srtNotification='{{trans('dashboard::messages.remote_server_deactivated')}}';
                }
                if (data['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: srtNotification
                    }).show();
                }
            }
        });
    });

    function ShowRemoteServerInput() {
        $('#remote_server_block').show();
    }

    function HideRemoteServerInput() {
        $('#remote_server_block').hide();
    }

    //-- Functionality for trigger Google maps visibility
    $('#use_elasticsearch').click(function () {
        var url = '{{ route('ajax_use_elasticsearch_update') }}';
        var use_elasticsearch = "N";

        if ($(this).is(":checked"))
        {
            use_elasticsearch="Y";
            ShowElasticSearchInput();
        }else{
            HideElasticSearchInput();
        }

        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                use_elasticsearch: use_elasticsearch,
                _token: token
            },
            success: function (data) {
                var srtNotification='{{trans('dashboard::messages.elasticsearch_activated')}}';
                if(use_remote_server=="N"){
                    srtNotification='{{trans('dashboard::messages.elasticsearch_deactivated')}}';
                }
                if (data['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: srtNotification
                    }).show();
                }
            }
        });
    });

    function ShowElasticSearchInput() {
        $('#elasticsearch_block').show();
    }

    function HideElasticSearchInput() {
        $('#elasticsearch_block').hide();
    }


    //-- Update App version
    $('#save_app_version').click(function () {
        //-- Hide alert block
        $('#alert_settings').css('display','none');

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
                        text: '{{trans('messages.app_version_was_updated')}}'+'!'
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


    //-- Update Elastic search index
    $('#save_elastic_update').click(function () {
        //-- Hide alert block
        $('#alert_settings').css('display','none');

        var url = '{{ route('ajax_admin_elasticsearch_update') }}';
        var elastic_user_id_update = $('#elastic_user_id_update').val();
        var elastic_model = $('#elastic_model').val();

        var actionStatus=true;
        var arrErrors=[];
        if(elastic_model<=0){
            actionStatus=false;
            arrErrors.push('{{trans('dashboard::messages.index_from_elasticsearch_should_be_selected')}}')
        }

        if(+elastic_user_id_update<=0){
            actionStatus=false;
            arrErrors.push('{{trans('dashboard::messages.please_select_correct_user')}}')
        }

        if(actionStatus){
        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                elastic_user_id_update: elastic_user_id_update,
                elastic_model: elastic_model,
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
                        text: '{{trans('dashboard::messages.elastic_sear_index_updated')}}'+'!'
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
        }else{
            var strErrors="";
            if(arrErrors.length>0){
                for(var i=0;i<arrErrors.length;i++){
                    strErrors+=arrErrors[i]+"<br>";
                }
                $('#alert_settings').css('display','block');
                $('#alert_settings').html(strErrors);
            }
        }
    });

    //-- Update Elastic search index
    $('#save_elastic_remove').click(function () {
        //-- Hide alert block
        $('#alert_settings').css('display','none');

        var url = '{{ route('ajax_admin_elasticsearch_truncate') }}';
        var elastic_user_id_update_remove = $('#elastic_user_id_update_remove').val();
        var elastic_model_remove = $('#elastic_model_remove').val();

        var actionStatus=true;
        var arrErrors=[];
        if(elastic_model_remove<=0){
            actionStatus=false;
            arrErrors.push('{{trans('dashboard::messages.index_from_elasticsearch_should_be_selected')}}')
        }

        if(+elastic_user_id_update_remove<=0){
            actionStatus=false;
            arrErrors.push('{{trans('dashboard::messages.please_select_correct_user')}}')
        }

        if(actionStatus){
            $.ajax({
                method: 'POST',
                url: url,
                dataType: "json",
                data: {
                    elastic_user_id_update_remove: elastic_user_id_update_remove,
                    elastic_model_remove: elastic_model_remove,
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
                            text: '{{trans('dashboard::messages.elastic_sear_index_truncated')}}'+'!'
                        }).show();
                    }else{
                        new Noty({
                            type: 'error',
                            layout: 'bottomLeft',
                            text: data['error']
                        }).show();

                        var strFailedIDs=data['arrErrorDelete'].join(', ');
                        $('#alert_settings').css('display','block');
                        $('#alert_settings').html("{{trans('dashboard::messages.following_ids_are_not_exist')}} <b>"+data['index']+"</b> index: <br>"+strFailedIDs);
                    }

                    //-- Hide loading image
                    $("div#divLoading").removeClass('show');
                }
            });
        }else{
            var strErrors="";
            if(arrErrors.length>0){
                for(var i=0;i<arrErrors.length;i++){
                    strErrors+=arrErrors[i]+"<br>";
                }
                $('#alert_settings').css('display','block');
                $('#alert_settings').html(strErrors);
            }
        }

    });



    //-- Functionality to update FTP connection type
    $('#admin_frp_credentials').click(function () {
        var url = '{{ route('ajax_admin_frp_credentials') }}';
        var admin_frp_credentials = "N";

        if ($(this).is(":checked"))
        {
            admin_frp_credentials="Y";
        }

        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                admin_frp_credentials: admin_frp_credentials,
                _token: token
            },
            success: function (data) {
                if (data['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: '{{trans('dashboard::messages.admin_settings_option_updated')}}!'
                    }).show();
                }
            }
        });
    });

</script>