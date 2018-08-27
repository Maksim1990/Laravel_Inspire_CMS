@extends('profile::layouts.master')

@section('styles')
    <style>
        form{
            display: inline;
        }
    </style>
@stop
@section ('scripts_header')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
@endsection
@section ('General')
    <div>
        <div>
            <h3 class="title">@lang('profile::messages.edit_user')</h3>
            <div id="title_shape"></div>
        </div>
        <div class="col-sm-5">
            <div class="col-sm-8 profile">
                <div class="profile_image">
                    <img src="{{$user->image ? $user->image->full_path :custom_asset("images/includes/noimage.png")}}"
                         class="image-responsive" alt="">
                    <div class="buttons">
                        <a href="{{route('profile',['id'=>Auth::id()])}}" class="btn btn-success">@lang('profile::messages.back_to_profile')</a><br>
                        <a href="{{route('change_password',['id'=>Auth::id()])}}" class="btn btn-info">@lang('profile::messages.change_password')</a><br>
                        @if(Auth::id()==$user->id)
                        <a data-toggle="modal" data-target="#delete_profile" class="btn btn-danger" >@lang('profile::messages.delete_profile')</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-7">
            {{ Form::model($user, ['method' =>'PATCH' , 'action' => ['\Modules\Profile\Http\Controllers\ProfileController@updateProfile',$user->id],'files'=>true])}}
            <div class="group-form">
                {!! Form::label('name',trans('messages.name').':') !!}
                {!! Form::text('name', null, ['class'=>'form-control']) !!}
            </div>
            <div class="group-form">
                {!! Form::label('email',trans('messages.email').':') !!}
                {!! Form::email('email', null, ['class'=>'form-control']) !!}
            </div>
            <div class="group-form">
                {!! Form::label('photo_id',trans('profile::messages.photo').':') !!}
                {!! Form::file('photo_id') !!}
            </div>

            <br>
            {!! Form::submit(trans('profile::messages.update_profile'),['class'=>'btn btn-warning']) !!}
            <a data-toggle="modal" data-target="#delete_profile" class="btn btn-danger" >@lang('profile::messages.delete_profile')</a>


            @include('includes.formErrors')
        </div>

    </div>


    {{--Delete profile modal--}}
    <div class="modal" id="delete_profile">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">@lang('profile::messages.want_delete_profile')</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <p class="confirm_info">
                        @lang('profile::messages.all_relevant_data_will_be_deleted')
                    </p>
                    <button type="button" class="btn btn-success" data-dismiss="modal"> @lang('messages.cancel')</button>
                    @if(Auth::id()==$user->id)
                        {!! Form::close() !!}
                        {{ Form::open(['method' =>'DELETE' ,'class'=>'deleteProfile', 'action' => ['\Modules\Profile\Http\Controllers\ProfileController@deleteProfile',$user->id]])}}
                        <input type="hidden" name="user_id" value="{{Auth::id()}}">
                        {!! Form::submit( trans('profile::messages.delete_profile'),['class'=>'btn btn-danger delete_profile']) !!}

                        {!! Form::close() !!}
                    @endif
                </div>

                <!-- Modal footer -->
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

@stop
@section ('scripts')
    <script>
        @if(Session::has('user_change'))
        new Noty({
            type: 'error',
            layout: 'bottomLeft',
            text: '{{session('user_change')}}'

        }).show();
        @endif

        // //-- Functionality for sending email form
        // $('.deleteProfile').submit( function(ev){
        //     ev.preventDefault();
        //
        //     var conf = confirm("Do you really want to delete profile?");
        //     if (conf) {
        //         //-- Submit email form
        //         $(this).unbind('submit').submit();
        //     }
        // });

    </script>
@endsection
