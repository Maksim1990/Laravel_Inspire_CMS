<div class="row maintab">
    <div class="col-sm-12  col-xs-12">
        <div>
            <h3 class="title">Website social networks settings</h3>
            <div id="title_shape"></div>
        </div>

        {{-- GitHub name--}}
        <div class="col-sm-12 col-lg-12 col-xs-12 line">
            <div class="col-sm-5 col-xs-12">
                <p class="text">
                    <span class="icon_social">
                        <i class="fab fa-github"></i>
                    </span>
                    GitHub
                <span class="w3-text-green"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="Update URL of your account in GitHub"></i></span>
                </p>

            </div>
            <div class="col-sm-5 col-xs-12">
                <div class="form-group">
                    <input type="text" class="form-control" id="github" oninput="checkInput(this)"
                           value="{{Auth::user()->social_icons->github}}">
                    <span class="info_alert" id="alert_github"></span>
                </div>
            </div>
            <div class="col-sm-2 col-xs-12">
                <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_github">Save</button>
            </div>
            <div class="col-sm-12 col-xs-12">
                <hr>
            </div>
        </div>

        {{-- Google name--}}
        <div class="col-sm-12 col-lg-12 col-xs-12 line">
            <div class="col-sm-5 col-xs-12">
                <p class="text">
                    <span class="icon_social">
                        <i class="fab fa-google-plus-g"></i>
                    </span>
                    Google
                    <span class="w3-text-green"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="Update URL of your account in Google"></i></span>
                </p>

            </div>
            <div class="col-sm-5 col-xs-12">
                <div class="form-group">
                    <input type="text" class="form-control" id="google" oninput="checkInput(this)"
                           value="{{Auth::user()->social_icons->google}}">
                    <span class="info_alert" id="alert_google"></span>
                </div>
            </div>
            <div class="col-sm-2 col-xs-12">
                <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_google">Save</button>
            </div>
            <div class="col-sm-12 col-xs-12">
                <hr>
            </div>
        </div>

        {{-- Instagram name--}}
        <div class="col-sm-12 col-lg-12 col-xs-12 line">
            <div class="col-sm-5 col-xs-12">
                <p class="text">
                            <span class="icon_social">
                    <i class="fab fa-instagram"></i>
                    </span>
                    Instagram
                    <span class="w3-text-green"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="Update URL of your account in Instagram"></i></span>
                </p>

            </div>
            <div class="col-sm-5 col-xs-12">
                <div class="form-group">
                    <input type="text" class="form-control" id="instagram" oninput="checkInput(this)"
                           value="{{Auth::user()->social_icons->instagram}}">
                    <span class="info_alert" id="alert_instagram"></span>
                </div>
            </div>
            <div class="col-sm-2 col-xs-12">
                <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_instagram">Save</button>
            </div>
            <div class="col-sm-12 col-xs-12">
                <hr>
            </div>
        </div>

        {{-- Facebook name--}}
        <div class="col-sm-12 col-lg-12 col-xs-12 line">
            <div class="col-sm-5 col-xs-12">
                <p class="text">
                        <span class="icon_social">
                        <i class="fab fa-facebook-square"></i>
                    </span>
                    Facebook
                    <span class="w3-text-green"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="Update URL of your account in Facebook"></i></span>
                </p>

            </div>
            <div class="col-sm-5 col-xs-12">
                <div class="form-group">
                    <input type="text" class="form-control" id="facebook" oninput="checkInput(this)"
                           value="{{Auth::user()->social_icons->facebook}}">
                    <span class="info_alert" id="alert_facebook"></span>
                </div>
            </div>
            <div class="col-sm-2 col-xs-12">
                <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_facebook">Save</button>
            </div>
            <div class="col-sm-12 col-xs-12">
                <hr>
            </div>
        </div>

        {{-- Twitter name--}}
        <div class="col-sm-12 col-lg-12 col-xs-12 line">
            <div class="col-sm-5 col-xs-12">
                <p class="text">
                            <span class="icon_social">
                    <i class="fab fa-twitter-square"></i>
                    </span>
                    Twitter
                    <span class="w3-text-green"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="Update URL of your account in Twitter"></i></span>
                </p>

            </div>
            <div class="col-sm-5 col-xs-12">
                <div class="form-group">
                    <input type="text" class="form-control" id="twitter" oninput="checkInput(this)"
                           value="{{Auth::user()->social_icons->twitter}}">
                    <span class="info_alert" id="alert_twitter"></span>
                </div>
            </div>
            <div class="col-sm-2 col-xs-12">
                <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_twitter">Save</button>
            </div>
            <div class="col-sm-12 col-xs-12">
                <hr>
            </div>
        </div>

        {{-- VK name--}}
        <div class="col-sm-12 col-lg-12 col-xs-12 line">
            <div class="col-sm-5 col-xs-12">
                <p class="text">
                       <span class="icon_social">
                        <i class="fab fa-vk"></i>
                    </span>
                    VK
                    <span class="w3-text-green"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="Update URL of your account in VK"></i></span>
                </p>

            </div>
            <div class="col-sm-5 col-xs-12">
                <div class="form-group">
                    <input type="text" class="form-control" id="vk" oninput="checkInput(this)"
                           value="{{Auth::user()->social_icons->vk}}">
                    <span class="info_alert" id="alert_vk"></span>
                </div>
            </div>
            <div class="col-sm-2 col-xs-12">
                <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_vk">Save</button>
            </div>
            <div class="col-sm-12 col-xs-12">
                <hr>
            </div>
        </div>

        {{-- LinkedIn name--}}
        <div class="col-sm-12 col-lg-12 col-xs-12 line">
            <div class="col-sm-5 col-xs-12">
                <p class="text">
                          <span class="icon_social">
                  <i class="fab fa-linkedin"></i>
                    </span>
                    LinkedIn
                    <span class="w3-text-green"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="Update URL of your account in LinkedIn"></i></span>
                </p>

            </div>
            <div class="col-sm-5 col-xs-12">
                <div class="form-group">
                    <input type="text" class="form-control" id="linkedin" oninput="checkInput(this)"
                           value="{{Auth::user()->social_icons->linkedin}}">
                    <span class="info_alert" id="alert_linkedin"></span>
                </div>
            </div>
            <div class="col-sm-2 col-xs-12">
                <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_linkedin">Save</button>
            </div>
            <div class="col-sm-12 col-xs-12">
                <hr>
            </div>
        </div>

        {{-- Line name--}}
        <div class="col-sm-12 col-lg-12 col-xs-12 line">
            <div class="col-sm-5 col-xs-12">
                <p class="text">
                          <span class="icon_social">
             <i class="fab fa-line"></i>
                    </span>
                    Line
                    <span class="w3-text-green"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="Update ID of your account in Line"></i></span>
                </p>

            </div>
            <div class="col-sm-5 col-xs-12">
                <div class="form-group">
                    <input type="text" class="form-control" id="line" oninput="checkInput(this)"
                           value="{{Auth::user()->social_icons->line}}">
                    <span class="info_alert" id="alert_line"></span>
                </div>
            </div>
            <div class="col-sm-2 col-xs-12">
                <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_line">Save</button>
            </div>
            <div class="col-sm-12 col-xs-12">
                <hr>
            </div>
        </div>

        {{-- Pinterest name--}}
        <div class="col-sm-12 col-lg-12 col-xs-12 line">
            <div class="col-sm-5 col-xs-12">
                <p class="text">
                       <span class="icon_social">
                  <i class="fab fa-pinterest-square"></i>
                    </span>
                    Pinterest
                    <span class="w3-text-green"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="Update URL of your account in Pinterest"></i></span>
                </p>

            </div>
            <div class="col-sm-5 col-xs-12">
                <div class="form-group">
                    <input type="text" class="form-control" id="pinterest" oninput="checkInput(this)"
                           value="{{Auth::user()->social_icons->pinterest}}">
                    <span class="info_alert" id="alert_pinterest"></span>
                </div>
            </div>
            <div class="col-sm-2 col-xs-12">
                <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_pinterest">Save</button>
            </div>
            <div class="col-sm-12 col-xs-12">
                <hr>
            </div>
        </div>

    </div>
</div>