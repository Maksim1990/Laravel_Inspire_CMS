</div>

<footer id="footer" class="col-xs-12">
    <div class="w3-row ">
        <div class="w3-col s6 m6  w3-center">
            <ul class="w3-ul">
                <li class="w3-hover-green"><a href="{{route('about_us')}}">@lang('messages.about_us')</a></li>
                <li class="w3-hover-green"><a href="{{route('office',['id'=>Auth::id()])}}">@lang('messages.inspire_cms_office')</a></li>
                <li class="w3-hover-green"><a href="{{route("website",['id'=>Auth::id(),'sitename'=>Auth::user()->website_setting->website_name])}}"  target="_blank">@lang('messages.visit_website')</a></li>
            </ul>
        </div>
        <div class="w3-col s6 m6  w3-center">
            <ul class="w3-ul">
                <li class="w3-hover-green"><a href="{{route('contacts')}}">@lang('messages.contact_us')</a></li>
                <li class="w3-hover-green"><a href="{{route('mail',['id'=>Auth::id()])}}">@lang('messages.mail_box')</a></li>
                <li class="w3-hover-green" data-toggle="modal" data-target="#modal_languages">@lang('messages.languages')</li>
            </ul>
        </div>
    </div>
    <div class="w3-row">
        <div class="w3-col s1 m1"><p></p></div>
        <div class="w3-col s10 m10  w3-center"><p>2018 &#169; Developed by <a href="https://www.linkedin.com/in/maksim-narushevich-b99783106/" target="_blank">
                    Maksim Narushevich</a></p></div>
    </div>
    <div class="w3-col s1 m1"><p></p></div>
</footer>
</div>


{{--Right sidebar button--}}
<a id="openNavRight" onclick="ShowRightSidebar()"><img src="{{custom_asset("images/includes/rightSideBarArrow.png")}}"
                                                       alt=""></a>


<div id="divLoading"></div>


{{--Image delete modal--}}
<div class="modal" id="modal_languages">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Do you want to change language?</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <ul>
                    @if(!empty($appFooter->getAppLanguages()))
                        @foreach($appFooter->getAppLanguages() as $strLand=>$strFullLang)
                            @if(strtolower($strLand)=='th')
                                @php $strImage='th'; @endphp
                            @elseif(strtolower($strLand)=='fr')
                                @php $strImage='fr'; @endphp
                            @elseif(strtolower($strLand)=='ru')
                                @php $strImage='ru'; @endphp
                            @else
                                @php $strImage='en'; @endphp
                            @endif
                            <li>
                                <a rel="alternate"
                                   href="{{ LaravelLocalization::getLocalizedURL(strtolower($strLand), null, [], true) }}">
                                    <img style="border-radius: 30px;" width="25" height="25"
                                         src="{{custom_asset('images/includes/flags/'.$strImage.'.png')}}"
                                         alt=""> {{$strFullLang}}
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer"></div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function () {
        var statusImageBorder = true;

        $('#loggedName img').css('border-style', 'solid');
        $('#loggedName img').css('border-color', 'transparent');
        $('#loggedName').click(function () {
            if (statusImageBorder) {
                $('#loggedName img').css('borderWidth', '3px');
                $('#loggedName img').css('borderRadius', '30px');
                $('#loggedName img').css('borderColor', 'orange');
                statusImageBorder = false;

            } else {
                $('#loggedName img').css('borderWidth', '0px');
                $('#loggedName img').css('borderRadius', '40px');
                $('#loggedName img').css('borderColor', 'transparent');
                statusImageBorder = true;
            }
        });
    });
</script>
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
                dataType: "json",
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
                HideLeftSidebar();
            }
            else {
                ShowLeftSidebar();
            }
        });

        $(window).resize(function () {
            if ($(window).width() < 960) {
                ShowLeftSidebar();
            }
            else {
                HideLeftSidebar();
            }
        });
    } else {
        HideLeftSidebar();
    }

    $(window).resize(function () {
        if ($(window).width() < 960) {
            HideRightSidebar(false);
        }
    });


    document.getElementById("Sidebar").style.width = "20%";

    function ShowLeftSidebar() {
        document.getElementById("main").style.marginLeft = "20%";
        document.getElementById("Sidebar").style.width = "20%";
        document.getElementById("mainside").style.marginLeft = "0";
        document.getElementById("footer").style.marginLeft = "0";
        document.getElementById("Sidebar").style.display = "block";
        document.getElementById("mainClick").style.display = "none";
        HideRightSidebar();
    }

    function HideLeftSidebar() {
        document.getElementById("main").style.marginLeft = "0%";
        document.getElementById("mainside").style.marginLeft = "50px";
        document.getElementById("footer").style.marginLeft = "70px";
        document.getElementById("Sidebar").style.display = "none";
        document.getElementById("mainClick").style.display = "inline-block";

    }
</script>


<script>
    function ShowRightSidebar() {
        document.getElementById("mainContent").style.marginRight = "25%";
        document.getElementById("rightSidebar").style.width = "25%";
        document.getElementById("rightSidebar").style.display = "block";
        document.getElementById("rightSidebar").style.right = "0%";
        document.getElementById("openNavRight").style.display = 'none';
        HideLeftSidebar();
    }

    function HideRightSidebar(status=true) {
        document.getElementById("mainContent").style.marginRight = "0%";
        document.getElementById("rightSidebar").style.display = "none";
        document.getElementById("openNavRight").style.display = "inline-block";
        if (!status) {
            HideLeftSidebar();
        }
    }
</script>


<script>
    $('.image_gallery img').attr('onclick', 'onClick(this)');


    //-- Funcrionality for adapt hover left sidebar submenus
    //-- In order to display above all other content on the page
    $('.tooltip_menu_side').on('mouseover', function () {
        $('.mainside').css('z-index', -2);
    });
    $('.tooltip_menu_side').on('mouseout', function () {
        $('.mainside').css('z-index', 2);
    });
</script>

<script>
    //-- Functionality that fixes issue with correct style for bootstrap tabs
    $('.tab_link').on('click', function () {
        var parentULTagId = $(this).parent().closest('ul').attr('id');
        $("#" + parentULTagId + ">li").removeClass("active");
        $(this).parent().addClass('active');
    });
</script>


<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@if(!isset($hideScript))
<script src="{{custom_asset('js/app.js')}}"></script>
@endif
<script src="{{custom_asset('js/app_custom.js')}}"></script>
@yield('scripts')


