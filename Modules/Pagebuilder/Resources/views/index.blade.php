@extends('pagebuilder::layouts.master')

@section('scripts_header')
    <script src="{{custom_asset('plugins/vendor/tinymce/js/tinymce/tinymce.min.js')}}" type="text/javascript"></script>
    @if(count($websiteBlocks)>0)
        @php

            $arrBlocks = array();
            $arrBlocksIds= array();
        @endphp
        @foreach($websiteBlocks as $blockMain)

            @php

                $arrBlocksIds[]="#".$blockMain->block_id;
            $strBlocksIds=implode(",",$arrBlocksIds);
            @endphp
            @foreach($blockMain->content as $block)
                @php

                    $arrBlocks[$blockMain->sortorder]["block_content_id"]=$block->id;
                    $arrBlocks[$blockMain->sortorder]["block_id"]=$blockMain->block_id;
                    $arrBlocks[$blockMain->sortorder]["id"]=$blockMain->id;
                    $arrBlocks[$blockMain->sortorder]["sortorder"]=$blockMain->sortorder;
                    //TODO ADD option to choose between original label and converted label to text
                    //$arrBlocks[$block->id]["content"]=$blockMain->filteredContent($block->content);
                    $arrBlocks[$blockMain->sortorder]["content"]=$blockMain->filteredContent($block->content);
                @endphp
            @endforeach
        @endforeach

        <script>
            tinymce.init({
                selector: 'h2.editable',
                inline: true,
                toolbar: 'undo redo',
                menubar: false
            });

            tinymce.init({
                selector: '{{$strBlocksIds}}',
                inline: true,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table contextmenu paste'
                ],
                toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                // we override default upload handler to simulate successful upload
                images_upload_handler: function (blobInfo, success, failure) {
                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', '{{route("editor_upload_image")}}');
                    xhr.setRequestHeader("X-CSRF-Token", "{{ csrf_token() }}");

                    xhr.onload = function () {
                        var json;

                        if (xhr.status != 200) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                        }

                        json = JSON.parse(xhr.responseText);

                        if (!json || typeof json.location != 'string') {
                            failure('Invalid JSON: ' + xhr.responseText);
                            return;
                        }
                        success(json.location);
                    };
                    formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    formData.append('blockID', blockID);

                    xhr.send(formData);
                },
                init_instance_callback: function (editor) {
                    editor.on('ContextMenu', function (e) {
                        test = "New_test";
                        console.log(e.target.closest("li").id);
                    });
                    editor.on('MouseOver', function (e) {
                        blockID = e.target.closest("li").id.replace("block_", "").trim();
                        var blockTextID = e.target.closest("li").dataset.blocktextid;


                        $("#pagebuilder_menu_code_editor_" + blockID).data('blockid', blockID);
                        $("#pagebuilder_menu_save_" + blockID).data('blockid', blockTextID);
                        $("#pagebuilder_menu_code_editor_" + blockID).attr('href', '{{route("code_editor")}}/' + blockID);
                        $("#pagebuilder_menu_background_" + blockID).attr('href', '{{route("background")}}/' + blockID);
                        $("#pagebuilder_menu_info_" + blockID).attr('href', '{{route("block_info")}}/' + blockID);

                    });
                },


                content_css: [
                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                    '//www.tinymce.com/css/codepen.min.css']
            });
        </script>
    @endif

@stop
@section('styles')
    <style type="text/css">
        #pagebuilder .placeHolder div {
            background-color: white !important;
            border: dashed 1px gray !important;
        }
    </style>

