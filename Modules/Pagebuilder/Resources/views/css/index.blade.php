@extends('pagebuilder::layouts.master')

@section('styles')

@stop
@section('scripts_header')
    <link rel="stylesheet" href="{{custom_asset('plugins/vendor/codemirror/lib/codemirror.css')}}">
    <link rel="stylesheet" href="{{custom_asset('plugins/vendor/codemirror/addon/display/fullscreen.css')}}">
    <link rel="stylesheet" href="{{custom_asset('plugins/vendor/codemirror/addon/hint/show-hint.css')}}">
    @php
        $strCodeeditorTheme=!empty(Auth::user()->setting->codeeditor_theme)? Auth::user()->setting->codeeditor_theme:'darcula';
        $strCodeeditorFullTheme='plugins/vendor/codemirror/theme/'.$strCodeeditorTheme.'.css';
    @endphp
    <link rel="stylesheet" href="{{custom_asset($strCodeeditorFullTheme)}}">

    <script src="{{custom_asset('plugins/vendor/codemirror/lib/codemirror.js')}}"></script>
    <script src="{{custom_asset('plugins/vendor/codemirror/mode/xml/xml.js')}}"></script>
    <script src="{{custom_asset('plugins/vendor/codemirror/addon/display/fullscreen.js')}}"></script>
    <script src="{{custom_asset('plugins/vendor/codemirror/mode/css/css.js')}}"></script>
    <script src="{{custom_asset('plugins/vendor/codemirror/addon/hint/show-hint.js')}}"></script>
    <script src="{{custom_asset('plugins/vendor/codemirror/addon/hint/css-hint.js')}}"></script>


@stop
@section('General')

    <div class="row maintab">
        <div class="col-sm-12 col-lg-12 col-xs-12">
            <div class="col-sm-8 col-lg-8 col-xs-12">
                <div>
                    <h3 class="title">Custom CSS</h3>
                    <div id="title_shape"></div>
                </div>

                <article>

                    <form>
            <textarea id="codeCSS" name="codeCSS" rows="10">{{$customSetting->custom_css}}</textarea>
                    </form>
                    <script>
                        var editor = CodeMirror.fromTextArea(document.getElementById("codeCSS"), {
                            lineNumbers: true,
                            theme: '{{$strCodeeditorTheme}}',
                            mode:'text/css',
                            extraKeys: {
                                "F11": function (cm) {
                                    cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                                },
                                "Esc": function (cm) {
                                    if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                                }
                            }
                        });
                    </script>

                    <p>Demonstration of
                        the <a href="../doc/manual.html#addon_fullscreen">fullscreen</a>
                        addon. Press <strong>F11</strong> when cursor is in the editor to
                        toggle full screen editing. <strong>Esc</strong> can also be used
                        to <i>exit</i> full screen editing.</p>
                </article>
                <a href="{{route("codeeditor_setting",Auth::id())}}" class="btn btn-info">Editor settings</a>
                <button id="submit" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script>
        var token = '{{\Illuminate\Support\Facades\Session::token()}}';
        var url = '{{ route('ajax_custom_css_update') }}';
        $('#submit').click(function () {
            var customCssContent = editor.getValue();

            $.ajax({
                method: 'POST',
                url: url,
                data: {
                    customCssContent: customCssContent,
                    _token: token
                },
                success: function (data) {
                    console.log(data);
                    if (data['result'] === "success") {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: 'Custom CSS was updated!'
                        }).show();
                    }
                }
            });
        });
    </script>
@stop