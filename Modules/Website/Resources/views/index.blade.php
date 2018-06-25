@extends('website::layouts.master')

@section('content')
    @if(Auth::check())
        @include('website::partials.dev_navigation_bar')
    @endif
    @include('website::partials.header_menu')

    @php
       //dd($websiteBlocks);
    @endphp
    @foreach($websiteBlocks as $block)
        @php
            $template="website::blocks.".$block["block_id"]
        @endphp
        @include($template, ['content' => $block["content"][0]["content"]])
    @endforeach



@stop