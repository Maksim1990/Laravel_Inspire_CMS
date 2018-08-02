@extends('post::layouts.master')
@section('scripts_header')
    <link rel="stylesheet" href="{{custom_asset('plugins/vendor/codemirror/lib/codemirror.css')}}">
    <link rel="stylesheet" href="{{custom_asset('plugins/vendor/codemirror/addon/display/fullscreen.css')}}">
    @php
        $strCodeeditorTheme=!empty(Auth::user()->setting->codeeditor_theme)? Auth::user()->setting->codeeditor_theme:'darcula';
        $strCodeeditorFullTheme='plugins/vendor/codemirror/theme/'.$strCodeeditorTheme.'.css';
    @endphp
    <link rel="stylesheet" href="{{custom_asset($strCodeeditorFullTheme)}}">

    <script src="{{custom_asset('plugins/vendor/codemirror/lib/codemirror.js')}}"></script>
    <script src="{{custom_asset('plugins/vendor/codemirror/mode/xml/xml.js')}}"></script>
    <script src="{{custom_asset('plugins/vendor/codemirror/addon/display/fullscreen.js')}}"></script>
@stop
@section ('General')
    <div class="row">
    <div class="col-sm-8 col-xs-10">
        <h3 class="title">Create Post</h3>
        <div id="title_shape"></div>

        {!! Form::open(['method'=>'POST','action'=>['\Modules\Post\Http\Controllers\PostController@store','userId'=>Auth::id()], 'files'=>true])!!}
        <div class="group-form">
            {!! Form::label('title','Title:') !!}
            {!! Form::text('title', null, ['class'=>'form-control']) !!}
        </div>


        <div class="group-form">
            {!! Form::label('content','Body:') !!}

            {!! Form::textarea('content', null, ['class'=>'form-control','id'=>'code']) !!}
            <br>
        </div>
        <a href="{{route("posts",Auth::id())}}" class="btn btn-success">Back to all posts</a>
        <a href="{{route("codeeditor_setting",Auth::id())}}" class="btn btn-info">Editor settings</a>
        {!! Form::submit('Create Post',['class'=>'btn btn-warning']) !!}
        {!! Form::close() !!}
    </div>
    @include('includes.formErrors')
    </div>
@stop
@section('scripts')
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
    <script>
        @if(Session::has('post_change'))
        new Noty({
            type: 'error',
            layout: 'bottomLeft',
            text: '{{session('post_change')}}'

        }).show();
        @endif
    </script>
@endsection