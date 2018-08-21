@section('Settings')
    <div class="row maintab">
        <div class="col-sm-12 col-lg-12 col-xs-12">
            <div>
                <h3 class="title">@lang('messages.website_settings')</h3>
                <div id="title_shape"></div>
            </div>
            {{-- Website name--}}
            <div class="col-sm-12 col-lg-12 col-xs-12">
                <div class="col-sm-5 col-xs-12">
                    <p class="text">@lang('dashboard::messages.website_name')</p>

                </div>
                <div class="col-sm-5 col-xs-12">
                    <div class="form-group">
                        <input type="text" class="form-control" id="website_name"
                               value="{{Auth::user()->website_setting->website_name}}">
                    </div>
                </div>
                <div class="col-sm-2 col-xs-12">
                    <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_website_name">@lang('messages.save')</button>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <hr>
                </div>
            </div>


            {{-- Email form--}}
            <div class="col-sm-12 col-lg-12 col-xs-12">
                <div class="col-sm-5 col-xs-12">
                    <p class="text">@lang('dashboard::messages.show_email_form_on_the_page')</p>

                </div>
                <div class="col-sm-5 hidden-lg hidden-sm col-xs-12">
                </div>
                <div class="col-sm-1 col-xs-12">
                    <div class="form-group" style="margin-top: 15px;">
                        @php
                            $strChecked="";
                            if(Auth::user()->website_setting->email_form=='Y'){
                             $strChecked="checked";
                            }
                        @endphp
                        <div class="material-switch pull-right" >
                            <input id="website_email_form" name="website_email_form" type="checkbox" {{$strChecked}}/>
                            <label for="website_email_form" class="label-success"></label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <hr>
                </div>
            </div>

            {{-- Go to the top button--}}
            <div class="col-sm-12 col-lg-12 col-xs-12">
                <div class="col-sm-5 col-xs-12">
                    <p class="text">@lang('dashboard::messages.show_go_to_the_top_button')</p>

                </div>
                <div class="col-sm-5 hidden-lg hidden-sm col-xs-12">
                </div>
                <div class="col-sm-1 col-xs-12">
                    <div class="form-group" style="margin-top: 15px;">
                        @php
                            $strChecked="";
                            if(Auth::user()->website_setting->go_top_button=='Y'){
                             $strChecked="checked";
                            }
                        @endphp
                        <div class="material-switch pull-right" >
                            <input id="website_go_to_the_top" name="website_go_to_the_top" type="checkbox" {{$strChecked}}/>
                            <label for="website_go_to_the_top" class="label-success"></label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <hr>
                </div>
            </div>

            {{-- Show posts page--}}
            <div class="col-sm-12 col-lg-12 col-xs-12">
                <div class="col-sm-5 col-xs-12">
                    <p class="text">@lang('dashboard::messages.show_posts_page')</p>

                </div>
                <div class="col-sm-5 hidden-lg hidden-sm col-xs-12">
                </div>
                <div class="col-sm-1 col-xs-12">
                    <div class="form-group" style="margin-top: 15px;">
                        @php
                            $strChecked="";
                            if(Auth::user()->website_setting->posts_page=='Y'){
                             $strChecked="checked";
                            }
                        @endphp
                        <div class="material-switch pull-right" >
                            <input id="website_posts_page" name="website_posts_page" type="checkbox" {{$strChecked}}/>
                            <label for="website_posts_page" class="label-success"></label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <hr>
                </div>
            </div>

            {{-- Show Google map on the page --}}
            <div class="col-sm-12 col-lg-12 col-xs-12">
                <div class="col-sm-5 col-xs-12">
                    <p class="text">@lang('dashboard::messages.show_google_map')</p>

                </div>
                <div class="col-sm-5 hidden-lg hidden-sm col-xs-12">
                </div>
                <div class="col-sm-1 col-xs-12">
                    <div class="form-group" style="margin-top: 15px;">
                        @php
                            $strChecked="";
                            if(Auth::user()->website_setting->google_map=='Y'){
                             $strChecked="checked";
                            }
                        @endphp
                        <div class="material-switch pull-right" >
                            <input id="website_google_map" name="website_google_map" type="checkbox" {{$strChecked}}/>
                            <label for="website_google_map" class="label-success"></label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <hr>
                </div>
            </div>


            {{-- Google map key --}}
            <div class="col-sm-12 col-lg-12 col-xs-12" id="google_maps_block" style="display:none;">
                <div class="col-sm-5 col-xs-12">
                    <p class="text">@lang('dashboard::messages.google_map_key')</p>

                </div>
                <div class="col-sm-5 col-xs-12">
                    <div class="form-group">
                        <input type="text" class="form-control" id="website_google_map_key"
                               value="{{Auth::user()->website_setting->google_map_key}}">
                    </div>
                </div>
                <div class="col-sm-2 col-xs-12">
                    <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_website_google_map_key">@lang('messages.save')</button>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <hr>
                </div>
            </div>


        </div>
    </div>
@stop
@section('Social')
    @include('dashboard::website_settings.social_icons')
@stop
