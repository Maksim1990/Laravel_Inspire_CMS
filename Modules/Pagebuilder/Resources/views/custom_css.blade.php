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
<br>

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
    <br>
</article>
<a href="{{route("codeeditor_setting",Auth::id())}}" class="btn btn-info">Editor settings</a>
<button id="submit_css" class="btn btn-success">Save</button>
<script>
    var token = '{{\Illuminate\Support\Facades\Session::token()}}';
    var url = '{{ route('ajax_custom_css_update') }}';
    $('#submit_css').click(function () {
        var customCssContent = editor.getValue();

        $.ajax({
            method: 'POST',
            url: url,
            dataType: "json",
            data: {
                customCssContent: customCssContent,
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
                        text: 'Custom CSS was updated!'
                    }).show();

                    //-- Hide loading image
                    $("div#divLoading").removeClass('show');
                }
            }
        });
    });
</script>