
<div class="w3-top" id="main_top_menu">
    <div class="w3-bar" id="myNavbar">
        <a class="w3-bar-item w3-button w3-hover-black w3-hide-medium w3-hide-large w3-right" href="javascript:void(0);" onclick="toggleFunction()" title="Toggle Navigation Menu">
            <i class="fa fa-bars"></i>
        </a>

        <a href="#{{$dataWebsite->getBlocks()->find(1)->block_custom_id}}" class="w3-bar-item w3-button">HOME</a>
        <a href="#{{$dataWebsite->getBlocks()->find(2)->block_custom_id}}" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-user"></i> ABOUT</a>
        <a href="#{{$dataWebsite->getBlocks()->find(4)->block_custom_id}}" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-th"></i> PORTFOLIO</a>
        <a href="#{{$dataWebsite->getBlocks()->find(6)->block_custom_id}}" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-envelope"></i> CONTACT</a>
        @if($dataWebsite->getWebsiteSettings()->posts_page=="Y")
        <a href="{{$dataWebsite->getWebsiteSettings()->website_name}}/posts" class="w3-bar-item w3-button w3-hide-small"><i class="fa fa-envelope"></i> POSTS</a>
            @endif
        @if($dataWebsite->getWebsiteSettings()->use_active_languages=="Y")
        <span style="float: right;margin-top: 5px;margin-right: 5%;">
                    @if(!empty($appFooter->getActiveLanguages()))
                       @foreach($appFooter->getActiveLanguages() as $strLand=>$strFullLang)
                           @if(strtolower($strLand)=='th')
                               @php $strImage='th'; @endphp
                           @elseif(strtolower($strLand)=='fr')
                               @php $strImage='fr'; @endphp
                           @elseif(strtolower($strLand)=='ru')
                               @php $strImage='ru'; @endphp
                           @else
                               @php $strImage='en'; @endphp
                           @endif
                                <a class="website_lang"
                                   href="{{ LaravelLocalization::getLocalizedURL(strtolower($strLand), null, [], true) }}">
                                    {{--<img style="border-radius: 30px;" width="25" height="25"--}}
                                         {{--src="{{custom_asset('images/includes/flags/'.$strImage.'.png')}}"--}}
                                         {{--alt="">--}}
                                    {{$strFullLang}}
                                </a>
                       @endforeach
                   @endif

        </span>
            @endif
    </div>

    <!-- Navbar on small screens -->
    <div id="navDemo" class="w3-bar-block w3-white w3-hide w3-hide-large w3-hide-medium">
        <a href="#{{$dataWebsite->getBlocks()->find(2)->block_custom_id}}" class="w3-bar-item w3-button" onclick="toggleFunction()">ABOUT</a>
        <a href="#{{$dataWebsite->getBlocks()->find(4)->block_custom_id}}" class="w3-bar-item w3-button" onclick="toggleFunction()">PORTFOLIO</a>
        <a href="#{{$dataWebsite->getBlocks()->find(6)->block_custom_id}}" class="w3-bar-item w3-button" onclick="toggleFunction()">CONTACT</a>
        @if($dataWebsite->getWebsiteSettings()->posts_page=="Y")
        <a href="#{{$dataWebsite->getBlocks()->find(6)->block_custom_id}}" class="w3-bar-item w3-button" onclick="toggleFunction()">POSTS</a>
            @endif
    </div>


</div>
