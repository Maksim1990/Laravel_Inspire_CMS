@include('partials.style_header')
@php
    //dd($menuCollection->getMenu());
@endphp
@include('partials.sidebar_right')
<div id="mainContent">
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{route('admin',['id'=>Auth::id()])}}">
                        <img style="margin-top: -15px;" height="70"
                             src="{{custom_asset('images/includes/inspire.png')}}" alt="">
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav ">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">@lang('messages.modules')</a>
                            @if(count($menuCollection->getMenu()->where('parent',1))>0)
                                {!! BuildMenu(1, $menuCollection) !!}
                            @endif
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">@lang('messages.settings')</a>
                            @if(count($menuCollection->getMenu()->where('parent',1))>0)
                                {!! BuildMenu(2, $menuCollection) !!}
                            @endif
                        </li>
                        <li>
                            <a href="{{route("website",['id'=>Auth::id(),'sitename'=>Auth::user()->website_setting->website_name])}}" data-toggle="tooltip" data-placement="bottom" title="@lang('messages.visit_website')"
                               target="_blank"><i style="font-size:25px;" class="fab fa-osi"></i></a></li>
                        @if(Auth::user()->admin==1)
                            <li>
                                <a href="{{route("admin_settings",['id'=>Auth::id()])}}" data-toggle="tooltip" data-placement="bottom" title="@lang('messages.admin_settings')">
                                    <i style="font-size:25px;" class="fas fa-users-cog"></i></a></li>
                        @endif
                    </ul>

                    <ul class="nav navbar-nav navbar-right" id="user_block_menu">
                        <li id="loggedName">
                            <p href="#" class="tooltip_header_menu">
                                <img style="border-radius: 40px;" height="45"
                                     src="{{Auth::user()->image ? Auth::user()->image->full_path : custom_asset("images/includes/noimage.png")}}"
                                     alt="">
                                <span class=""
                                      style="color:white;display:inline;position: relative;top: 5px;"> @lang('messages.hello'), {{ Auth::user()->name }}
                                    !</span>
                                <span class="tooltiptext">
                                <a href="{{route('profile',['id'=>Auth::id()])}}">@lang('messages.profile')</a><br>
                                <a href="{{route('profile_settings',['id'=>Auth::id()])}}">@lang('messages.settings')</a><br>
                                 <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                       @lang('messages.logout')
                                    </a>
                            </span>
                            </p>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right" style="margin:-10px 40px 0 0;">
                        <li data-toggle="tooltip" data-placement="bottom" title="@lang('messages.no_notifications')">
                            <a href="#">
                                <i class="fa fa-bell w3-xxlarge w3-text-yellow" aria-hidden="true"></i>
                                <span class="w3-badge w3-large  w3-white" id="notification_number">0</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    </header>
