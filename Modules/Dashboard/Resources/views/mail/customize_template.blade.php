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
        <div class="col-sm-12 col-xs-12">
            <h3 class="title">@lang('dashboard::messages.customize_mail_template')</h3>
            <div id="title_shape"></div>
            <div class="col-sm-8 col-xs-12">
                <article>

                    <form>
                        <div class="col-sm-12col-xs-12 w3-margin-bottom">
                            <input type="text" id="template_title" class="form-control" placeholder="@lang('dashboard::messages.template_title')"
                                   data-toggle="tooltip" data-placement="top" title="@lang('dashboard::messages.template_title')" aria-describedby="basic-addon2"
                                   value="{{isset($template)?$template->title:""}}">

                        </div>
                        <div class="col-sm-12col-xs-12">
                        <textarea id="codeCSS" name="codeCSS" rows="10">{{isset($template)?$template->content:""}}</textarea>
                        </div>
                    </form>
                    <script>
                        var editor = CodeMirror.fromTextArea(document.getElementById("codeCSS"), {
                            lineNumbers: true,
                            theme: '{{$strCodeeditorTheme}}',
                            mode: 'text/css',
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
                <a href="{{route("mail",Auth::id())}}" class="btn btn-success">@lang('messages.back_to_mail_module')</a>
                <a href="{{route("codeeditor_setting",Auth::id())}}" class="btn btn-info">Editor settings</a>
                <a href="{{route("mail_template_list",['id'=>Auth::id()])}}" class="btn btn-warning">@lang('dashboard::messages.mail_templates_list')</a>
                <button id="submit" class="btn btn-success">Save</button>
            </div>
            <div class="col-sm-4 col-xs-10">
                @if(isset($template))
                <div>
                    @php
                        $strActive=trans('messages.not_active');
                        $strClass="success";
                        $strButtonTittle=trans('messages.activate');
                        $strClassText="red";
                    if($template->active=="Y"){
                    $strActive=trans('messages.active');
                    $strClassText="green";
                    }
                    @endphp
                    Template status: <b class="w3-text-{{$strClassText}}" id="status">{{$strActive}}</b>
                    @if($template->active=="N")
                    <a href="#" class="btn btn-{{$strClass}}" id="activate_button" onclick="ChangeActiveTemplate('{{$template->id}}')">{{$strButtonTittle}}</a>
                    @endif
                    <br><hr>
                </div>
                @endif
                @lang('dashboard::messages.mail_template_customize_info',['mailVariable'=>'@{{$content}}'])
            </div>
        </div>
    </div>


@stop


@section('scripts')
    <script>
        var token = '{{\Illuminate\Support\Facades\Session::token()}}';
        var url = '{{ route('ajax_mail_template_update') }}';
        $('#submit').click(function () {
            var mailTemplateContent = editor.getValue();
            var template_title = $('#template_title').val();

            $.ajax({
                method: 'POST',
                url: url,
                dataType: "json",
                data: {
                    mailTemplateContent: mailTemplateContent,
                    template_id: '{{$template_id}}',
                    template_title: template_title,
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

                    } else {
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

        function ChangeActiveTemplate(id) {

            var url = '{{ route('ajax_mail_template_active_update') }}';
            $.ajax({
                method: 'POST',
                url: url,
                dataType: "json",
                data: {

                    template_id: id,
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
                            text: '{{trans('dashboard::messages.mail_template_activated')}}'
                        }).show();

                        $('#status').removeClass('w3-text-red').addClass('w3-text-green').text('{{trans('messages.active')}}');
                        $('#activate_button').hide();
                    } else {
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
        }


    </script>
@stop