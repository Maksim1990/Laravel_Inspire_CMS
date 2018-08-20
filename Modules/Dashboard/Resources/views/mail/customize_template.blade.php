@extends('dashboard::layouts.master')
@section ('styles')

@endsection
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
    <div class="row">
        <div class="col-sm-8 col-xs-10">
            <h3 class="title">@lang('dashboard::messages.customize_mail_template')</h3>
            <div id="title_shape"></div>

            <article>

                <form>
                    <textarea id="codeCSS" name="codeCSS" rows="10">{{$template->content}}</textarea>
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
            <button id="submit" class="btn btn-success">Save</button>
        </div>
    </div>


@stop


@section('scripts')
    <script>
        var token = '{{\Illuminate\Support\Facades\Session::token()}}';
        var url = '{{ route('ajax_mail_template_update') }}';
        $('#submit').click(function () {
            var mailTemplateContent = editor.getValue();

            $.ajax({
                method: 'POST',
                url: url,
                dataType: "json",
                data: {
                    mailTemplateContent: mailTemplateContent,
                    template_id: '{{$template_id}}',
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
                            text: '{{trans('dashboard::messages.mail_template_updated')}}'
                        }).show();

                    }else{
                        new Noty({
                            type: 'error',
                            layout: 'bottomLeft',
                            text: data['result']
                        }).show();
                    }
                    //-- Hide loading image
                    $("div#divLoading").removeClass('show');
                }
            });
        });
    </script>
@stop