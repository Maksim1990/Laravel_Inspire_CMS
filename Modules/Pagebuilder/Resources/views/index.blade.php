@extends('pagebuilder::layouts.master')

@section('styles')


@stop
@section('scripts_header')
    <script src="{{asset('plugins/vendor/tinymce/js/tinymce/tinymce.min.js')}}" type="text/javascript"></script>
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

                        $arrBlocks[$block->id]["block_content_id"]=$block->id;
                        $arrBlocks[$block->id]["block_id"]=$blockMain->block_id;
                        $arrBlocks[$block->id]["id"]=$blockMain->id;
                        $arrBlocks[$block->id]["sortorder"]=$blockMain->sortorder;
                        $arrBlocks[$block->id]["content"]=$blockMain->filteredContent($block->content);
                @endphp
            @endforeach
        @endforeach

        @php
            //dd($arrBlocks);
        @endphp

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
                    formData.append('test', test);

                    xhr.send(formData);
                },
                init_instance_callback: function (editor) {
                    editor.on('ContextMenu', function (e) {
                        test = "New_test";
                        console.log(e.target.closest("li").id);
                    });
                    editor.on('MouseOver', function (e) {
                        var blockID = e.target.closest("li").id.replace("block_", "").trim();
                        var blockTextID = e.target.closest("li").dataset.blocktextid;
                        //console.log(blockTextID);

                        $("#pagebuilder_menu_code_editor_" + blockID).data('blockid', blockID);
                        $("#pagebuilder_menu_save_" + blockID).data('blockid', blockTextID);
                        $("#pagebuilder_menu_code_editor_" + blockID).attr('href', '{{route("code_editor")}}/' + blockID);
                        //console.log($("#pagebuilder_menu_code_editor").data('blockid'));
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
    </style>
    <div class="col-sm-12 col-xs-12">
        @if(count($websiteBlocks)>0)
            <div id="pagebuilder" class="col-sm-6 col-xs-12" style="background-color: lightcyan;">
                <ul id="gallery">
                    @php
                        for ($idx = 1; $idx < count($arrBlocks); $idx += 1) {
                            echo "<li class=\"tooltip_menu\" data-itemid='" . $arrBlocks[$idx]['sortorder'] . "' id='block_".$arrBlocks[$idx]['id']."' data-blocktextid='".$arrBlocks[$idx]['block_id']."'>";
                            echo "<div class='editable' id='".$arrBlocks[$idx]['block_id']."'>" . $arrBlocks[$idx]['content'] . "<hr></div>";
                            echo "<span class=\"tooltiptext\">";
                            //-- Code editor button
                            echo "<a id='pagebuilder_menu_code_editor_".$arrBlocks[$idx]['id']."' data-blockid='' href='#' class='btn btn-info tooltip_link'>Go to code editor</a><br>";
                            echo "<a id='pagebuilder_menu_style_".$arrBlocks[$idx]['id']."' data-blockid='' href='#' class='btn btn-warning tooltip_link'>Change style</a><br>";
                            echo "<a id='pagebuilder_menu_style_".$arrBlocks[$idx]['id']."' data-blockid='' href='#' class='btn btn-warning tooltip_link'>Change style</a><br>";
                            echo "<a id='pagebuilder_menu_style_".$arrBlocks[$idx]['id']."' data-blockid='' href='#' class='btn btn-warning tooltip_link'>Change style</a><br>";
                            echo "<a id='pagebuilder_menu_style_".$arrBlocks[$idx]['id']."' data-blockid='' href='#' class='btn btn-warning tooltip_link'>Change style</a><br>";
                            echo "<button id='pagebuilder_menu_save_".$arrBlocks[$idx]['id']."' data-blockid='' class='btn btn-success tooltip_link'>Save</button><br>";
                            echo "</span>";
                            echo "</li>";
                        }
                    @endphp
                </ul>
                <div style="clear:both;"></div>
            </div>
            <div id="pagebuilder_menu" class="col-sm-6 col-xs-12">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">Editor settings</a></li>
                    <li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
                    <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
                </ul>

                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <h3>HOME</h3>
                        <p>Some content.</p>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <h3>Menu 1</h3>
                        <p>Some content in menu 1.</p>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <h3>Menu 2</h3>
                        <p>Some content in menu 2.</p>
                    </div>
                </div>
            </div>
        @else
            <p>No data found for pagebuilder!</p>
        @endif
    </div>
@stop
@section('scripts')
    <script src="{{asset('js/jquery.dragsort.js')}}" type="text/javascript"></script>

    <script type="text/javascript">


        $("#gallery").dragsort({
            dragSelector: "div",
            dragEnd: saveOrder,
            placeHolderTemplate: "<li class='placeHolder'><div></div></li>"
        });

        function saveOrder() {
            var data = $("#gallery li").map(function () {
                return $(this).data("itemid");
            }).get();
            console.log(data);
            // $.post("admin/pagebuilder", { "ids[]": data });
        };
    </script>
    <script>
        var token = '{{\Illuminate\Support\Facades\Session::token()}}';
        var url = '{{ route('ajax_content_editor_update') }}';

        $('button[id^="pagebuilder_menu_save_"]').click(function () {
            var intBlockId = $(this).data('blockid');
            //console.log(tinyMCE.get(intBlockId).getContent());
            var codeEditorContent = tinyMCE.get(intBlockId).getContent();
            $.ajax({
                method: 'POST',
                url: url,
                data: {
                    codeEditorContent: codeEditorContent,
                    block_id: intBlockId,
                    _token: token
                },
                success: function (data) {
                    if (data['result'] === "success") {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: 'Code updated!'
                        }).show();
                    }
                }
            });
        });

    </script>
@stop
