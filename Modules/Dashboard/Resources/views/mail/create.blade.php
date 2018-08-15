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
            <h3 class="title">@lang('messages.create_mail')</h3>
            <div id="title_shape"></div>
            {!! Form::open(['method'=>'POST', 'id'=>"email_form",'action'=>['\Modules\Dashboard\Http\Controllers\MailController@store','id'=>Auth::id()], 'files'=>true])!!}
            {!! Form::hidden('from', \Auth::user()->email) !!}
            <div class="group-form">
                {!! Form::label('sender',trans('messages.from').':') !!}
                {!! Form::text('sender', \Auth::user()->email, ['class'=>'form-control','disabled'=>'disabled']) !!}
            </div>

            <div class="group-form">
                {!! Form::label('to',trans('messages.to').':') !!}
                {!! Form::text('to', null, ['class'=>'form-control']) !!}
            </div>

            <div class="group-form">
                {!! Form::label('title',trans('messages.title').':') !!}
                {!! Form::text('title', null, ['class'=>'form-control']) !!}
            </div>


            <div class="group-form">
                {!! Form::label('content',trans('messages.content').':') !!}

                {!! Form::textarea('content', null, ['class'=>'form-control','id'=>'code']) !!}
                <br>
            </div>



            <a href="{{route("mail",Auth::id())}}" class="btn btn-success">@lang('messages.back_to_mail_module')</a>
            <a href="#" id="add_attachment" class="btn btn-info">@lang('messages.add_attachment')</a>
            <a data-toggle="modal" data-target="#send_mail" class="btn btn-warning" >@lang('messages.send_mail')</a>
            {!! Form::close() !!}

            <div id="mail_attachments">
                {!! Form::open(['method'=>'POST','action'=>['\Modules\Dashboard\Http\Controllers\MailController@attachImages','id'=>Auth::id()],'id'=>'attacheImage', 'class'=>'dropzone'])!!}
                {!! Form::close() !!}
            </div>
            <br>
            @include('includes.formErrors')
        </div>
    </div>


    {{--Delete profile modal--}}
    <div class="modal" id="send_mail">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">@lang('messages.want_to_send_email')?</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <p class="confirm_info">
                        @lang('messages.check_email_form')
                    </p>
                    <button type="button" class="btn" data-dismiss="modal">@lang('messages.cancel')</button>
                    <a href="#" id="send_mail_form" class="btn btn-success">@lang('messages.send_mail')</a>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer"></div>
            </div>
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
            dataType: "json",
            success: function(file, response){
                if (response == "success") {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: '{{trans('messages.images_attached')}}!'
                    }).show();
                }else{
                    new Noty({
                        type: 'error',
                        layout: 'bottomLeft',
                        text: response
                    }).show();
                }
            }
        };


        // //-- Functionality for sending email form
        // $('form').submit( function(ev){
        //     ev.preventDefault();
        //
        //     var conf = confirm("Send this email?");
        //     if (conf) {
        //         //-- Submit email form
        //         $(this).unbind('submit').submit();
        //     }
        // });

        //-- Functionality to show area for uploading images
        $('#add_attachment').click(function (e) {
            e.preventDefault();
            $('#mail_attachments').toggle();
        });


        //-- Functionality to submit email form
        $('#send_mail_form').click(function () {
            new Noty({
                type: 'success',
                layout: 'topRight',
                text: '{{trans('messages.email_form_submitted')}}!'
            }).show();
            $('#email_form').trigger('submit');
        });

    </script>
@endsection