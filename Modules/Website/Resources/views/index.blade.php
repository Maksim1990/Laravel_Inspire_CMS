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
                $strBlockHtmlId=$blockMain->block_custom_id;

                $objBackground=$blockMain->background;

                $template="website::blocks.".$arrBlockName[0];


             if($adminSettings->use_remote_server=="Y" && !empty($adminSettings->remote_server)){
             $strContent=str_replace('../../public/storage',$adminSettings->remote_server.'/public/storage',$blockMain->filteredContent($block->content));
              $strContent=str_replace('../../storage',$adminSettings->remote_server.'/public/storage',$blockMain->filteredContent($block->content));
             }else{
             $strContent=str_replace('../../public/storage','../../../public/storage',$blockMain->filteredContent($block->content));
              $strContent=str_replace('../../storage','/public/storage',$blockMain->filteredContent($block->content));
             }

            @endphp
            @include($template, ['content' => $strContent,'id'=>$strBlockHtmlId,'background'=>$objBackground])
        @endforeach
    @endforeach

@stop