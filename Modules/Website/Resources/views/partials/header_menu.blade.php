
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
