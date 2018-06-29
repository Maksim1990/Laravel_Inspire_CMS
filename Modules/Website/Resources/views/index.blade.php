@extends('website::layouts.master')

@section('content')
    @if(Auth::check())
        @include('website::partials.dev_navigation_bar')
    @endif
    @include('website::partials.header_menu')

    @foreach($websiteBlocks as $blockMain)
        @foreach($blockMain->content as $block)
            @php
                $template="website::blocks.".$blockMain->block_id
            @endphp
            @include($template, ['content' => $blockMain->filteredContent($block->content)])
        @endforeach
    @endforeach

@stop