@stop
@section('General')
    <style>
        .tooltip_menu {
            width: 100%;
            overflow: auto;
        }

        .tooltip_menu .tooltiptext {
            visibility: hidden;
            width: 40%;
            background-color: darkgray;
            opacity: 0.7;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;

            /* Position the tooltip */
            position: fixed;
            z-index: 1;
            top: 150px;
            left: 45%;
        }

        .tooltip_menu:hover .tooltiptext {
            visibility: visible;
        }

        .tooltip_link {
            margin-bottom: 15px;
        }
        .pagebuilder_block{
            border:2px solid black;
            min-height: 50px;
        }
    </style>
    <div class="col-sm-12 col-xs-12">
        @if(count($websiteBlocks)>0)
            <div id="pagebuilder" class="col-sm-6 col-xs-12" style="background-color: lightcyan;">
                <ul id="gallery">
                    @php
                        for ($idx = 1; $idx < count($arrBlocks); $idx += 1) {
                        if(isset($arrBlocks[$idx])){
                           if($adminSettings->use_remote_server=="Y" && !empty($adminSettings->remote_server)){
                            $strContent=str_replace('../../public/storage',$adminSettings->remote_server.'/public/storage',$arrBlocks[$idx]['content']);
                            $strContent=str_replace('../../storage',$adminSettings->remote_server.'/public/storage',$arrBlocks[$idx]['content']);
                        }else{
                            $strContent=str_replace('../../public/storage','../../../public/storage',$arrBlocks[$idx]['content']);
                            $strContent=str_replace('../../storage','/public/storage',$arrBlocks[$idx]['content']);
                            }
                            echo "<li class=\"tooltip_menu pagebuilder_block\" data-itemid='" . $arrBlocks[$idx]['id'] . "' id='block_".$arrBlocks[$idx]['id']."' data-blocktextid='".$arrBlocks[$idx]['block_id']."'>";
                            echo "<div class='editable' id='".$arrBlocks[$idx]['block_id']."'>" . $strContent . "<hr></div>";
                            echo "<span class=\"tooltiptext\">";
                            //-- Code editor button
                            echo "<a id='pagebuilder_menu_code_editor_".$arrBlocks[$idx]['id']."' data-blockid='' href='#' class='btn btn-info tooltip_link'>".trans('pagebuilder::messages.go_to_code_editor')."</a><br>";
                            echo "<a id='pagebuilder_menu_background_".$arrBlocks[$idx]['id']."' data-blockid='' href='#' class='btn btn-warning tooltip_link'>".trans('pagebuilder::messages.change_background')."</a><br>";
                            echo "<a id='pagebuilder_menu_info_".$arrBlocks[$idx]['id']."' data-blockid='' href='#' class='btn btn-warning tooltip_link'>".trans('pagebuilder::messages.block_info')."</a><br>";
                            echo "<button id='pagebuilder_menu_save_".$arrBlocks[$idx]['id']."' data-blockid='' class='btn btn-success tooltip_link'>".trans('messages.save')."</button><br>";
                            echo "</span>";
                            echo "</li>";
                            }
                        }
                    @endphp
                </ul>
                <div style="clear:both;"></div>
            </div>
            <div id="pagebuilder_menu" class="col-sm-6 col-xs-12">
                <ul class="nav nav-tabs" id="pagebuilder_settings">
                    <li class="active"><a data-toggle="tab" href="#home" class="tab_link">Editor settings</a></li>
                    <li><a data-toggle="tab" href="#menu1" class="tab_link">Custom CSS</a></li>
                </ul>

                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <h3>HOME</h3>
                        <p>1. Pagebuilder background color</p>
                        <p>2. How to display labels in text</p>
                        <div>
                            <a href="{{route("background",['id'=>'footer'])}}"
                               class="btn btn-warning w3-margin-bottom">Customize website footer</a><br>
                            <a href="{{route("background",['id'=>'google_contact_form'])}}"
                               class="btn btn-warning w3-margin-bottom">Customize Google & Contact form block</a><br>
                            <a href="{{route("pagebuilder_order",['id'=>Auth::id()])}}"
                               class="btn btn-warning w3-margin-bottom">Change block orders</a><br>
                        </div>
                    </div>
                    <div id="menu1" class="tab-pane">
                        @include('pagebuilder::custom_css')
                    </div>
                </div>
            </div>
        @else
            <p>@lang('pagebuilder::messages.no_data_found_for_pagebuilder')</p>
        @endif
    </div>
@stop

{{-- Including website settings tabs --}}
@include('pagebuilder::settings')

@section('scripts')
    <script src="{{custom_asset('js/jquery.dragsort.js')}}" type="text/javascript"></script>

    <script type="text/javascript">

        //-- Code for draagging functionality
        $("#gallery").dragsort({
            dragSelector: "div",
            dragEnd: saveOrder,
            placeHolderTemplate: "<li class='placeHolder'><div></div></li>"
        });

        function saveOrder() {
            var arrIDs = $("#gallery li").map(function () {
                return $(this).data("itemid");
            }).get();


            var token = '{{\Illuminate\Support\Facades\Session::token()}}';
            var url = '{{ route('ajax_blocks_sortorder_update') }}';

            $.ajax({
                method: 'POST',
                url: url,
                dataType: "json",
                data: {
                    arrIDs: arrIDs,
                    _token: token
                },
                success: function (data) {
                    if (data['result'] === "success") {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: '{{trans('pagebuilder::messages.custom_css_updated')}}'
                        }).show();
                    }
                }
            });
        };
    </script>
    <script>
        var token = '{{\Illuminate\Support\Facades\Session::token()}}';
        var url = '{{ route('ajax_content_editor_update') }}';
      
        $('button[id^="pagebuilder_menu_save_"]').click(function () {

            var intBlockId = $(this).data('blockid');
            var codeEditorContent = tinyMCE.get(intBlockId).getContent();
            $.ajax({
                method: 'POST',
                url: url,
                dataType: "json",
                data: {
                    codeEditorContent: codeEditorContent,
                    block_id: intBlockId,
                    blockID: blockID,
                    _token: token
                },
                success: function (data) {
                    if (data['result'] === "success") {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: '{{trans('pagebuilder::messages.code_updated')}}'
                        }).show();
                    }
                }
            });
        });

    </script>

    @include('dashboard::website_settings.scripts')
@stop
