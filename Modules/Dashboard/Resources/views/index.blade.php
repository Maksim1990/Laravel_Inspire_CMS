@extends('dashboard::layouts.master')

@section('General')
    <h3 class="title">Dashboard</h3>
    <div id="title_shape"></div>
    <div class="w3-row">
        <!-- Page Container -->
        <div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">
            <!-- The Grid -->
            <div class="w3-row">
                <!-- Left Column -->
                <div class="w3-col m3">
                    <!-- Profile -->
                    <div class="w3-card w3-round w3-white">
                        <div class="w3-container">
                            <h4 class="w3-center">My Profile</h4>
                            <p class="w3-center">
                                <img height="150"
                                     src="{{Auth::user()->image ? Auth::user()->image->full_path : custom_asset("images/includes/noimage.png")}}"
                                     alt="">
                            </p>
                            <hr>
                            <p><i class="fa fa-pencil fa-fw w3-margin-right w3-text-theme"></i> Designer, UI</p>
                            <p><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i> London, UK</p>
                            <p><i class="fa fa-birthday-cake fa-fw w3-margin-right w3-text-theme"></i> April 1, 1988</p>
                        </div>
                    </div>
                    <br>

                    <!-- Accordion -->
                    <div class="w3-card w3-round">
                        <div class="w3-white">
                            <button onclick="myFunction('Demo1')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-circle-o-notch fa-fw w3-margin-right"></i> My Groups</button>
                            <div id="Demo1" class="w3-hide w3-container">
                                <p>Some text..</p>
                            </div>
                            <button onclick="myFunction('Demo2')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-calendar-check-o fa-fw w3-margin-right"></i> My Events</button>
                            <div id="Demo2" class="w3-hide w3-container">
                                <p>Some other text..</p>
                            </div>
                            <button onclick="myFunction('Demo3')" class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-users fa-fw w3-margin-right"></i> My Photos</button>
                            <div id="Demo3" class="w3-hide w3-container">
                                <div class="w3-row-padding">
                                    <br>
                                    <div class="w3-half">
                                        <img src="/w3images/lights.jpg" style="width:100%" class="w3-margin-bottom">
                                    </div>
                                    <div class="w3-half">
                                        <img src="/w3images/nature.jpg" style="width:100%" class="w3-margin-bottom">
                                    </div>
                                    <div class="w3-half">
                                        <img src="/w3images/mountains.jpg" style="width:100%" class="w3-margin-bottom">
                                    </div>
                                    <div class="w3-half">
                                        <img src="/w3images/forest.jpg" style="width:100%" class="w3-margin-bottom">
                                    </div>
                                    <div class="w3-half">
                                        <img src="/w3images/nature.jpg" style="width:100%" class="w3-margin-bottom">
                                    </div>
                                    <div class="w3-half">
                                        <img src="/w3images/snow.jpg" style="width:100%" class="w3-margin-bottom">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>>
                </div>

                <!-- Middle Column -->
                <div class="w3-col m7">

                    <div class="w3-row-padding w3-margin-bottom">
                        <div class="w3-col m12">
                            <div class="w3-card w3-round w3-white">
                                <div class="w3-container w3-padding">
                                    <h6 class="w3-opacity">Change name of your new website</h6>
                                    <p contenteditable="true" class="w3-border w3-padding">Status: Feeling Blue</p>
                                    <button type="button" class="w3-button btn-success">@lang('messages.save')</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w3-row-padding  w3-margin-bottom">
                        <div class="w3-col m12">
                            <div class="w3-card w3-round w3-white">
                                <div class="w3-container">
                                    <p><a href="#">Available website blocks</a></p>
                                    <p>
                                        <span class="w3-tag w3-small w3-theme-d5">News</span>
                                        <span class="w3-tag w3-small w3-theme-d4">W3Schools</span>
                                        <span class="w3-tag w3-small w3-theme-d3">Labels</span>
                                        <span class="w3-tag w3-small w3-theme-d2">Games</span>
                                        <span class="w3-tag w3-small w3-theme-d1">Friends</span>
                                        <span class="w3-tag w3-small w3-theme">Games</span>
                                        <span class="w3-tag w3-small w3-theme-l1">Friends</span>
                                        <span class="w3-tag w3-small w3-theme-l2">Food</span>
                                        <span class="w3-tag w3-small w3-theme-l3">Design</span>
                                        <span class="w3-tag w3-small w3-theme-l4">Art</span>
                                        <span class="w3-tag w3-small w3-theme-l5">Photos</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w3-row-padding  ">
                        <div class="w3-col m6 w3-margin-bottom">
                            <div class="w3-card w3-round w3-white w3-center w3-margin-bottom">
                                <div class="w3-container">
                                    <p>Change profile</p>
                                    <div class="w3-row w3-opacity">
                                        <div class="w3-half">
                                            <button class="w3-button w3-block w3-green w3-section" title="Accept">Update</button>
                                        </div>
                                        <div class="w3-half">
                                            <button class="w3-button w3-block w3-red w3-section" title="Decline">@lang('messages.delete')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w3-card w3-round w3-white w3-padding-32 w3-center">
                                <a href="{{route('mail',['id'=>Auth::id()])}}">
                                <p style="font-size:45px;">
                                    <img width="100" src="{{custom_asset("images/includes/mail.png")}}" alt="">
                                </p>
                                <p class="w3-xxlarge">Mail box</p>
                                </a>
                            </div>
                        </div>

                        <div class="w3-col m6 w3-margin-bottom">
                            <div class="w3-card w3-round w3-white w3-margin-bottom">
                                <div class="w3-container">
                                    <p>Interests</p>
                                    <p>
                                        <span class="w3-tag w3-small w3-theme-d5">News</span>
                                        <span class="w3-tag w3-small w3-theme-d4">W3Schools</span>
                                        <span class="w3-tag w3-small w3-theme-d3">Labels</span>
                                        <span class="w3-tag w3-small w3-theme-d2">Games</span>
                                        <span class="w3-tag w3-small w3-theme-d1">Friends</span>
                                        <span class="w3-tag w3-small w3-theme">Games</span>
                                        <span class="w3-tag w3-small w3-theme-l1">Friends</span>
                                        <span class="w3-tag w3-small w3-theme-l2">Food</span>
                                        <span class="w3-tag w3-small w3-theme-l3">Design</span>
                                        <span class="w3-tag w3-small w3-theme-l4">Art</span>
                                        <span class="w3-tag w3-small w3-theme-l5">Photos</span>
                                    </p>
                                </div>
                            </div>

                            <div class="w3-card w3-round w3-white w3-padding-16 w3-center">
                                <p>ADS</p>
                            </div>
                            <br>
                        </div>
                    </div>
                    <!-- End Middle Column -->
                </div>

                <!-- Right Column -->
                <div class="w3-col m2">
                    <div class="w3-card w3-round w3-white w3-center">
                        <div class="w3-container">
                            <p>Upcoming Events:</p>
                            <img src="/w3images/forest.jpg" alt="Forest" style="width:100%;">
                            <p><strong>Holiday</strong></p>
                            <p>Friday 15:00</p>
                            <p><button class="w3-button w3-block w3-theme-l4">Info</button></p>
                        </div>
                    </div>
                    <br>

                    <div class="w3-card w3-round w3-white w3-center">
                        <div class="w3-container">
                            <p>Friend Request</p>
                            <img src="/w3images/avatar6.png" alt="Avatar" style="width:50%"><br>
                            <span>Jane Doe</span>
                            <div class="w3-row w3-opacity">
                                <div class="w3-half">
                                    <button class="w3-button w3-block w3-green w3-section" title="Accept"><i class="fa fa-check"></i></button>
                                </div>
                                <div class="w3-half">
                                    <button class="w3-button w3-block w3-red w3-section" title="Decline"><i class="fa fa-remove"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="w3-card w3-round w3-white w3-hide-small">
                        <div class="w3-container">
                            <p>
                                <a href="{{route('languages',['id'=>Auth::id()])}}">Active languages</a></p>
                            <p>
                                <span class="w3-tag w3-small w3-theme-d5">News</span>
                                <span class="w3-tag w3-small w3-theme-d4">W3Schools</span>
                                <span class="w3-tag w3-small w3-theme-d3">Labels</span>
                                <span class="w3-tag w3-small w3-theme-d2">Games</span>
                                <span class="w3-tag w3-small w3-theme-d1">Friends</span>
                                <span class="w3-tag w3-small w3-theme">Games</span>
                                <span class="w3-tag w3-small w3-theme-l1">Friends</span>
                                <span class="w3-tag w3-small w3-theme-l2">Food</span>
                                <span class="w3-tag w3-small w3-theme-l3">Design</span>
                                <span class="w3-tag w3-small w3-theme-l4">Art</span>
                                <span class="w3-tag w3-small w3-theme-l5">Photos</span>
                            </p>
                        </div>
                    </div>

                    <!-- End Right Column -->
                </div>

                <!-- End Grid -->
            </div>

            <!-- End Page Container -->
    </div>
@stop
