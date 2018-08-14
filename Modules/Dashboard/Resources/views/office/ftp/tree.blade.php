@extends('dashboard::layouts.master')
@section('styles')

@stop
@section('scripts_header')
    <link rel="stylesheet" href="{{custom_asset('plugins/vendor/jstree/dist/themes/default/style.css')}}">



@stop
@section('General')
    <div class="row">
        <div class="col-sm-12 col-md-10  col-xs-12">
            <div class="col-sm-12 col-md-12  col-xs-12">
                <h3 class="title">JS Tree</h3>
                <div id="title_shape"></div>

                <div id="jstree"></div>
                
            </div>

        </div>

    </div>
@stop
@section('scripts')
    <script src="{{custom_asset('plugins/vendor/jstree/dist/jstree.min.js')}}"></script>
    <script>
        // Setup the jsTree.
        $(function () {
            $('#jstree').on("changed.jstree", function (e, data) {
                if(data.selected.length) {
                    alert('The selected node is: ' + data.instance.get_node(data.selected[0]).text+' The selected ID is: ' + data.instance.get_node(data.selected[0]).id);
                }
                var arr=data.instance.get_node(data.selected[0]).id.split('_');

                var intNum=arr[1]+1;
                alert(intNum);
                createNode("#"+data.instance.get_node(data.selected[0]).id, "sub_"+intNum, "Sub "+intNum, "last");
                openNode("#"+data.instance.get_node(data.selected[0]).id);
            }).jstree({

                'core': {
                    'data': [{
                        "id": "base_directory",
                        "text": "Base Directory",
                        "state": {
                            "opened": true
                        },
                        "children": [{
                            "text": "Sub 1",
                            "id": "sub_1"
                        },
                            {
                                "text": "Sub 2",
                                "id": "sub_2"
                            },
                            {
                                "text": "Sub 3",
                                "id": "sub_3"
                            }
                        ]
                    }],
                    'check_callback': true
                }
            });
        });

        // When the jsTree is ready, add two more records.
        $('#jstree').on('ready.jstree', function (e, data) {
            createNode("#jstree", "another_base_directory", "Another Base Directory", "first");
            createNode("#base_directory", "sub_4", "Sub 4", "last");
            createNode("#sub_2", "sub_5", "Sub 5", "last");
        });

        // Helper method createNode(parent, id, text, position).
        // Dynamically adds nodes to the jsTree. Position can be 'first' or 'last'.
        function createNode(parent_node, new_node_id, new_node_text, position) {
            $('#jstree').jstree('create_node', $(parent_node), { "text":new_node_text, "id":new_node_id }, position, false, false);
        }
        function openNode(parent_node) {
            $('#jstree').jstree('open_node', $(parent_node));
        }
    </script>
@stop
