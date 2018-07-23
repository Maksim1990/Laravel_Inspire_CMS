@extends('profile::layouts.master')


@section('scripts_header')
@stop

@section('styles')
@stop

@section('General')
    <h1>My Profile</h1>

    <p>
        This view is loaded from module: {!! config('profile.name') !!}
    </p>
@stop
