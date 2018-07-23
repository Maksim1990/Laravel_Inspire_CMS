@extends('profile::layouts.master')

@section('styles')
@stop
@section ('scripts_header')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
@endsection
@section ('General')
    <div>
        <p >Edit User</p>
        <div class="col-sm-3">
            <img height="200"  src="{{$user->image ? $user->image->full_path :"/images/includes/noimage.png"}}" class="image-responsive" alt="">
        </div>
        <div class="col-sm-9">
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
            {!! Form::submit('Update User',['class'=>'btn btn-warning']) !!}
            @if(Auth::id()==$user->id)
                {!! Form::close() !!}
                {{ Form::open(['method' =>'DELETE' , 'action' => ['\Modules\Profile\Http\Controllers\ProfileController@deleteProfile',$user->id]])}}

                {!! Form::submit('Delete User',['class'=>'btn btn-danger']) !!}

                {!! Form::close() !!}
            @endif
            @include('includes.formErrors')
        </div>

    </div>

@stop
@section ('Password')
<div class="col-sm-6">
{{ Form::model($user, ['method' =>'PATCH' , 'action' => ['\Modules\Profile\Http\Controllers\ProfileController@updatePassword',$user->id],'files'=>true])}}

<div class="group-form">
{!! Form::label('password','Old password:') !!}
{!! Form::password('old_password', ['class'=>'form-control']) !!}
</div>
<div class="group-form">
{!! Form::label('password','New password:') !!}
{!! Form::password('password', ['class'=>'form-control']) !!}
</div>
<div class="group-form">
{!! Form::label('password','Repeat new password:') !!}
{!! Form::password('password_2', ['class'=>'form-control']) !!}
</div>
<br>
{!! Form::submit('Update password',['class'=>'btn btn-warning']) !!}
{!! Form::close() !!}
</div>
@stop
{{--@section ('Profile')--}}
{{--<div class="col-sm-6">--}}
{{--{{ Form::model($profile, ['method' =>'PATCH' , 'action' => ['\Modules\Profile\Http\Controllers\ProfileController@update',$profile->id],'files'=>true])}}--}}
{{--<div class="group-form">--}}
{{--{!! Form::label('lastname','Lastname:') !!}--}}
{{--{!! Form::text('lastname', null, ['class'=>'form-control']) !!}--}}
{{--</div>--}}
{{--<div class="group-form">--}}
{{--{!! Form::label('birthdate','Birthdate:') !!}--}}
{{--{!!  Form::text('birthdate', null, array('id' => 'datepicker')) !!}--}}
{{--</div>--}}
{{--<div class="group-form">--}}
{{--{!! Form::label('Gender:') !!}--}}
{{--<span>Male</span>--}}
{{--{!! Form::radio('user_gender', 'M') !!}--}}
{{--<span>Female</span>--}}
{{--{!! Form::radio('user_gender', 'F') !!}--}}
{{--</div>--}}
{{--<div class="group-form">--}}
{{--{!! Form::label('status','Status:') !!}--}}
{{--{!! Form::text('status', null, ['class'=>'form-control']) !!}--}}
{{--</div>--}}
{{--<div class="group-form">--}}
{{--{!! Form::label('country','Country:') !!}--}}
{{--{!! Form::select('country',[""=>"Choose country"]+$countries ,null, ['class'=>'form-control']) !!}--}}
{{--</div>--}}
{{--<div class="group-form">--}}
{{--{!! Form::label('city','City:') !!}--}}
{{--{!! Form::text('city', null, ['class'=>'form-control']) !!}--}}
{{--</div>--}}
{{--<br>--}}
{{--{!! Form::submit('Update User',['class'=>'btn btn-warning']) !!}--}}

{{--{!! Form::close() !!}--}}
{{--</div>--}}
{{--@stop--}}
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
