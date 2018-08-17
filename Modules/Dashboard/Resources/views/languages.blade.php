@extends('dashboard::layouts.master')

@section('General')
    <div>
        <h3 class="title">@lang('messages.language_settings')</h3>
        <div id="title_shape"></div>
    </div>
    <div>

        <div>
            <form action="POST" name="lang_form" id="lang_form">
                @if(count($allAvailableLanguages)>0)
                    @foreach($allAvailableLanguages as $strKey=>$langItem)
                        @php
                            $strChecked='';
                              if(in_array(strtoupper($strKey),$arrOfActiveLanguagesKeys)){
                              $strChecked='checked';
                              }

                        $strDisabled='';
                        //-- Disable default app language that can't be deactivated
                        if(in_array(strtoupper($strKey),$arrOfDefaultLanguagesKeys)){
                              $strDisabled='disabled';
                              }
                        @endphp
                        <p><input type="checkbox" {{$strChecked}} {{$strDisabled}} name="selectedLangs[]"
                                  value="{{$strKey}}_{{$langItem['native']}}_{{$langItem['name']}}">{{$langItem['native']}}
                        </p>
                    @endforeach

                @endif

            </form>
            <div class="border-top mt-4 pt-2 text-right">
                <br>
                <input type="submit" id="submit" value="@lang('messages.save')" class="btn btn-success">
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script>
        var token = '{{\Illuminate\Support\Facades\Session::token()}}';
        var url = '{{ route('ajax_update_languages') }}';

        //-- Functionality to update menus
        $('#submit').click(function () {
            SaveMenu();
        });


        function SaveMenu() {

            var selectedLangs = $('#lang_form').serializeArray();

            $.ajax({
                method: 'POST',
                url: url,
                dataType: "json",
                data: {
                    selectedLangs: selectedLangs,
                    _token: token
                }, beforeSend: function () {
                    //-- Show loading image while execution of ajax request
                    $("div#divLoading").addClass('show');
                },
                success: function (data) {
                    if (data['result'] === "success") {

                        //-- Hide loading image
                        $("div#divLoading").removeClass('show');

                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: '{{trans('messages.language_updated')}}!'
                        }).show();
                    }
                }
            });
        }


    </script>
@stop