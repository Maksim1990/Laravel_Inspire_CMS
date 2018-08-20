@extends('pagebuilder::layouts.master')



@section('scripts_header')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        #sortable1, #sortable2 {
            border: 1px solid #eee;
            width: 142px;
            min-height: 20px;
            list-style-type: none;
            margin: 0;
            padding: 5px 0 0 0;
            float: left;
            margin-right: 10px;
        }
        #sortable1 li, #sortable2 li {
            margin: 0 5px 5px 5px;
            padding: 5px;
            font-size: 1.2em;
            width: 120px;
        }
        .edit_title{
            width: 100%;
        }
    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
            $( "#sortable1, #sortable2" ).sortable({
                connectWith: ".connectedSortable"
            }).disableSelection();
        } );
    </script>

@stop
@section('General')
    <div class="row maintab">
        <div class="col-sm-12 col-lg-12 col-xs-12">
            <div class="col-sm-8 col-lg-8 col-xs-12">
                <div>
                    <h3 class="title">@lang('pagebuilder::messages.background')</h3>
                    <div id="title_shape"></div>
                </div>
                <div class="insp_buttons">
                    <a href="{{route("pagebuilder_index",['id'=>Auth::id()])}}"
                       class="btn btn-warning">@lang('pagebuilder::messages.back_to_pagebuilder')
                    </a> <a href="#"
                       class="btn btn-info" id="create_block">Create block</a>
                </div>

                <div>

                    <ul id="sortable1" class="connectedSortable">
                        <li class="ui-state-default" id="block_6" data-sortorder="6">
                            <p id="title_6">Item 6</p>
                            <input type="text" id="edit_6" class="edit_title" value="Item 6">
                        </li>
                        <li class="ui-state-default" id="block_7" data-sortorder="7">
                            <p id="title_7">Item 7</p>
                            <input type="text" id="edit_7" class="edit_title" value="Item 7">
                        </li>
                        <li class="ui-state-default" id="block_8" data-sortorder="8">
                            <p id="title_8">Item 8</p>
                            <input type="text" id="edit_8" class="edit_title" value="Item 8">
                        </li>
                        <li class="ui-state-default" id="block_9" data-sortorder="9">
                            <p id="title_9">Item 9</p>
                            <input type="text" id="edit_9" class="edit_title" value="Item 9">
                        </li>
                        <li class="ui-state-default" id="block_10" data-sortorder="10">
                            <p id="title_10">Item 10</p>
                            <input type="text" id="edit_10" class="edit_title" value="Item 10">
                        </li>
                    </ul>

                    <ul id="sortable2" class="connectedSortable">
                        <li class="ui-state-highlight" id="block_1" data-sortorder="1">
                            <p id="title_1">Item 1</p>
                            <input type="text" id="edit_1" class="edit_title" value="Item 1">
                        </li>
                        <li class="ui-state-highlight" id="block_2" data-sortorder="2">
                            <p id="title_2">Item 2</p>
                            <input type="text" id="edit_2" class="edit_title" value="Item 2">
                        </li>
                        <li class="ui-state-highlight" id="block_3" data-sortorder="3">
                            <p id="title_3">Item 3</p>
                            <input type="text" id="edit_3" class="edit_title" value="Item 3">
                        </li>
                        <li class="ui-state-highlight" id="block_4" data-sortorder="4">
                            <p id="title_4">Item 4</p>
                            <input type="text" id="edit_4" class="edit_title" value="Item 4">
                        </li>
                        <li class="ui-state-highlight" id="block_5" data-sortorder="5">
                            <p id="title_5">Item 5</p>
                            <input type="text" id="edit_5" class="edit_title" value="Item 5">
                        </li>
                    </ul>


                </div>


            </div>
        </div>
    </div>


@stop

@section('scripts')

    <script src="{{custom_asset('js/jquery.dragsort.js')}}" type="text/javascript"></script>

    <script type="text/javascript">

        $('#create_block').click(function () {
          var newBlock="<li class=\"ui-state-default\" id=\"block_11\" data-sortorder=\"11\">Item 11</li>";
            $("#sortable1").append(newBlock);
        });


        //-- Code for draagging functionality
        $("#sortable1,#sortable2").dragsort({
            dragSelector: "li",
            dragEnd: saveOrder,
            dragBetween:true,
            placeHolderTemplate: "<li class='placeHolder'><div></div></li>"
        });

        function saveOrder() {
            var arrBlocks = [];
            $('#sortable2 [id^="block_"]').each(function () {
                if ($(this).attr('id')) {
                    var arrId = $(this).attr('id').replace("block_","");
                    arrBlocks.push(arrId);
                }
            });
            console.log(arrBlocks);
        }
    </script>

@stop
