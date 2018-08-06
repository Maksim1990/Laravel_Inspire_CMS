@include('partials.style_header')
@php
//dd($menuCollection->getMenu());
@endphp
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
                    <img style="margin-top: -15px;" height="50" src="{{custom_asset('images/includes/logo_white.png')}}" alt="">
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav ">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Modules</a>
                        @if(count($menuCollection->getMenu()->where('parent',1))>0)
                            {!! BuildMenu(1, $menuCollection) !!}
                        @endif
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings</a>
                        @if(count($menuCollection->getMenu()->where('parent',1))>0)
                            {!! BuildMenu(2, $menuCollection) !!}
                        @endif
                    </li>
                    <li><a href="{{route("website")}}" target="_blank">Visit website</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right" id="user_block_menu">
                    <li id="loggedName">
                        <p href="#" class="tooltip_header_menu">
                            <img style="border-radius: 40px;" height="45"
                                 src="{{Auth::user()->image ? Auth::user()->image->full_path : custom_asset("images/includes/noimage.png")}}"
                                 alt="">
                            <span class=""
                                  style="color:white;display:inline;position: relative;top: 5px;"> Hello, {{ Auth::user()->name }}
                                !</span>
                            <span class="tooltiptext">
                                <a href="{{route('profile',['id'=>Auth::id()])}}">Profile</a><br>
                                <a href="{{route('profile_settings',['id'=>Auth::id()])}}">Settings</a><br>
                                 <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                            </span>
                        </p>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right" style="margin:-10px 40px 0 0;">
                    <li><a href="#">
                            <i class="fa fa-bell w3-xxlarge w3-text-yellow" aria-hidden="true"></i>
                            <span class="w3-badge w3-large  w3-white" id="notification_number">0</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


</header>
