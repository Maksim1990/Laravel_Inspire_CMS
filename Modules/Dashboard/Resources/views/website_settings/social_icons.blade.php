<div class="row maintab">
    <div class="col-sm-12  col-xs-12">
        <div>
            <h3 class="title">@lang('messages.website_social_networks_settings')</h3>
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
                <span class="w3-text-green"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="@lang('messages.update') GitHub URL"></i></span>
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
                <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_github">@lang('messages.save')</button>
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
                    <span class="w3-text-green"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="@lang('messages.update') Google URL"></i></span>
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
                <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_google">@lang('messages.save')</button>
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
                    <span class="w3-text-green"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="@lang('messages.update') Instagram ID"></i></span>
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
                <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_instagram">@lang('messages.save')</button>
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
                    <span class="w3-text-green"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="@lang('messages.update') Facebook URL"></i></span>
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
                <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_facebook">@lang('messages.save')</button>
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
                    <span class="w3-text-green"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="@lang('messages.update') Twitter URL"></i></span>
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
                <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_twitter">@lang('messages.save')</button>
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
                    <span class="w3-text-green"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="@lang('messages.update') VK URL"></i></span>
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
                <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_vk">@lang('messages.save')</button>
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
                    <span class="w3-text-green"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="@lang('messages.update') LinkedIn URL"></i></span>
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
                <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_linkedin">@lang('messages.save')</button>
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
                    <span class="w3-text-green"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="@lang('messages.update') Line ID"></i></span>
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
                <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_line">@lang('messages.save')</button>
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
                    <span class="w3-text-green"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="@lang('messages.update') Pinterest URL"></i></span>
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
                <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_pinterest">@lang('messages.save')</button>
            </div>
            <div class="col-sm-12 col-xs-12">
                <hr>
            </div>
        </div>

    </div>
</div>