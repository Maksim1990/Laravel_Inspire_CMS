@extends('pagebuilder::layouts.master')

@section('styles')

@stop
@section('scripts_header')
    <link rel="stylesheet" href="{{asset('plugins/vendor/codemirror/lib/codemirror.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/vendor/codemirror/addon/display/fullscreen.css')}}">
    @php
        $strCodeeditorTheme=!empty(Auth::user()->setting->codeeditor_theme)? Auth::user()->setting->codeeditor_theme:'darcula';
        $strCodeeditorFullTheme='plugins/vendor/codemirror/theme/'.$strCodeeditorTheme.'.css';
    @endphp
    <link rel="stylesheet" href="{{asset($strCodeeditorFullTheme)}}">

    <script src="{{asset('plugins/vendor/codemirror/lib/codemirror.js')}}"></script>
    <script src="{{asset('plugins/vendor/codemirror/mode/xml/xml.js')}}"></script>
    <script src="{{asset('plugins/vendor/codemirror/addon/display/fullscreen.js')}}"></script>

@stop
@section('General')
    <div class="row maintab">
        <div class="col-sm-12 col-lg-12 col-xs-12">
            <div class="col-sm-8 col-lg-8 col-xs-12">
                <article>
                    <form>
                        <textarea id="code" name="code" rows="10">{{$blockCode}}</textarea>
                    </form>
                    <script>
                        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                            lineNumbers: true,
                            theme: '{{$strCodeeditorTheme}}',
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
                <a href="{{route("pagebuilder_index",Auth::id())}}" class="btn btn-warning">Back to pagebuilder</a>
                <a href="{{route("codeeditor_setting",Auth::id())}}" class="btn btn-info">Editor settings</a>
                <button id="submit" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script>
        var token = '{{\Illuminate\Support\Facades\Session::token()}}';
        var url = '{{ route('ajax_codeeditor_update') }}';

        $('#submit').click(function () {
            var codeEditorContent = editor.getValue();
            var block_id = '{{$block_id}}';

            $.ajax({
                method: 'POST',
                url: url,
                data: {
                    codeEditorContent: codeEditorContent,
                    block_id: block_id,
                    _token: token
                },
                success: function (data) {
                    if (data['result'] === "success") {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: 'Code updated!'
                        }).show();
                    }
                }
            });
        });
    </script>


@stop