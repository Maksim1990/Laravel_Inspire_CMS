@extends('label::layouts.master')

@section('styles')

@stop
@section('General')
    <h3 class="title">Translations</h3>
    <div id="title_shape"></div>

    <div class="insp_buttons">
        <a href="{{route("office",['id'=>Auth::id()])}}"
           class="btn btn-warning">@lang('dashboard::messages.back_to_office_menu')</a>
    </div>

    <div>
        @if(!empty($translations))
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


            <table class="w3-table-all w3-hoverable ">
                <thead>
                <tr class="w3-light-grey">
                    <th>Key</th>
                    @foreach($arrOfActiveLanguages as $strLang)
                        <th>{{$strLang}}</th>
                    @endforeach
                    <th></th>
                </tr>

                </thead>
                <tbody id="labels_body">
                @foreach($translations as $translate)
                    <tr class="label_item" id="label_{{$translate->id}}">
                        <td>
                            <input type="text" class="form-control" id="key_{{$translate->id}}"
                                   value="{{$translate->key}}">
                        </td>
                        @foreach($arrOfActiveLanguages as $strKey=>$strLang)
                            <td>
                                @if(isset($translate->text[strtolower($strKey)]))
                                    <input type="text" class="form-control"
                                           id="{{$translate->id}}_text_{{strtolower($strKey)}}"
                                           value="{{$translate->text[strtolower($strKey)]}}">
                                @else
                                    <input type="text" class="form-control" id="{{$translate->id}}_text_{{strtolower($strKey)}}" name="" value="">
                                @endif
                            </td>
                            @php
                                $intLastId=$translate->id;
                            @endphp
                        @endforeach
                        <td>
                            @if($translate->user_id==Auth::id())
                                <a href="#" id="modal_delete_{{$translate->id}}">
                                <span class="delete w3-text-red">
                                    <i class="fas fa-minus-circle"></i>
                                </span>
                                </a>
                            @endif
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="border-top mt-4 pt-2 text-right">
                <br>
                <input id="add" value="Add new label" class="btn btn-warning">
                <input type="submit" id="submit" value="Save" class="btn btn-success">
            </div>

            </form>
        @endif
    </div>

    {{--Delete label modal--}}
    <div class="modal" id="delete_label_modal">
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
@stop
@section('scripts')
    <script>
        var token = '{{\Illuminate\Support\Facades\Session::token()}}';
        var url = '{{ route('ajax_update_label') }}';

        //-- Functionality to update labels for current module
        $('#submit').click(function () {
            SaveLabel();
        });

        //-- Show delete file modal functionality
        $('[id^="modal_delete_"]').click(function () {
            ShowDeleteModal($(this).attr('id').replace('modal_delete_', ""));
        });


        function ShowDeleteModal(id) {
            var strDeleteButton = '<a href="#" class="btn btn-danger delete_label" data-id="' + id + '" >{{trans('messages.delete')}}</a>';
            $("#delete_button").html(strDeleteButton);
            $('#delete_label_modal').modal('toggle');


            $('.delete_label').click(function () {
                var id = $(this).data('id')
                //-- Add new label functionality
                var newLabelCount = '{{$intLastLabelId}}';
                if(id<= +newLabelCount){
                    DeleteLabel(id);
                }else{
                    //-- Hide menu line from table
                    $('#menu_' + id).remove();
                    //-- Hide delete modal
                    $('#delete_menu_modal').modal('hide');
                }
            });

        }


        //-- Add new label functionality
        var newLabelCount = '{{$intLastLabelId}}';
        $('#add').click(function () {
            newLabelCount++;
            var keyField = "<td><input type=\"text\" class=\"form-control\" id='key_" + newLabelCount + "'></td>";
            var langField = "";
            @foreach($arrOfActiveLanguages as $strKey=>$strLang)
                langField += "<td><input type='text' id='" + newLabelCount + "_text_{{strtolower($strKey)}}' class=\"form-control\" name='' value=''></td>";
                    @endforeach

            var deleteIcon = "<td><a href=\"#\" id='modal_delete_" + newLabelCount + "'><span class=\"delete\"><i class=\"fas fa-minus-circle\"></i></span></a></td>";
            $('<tr id="label_' + newLabelCount + '">').html(keyField + langField + deleteIcon + "</tr>").appendTo('#labels_body');

            //-- Show delete file modal functionality
            $('[id^="modal_delete_"]').click(function () {
                ShowDeleteModal($(this).attr('id').replace('modal_delete_', ""));
            });

        });

        function DeleteLabel(id) {

            //-- Hide delete modal
            $('#delete_label_modal').modal('hide');

            var url = '{{ route('ajax_delete_label') }}';

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

                            //-- Hide label line from table
                            $('#label_' + id).hide();
                            //-- Hide loading image
                            $("div#divLoading").removeClass('show');

                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: 'Labels deleted!'
                            }).show();
                        }
                    }
                });
        }


        function SaveLabel() {
            var arrTranslationsKeys = {};
            var arrTranslations = {};

            var blnAllowSubmit = true;

            $('input[id^="key_"]').each(function () {
                if ($(this).attr('id')) {
                    var id = $(this).attr('id').replace("key_", "").trim();

                    arrTranslationsKeys[id] = $(this).val();
                    if (arrTranslationsKeys[id] === "") {
                        blnAllowSubmit = false;
                    }
                    var pattern = id + "_text_";

                    $('input[id^=' + pattern + ']').each(function () {
                        var idLabel = $(this).attr('id').replace(id + "_text_", "").trim();
                        arrTranslations[id + "_" + idLabel] = $(this).val();
                    });
                }
            });


            if (blnAllowSubmit) {
                $.ajax({
                    method: 'POST',
                    url: url,
                    dataType: "json",
                    data: {
                        arrTranslations: arrTranslations,
                        arrTranslationsKeys: arrTranslationsKeys,
                        module: "website",
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
                                text: 'Labels updated!'
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

                        //-- Update labels list
                        SearchAndUpdateLabels();
                    }
                });
            } else {
                new Noty({
                    type: 'error',
                    layout: 'bottomLeft',
                    text: 'Label key can not be empty!'
                }).show();
            }
        }


        //-- Functionality when something was typed in Searching bar
        $('#search_bar').keyup(function () {
            SearchAndUpdateLabels();
        });

        function SearchAndUpdateLabels() {
            var url = '{{ route('ajax_search_bar') }}';
            var strValue = $('#search_bar').val();

            $.ajax({
                method: 'POST',
                url: url,
                dataType: "json",
                data: {
                    strValue: strValue,
                    strModule: 'label',
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
                        $("#labels_body,#found_items").html('');
                        if (data['arrData'].length > 0) {

                            //-- Set number of found items
                            $("#found_items").html('{{trans('messages.number_of_found_items')}}:<b>'+data['arrData'].length+'</b>');

                            for (var i = 0; i < data['arrData'].length; i++) {

                                var newMenuCount = data['arrData'][i]['id'];
                                var strKey = '<td><input type="text" class="form-control" id="key_' + data['arrData'][i]['id'] + '" value="' + data['arrData'][i]['key'] + '"</td>';

                                var strTranslations="";
                                for (var j = 0; j < data['arrData'][i]['langs'].length; j++) {
                                    var strTranslation=data['arrData'][i]['langs'][j]['translation'];
                                    if(strTranslation===null){
                                        strTranslation="";
                                    }
                                    strTranslations += '<td><input type="text" class="form-control" id="' + data['arrData'][i]['id'] + '_text_' + data['arrData'][i]['langs'][j]['langKey'] + '" value="' + strTranslation + '"></td>';
                                }

                                var strDeleteButton = '<td><a href="#" id="modal_delete_' + data['arrData'][i]['id'] + '"><span class="delete w3-text-red"><i class="fas fa-minus-circle"></i></span></a></td>';



                                var strContent = strKey + strTranslations + strDeleteButton;

                                $(' <tr class="label_item" id="label_' + newMenuCount + '" data-id="' + newMenuCount + '">').html(strContent + "</tr>").appendTo('#labels_body');

                            }

                            //-- Show delete file modal functionality
                            $('[id^="modal_delete_"]').click(function () {
                                ShowDeleteModal($(this).attr('id').replace('modal_delete_', ""));
                            });
                        } else {
                            $(' <p class="w3-text-grey not_found_text">').html("{{trans('dashboard::messages.no_files_found')}}</p>").appendTo('#labels_body');
                        }
                    }
                }
            });
        }
    </script>
@stop
