@extends('pagebuilder::layouts.master')

@section('scripts_header')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        #sortableDeactivated, #sortableActive {
            border: 1px solid #eee;
            width: 142px;
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

                    <ul id="sortableDeactivated" class="connectedSortable">
                        @if(!empty($websiteBlocksDeactivated))
                            @foreach($websiteBlocksDeactivated as $block)
                                <li class="ui-state-default" id="block_{{$block->block_id}}" data-sortorder="1">
                                    <p id="title_{{$block->block_id}}">{{$block->block_custom_id}}</p>
                                    <input type="text" id="edit_{{$block->block_id}}" class="edit_title" value="{{$block->block_custom_id}}">
                                </li>
                            @endforeach
                        @endif
                    </ul>

                    <ul id="sortableActive" class="connectedSortable">
                        @if(!empty($websiteBlocksActive))
                            @foreach($websiteBlocksActive as $block)
                                <li class="ui-state-highlight" id="block_{{$block->block_id}}" data-sortorder="1">
                                    <p id="title_{{$block->block_id}}">{{$block->block_custom_id}}</p>
                                    <input type="text" id="edit_{{$block->block_id}}" class="edit_title" value="{{$block->block_custom_id}}">
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
        var lastBlockId='{{$lastBlockId}}';
        $('#create_block').click(function () {
            lastBlockId++;
            var strBloсkID="block"+lastBlockId+"_{{Auth::id()}}";
            var strBloсkCustomId="block"+lastBlockId;

          var newBlock="<li class='ui-state-highlight' id='block_"+strBloсkID+"' data-sortorder='1'><p id='title_"+strBloсkID+"'>"+strBloсkCustomId+"</p><input type='text' id='edit_"+strBloсkID+"' class='edit_title' value='"+strBloсkCustomId+"'></li>";
            $("#sortableDeactivated").append(newBlock);
        });


        //-- Code for draagging functionality
        $("#sortableDeactivated,#sortableActive").dragsort({
            dragSelector: "li",
            dragEnd: PrepareBlockOrder,
            dragBetween:true,
            placeHolderTemplate: "<li class='placeHolder'><div></div></li>"
        });

        function PrepareBlockOrder() {
            var arrBlocks = [];
            var arrIDCustom = [];
            $('#sortableActive [id^="block_"]').each(function () {
                if ($(this).attr('id')) {
                    var arrId = $(this).attr('id').replace("block_","");
                    arrBlocks.push(arrId);
                }
            });
            $('#sortableActive [id^="title_"]').each(function () {
                    var strIdCustom = $(this).text();
                    arrIDCustom.push(strIdCustom);

            });
            console.log(arrBlocks);
            console.log(arrIDCustom);
            SaveBlocks(arrBlocks,arrIDCustom);
        }

        function SaveBlocks(arrBlocks,arrIDCustom) {
            var token = '{{\Illuminate\Support\Facades\Session::token()}}';
            var url = '{{ route('ajax_save_blocks_sortorder') }}';

            $.ajax({
                method: 'POST',
                url: url,
                dataType: "json",
                data: {
                    arrBlocks: arrBlocks,
                    arrIDCustom: arrIDCustom,
                    _token: token
                },
                success: function (data) {
                    console.log(data);
                    if (data['result'] === "success") {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: '{{trans('pagebuilder::messages.custom_css_updated')}}'
                        }).show();
                    }
                }
            });
        }
    </script>

@stop
