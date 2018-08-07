@extends('website::layouts.master')

@section('content')
    @if(Auth::check())
        @include('website::partials.dev_navigation_bar')
    @endif
    @include('website::partials.header_menu')

    @foreach($websiteBlocks as $blockMain)
        @foreach($blockMain->content as $block)
            @php
                $arrBlockName=explode("_",$blockMain->block_id);
                $template="website::blocks.".$arrBlockName[0];
             $strContent=str_replace('../../public/storage','../../../public/storage',$blockMain->filteredContent($block->content));
                            $strContent=str_replace('../../storage','/public/storage',$blockMain->filteredContent($block->content));
            @endphp
            @include($template, ['content' => $strContent])
        @endforeach
    @endforeach

@stop