<footer id="footer">
    <div class="w3-row ">
        <div class="w3-col s6 m6  w3-center"><ul class="w3-ul">
                <li class="w3-hover-green"><a href="#">About</a></li>
                <li class="w3-hover-green">Future updates</li>
                <li class="w3-hover-green">Adam</li>
            </ul></div>
        <div class="w3-col s6 m6  w3-center">
            <ul class="w3-ul">
                <li class="w3-hover-green"><a href="#">Contact Us</a></li>
                <li class="w3-hover-green">Eve</li>
                <li class="w3-hover-green">Adam</li>
            </ul>
        </div>
    </div>
    <div class="w3-row">
        <div class="w3-col s1 m1"><p></p></div>
        <div class="w3-col s10 m10  w3-center"><p>2018 &#169; Developed by <a href="#">
                    Maksim Narushevich</a></p></div>
    </div>
    <div class="w3-col s1 m1"><p></p></div>
</footer>
</div>
<div id="posts_all" class="hide" style="width:3000px;">
    <p> <a href="#">All Posts</a></p>
    <p> <a href="#">Create Post</a></p>
</div>
{{--<div id="users" class="hide" style="width:3000px;">--}}
{{--<p> <a href="{{URL::to('users/'.Auth::user()->id)}}" >My profile</a></p>--}}
{{--<p>  <a href="{{URL::to('users ')}}" >All Users</a></p>--}}
{{--@if(Auth::user()->role_id=="1")--}}
{{--<p>   <a href="{{URL::to('users/create ')}}">Create User</a></p>--}}
{{--@endif--}}
{{--</div>--}}
{{--<div id="categories" class="hide" style="width:3000px;">--}}
{{--<p>  <a href="{{URL::to('categories ')}}">All Categories</a></p>--}}
{{--</div>--}}
{{--<div id="logged_user" class="hide" style="width:3000px;">--}}
{{--<p><a data-userid="{{Auth::user()->id}}" href="{{ URL::to('users/' . Auth::user()->id ) }}">My profile</a>--}}
{{--</p>--}}
{{--<p>  <a href="{{ route('logout') }}"onclick="event.preventDefault();--}}
{{--document.getElementById('logout-form').submit();">Logout</a></p>--}}
{{--</div>--}}

<script>
    function emojiDir(emoji) {
        var emojiPathImage="<img width='30' src="+emoji+"  alt='' />";
        $('#postInput').val(function(_, val){return val + emojiPathImage; });
    }
</script>
<script>
    $(document).ready(function(){
        var statusImageBorder=true;

        $('#loggedName img').css('border-style','solid');
        $('#loggedName img').css('border-color','transparent');
        $('#loggedName').click(function(){
            if(statusImageBorder){
                $('#loggedName img').css('borderWidth','3px');
                $('#loggedName img').css('borderRadius','30px');
                $('#loggedName img').css('borderColor','orange');
                statusImageBorder=false;

            }else{
                $('#loggedName img').css('borderWidth','0px');
                $('#loggedName img').css('borderRadius','40px');
                $('#loggedName img').css('borderColor','transparent');
                statusImageBorder=true;
            }
        });
    });
</script>
<script src="{{asset('js/popover-custom.js')}}"></script>
{{--<!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-57add4a572776064"></script>--}}

<script>

    var token = '{{\Illuminate\Support\Facades\Session::token()}}';
    var url_side_bar = '{{ route('show_left_sidebar') }}';
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
@yield('scripts')


