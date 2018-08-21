@extends('pagebuilder::layouts.master')

@section('scripts_header')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        #sortableDeactivated, #sortableActive {
            border: 1px solid #eee;
            width: 310px;
            min-height: 20px;
            list-style-type: none;
            margin: 0;
            padding: 5px 0 0 0;
            float: left;
            margin-right: 10px;
        }

        #sortableDeactivated li, #sortableActive li {
            margin: 0 5px 5px 5px;
            padding: 5px;
            font-size: 1.2em;
            width: 300px;
        }

        .ui-state-highlight {
            background-color: darkseagreen;
            border: 1px solid #6b8a6b;
        }

        .ui-state-highlight .title_block {
            color: white;
        }

        .edit_title {
            width: 100%;
        }

    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function () {
            $("#sortable1, #sortable2").sortable({
                connectWith: ".connectedSortable"
            }).disableSelection();
        });
    </script>

@stop
@section('General')
    <div class="row maintab">
        <div class="col-sm-12 col-lg-12 col-xs-12">
            <div class="col-sm-8 col-lg-8 col-xs-12">
                <div>
                    <h3 class="title">@lang('pagebuilder::messages.block_settings')</h3>
                    <div id="title_shape"></div>
                </div>
                <div class="insp_buttons">
                    <a href="{{route("pagebuilder_index",['id'=>Auth::id()])}}"
                       class="btn btn-warning">@lang('pagebuilder::messages.back_to_pagebuilder')
                    </a> <a href="#"
                            class="btn btn-info" id="create_block">Create block</a>
                </div>

                <div class="col-sm-5 col-lg-5 col-xs-12">
                    <div class="w3-center text w3-xlarge">Not active blocks</div>
                    <ul id="sortableDeactivated" class="connectedSortable">
                        @if(!empty($websiteBlocksDeactivated))
                            @foreach($websiteBlocksDeactivated as $block)
                                <li class="ui-state-default tooltip_block_item" id="block_{{$block->block_id}}"
                                    data-sortorder="1">
                                    <p id="title_{{$block->block_id}}" class="title_block">{{$block->block_custom_id}}</p>
                                    <input type="text" id="edit_{{$block->block_id}}" class="edit_title"
                                           style="display: none;"
                                           value="{{$block->block_custom_id}}">
                                    <span class="tooltiptext">
                                    <span id="delete_button_{{$block->block_id}}"
                                          onclick="DeleteBlockItem('{{$block->block_id}}')"
                                          class="delete_block">@lang('messages.delete')</span>
                            </span>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div class="col-sm-5 col-sm-offset-2 col-lg-5 col-xs-12">
                    <div class="w3-center text w3-xlarge">Active blocks</div>
                    <ul id="sortableActive" class="connectedSortable">
                        @if(!empty($websiteBlocksActive))
                            @foreach($websiteBlocksActive as $block)
                                <li class="ui-state-highlight tooltip_block_item" id="block_{{$block->block_id}}"
                                    data-sortorder="1">
                                    <p id="title_{{$block->block_id}}"
                                       class="title_block">{{$block->block_custom_id}}</p>
                                    <input type="text" id="edit_{{$block->block_id}}" class="edit_title"
                                           style="display: none;"
                                           value="{{$block->block_custom_id}}">
                                    <span class="tooltiptext">
                                    <span id="delete_button_{{$block->block_id}}"
                                          onclick="DeleteBlockItem('{{$block->block_id}}')"
                                          class="delete_block">@lang('messages.delete')</span>
                            </span>
                                </li>
                            @endforeach
                        @endif
                    </ul>


                </div>


            </div>
        </div>
    </div>


@stop

