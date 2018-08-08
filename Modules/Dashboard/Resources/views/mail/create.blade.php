@extends('dashboard::layouts.master')
@section ('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.0/min/dropzone.min.css" rel="stylesheet">
    <style>
        #mail_attachments{
            padding-top: 20px;
            display: none;
        }
    </style>
@endsection
@section('General')
    <div class="row">
        <div class="col-sm-8 col-xs-10">
            <h3 class="title">Create mail</h3>
            <div id="title_shape"></div>
            {!! Form::open(['method'=>'POST','action'=>['\Modules\Dashboard\Http\Controllers\MailController@store','id'=>Auth::id()], 'files'=>true])!!}
            {!! Form::hidden('from', \Auth::user()->email) !!}
            <div class="group-form">
                {!! Form::label('sender','From:') !!}
                {!! Form::text('sender', \Auth::user()->email, ['class'=>'form-control','disabled'=>'disabled']) !!}
            </div>

            <div class="group-form">
                {!! Form::label('to','To:') !!}
                {!! Form::text('to', null, ['class'=>'form-control']) !!}
            </div>

            <div class="group-form">
                {!! Form::label('title','Title:') !!}
                {!! Form::text('title', null, ['class'=>'form-control']) !!}
            </div>


            <div class="group-form">
                {!! Form::label('content','Content:') !!}

                {!! Form::textarea('content', null, ['class'=>'form-control','id'=>'code']) !!}
                <br>
            </div>



            <a href="{{route("mail",Auth::id())}}" class="btn btn-success">Back to Mail module</a>
            <a href="#" id="add_attachment" class="btn btn-info">Add attachment</a>
            {!! Form::submit('Send',['class'=>'btn btn-warning']) !!}
            {!! Form::close() !!}

            <div id="mail_attachments">
                {!! Form::open(['method'=>'POST','action'=>['\Modules\Dashboard\Http\Controllers\MailController@attachImages','id'=>Auth::id()],'id'=>'attacheImage', 'class'=>'dropzone'])!!}
                {!! Form::close() !!}
            </div>
            <br>
            @include('includes.formErrors')
        </div>

    </div>
@stop
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.0/min/dropzone.min.js"></script>
    <script>
        @if(Session::has('mail_change'))
        new Noty({
            type: 'error',
            layout: 'bottomLeft',
            text: '{{session('mail_change')}}'

        }).show();
        @endif
    </script>
    <script>
        Dropzone.options.uploadForm = {
            success: function(file, response){
                if (response['result'] === "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'Images attached!'
                    }).show();
                }else{
                    new Noty({
                        type: 'error',
                        layout: 'bottomLeft',
                        text: response['error']
                    }).show();
                }
            }
        };


        //-- Functionality to update labels for current module
        $('#add_attachment').click(function (e) {
            e.preventDefault();
            $('#mail_attachments').toggle();
        });

    </script>
@endsection