<!-- Container (Portfolio Section) -->
@php

    if($background->background_type=='color'){
    $strBackground="background-color:".$background->color.";";
    }elseif($background->background_type=='image'){
    $strBackground="background: url('".custom_asset("storage/".$background->image_path)."') no-repeat center center fixed;
        min-height: 100%;
        background-size: cover;
        ";
    }else{
    $strBackground="";
    }

@endphp

<div class="w3-padding" id="{{$id}}" style="{{$strBackground}}">
    {!! $content !!}
</div>