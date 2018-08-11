@extends('dashboard::layouts.master')

@section('General')
    <h3 class="title">@lang('messages.contact_us')</h3>
    <div id="title_shape"></div>

    <p>
        This view is loaded from module: {!! config('dashboard.name') !!}
    </p>
@stop