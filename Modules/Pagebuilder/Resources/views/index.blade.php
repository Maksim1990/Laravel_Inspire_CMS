@extends('pagebuilder::layouts.master')

@section('styles')
    <style type="text/css">
        #pagebuilder h1 { font-size:16pt; }
        #pagebuilder h2 { font-size:13pt; }
        #pagebuilder ul { width:350px; list-style-type: none; margin:0px; padding:0px; }
        #pagebuilder li { float:left; padding:5px; width:100px; height:100px; }
        #pagebuilder li div { width:90px; height:50px; border:solid 1px black; background-color:#E0E0E0; text-align:center; padding-top:40px; }
        #pagebuilder .placeHolder div { background-color:white!important; border:dashed 1px gray !important; }
    </style>
@stop
@section('General')
    <div id="pagebuilder">
    <h3>Pagebuilder</h3>


    <h2>Save list order with ajax:</h2>

    <ul id="gallery">
        <?php
        $list = array("blue", "orange", "brown", "red", "yellow", "green", "black", "white", "purple");
        for ($idx = 0; $idx < count($list); $idx+=1) {
            echo "<li data-itemid='" . $idx . "'>";
            echo "<div>" . $list[$idx] . "</div>";
            echo "</li>";
        }
        ?>
    </ul>
    <div style="clear:both;"></div>
    </div>
@stop
@section('scripts')
    <script src="{{asset('js/jquery.dragsort.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $("#gallery").dragsort({ dragSelector: "div", dragEnd: saveOrder, placeHolderTemplate: "<li class='placeHolder'><div></div></li>" });

        function saveOrder() {
             var data = $("#gallery li").map(function() { return $(this).data("itemid"); }).get();
             console.log(data);
            // $.post("admin/pagebuilder", { "ids[]": data });
        };
    </script>
    <script>
        {{--var token = '{{\Illuminate\Support\Facades\Session::token()}}';--}}
        {{--var url = '{{ route('ajax_update_label') }}';--}}


    </script>
@stop
