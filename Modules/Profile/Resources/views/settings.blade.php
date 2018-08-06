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
            <h3 class="title">Edit User</h3>
            <div id="title_shape"></div>
        </div>
        <div class="col-sm-5">
            <div class="col-sm-8 profile">
                <div class="profile_image">
                    <img src="{{$user->image ? $user->image->full_path :custom_asset("images/includes/noimage.png")}}"
                         class="image-responsive" alt="">
                    <div class="buttons">
                        <a href="{{route('profile',['id'=>Auth::id()])}}" class="btn btn-success">Back to profile</a><br>
                        <a href="{{route('change_password',['id'=>Auth::id()])}}" class="btn btn-info">Change password</a><br>
                        @if(Auth::id()==$user->id)
                            {!! Form::close() !!}
                            {{ Form::open(['method' =>'DELETE' , 'action' => ['\Modules\Profile\Http\Controllers\ProfileController@deleteProfile',$user->id]])}}
                            <input type="hidden" name="user_id" value="{{Auth::id()}}">
                            {!! Form::submit('Delete profile',['class'=>'btn btn-danger']) !!}

                            {!! Form::close() !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-7">
            {{ Form::model($user, ['method' =>'PATCH' , 'action' => ['\Modules\Profile\Http\Controllers\ProfileController@updateProfile',$user->id],'files'=>true])}}
            <div class="group-form">
                {!! Form::label('name','User name:') !!}
                {!! Form::text('name', null, ['class'=>'form-control']) !!}
            </div>
            <div class="group-form">
                {!! Form::label('email','User email:') !!}
                {!! Form::email('email', null, ['class'=>'form-control']) !!}
            </div>
            <div class="group-form">
                {!! Form::label('photo_id','Photo:') !!}
                {!! Form::file('photo_id') !!}
            </div>

            <br>
            {!! Form::submit('Update profile',['class'=>'btn btn-warning']) !!}
            @if(Auth::id()==$user->id)
                {!! Form::close() !!}
                {{ Form::open(['method' =>'DELETE' , 'action' => ['\Modules\Profile\Http\Controllers\ProfileController@deleteProfile',$user->id]])}}
                <input type="hidden" name="user_id" value="{{Auth::id()}}">
                {!! Form::submit('Delete profile',['class'=>'btn btn-danger']) !!}

                {!! Form::close() !!}
            @endif
            @include('includes.formErrors')
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
    </script>
@endsection
