@extends('dashboard::layouts.master')

@section('General')

    <h3 class="title">@lang('messages.mail_box')</h3>
    <div id="title_shape"></div>

    <div class="insp_buttons">
        <a href="{{route("create_mail",Auth::id())}}" class="btn btn-success">@lang('messages.create_new_email')</a>
        <a href="{{route("customize_mail_template",['id'=>Auth::id(),'template_id'=>1])}}" class="btn btn-info">@lang('dashboard::messages.customize_mail_template')</a>
    </div>

    @if(count($mails)>0)
        <div class="row">
            <div class="col-sm-12 col-lg-8 col-xs-12">
                <span id="found_items"></span>
            </div>
            <div class="col-sm-12 col-lg-4 col-xs-12">
                <input type="text" class="form-control" style="display: inline;" id="search_bar"
                       placeholder="@lang('messages.search')">

            </div>
            <hr>
        </div>

        <table class="w3-table-all w3-hoverable">
            <thead>
            <tr class="w3-light-grey">
                <th>@lang('messages.from')</th>
                <th>@lang('messages.to')</th>
                <th>@lang('messages.title')</th>
                <th>@lang('messages.date')</th>
                <th></th>
            </tr>
            </thead>
            <tbody id="mail_body">
            @foreach($mails as $mail)

                <tr class="mail_item" id="mail_{{$mail->id}}" data-id="{{$mail->id}}">
                    <td class="mail_click">{{$mail->from}}</td>
                    <td class="mail_click">{{$mail->to}}</td>
                    <td class="mail_click">{{$mail->title}}</td>
                    <td class="mail_click">{{$mail->created_at}}</td>
                    <td>
                        @if($mail->user_id==Auth::id())
                            <a href="#" id="modal_delete_{{$mail->id}}">
                                <span class="delete w3-text-red">
                                    <i class="fas fa-minus-circle"></i>
                                </span>
                            </a>
                        @endif
                    </td>
                </tr>

            @endforeach
            </tbody>
            <tbody id="mail_body_search"></tbody>
        </table>
    @endif
    <div class="col-sm-12 col-lg-8 col-xs-12 w3-center" id="links">
        {!! $mails->links() !!}
    </div>
    {{--Image big size modal--}}
    <div class="modal" id="mail_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="mail_title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div id="mail_content"></div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('messages.close')</button>
                </div>

            </div>
        </div>
    </div>

    {{--Delete profile modal--}}
    <div class="modal" id="delete_mail">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">@lang('dashboard::messages.delete_this_mail')</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <button type="button" class="btn btn-success" id="cancel"
                            data-dismiss="modal">@lang('messages.cancel')</button>
                    <span id="delete_button"></span>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

