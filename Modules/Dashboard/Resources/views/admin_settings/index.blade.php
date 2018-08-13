@extends('dashboard::layouts.master')

@section('General')
    <div class="row maintab">
        <div class="col-sm-12 col-lg-12 col-xs-12">
            <div class="alert alert-danger" role="alert" id="alert_settings" style="display:none;"></div>
            <div>
                <h3 class="title">@lang('messages.admin_settings')</h3>
                <div id="title_shape"></div>
            </div>
            {{-- Website name--}}
            <div class="col-sm-12 col-lg-12 col-xs-12">
                <div class="col-sm-5 col-xs-12">
                    <p class="text">@lang('dashboard::messages.app_version')</p>

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
                    <p class="text">@lang('dashboard::messages.reset_cache_for_specific_user')</p>

                </div>
                <div class="col-sm-5 col-xs-12">
                    <div class="form-group">
                        <select name="reset_cache" class="form-control" id="reset_cache" style="height: 35px;">
                            <option value="0"></option>
                            @if(!empty($users))
                                @foreach($users as $intId=>$strName)
                                    <option value="{{$intId}}">{{$strName}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-sm-2 col-xs-12">
                    <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_reset_cache">@lang('messages.save')</button>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <hr>
                </div>
            </div>

            {{-- Update Elastic search index --}}
            <div class="col-sm-12 col-lg-12 col-xs-12">
                <div class="col-sm-6 col-xs-12">
                    <p class="text">@lang('dashboard::messages.map_data_to_elasticsearch')</p>

                </div>
                <div class="col-sm-2 col-xs-12">
                    <div class="form-group">
                        <select name="elastic_model" class="form-control" id="elastic_model" style="height: 35px;">
                            <option value="0"></option>
                            @if(!empty($arrElasticSearch))
                            @foreach($arrElasticSearch as $intKey=>$strModule)
                            <option value="{{$intKey}}">{{$strModule}}</option>
                                @endforeach
                                @endif
                        </select>
                    </div>
                </div>
                <div class="col-sm-2 col-xs-12">
                    <div class="form-group">
                        <select name="elastic_user_id_update" class="form-control" id="elastic_user_id_update" style="height: 35px;">
                            <option value="0"></option>
                            @if(!empty($users))
                                @foreach($users as $intId=>$strName)
                                    <option value="{{$intId}}">{{$strName}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-sm-2 col-xs-12">
                    <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_elastic_update">@lang('messages.save')</button>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <hr>
                </div>
            </div>

            {{-- Remove Elastic search index --}}
            <div class="col-sm-12 col-lg-12 col-xs-12">
                <div class="col-sm-6 col-xs-12">
                    <p class="text">@lang('dashboard::messages.remove_elasticsearch_index')</p>

                </div>
                <div class="col-sm-2 col-xs-12">
                    <div class="form-group">
                        <select name="elastic_model_remove" class="form-control" id="elastic_model_remove" style="height: 35px;">
                            <option value="0"></option>
                            @if(!empty($arrElasticSearch))
                                @foreach($arrElasticSearch as $intKey=>$strModule)
                                    <option value="{{$intKey}}">{{$strModule}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-sm-2 col-xs-12">
                    <div class="form-group">
                        <select name="elastic_user_id_update_remove" class="form-control" id="elastic_user_id_update_remove" style="height: 35px;">
                            <option value="0"></option>
                            @if(!empty($users))
                                @foreach($users as $intId=>$strName)
                                    <option value="{{$intId}}">{{$strName}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-sm-2 col-xs-12">
                    <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_elastic_remove">@lang('messages.save')</button>
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