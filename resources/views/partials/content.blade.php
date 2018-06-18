<div id="wrapper" class="mainCont">
    @include('partials.sidebar')
    <div class="w3-main" id="main">
        <div class="w3-main" id="main-sub">
            <div class=" col-xs-7 col-sm-1" id="mainClick">

                <p class="btnShowSidebar" onclick="w3_open()"><span>&#9776;</span></p>
                <p data-placement="right" data-container="body" data-toggle="users" data-placement="left"
                   data-html="true" href="#"><span data-html="true" data-container="body" data-placement="right"
                                                   data-toggle="tooltip" title="Users"><i class='fa fa-users'
                                                                                          aria-hidden='true'></i></span>
                </p>
                <p data-placement="right" data-container="body" data-toggle="posts_all" data-placement="left"
                   data-html="true" href="#"><span data-html="true" data-container="body" data-placement="right"
                                                   data-toggle="tooltip" title="Posts"><i class='fa fa-bookmark'
                                                                                          aria-hidden='true'></i></span>
                </p>
                <p data-placement="right" data-container="body" data-toggle="categories" data-placement="left"
                   data-html="true" href="#"><span data-html="true" data-container="body" data-placement="right"
                                                   data-toggle="tooltip" title="Categories"><i class='fa fa-list'
                                                                                               aria-hidden='true'></i></span>
                </p>
                <p><span data-html="true" data-container="body" data-placement="right" data-toggle="tooltip"
                         title="Blog"><a href="#"><i class='fa fa-book' aria-hidden='true'></i></a></span></p>
                <p><span rel="tooltip" title="A nice tooltip"><a
                                href="#"><i class='fa fa-comments' aria-hidden='true'></i></a></span></p>

            </div>
            @include('partials.tabs')
        </div>
    </div>

</div>
