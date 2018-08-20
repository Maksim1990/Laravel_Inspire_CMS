@extends('pagebuilder::layouts.master')

@section('styles')

@stop
@section('scripts_header')


@stop
@section('General')
    <div class="row maintab">
        <div class="col-sm-12 col-lg-12 col-xs-12">
            <div class="col-sm-6 col-lg-12 col-xs-12">
                <div>
                    <h3 class="title">Code editor settings</h3>
                    <div id="title_shape"></div>
                </div>
                <div class="col-sm-7">
                    <p class="text">Choose favorite style of code editor</p>

                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        @if(count($arrThemes)>0)
                            <select id="editorCSS" class="custom-select" style="height: 40px;">
                                @foreach($arrThemes as $strTheme)
                                    @php
                                    $strStyle=!empty(Auth::user()->setting->codeeditor_theme)? Auth::user()->setting->codeeditor_theme:'darcula';
                                    $strSelected="";
                                    if($strStyle==$strTheme){
                                    $strSelected='selected';
                                    }

                                    @endphp
                                    <option value="{{$strTheme}}" {{$strSelected}}>{{$strTheme}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-sm btn-success" style="margin-top: 5px;" id="save_codeeditor_theme">Save</button>
                </div>
                <div class="col-sm-12">
                    <hr>
                </div>
            </div>
        </div>
    </div>

@stop
@section('scripts')
    <script>
        var token = '{{\Illuminate\Support\Facades\Session::token()}}';
        var url = '{{ route('ajax_codeeditor_theme_update') }}';
        $('#save_codeeditor_theme').click(function () {
            var codeEditorTheme = $('#editorCSS').val();
            $.ajax({
                method: 'POST',
                url: url,
                dataType: "json",
                data: {
                    codeEditorTheme: codeEditorTheme,
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
                            text: 'Theme was successfully updated!'
                        }).show();
                    }
                    //-- Hide loading image
                    $("div#divLoading").removeClass('show');
                }
            });


        });
    </script>
@stop