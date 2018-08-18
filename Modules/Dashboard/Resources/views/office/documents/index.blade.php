@extends('dashboard::layouts.master')
@section('styles')

@endsection
@section('General')
    <div class="row">
        <div class="col-sm-12 col-md-10  col-xs-12">
            <h3 class="title">@lang('dashboard::messages.documents')</h3>
            <div id="title_shape"></div>

            <div class="insp_buttons">
                <a href="{{route("office",['id'=>Auth::id()])}}"
                   class="btn btn-warning">@lang('dashboard::messages.back_to_office_menu')</a>
                <a href="{{route("upload_document",Auth::id())}}" class="btn btn-success">@lang('dashboard::messages.upload_new_document')</a>
            </div>

                @if(count($documents)>0)
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
                            <th>@lang('messages.name')</th>
                            <th>@lang('messages.extension')</th>
                            <th>@lang('messages.size')</th>
                            <th>@lang('messages.date')</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="file_body">
                        @foreach($documents as $doc)

                            <tr class="file_item" id="file_{{$doc->id}}" data-id="{{$doc->id}}">
                                <td class="file_click">{{$doc->name}}</td>
                                <td class="file_click">{{$doc->extension}}</td>
                                <td class="file_click">{{$doc->size}} bytes</td>
                                <td class="file_click">{{$doc->created_at}}</td>
                                <td>
                                    @if($doc->user_id==Auth::id())
                                        <a href="#" id="modal_delete_{{$doc->id}}">
                                <span class="delete w3-text-red">
                                    <i class="fas fa-minus-circle"></i>
                                </span>
                                        </a>
                                    @endif
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                        <tbody id="file_body_search"></tbody>
                    </table>
                @endif
        </div>
        <div class="col-sm-12 col-lg-8 col-xs-12 w3-center" id="links">
            {!! $documents->links() !!}
        </div>
    </div>
    {{--Delete profile modal--}}
    <div class="modal" id="delete_doc">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">@lang('dashboard::messages.delete_this_file')</h4>
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

@endsection
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

        //-- Show delete file modal functionality
        $('[id^="modal_delete_"]').click(function () {
            ShowDeleteModal($(this).attr('id').replace('modal_delete_', ""));
        });


        function ShowDeleteModal(id) {
            var strDeleteButton = '<a href="#" class="btn btn-danger delete_file" data-id="' + id + '" >{{trans('messages.delete')}}</a>';
            $("#delete_button").html(strDeleteButton);
            $('#delete_doc').modal('toggle');


            $('.delete_file').click(function () {
                var id = $(this).data('id');
                DeleteFile(id);
            });

        }

        //-- Delete file functionality
        function DeleteFile(id) {

            //-- Hide delete modal
            $('#delete_doc').modal('hide');

            var url = '{{ route('ajax_delete_file') }}';
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
                        $('#file_' + id).hide();
                        //-- Hide loading image
                        $("div#divLoading").removeClass('show');

                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: '{{trans('dashboard::messages.file_deleted')}}' + '!'
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
                        strModule: 'file',
                        _token: token
                    }, beforeSend: function () {
                        //-- Show loading image while execution of ajax request
                        $("div#divLoading").addClass('show');
                    },
                    success: function (data) {
                        if (data['result'] === "success") {

                            //-- Hide loading image
                            $("div#divLoading").removeClass('show');

                            //-- Hide files list
                            $("#file_body,#links").hide();
                            $("#file_body_search,#found_items").html('');
                            if (data['arrData'].length > 0) {

                                //-- Set number of found items
                                $("#found_items").html('Number of found items:<b>'+data['arrData'].length+'</b>');

                                for (var i = 0; i < data['arrData'].length; i++) {

                                    var newMenuCount = data['arrData'][i]['id'];

                                    var strName = '<td class="file_click">' + data['arrData'][i]['name'] + '</td>';
                                    var strExtension = '<td class="file_click">' + data['arrData'][i]['extension'] + '</td>';
                                    var strSize = '<td class="file_click">' + data['arrData'][i]['size'] + ' bytes</td>';
                                    var strDate = '<td class="file_click">' + data['arrData'][i]['created_at'] + '</td>';
                                    var strDeleteButton = '<td><a href="#" id="modal_delete_' + data['arrData'][i]['id'] + '"><span class="delete w3-text-red"><i class="fas fa-minus-circle"></i></span></a></td>';



                                    var strContent = strName + strExtension + strSize + strDate + strDeleteButton;

                                    $(' <tr class="file_item" id="file_' + newMenuCount + '" data-id="' + newMenuCount + '">').html(strContent + "</tr>").appendTo('#file_body_search');

                                }
                            } else {
                                $(' <p class="w3-text-grey not_found_text">').html("{{trans('dashboard::messages.no_files_found')}}</p>").appendTo('#file_body_search');
                            }

                        }

                        //-- Show delete file modal functionality
                        $('[id^="modal_delete_"]').click(function () {
                            ShowDeleteModal($(this).attr('id').replace('modal_delete_', ""));
                        });

                    }
                });
            }else{
                $("#file_body_search,#found_items").html('');
                $("#file_body,#links").show();
            }


        });


    </script>
@endsection