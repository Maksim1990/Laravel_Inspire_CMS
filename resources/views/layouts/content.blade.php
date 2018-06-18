<div id="wrapper" class="mainCont">
    @include('layouts.sidebar')
    <div class="w3-main" id="main">
        <div class="w3-main" id="main-sub">
            <div class=" col-xs-7 col-sm-1" id="mainClick">

                <p class="btnShowSidebar" onclick="w3_open()"><span>&#9776;</span></p>
                <p data-placement="right" data-container="body" data-toggle="users" data-placement="left"
                   data-html="true" href="#"><span data-html="true" data-container="body" data-placement="right"
                                                   data-toggle="tooltip" title="Users"><i class='fa fa-users'
                                                                                          aria-hidden='true'></i></span>
                </p>
                <p data-placement="right" data-container="body" data-toggle="posts_all" data-placement="left"
                   data-html="true" href="#"><span data-html="true" data-container="body" data-placement="right"
                                                   data-toggle="tooltip" title="Posts"><i class='fa fa-bookmark'
                                                                                          aria-hidden='true'></i></span>
                </p>
                <p data-placement="right" data-container="body" data-toggle="categories" data-placement="left"
                   data-html="true" href="#"><span data-html="true" data-container="body" data-placement="right"
                                                   data-toggle="tooltip" title="Categories"><i class='fa fa-list'
                                                                                               aria-hidden='true'></i></span>
                </p>
                <p><span data-html="true" data-container="body" data-placement="right" data-toggle="tooltip"
                         title="Blog"><a href="#"><i class='fa fa-book' aria-hidden='true'></i></a></span></p>
                <p><span rel="tooltip" title="A nice tooltip"><a
                                href="#"><i class='fa fa-comments' aria-hidden='true'></i></a></span></p>

            </div>
            @include('layouts.tabs')


        </div>
        @include('layouts.footer')
    </div>
    <script>
        new Noty({
            type: 'warning',
            layout: 'topRight',
            text: 'Test'
        }).show();
    </script>
    <script>

        var token = '{{\Illuminate\Support\Facades\Session::token()}}';
        var url_side_bar = '{{ URL::to('show_left_sidebar') }}';
        var user_id = '{{ Auth::id() }}';
        $(document).ready(function () {
            $('.btnShowSidebar, #Sidebar>button').on('click', function (event) {
                var active_left_sidebar = '{{Auth::user()->setting? Auth::user()->setting->active_left_sidebar :'Y'}}';
                $.ajax({
                    method: 'POST',
                    url: url_side_bar,
                    data: {active_left_sidebar: active_left_sidebar, user_id: user_id, _token: token}
                });
            });
        });
    </script>
    <script>
        var show_left_sidebar = '{{Auth::user()->setting? Auth::user()->setting->active_left_sidebar :'Y'}}';
        if (show_left_sidebar == 'Y') {
            $(document).ready(function () {
                if ($(window).width() < 960) {
                    w3_close();
                }
                else {
                    w3_open();
                }
            });
            $(window).resize(function () {
                if ($(window).width() < 960) {
                    w3_close();
                }
                else {
                    w3_open();
                }
            });
        } else {
            w3_close();
        }
        document.getElementById("Sidebar").style.width = "20%";

        function w3_open() {

            document.getElementById("main").style.marginLeft = "20%";
            document.getElementById("Sidebar").style.width = "20%";
            document.getElementById("mainside").style.marginLeft = "0";
            document.getElementById("footer").style.marginLeft = "0";
            document.getElementById("Sidebar").style.display = "block";
            document.getElementById("mainClick").style.display = "none";

        }

        function w3_close() {
            document.getElementById("main").style.marginLeft = "0%";
            document.getElementById("mainside").style.marginLeft = "50px";
            document.getElementById("footer").style.marginLeft = "70px";
            document.getElementById("Sidebar").style.display = "none";
            document.getElementById("mainClick").style.display = "inline-block";
        }
    </script>
    <script src="{{asset('js/app.js')}}"></script>


</div>