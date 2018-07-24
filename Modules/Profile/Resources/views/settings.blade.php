@extends('profile::layouts.master')

@section('styles')
@stop
@section ('scripts_header')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
@endsection
@section ('General')
    <div>
        <p >Edit User</p>
        <div class="col-sm-5">
            <img height="200"  src="{{$user->image ? $user->image->full_path :"/images/includes/noimage.png"}}" class="image-responsive" alt="">
            <div>
                <a href="{{route('change_password',['id'=>Auth::id()])}}" class="link">Change password</a>
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
