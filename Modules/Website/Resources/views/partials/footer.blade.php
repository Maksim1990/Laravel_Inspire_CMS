<!-- Footer -->
<footer class="w3-center w3-black w3-padding-64 w3-opacity w3-hover-opacity-off">
    @if($dataWebsite->getWebsiteSettings()->go_top_button=="Y")
    <a href="#home" class="w3-button w3-light-grey"><i class="fa fa-arrow-up w3-margin-right"></i>To the top</a>
    @endif
    <div class="w3-xlarge w3-section">
        <a href="{{$dataWebsite->getSocialIcons()->facebook}}" target="_blank"><i class="fab fa-facebook-square w3-hover-opacity"></i></a>
        <a href="{{$dataWebsite->getSocialIcons()->google}}" target="_blank"><i class="fab fa-google-plus-g w3-hover-opacity"></i></a>
        <a href="{{$dataWebsite->getSocialIcons()->instagram}}" target="_blank"><i class="fab fa-instagram w3-hover-opacity"></i></a>
        <a href="{{$dataWebsite->getSocialIcons()->line}}" target="_blank"><i class="fab fa-line w3-hover-opacity"></i></a>
        <a href="{{$dataWebsite->getSocialIcons()->pinterest}}" target="_blank"><i class="fab fa-pinterest-square w3-hover-opacity"></i></a>
        <a href="{{$dataWebsite->getSocialIcons()->twitter}}" target="_blank"><i class="fab fa-twitter-square w3-hover-opacity"></i></a>
        <a href="{{$dataWebsite->getSocialIcons()->linkedin}}" target="_blank"><i class="fab fa-linkedin w3-hover-opacity"></i></a>
        <a href="{{$dataWebsite->getSocialIcons()->vk}}" target="_blank"><i class="fab fa-vk w3-hover-opacity"></i></a>
    </div>
    <p>Powered by <a href="{{route('admin',['id'=>Auth::id()])}}" title="W3.CSS" target="_blank"
                     class="w3-hover-text-green">Inspire CMS</a></p>
</footer>

<!-- Add Google Maps -->
<script>
    function myMap() {
        myCenter = new google.maps.LatLng(41.878114, -87.629798);
        var mapOptions = {
            center: myCenter,
            zoom: 12, scrollwheel: false, draggable: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("googleMap"), mapOptions);

        var marker = new google.maps.Marker({
            position: myCenter,
        });
        marker.setMap(map);
    }

    // Modal Image Gallery
    function onClick(element) {
        document.getElementById("img01").src = element.src;
        document.getElementById("modal01").style.display = "block";
        var captionText = document.getElementById("caption");
        captionText.innerHTML = element.alt;
    }

    // Change style of navbar on scroll
    window.onscroll = function () {
        myFunction()
    };

    function myFunction() {
        var navbar = document.getElementById("myNavbar");

                @if(Auth::check())
        var navbar_dev = document.getElementById("navbar");
        var sticky = navbar_dev.offsetTop;

        if (window.pageYOffset >= sticky) {
            navbar_dev.classList.add("sticky")
        } else {
            navbar_dev.classList.remove("sticky");
        }
        if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
            @else
            if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                @endif
                    navbar.className = "w3-bar" + " w3-card" + " w3-animate-top" + " w3-white";

            } else {
                navbar.className = navbar.className.replace(" w3-card w3-animate-top w3-white", "");

            }
        }

        // Used to toggle the menu on small screens when clicking on the menu button
        function toggleFunction() {
            var x = document.getElementById("navDemo");
            if (x.className.indexOf("w3-show") == -1) {
                x.className += " w3-show";
            } else {
                x.className = x.className.replace(" w3-show", "");
            }
        }

</script>
<script>
    //-- Add onClick(this) event manually for all images in image_gallery class
    //-- In order to escape any JS from code editor that are deleted by Purifier before saving in DB
    $('.image_gallery img').attr('onclick', 'onClick(this)');
</script>
@if($dataWebsite->getWebsiteSettings()->google_map=="Y")
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{$dataWebsite->getWebsiteSettings()->google_map_key}}"></script>
    @endif