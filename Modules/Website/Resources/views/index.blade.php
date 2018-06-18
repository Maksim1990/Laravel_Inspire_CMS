@extends('website::layouts.master')

@section('content')
    <h1>Your website soon will be here!</h1>

    <p>
        This view is loaded from module: {!! config('website.name') !!}
    </p>
@stop
