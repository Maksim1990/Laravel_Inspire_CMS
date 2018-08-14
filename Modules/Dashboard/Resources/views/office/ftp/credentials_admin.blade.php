@extends('dashboard::layouts.master')

@section('General')
    <div class="row">
        <div class="col-sm-12 col-md-6  col-xs-12">
            <div class="col-sm-12 col-md-12  col-xs-12">
                <h3 class="title">@lang('dashboard::messages.ftp_admin_connection')</h3>
                <div id="title_shape"></div>

                {!! Form::open(['method'=>'POST','action'=>['\Modules\Dashboard\Http\Controllers\OfficeController@setFTPCredentialsAdmin','userId'=>Auth::id()], 'files'=>true])!!}
                <div class="group-form">
                    {!! Form::label('ftp_host',trans('dashboard::messages.ftp_host').':') !!}
                    {!! Form::text('ftp_host', null, ['class'=>'form-control']) !!}
                </div>

                <div class="group-form">
                    {!! Form::label('ftp_user_name',trans('dashboard::messages.ftp_user_name').':') !!}
                    {!! Form::text('ftp_user_name', null, ['class'=>'form-control']) !!}
                </div>

                <div class="group-form">
                    {!! Form::label('ftp_password',trans('dashboard::messages.ftp_password').':') !!}
                    {!! Form::text('ftp_password', null, ['class'=>'form-control']) !!}
                </div>

                <div class="col-sm-12">
                    <br>
                    <a href="{{route("office",Auth::id())}}" class="btn btn-warning">@lang('dashboard::messages.ftp_bach_to_manager')</a>
                    {!! Form::submit(trans('messages.save'),['class'=>'btn btn-success']) !!}
                </div>

                {!! Form::close() !!}
            </div>

        </div>
        <div class="col-sm-12 col-md-12  col-xs-12">
            <br>
            @include('includes.formErrors')
        </div>
    </div>
@stop