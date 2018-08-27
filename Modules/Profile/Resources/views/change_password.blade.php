@extends('profile::layouts.master')

@section ('General')

    <div class="col-sm-6">
        <div>
            <h3 class="title">@lang('profile::messages.change_password')</h3>
            <div id="title_shape"></div>
        </div>
        {{ Form::model($user, ['method' =>'PATCH' , 'action' => ['\Modules\Profile\Http\Controllers\ProfileController@updatePassword',$user->id],'files'=>true])}}
        <div class="group-form">
            {!! Form::label('password',trans('profile::messages.old_password').':') !!}
            {!! Form::password('old_password', ['class'=>'form-control']) !!}
        </div>
        <div class="group-form">
            {!! Form::label('password',trans('profile::messages.new_password').':') !!}
            {!! Form::password('password', ['class'=>'form-control']) !!}
        </div>
        <div class="group-form">
            {!! Form::label('password',trans('profile::messages.repeat_password').':') !!}
            {!! Form::password('password_2', ['class'=>'form-control']) !!}
        </div><br>
        <a href="{{route('profile_settings',['id'=>Auth::id()])}}" class="btn btn-info">@lang('profile::messages.back_to_profile_settings')</a>
        {!! Form::submit(trans('profile::messages.update_password'),['class'=>'btn btn-warning']) !!}
        {!! Form::close() !!}

        @include('includes.formErrors')
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