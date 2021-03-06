<h3 class="w3-center">WHERE I WORK</h3>
<p class="w3-center"><em>I'd love your feedback!</em></p>

<div class="w3-row w3-padding-32 w3-section">
    @if($dataWebsite->getWebsiteSettings()->google_map=="Y")
    <div class="w3-col m4 w3-container">
        <!-- Add Google Maps -->
        <div id="googleMap" class="w3-round-large w3-greyscale" style="width:100%;height:400px;"></div>
    </div>
    @endif
    <div class="w3-col m8 w3-panel">
        <div class="w3-large w3-margin-bottom">
            <i class="fa fa-map-marker fa-fw w3-hover-text-black w3-xlarge w3-margin-right"></i> Chicago, US<br>
            <i class="fa fa-phone fa-fw w3-hover-text-black w3-xlarge w3-margin-right"></i> Phone: +00 151515<br>
            <i class="fa fa-envelope fa-fw w3-hover-text-black w3-xlarge w3-margin-right"></i> Email: mail@mail.com<br>
        </div>
        <p>Swing by for a cup of <i class="fa fa-coffee"></i>, or leave me a note:</p>
        @if($dataWebsite->getWebsiteSettings()->email_form=="Y")
        <form action="/action_page.php" target="_blank">
            <div class="w3-row-padding" style="margin:0 -16px 8px -16px">
                <div class="w3-half">
                    <input class="w3-input w3-border" type="text" placeholder="Name" required name="Name">
                </div>
                <div class="w3-half">
                    <input class="w3-input w3-border" type="text" placeholder="Email" required name="Email">
                </div>
            </div>
            <input class="w3-input w3-border" type="text" placeholder="Message" required name="Message">
            <button class="w3-button w3-black w3-right w3-section" type="submit">
                <i class="fa fa-paper-plane"></i> SEND MESSAGE
            </button>
        </form>
            @endif
    </div>
</div>