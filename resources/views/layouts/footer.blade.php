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
{{--<script>--}}
    {{--$(document).ready(function () {--}}
        {{--var token='{{\Illuminate\Support\Facades\Session::token()}}';--}}
        {{--var url_check='{{ URL::to('check_notices') }}';--}}
        {{--$.ajax({--}}
            {{--method:'POST',--}}
            {{--url:url_check,--}}
            {{--data:{_token:token},--}}
            {{--success: function(data) {--}}
                {{--$('#notification_number').text(data['quantity']);--}}
            {{--}--}}
        {{--});--}}

    {{--});--}}
{{--</script>--}}
<script src="{{asset('js/popover-custom.js')}}"></script>
{{--<!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-57add4a572776064"></script>--}}

