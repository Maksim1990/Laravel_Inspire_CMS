@extends('dashboard::layouts.master')

@section('General')
    <div class="row">
        <div class="col-sm-12 col-md-4  col-xs-12">
            <div class="col-sm-12 col-md-12  col-xs-12">
                <h3 class="title">FTP connection</h3>

                {!! Form::open(['method'=>'POST','action'=>['\Modules\Dashboard\Http\Controllers\OfficeController@storeFTPCredentials','userId'=>Auth::id()], 'files'=>true])!!}
                <div class="group-form">
                    {!! Form::label('ftp_host','FTP Host:') !!}
                    {!! Form::text('ftp_host', null, ['class'=>'form-control']) !!}
                </div>

                <div class="group-form">
                    {!! Form::label('ftp_user_name','FTP User name:') !!}
                    {!! Form::text('ftp_user_name', null, ['class'=>'form-control']) !!}
                </div>

                <div class="group-form">
                    {!! Form::label('ftp_password','FTP Password:') !!}
                    {!! Form::text('ftp_password', null, ['class'=>'form-control']) !!}
                </div>

                <div class="col-sm-12">
                    <br>
                    <a href="{{route("office",Auth::id())}}" class="btn btn-warning">Back to the Office</a>
                    {!! Form::submit('Save',['class'=>'btn btn-success']) !!}
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
