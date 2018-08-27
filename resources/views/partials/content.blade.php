<div id="wrapper" class="mainCont">
    @include('partials.sidebar')

    <div class="w3-main" id="main">
        <div class="w3-main" id="main-sub">
            <div class=" col-xs-7 col-sm-1" id="mainClick">

                <p class="btnShowSidebar" style="margin-top: -5px;" onclick="ShowLeftSidebar()"><span>&#9776;</span></p>
                <p class="tooltip_menu_side"><span><i class='fa fa-users' aria-hidden='true'></i></span>
                    <span class="tooltiptext">
                                    <a href="{{route('profile',['id'=>Auth::id()])}}" >@lang('messages.my_profile')</a>
                                    <a href="{{route('profile_settings',['id'=>Auth::id()])}}" >@lang('messages.settings')</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    @lang('messages.logout')
                                    </a>
                            </span>
                </p>
                <p class="tooltip_menu_side"><span><i class='fa fa-bookmark' aria-hidden='true'></i></span>
                    <span class="tooltiptext">
                                    <a href="{{route('posts',['id'=>Auth::id()])}}" >@lang('messages.posts')</a>
                                    <a href="{{route('images',['id'=>Auth::id()])}}" >@lang('messages.images')</a>
                                    <a href="{{route('office',['id'=>Auth::id()])}}" >@lang('messages.office')</a>
                                    <a href="{{route('label',['id'=>Auth::id()])}}">@lang('messages.labels_management')</a>
                                    <a href="{{route('mail',['id'=>Auth::id()])}}">@lang('messages.mail_box')</a>
                            </span>
                </p>
                <p class="tooltip_menu_side"><span><a href="#"><i class='fa fa-book' aria-hidden='true'></i></a></span>
                    <span class="tooltiptext">
                                    <a href="{{route('profile_settings',['id'=>Auth::id()])}}" >@lang('messages.profile_settings')</a>
                                    <a href="{{route('website_settings',['id'=>Auth::id()])}}" >@lang('messages.website_settings')</a>
                                    <a href="{{route('languages',['id'=>Auth::id()])}}" >@lang('messages.language_settings')</a>
                                    <a href="{{route('codeeditor_setting',['id'=>Auth::id()])}}" >@lang('messages.code_editor_settings')</a>
                            </span>
                </p>
                <p class="tooltip_menu_side"><span><a href="#"><i class='fa fa-comments' aria-hidden='true'></i></a></span>
                    <span class="tooltiptext">
                                  <a href="{{route('website_settings',['id'=>Auth::id()])}}" >@lang('messages.website_settings')</a>
                            </span>
                </p>

            </div>
            @include('partials.tabs')
        </div>



