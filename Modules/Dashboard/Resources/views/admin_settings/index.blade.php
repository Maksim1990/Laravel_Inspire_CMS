@extends('dashboard::layouts.master')

@section('General')
    <div class="row maintab">
        <div class="col-sm-12 col-lg-12 col-xs-12">
            <div>
                <h3 class="title">@lang('messages.admin_settings')</h3>
                <div id="title_shape"></div>
            </div>
            {{-- Website name--}}
            <div class="col-sm-12 col-lg-12 col-xs-12">
                <div class="col-sm-5 col-xs-12">
                    <p class="text">@lang('messages.app_version')</p>

                </div>
                <div class="col-sm-5 col-xs-12">
                    <div class="form-group">
                        <input type="text" class="form-control" id="app_version"
                               value="{{$adminSettings->app_version}}">
                    </div>
                </div>
                <div class="col-sm-2 col-xs-12">
                    <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_app_version">@lang('messages.save')</button>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <hr>
                </div>
            </div>


            {{-- Reset Cache form--}}
            <div class="col-sm-12 col-lg-12 col-xs-12">
                <div class="col-sm-5 col-xs-12">
                    <p class="text">@lang('messages.reset_cache_for_specific_user')</p>

                </div>
                <div class="col-sm-5 col-xs-12">
                    <div class="form-group">
                        <input type="text" class="form-control" id="reset_cache"
                               value="">
                    </div>
                </div>
                <div class="col-sm-2 col-xs-12">
                    <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_reset_cache">@lang('messages.save')</button>
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