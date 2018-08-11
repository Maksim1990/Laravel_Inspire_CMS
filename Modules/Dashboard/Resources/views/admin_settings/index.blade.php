@extends('dashboard::layouts.master')

@section('General')
    <div class="row maintab">
        <div class="col-sm-12 col-lg-12 col-xs-12">
            <div>
                <h3 class="title">Admin settings</h3>
                <div id="title_shape"></div>
            </div>
            {{-- Website name--}}
            <div class="col-sm-12 col-lg-12 col-xs-12">
                <div class="col-sm-5 col-xs-12">
                    <p class="text">Application version</p>

                </div>
                <div class="col-sm-5 col-xs-12">
                    <div class="form-group">
                        <input type="text" class="form-control" id="website_name"
                               value="{{Auth::user()->website_setting->website_name}}">
                    </div>
                </div>
                <div class="col-sm-2 col-xs-12">
                    <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_website_name">Save</button>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <hr>
                </div>
            </div>


            {{-- Reset Cache form--}}
            <div class="col-sm-12 col-lg-12 col-xs-12">
                <div class="col-sm-5 col-xs-12">
                    <p class="text">Reset cache for specific user</p>

                </div>
                <div class="col-sm-5 col-xs-12">
                    <div class="form-group">
                        <input type="text" class="form-control" id="reset_cache"
                               value="">
                    </div>
                </div>
                <div class="col-sm-2 col-xs-12">
                    <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_reset_cache">Save</button>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <hr>
                </div>
            </div>

            {{-- Email form--}}
            <div class="col-sm-12 col-lg-12 col-xs-12">
                <div class="col-sm-5 col-xs-12">
                    <p class="text">Show email form on the page</p>

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


        </div>
    </div>
@stop

@section('scripts')
    @include('dashboard::admin_settings.scripts')
@stop