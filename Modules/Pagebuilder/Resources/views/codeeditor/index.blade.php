@extends('pagebuilder::layouts.master')

@section('styles')

@stop
@section('scripts_header')

    {{--<link rel=stylesheet href="{{asset('plugins/vendor/codemirror/doc/docs.css')}}">--}}
    <link rel="stylesheet" href="{{asset('plugins/vendor/codemirror/lib/codemirror.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/vendor/codemirror/addon/display/fullscreen.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/vendor/codemirror/theme/darcula.css')}}">

    <script src="{{asset('plugins/vendor/codemirror/lib/codemirror.js')}}"></script>
    <script src="{{asset('plugins/vendor/codemirror/mode/xml/xml.js')}}"></script>
    <script src="{{asset('plugins/vendor/codemirror/addon/display/fullscreen.js')}}"></script>

@stop
@section('General')
    <button id="submit" class="btn btn-info">Test</button>
    <article>

        <form>
            <textarea id="code" name="code" rows="10">


     <h2><img title="TinyMCE Logo" src="//www.tinymce.com/images/glyph-tinymce@2x.png" alt="TinyMCE Logo" width="110"
              height="97" style="float: right"/>TinyMCE Inline Mode</h2>
        <div class="w3-row">
            <div class="w3-col s4 w3-green w3-center"><p>s4</p></div>
            <div class="w3-col s4 w3-dark-grey w3-center"><p>s4</p></div>
            <div class="w3-col s4 w3-red w3-center"><p>s4</p></div>
        </div>

        <hr>

        </textarea>
        </form>
        <script>
            var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
                lineNumbers: true,
                theme: "darcula",
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

@stop
@section('scripts')
    <script>
        $('#submit').click(function () {
            console.log(editor.getValue());
        });
    </script>
@stop