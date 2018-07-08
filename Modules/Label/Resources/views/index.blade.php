@extends('label::layouts.master')

@section('styles')
    <style>
        .delete {
            color: #be241a;
            font-size: 23px;
        }
    </style>
@stop
@section('General')
    <h3>Translations</h3>
    <div>
        <p>Module: <b>Website</b></p>
        @if(!empty($translations))

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
                    <tr id="label_{{$translate->id}}">
                        <td>
                            <input type="text" class="form-control" id="key_{{$translate->id}}"
                                   value="{{$translate->key}}">
                        </td>
                        @foreach($arrOfActiveLanguages as $strKey=>$strLang)
                            <td>
                                @if(isset($translate->text[strtolower($strKey)]) || $translate->text[strtolower($strKey)]=="")
                                    <input type="text" class="form-control"
                                           id="{{$translate->id}}_text_{{strtolower($strKey)}}"
                                           value="{{$translate->text[strtolower($strKey)]}}">
                                @else
                                    <input type="text" class="form-control" name="" value="">
                                @endif
                            </td>
                            @php
                            $intLastId=$translate->id;
                            @endphp
                        @endforeach
                        <td>
                            @if($translate->user_id==Auth::id())
                                <a href="#" id="delete_{{$translate->id}}">
                                <span class="delete">
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
@stop
@section('scripts')
    <script>
        var token = '{{\Illuminate\Support\Facades\Session::token()}}';
        var url = '{{ route('ajax_update_label') }}';

        //-- Functionality to update labels for current module
        $('#submit').click(function () {
            SaveLabel();
        });

        //-- Delete label functionality
        $('[id^="delete_"]').click(function () {
            DeleteLabel($(this).attr('id').replace('delete_', ""));
        });


        //-- Add new label functionality
        var newLabelCount='{{$intLastLabelId}}';
        $('#add').click(function () {
            newLabelCount++;
            var keyField = "<td><input type=\"text\" class=\"form-control\" id='key_"+newLabelCount+"'></td>";
            var langField = "";
            @foreach($arrOfActiveLanguages as $strKey=>$strLang)
                langField += "<td><input type='text' id='"+newLabelCount+"_text_{{strtolower($strKey)}}' class=\"form-control\" name='' value=''></td>";
            @endforeach

            var deleteIcon = "<td><a href=\"#\" id='delete_"+newLabelCount+"'><span class=\"delete\"><i class=\"fas fa-minus-circle\"></i></span></a></td>";
            $('<tr id="label_'+newLabelCount+'">').html(keyField + langField + deleteIcon + "</tr>").appendTo('#labels_body');

            $('[id^="delete_"]').click(function () {
                DeleteLabel($(this).attr('id').replace('delete_', ""));
            });

        });

        function DeleteLabel(id) {
           $('#label_'+id).hide();
            var url = '{{ route('ajax_delete_label') }}';

            var conf=confirm("Do you want to delete this label?");
            if(conf) {
                $.ajax({
                    method: 'POST',
                    url: url,
                    data: {
                        id: id,
                        _token: token
                    },
                    success: function (data) {
                        if (data['result'] === "success") {
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: 'Labels deleted!'
                            }).show();
                        }
                    }
                });
            }

        }


        function SaveLabel() {
            var arrTranslationsKeys = {};
            var arrTranslations = {};
            $('input[id^="key_"]').each(function () {
                if ($(this).attr('id')) {
                    var id = $(this).attr('id').replace("key_", "").trim();
                    arrTranslationsKeys[id] = $(this).val();
                    var pattern = id + "_text_";

                    $('input[id^=' + pattern + ']').each(function () {
                        var idLabel = $(this).attr('id').replace(id + "_text_", "").trim();
                        arrTranslations[id + "_" + idLabel] = $(this).val();
                    });
                }
            });
            console.log(arrTranslations);
            $.ajax({
                method: 'POST',
                url: url,
                data: {
                    arrTranslations: arrTranslations,
                    arrTranslationsKeys: arrTranslationsKeys,
                    module: "website",
                    _token: token
                },
                success: function (data) {
                    if (data['result'] === "success") {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: 'Labels updated!'
                        }).show();
                    }
                }
            });
        }
    </script>
@stop
