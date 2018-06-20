@extends('label::layouts.master')

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
                </tr>
                </thead>
                @foreach($translations as $translate)
                    <tr>
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
                                    <input type="text" class="form-control" name="" value="">
                                @endif
                            </td>
                        @endforeach

                    </tr>
                @endforeach
            </table>
            <div class="border-top mt-4 pt-2 text-right">
                <br>
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
        });


    </script>
@stop