@section('scripts')

    <script src="{{custom_asset('js/jquery.dragsort.js')}}" type="text/javascript"></script>


    <script type="text/javascript">
        var token = '{{\Illuminate\Support\Facades\Session::token()}}';

        var lastBlockId = '{{$lastBlockId}}';

        $('#create_block').click(function () {
            $('[id^="title_"]').show();
            $('[id^="edit_"]').hide();
            lastBlockId++;
            var strBloсkID = "block" + lastBlockId + "_{{Auth::id()}}";
            var strBloсkCustomId = "block" + lastBlockId;

            var newBlock = "  <li class=\"ui-state-highlight tooltip_block_item\" onclick=\"ClickBlock(event,'" + strBloсkID + "')\" id=\"block_" + strBloсkID + "\"\n" +
                "                                    data-sortorder=\"1\">\n" +
                "                                    <p id=\"title_" + strBloсkID + "\"\n" +
                "                                       class=\"title_block\">" + strBloсkCustomId + "</p>\n" +
                "                                    <input type=\"text\" id=\"edit_" + strBloсkID + "\" class=\"edit_title\" style=\"display: none;\"\n" +
                "                                           value=\"" + strBloсkCustomId + "\">\n" +
                "                                    <span class=\"tooltiptext\">\n" +
                "                                    <span  id=\"delete_button_" + strBloсkID + "\" onclick=\"DeleteBlockItem('" + strBloсkID + "')\" class=\"delete_block\">{{trans('messages.delete')}}</span>\n" +
                "                            </span>\n" +
                "                                </li>";


            $("#sortableDeactivated").append(newBlock);
            //-- Create new block
            CreateBlock(strBloсkID, strBloсkCustomId);


        });

        //-- Functionality to create new block
        function CreateBlock(id, custom_id) {
            var url = '{{ route('ajax_create_block') }}';

            $.ajax({
                method: 'POST',
                url: url,
                dataType: "json",
                data: {
                    block_id: id,
                    custom_id: custom_id,
                    _token: token
                }, beforeSend: function () {
                    //-- Show loading image while execution of ajax request
                    $("div#divLoading").addClass('show');
                },
                success: function (data) {
                    if (data['result'] === "success") {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: '{{trans('pagebuilder::messages.block_created')}}'
                        }).show();

                    } else {
                        new Noty({
                            type: 'error',
                            layout: 'bottomLeft',
                            text: data['error']
                        }).show();
                    }
                    //-- Hide loading image
                    $("div#divLoading").removeClass('show');
                }
            });
        }

        //-- Functionality when click on block item
        $('.tooltip_block_item').click(function (e) {
            if (!$(e.target).hasClass('delete_block')) {


                var blockId = $(this).attr('id').replace("block_", "");
                $('[id^="edit_"]').each(function () {
                    var blockId = $(this).attr('id').replace("edit_", "");
                    var blockValue = $(this).val();
                    $('#title_' + blockId).text(blockValue);
                });
                if (!$('#edit_' + blockId).is(":visible")) {
                    ShowBlockInput(blockId);
                } else {

                    HideBlockInput(blockId);
                }
                SaveAllBlocks();
            }
        });
        //-- Functionality when click on block item
        $('html').click(function (e) {
            if(!$(e.target).hasClass('tooltip_block_item') && !$(e.target).hasClass('title_block') )
            {
                if($('[id^="edit_"]').is(":visible")) {
                    $('[id^="title_"]').show();
                    $('[id^="edit_"]').hide();
                    SaveAllBlocks();
                }
            }
        });

        //-- Dynamically update <p> tag text of the block when update input value
        $('[id^="edit_"]').keyup(function (e) {
            var blockId = $(this).attr('id').replace("edit_", "");
            var blockValue = $('#edit_' + blockId).val();
            $('#title_' + blockId).text(blockValue);
        });


        function ClickBlock(event, blockId) {

            if (!$(event.target).hasClass('delete_block')) {

                $('[id^="edit_"]').each(function () {
                    var blockId = $(this).attr('id').replace("edit_", "");
                    var blockValue = $(this).val();
                    $('#title_' + blockId).text(blockValue);
                });
                if (!$('#edit_' + blockId).is(":visible")) {
                    ShowBlockInput(blockId);
                } else {
                    HideBlockInput(blockId);
                }
                SaveAllBlocks();
            }
        }

        //-- Functionality to save all custom ID from active inputs
        function SaveAllBlocks() {
            var arrBlocks = [];
            var arrIDCustom = [];
            $('[id^="block_"]').each(function () {
                if ($(this).attr('id')) {
                    var arrId = $(this).attr('id').replace("block_", "");
                    arrBlocks.push(arrId);
                }
            });
            $('[id^="title_"]').each(function () {
                var strIdCustom = $(this).text();
                if (strIdCustom !== "") {
                    arrIDCustom.push(strIdCustom);
                }
            });

            var url = '{{ route('ajax_save_all_blocks_custom_ids') }}';

            $.ajax({
                method: 'POST',
                url: url,
                dataType: "json",
                data: {
                    arrBlocks: arrBlocks,
                    arrIDCustom: arrIDCustom,
                    _token: token
                }, beforeSend: function () {
                    //-- Show loading image while execution of ajax request
                    $("div#divLoading").addClass('show');
                },
                success: function (data) {
                    if (data['result'] !== "success") {
                        new Noty({
                            type: 'error',
                            layout: 'bottomLeft',
                            text: data['error']
                        }).show();
                    }
                    //-- Hide loading image
                    $("div#divLoading").removeClass('show');
                }
            });


        }

        function ShowBlockInput(id) {
            //-- Initially deactivate all inputs
            $('[id^="title_"]').show();
            $('[id^="edit_"]').hide();

            $('#title_' + id).hide();
            $('#edit_' + id).show().focus();
        }

        function HideBlockInput(id) {

            var blockCustomId = $('#edit_' + id).val();
            $('#title_' + id).text(blockCustomId);

            //-- Initially deactivate all inputs
            $('[id^="title_"]').show();
            $('[id^="edit_"]').hide();
        }


        function DeleteBlockItem(id) {

            var url = '{{ route('ajax_delete_block') }}';

            $.ajax({
                method: 'POST',
                url: url,
                dataType: "json",
                data: {
                    block_id: id,
                    _token: token
                }, beforeSend: function () {
                    //-- Show loading image while execution of ajax request
                    $("div#divLoading").addClass('show');
                },
                success: function (data) {
                    if (data['result'] === "success") {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: '{{trans('pagebuilder::messages.block_deleted')}}'
                        }).show();

                        $('#block_' + id).remove();
                    } else {
                        new Noty({
                            type: 'error',
                            layout: 'bottomLeft',
                            text: data['error']
                        }).show();
                    }
                    //-- Hide loading image
                    $("div#divLoading").removeClass('show');
                }
            });
        }

        //-- Code for draagging functionality
        $("#sortableDeactivated,#sortableActive").dragsort({
            dragSelector: "li",
            dragEnd: PrepareBlockOrder,
            dragBetween: true,
            placeHolderTemplate: "<li class='placeHolder'><div></div></li>"
        });

        function PrepareBlockOrder() {
            var arrBlocks = [];
            var arrIDCustom = [];
            $('#sortableActive [id^="block_"]').each(function () {
                if ($(this).attr('id')) {
                    var arrId = $(this).attr('id').replace("block_", "");
                    arrBlocks.push(arrId);
                }
            });
            $('#sortableActive [id^="title_"]').each(function () {
                var strIdCustom = $(this).text();
                arrIDCustom.push(strIdCustom);

            });

            //-- Save current block order and status
            SaveBlocks(arrBlocks, arrIDCustom);
        }

        function SaveBlocks(arrBlocks, arrIDCustom) {

            var url = '{{ route('ajax_save_blocks_sortorder') }}';

            $.ajax({
                method: 'POST',
                url: url,
                dataType: "json",
                data: {
                    arrBlocks: arrBlocks,
                    arrIDCustom: arrIDCustom,
                    _token: token
                }, beforeSend: function () {
                    //-- Show loading image while execution of ajax request
                    $("div#divLoading").addClass('show');
                },
                success: function (data) {
                    if (data['result'] === "success") {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: '{{trans('pagebuilder::messages.custom_css_updated')}}'
                        }).show();
                    }
                    //-- Hide loading image
                    $("div#divLoading").removeClass('show');
                }
            });
        }


    </script>

@stop
