@extends('pagebuilder::layouts.master')

@section('scripts_header')
    <script src="{{asset('plugins/vendor/tinymce/js/tinymce/tinymce.min.js')}}" type="text/javascript"></script>

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
                $arrBlocks[$block->id]["content"]=$block->content;
            @endphp
        @endforeach
    @endforeach

    @php
        //dd($arrBlocks);
    @endphp
    @include('website::partials.header_html')
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
                    var blockID=e.target.closest("li").id.replace("block_","").trim();
                   // console.log(blockID);

                    $("#pagebuilder_menu_code_editor").data('blockid', blockID);
                    $("#pagebuilder_menu_code_editor").attr('href', '{{route("code_editor")}}/'+blockID)
                    $("#pagebuilder_menu").css('display', 'block');
                    console.log($("#pagebuilder_menu_code_editor").data('blockid'));
                });
            },


            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tinymce.com/css/codepen.min.css']
        });
    </script>
@stop
@section('styles')
    <style type="text/css">
        /*#pagebuilder h1 {*/
        /*font-size: 16pt;*/
        /*}*/

        /*#pagebuilder h2 {*/
        /*font-size: 13pt;*/
        /*}*/

        /*#pagebuilder ul {*/
        /*width: 100%;*/
        /*list-style-type: none;*/
        /*margin: 0px;*/
        /*padding: 0px;*/
        /*}*/

        /*#pagebuilder li {*/
        /*float: left;*/
        /*padding: 5px;*/
        /*width: 100%;*/
        /*height: 100px;*/
        /*}*/

        /*#pagebuilder li div {*/
        /*width: 80%;*/
        /*height: 50px;*/
        /*border: solid 1px black;*/
        /*background-color: #E0E0E0;*/
        /*text-align: center;*/
        /*padding-top: 40px;*/
        /*}*/

        #pagebuilder .placeHolder div {
            background-color: white !important;
            border: dashed 1px gray !important;
        }
    </style>
@stop
@section('General')

    <div class="col-sm-12 col-xs-12">
        <div id="pagebuilder" class="col-sm-6 col-xs-12" style="background-color: lightcyan;">
            <ul id="gallery">

                @php

                    //dd($list);
                @endphp

                @php

                    for ($idx = 1; $idx < count($arrBlocks); $idx += 1) {
                        echo "<li data-itemid='" . $arrBlocks[$idx]['sortorder'] . "' id='block_".$arrBlocks[$idx]['id']."'>";
                        echo "<div class='editable' id='".$arrBlocks[$idx]['block_id']."'>" . $arrBlocks[$idx]['content'] . "<hr></div>";
                        echo "</li>";
                    }
                @endphp
            </ul>
            <div style="clear:both;"></div>
        </div>

    <div id="pagebuilder_menu" class="col-sm-6 col-xs-12" style="display: none;position:fixed;top: 150px;left: 55%">
        <a id="pagebuilder_menu_code_editor" data-blockid="" href="#" class="btn btn-info">Go to code editor</a>
    </div>
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
        {{--var token = '{{\Illuminate\Support\Facades\Session::token()}}';--}}
        {{--var url = '{{ route('ajax_update_label') }}';--}}


    </script>
@stop
