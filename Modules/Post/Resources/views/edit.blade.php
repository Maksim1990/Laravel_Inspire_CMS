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
            <h3 class="title">Edit Post</h3>
            <div id="title_shape"></div>

            {!! Form::model($post,['method'=>'PATCH','action'=>['\Modules\Post\Http\Controllers\PostController@updatePost','id'=>$post->id], 'files'=>true])!!}
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

            {!! Form::submit('Update Post',['class'=>'btn btn-warning']) !!}

            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#image_modal">Insert image</a>
            {!! Form::close() !!}
        </div>


        {{--Image details modal--}}
        <div class="modal" id="image_modal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h3 class="title">Select image</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="row w3-margin-left">
                                @if(count($userImages)>0)
                                    @foreach($userImages as $image)
                                        <a class="insert_image" data-toggle="modal" data-target="#image_modal_{{$image->id}}" data-path="{{$image->path}}">
                                            <img src="{{custom_asset("storage/".$image->path)}}" width="100" height="100" class="w3-border w3-hover-opacity" >
                                        </a>
                                    @endforeach
                                @else
                                    <div class="w3-text-grey not_found_text" style="width: 100%;">@lang('images::messages.no_images_found')</div>
                                    <div>
                                        <a href="{{route("images",['id'=>Auth::id()])}}"
                                           class="btn btn-success">@lang('images::messages.go_to_images_module')</a>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
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

    <script>
        $('.insert_image').click(function () {
            var imagePath=$(this).data('path');
            var contentCode = editor.getValue();
            contentCode += " <img src=\"{{custom_asset("storage")}}/"+imagePath+"\" class=\"w3-border w3-hover-opacity\" style=\"width:100%\">";
            editor.getDoc().setValue(contentCode);

            //-- Close modal with images
            $('#image_modal').modal('toggle');

        });
    </script>
@endsection