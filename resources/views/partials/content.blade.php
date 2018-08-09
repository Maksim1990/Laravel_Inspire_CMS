<div id="wrapper" class="mainCont">
    @include('partials.sidebar')

    <div class="w3-main" id="main">
        <div class="w3-main" id="main-sub">
            <div class=" col-xs-7 col-sm-1" id="mainClick">

                <p class="btnShowSidebar" style="margin-top: -5px;" onclick="ShowLeftSidebar()"><span>&#9776;</span></p>
                <p class="tooltip_menu_side"><span><i class='fa fa-users' aria-hidden='true'></i></span>
                    <span class="tooltiptext">
                               <a href="#" >All</a>
                                <a href="#" >Settings</a>
                                <a href="#" >Info</a>
                            </span>
                </p>
                <p class="tooltip_menu_side"><span><i class='fa fa-bookmark' aria-hidden='true'></i></span>
                    <span class="tooltiptext">
                               <a href="#" >Profile</a>
                                <a href="#" >CSS</a>
                                <a href="#" >Settings</a>
                            </span>
                </p>
                <p><span data-html="true" data-container="body" data-placement="right" data-toggle="tooltip"
                         title="Blog"><a href="#"><i class='fa fa-book' aria-hidden='true'></i></a></span></p>
                <p><span rel="tooltip" title="A nice tooltip"><a
                                href="#"><i class='fa fa-comments' aria-hidden='true'></i></a></span></p>

            </div>
            @include('partials.tabs')
        </div>



