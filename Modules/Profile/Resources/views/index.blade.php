@extends('profile::layouts.master')


@section('scripts_header')
@stop

@section('styles')

@stop

@section('General')
    <div class="row">
        <div class="col-sm-10 col-xs-10">
            <h3 class="title">@lang('messages.my_profile')</h3>
            <div id="title_shape"></div>

            <div class="col-sm-12 col-xs-12 profile">
                <div class="col-sm-4 col-xs-12 profile_image">
                    <img
                         src="{{Auth::user()->image ? Auth::user()->image->full_path : custom_asset("images/includes/noimage.png")}}"
                         alt="">
                    <div class="buttons">
                        <a href="{{route('profile_settings',['id'=>Auth::id()])}}" class="btn btn-warning">@lang('profile::messages.edit_profile')</a><br>
                        <a href="{{route('change_password',['id'=>Auth::id()])}}" class="btn btn-info">@lang('profile::messages.change_password')</a><br>
                        <a href="{{route('delete_profile',['id'=>Auth::id()])}}" class="btn btn-danger">@lang('profile::messages.delete_profile')</a><br>
                    </div>
                </div>
                <div class="col-sm-8 col-xs-12 profile_info">
                    <div class="col-sm-6"><b>@lang('messages.name')</b></div>
                    <div class="col-sm-6">{{$user->name}}</div>

                    <div class="col-sm-6"><b>@lang('messages.email')</b></div>
                    <div class="col-sm-6">{{$user->email}}</div>

                    <div class="col-sm-6"><b>@lang('profile::messages.registered')</b></div>
                    <div class="col-sm-6">{{$user->created_at->diffForHumans()}}</div>

                    <div class="col-sm-6"><b>@lang('profile::messages.profile_last_modified')</b></div>
                    <div class="col-sm-6">{{$user->updated_at->diffForHumans()}}</div>

                </div>
                <div class="col-sm-8 col-xs-12"><h3 class="title"></h3></div>
            </div>
        </div>
    </div>
@stop
@section ('scripts')
    <script>
        @if(Session::has('user_change'))
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: '{{session('user_change')}}'

        }).show();
        @endif
    </script>
@endsection