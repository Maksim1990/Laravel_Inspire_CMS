<div class="leftside col-xs-10 col-sm-5 w3-sidebar w3-bar-block w3-card-2 w3-animate-left" style="display:inline-block;" id="Sidebar">
    <button class="w3-bar-item w3-button w3-large" style="text-align: right;"
            onclick="HideLeftSidebar()"><i class="fas fa-arrow-circle-left"></i></button>
    <div class="navbar-default sidebar">
        <div class="sidebar-nav">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                <i class="fa fa-users"></i> @lang('messages.profile')<span class="fa arrow"></span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('profile',['id'=>Auth::id()])}}" >@lang('messages.my_profile')</a>
                                </li>
                                <li>
                                    <a href="{{route('profile_settings',['id'=>Auth::id()])}}" >@lang('messages.settings')</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    @lang('messages.logout')
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" >
                                <i class="fa fa-bookmark"></i> @lang('messages.modules')<span class="fa arrow"></span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('posts',['id'=>Auth::id()])}}" >@lang('messages.posts')</a>
                                </li>
                                <li>
                                    <a href="{{route('images',['id'=>Auth::id()])}}" >@lang('messages.images')</a>
                                </li>
                                <li>
                                    <a href="{{route('office',['id'=>Auth::id()])}}" >@lang('messages.office')</a>
                                </li>
                                <li>
                                    <a href="{{route('label',['id'=>Auth::id()])}}">@lang('messages.labels_management')</a>
                                </li>
                                 <li>
                                    <a href="{{route('mail',['id'=>Auth::id()])}}">@lang('messages.mail_box')</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" >
                                <i class="fa fa-list"></i>  @lang('messages.settings')<span class="fa arrow"></span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('profile_settings',['id'=>Auth::id()])}}" >@lang('messages.profile_settings')</a>
                                </li>
                                <li>
                                    <a href="{{route('website_settings',['id'=>Auth::id()])}}" >@lang('messages.website_settings')</a>
                                </li>
                                <li>
                                    <a href="{{route('languages',['id'=>Auth::id()])}}" >@lang('messages.language_settings')</a>
                                </li>
                                <li>
                                    <a href="{{route('codeeditor_setting',['id'=>Auth::id()])}}" >@lang('messages.code_editor_settings')</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingFour" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        <h4 class="panel-title">
                            <a class="collapsed" role="button" >
                                <i class="fa fa-picture-o"></i> @lang('messages.website_settings')<span class="fa arrow"></span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                        <div class="panel-body">
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('website_settings',['id'=>Auth::id()])}}" >@lang('messages.website_settings')</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="w3-center " style="position:absolute;bottom:15%;left:5%;">
                    <span >@lang('messages.version') {{$dataSidebar->getAppVersion()}}</span>
                </div>

            </div>
        </div>
    </div>
</div>