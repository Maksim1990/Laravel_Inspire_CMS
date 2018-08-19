<!-- Modal for full size images on click-->
@php

    if(!empty($background) && $background->background_type=='color'){
    $strBackground="background-color:".$background->color.";";
    }elseif(!empty($background) && $background->background_type=='image'){
    if(!empty($background->image_path)){
    $strBackground="background: url('".custom_asset("storage/".$background->image_path)."') no-repeat center center fixed;
        min-height: 100%;
        background-size: cover;
        ";
    }else{
    $strBackground="";
    }
    }else{
    $strBackground="";
    }

@endphp
<div style="{{$strBackground}}">
    {!! $content !!}
</div>