@stop
@section('scripts')
    <script>
        @if(Session::has('mail_change'))
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: '{{session('mail_change')}}'

        }).show();
        @endif
    </script>
    <script>
        var token = '{{\Illuminate\Support\Facades\Session::token()}}';

        //-- Delete label functionality
        $('[id^="modal_delete_"]').click(function () {
            ShowDeleteModal($(this).attr('id').replace('modal_delete_', ""));
        });


        function ShowDeleteModal(id) {
            var strDeleteButton = '<a href="#" class="btn btn-danger delete_mail" data-id="' + id + '" >{{trans('messages.delete')}}</a>';
            $("#delete_button").html(strDeleteButton);
            $('#delete_mail').modal('toggle');


            $('.delete_mail').click(function () {
                var id = $(this).data('id');
                DeleteMail(id);
            });

        }


        //-- Show mail content
        $('.mail_item .mail_click').click(function () {
            ShowMailInfo();
        });

        function ShowMailInfo(){
            var mailId = $('.mail_item').data('id');

            var url = '{{ route('ajax_get_mail_data') }}';
            $.ajax({
                method: 'POST',
                url: url,
                dataType: "json",
                data: {
                    mailId: mailId,
                    _token: token
                }, beforeSend: function () {
                    //-- Show loading image while execution of ajax request
                    $("div#divLoading").addClass('show');
                },
                success: function (data) {
                    if (data['result'] === "success") {

                        $("#mail_title").html("<b>" + data['mail']['title'] + "</b><br><span>" + data['mail']['created_at'] + "</span>");
                        $("#mail_content").html(data['mail']['content']);
                        $('#mail_modal').modal('toggle');
                    } else {
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
        }


        function DeleteMail(id) {

            //-- Hide delete modal
            $('#delete_mail').modal('hide');

            var url = '{{ route('ajax_delete_mail') }}';
            $.ajax({
                method: 'POST',
                url: url,
                dataType: "json",
                data: {
                    id: id,
                    _token: token
                }, beforeSend: function () {
                    //-- Show loading image while execution of ajax request
                    $("div#divLoading").addClass('show');
                },
                success: function (data) {
                    if (data['result'] === "success") {

                        //-- Hide mail line from table
                        $('#mail_' + id).hide();
                        //-- Hide loading image
                        $("div#divLoading").removeClass('show');

                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: '{{trans('dashboard::messages.mail_deleted')}}' + '!'
                        }).show();
                    }
                }
            });

        }


        //-- Functionality when something was typed in Searching bar
        $('#search_bar').keyup(function () {
            var url = '{{ route('ajax_search_bar') }}';
            var strValue = $(this).val();

            if(strValue!=""){
            $.ajax({
                method: 'POST',
                url: url,
                dataType: "json",
                data: {
                    strValue: strValue,
                    strModule: 'mail',
                    _token: token
                }, beforeSend: function () {
                    //-- Show loading image while execution of ajax request
                    $("div#divLoading").addClass('show');
                },
                success: function (data) {
                    if (data['result'] === "success") {

                        //-- Hide loading image
                        $("div#divLoading").removeClass('show');

                        //-- Hide mails list
                        $("#mail_body,#links").hide();
                        $("#mail_body_search,#found_items").html('');

                        if (data['arrData'].length > 0) {

                            //-- Set number of found items
                            $("#found_items").html('{{trans('messages.number_of_found_items')}}:<b>'+data['arrData'].length+'</b>');

                            for (var i = 0; i < data['arrData'].length; i++) {

                                var newMenuCount = data['arrData'][i]['id'];

                                var strFrom = '<td class="mail_click">' + data['arrData'][i]['from'] + '</td>';
                                var strTo = '<td class="mail_click">' + data['arrData'][i]['to'] + '</td>';
                                var strTitle = '<td class="mail_click">' + data['arrData'][i]['title'] + '</td>';
                                var strDate = '<td class="mail_click">' + data['arrData'][i]['created_at'] + '</td>';
                                var strDeleteButton = '<td><a href="#" id="delete_' + data['arrData'][i]['id'] + '"><span class="delete w3-text-red"><i class="fas fa-minus-circle"></i></span></a></td>';
                                var strContent = strFrom + strTo + strTitle + strDate + strDeleteButton;

                                $(' <tr class="mail_item" id="mail_' + newMenuCount + '" data-id="' + newMenuCount + '">').html(strContent + "</tr>").appendTo('#mail_body_search');

                            }
                        } else {
                            $(' <p class="w3-text-grey" style="font-size: 30px;padding:10px 10px;">').html("{{trans('dashboard::messages.no_mails_found')}}</p>").appendTo('#mail_body_search');
                        }

                    }

                    //-- Delete label functionality
                    $('[id^="modal_delete_"]').click(function () {
                        ShowDeleteModal($(this).attr('id').replace('modal_delete_', ""));
                    });

                    //-- Show mail content
                    $('.mail_item .mail_click').click(function () {
                        ShowMailInfo();
                    });
                }
            });
            }else{
                $("#mail_body_search,#found_items").html('');
                $("#mail_body,#links").show();
            }

        });


    </script>
@endsection