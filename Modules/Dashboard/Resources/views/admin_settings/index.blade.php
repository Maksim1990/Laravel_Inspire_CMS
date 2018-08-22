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
                    <button class="btn btn-sm btn-success" style="margin-top: 2px;"
                            id="save_app_version">@lang('messages.save')</button>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <hr>
                </div>
            </div>


            {{-- Use remote server --}}
            <div class="col-sm-12 col-lg-12 col-xs-12">
                <div class="col-sm-5 col-xs-12">
                    <p class="text">@lang('dashboard::messages.use_remote_server')</p>

                </div>
                <div class="col-sm-5 hidden-lg hidden-sm col-xs-12">
                </div>
                <div class="col-sm-1 col-xs-12">
                    <div class="form-group" style="margin-top: 15px;">
                        @php
                            $strChecked="";
                            if($adminSettings->use_remote_server=='Y'){
                             $strChecked="checked";
                            }
                        @endphp
                        <div class="material-switch pull-right">
                            <input id="use_remote_server" name="use_remote_server" type="checkbox" {{$strChecked}}/>
                            <label for="use_remote_server" class="label-success"></label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <hr>
                </div>
            </div>

            {{-- Remote server --}}
            <div class="col-sm-12 col-lg-12 col-xs-12" id="remote_server_block" style="display:none;">
                <div class="col-sm-5 col-xs-12">
                    <p class="text">@lang('dashboard::messages.remote_server')</p>

                </div>
                <div class="col-sm-5 col-xs-12">
                    <div class="form-group">
                        <input type="text" class="form-control" id="remote_server"
                               value="{{$adminSettings->remote_server}}">
                    </div>
                </div>
                <div class="col-sm-2 col-xs-12">
                    <button class="btn btn-sm btn-success" style="margin-top: 2px;"
                            id="save_remote_server">@lang('messages.save')</button>
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
                    <button class="btn btn-sm btn-success" style="margin-top: 2px;"
                            id="save_reset_cache">@lang('messages.save')</button>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <hr>
                </div>
            </div>


            {{-- Use Elasticsearch --}}
            <div class="col-sm-12 col-lg-12 col-xs-12">
                <div class="col-sm-5 col-xs-12">
                    <p class="text">@lang('dashboard::messages.use_elasticsearch')
                        <img height="30" data-toggle="tooltip" data-placement="right"
                             title="Elasticsearch functionality"
                             src="{{custom_asset('images/includes/elastic-elasticsearch.svg')}}" alt="" align="top">
                    </p>
                </div>
                <div class="col-sm-5 hidden-lg hidden-sm col-xs-12">
                </div>
                <div class="col-sm-1 col-xs-12">
                    <div class="form-group" style="margin-top: 15px;">
                        @php
                            $strChecked="";
                            if($adminSettings->use_elasticsearch=='Y'){
                             $strChecked="checked";
                            }
                        @endphp
                        <div class="material-switch pull-right">
                            <input id="use_elasticsearch" name="use_elasticsearch" type="checkbox" {{$strChecked}}/>
                            <label for="use_elasticsearch" class="label-success"></label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12">
                    <hr>
                </div>
            </div>



            <div class="col-sm-12 col-lg-12 col-xs-12" id="elasticsearch_block"  style="display:none;">
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
                            <select name="elastic_user_id_update" class="form-control" id="elastic_user_id_update"
                                    style="height: 35px;">
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
                        <button class="btn btn-sm btn-success" style="margin-top: 2px;"
                                id="save_elastic_update">@lang('messages.save')</button>
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
                            <select name="elastic_model_remove" class="form-control" id="elastic_model_remove"
                                    style="height: 35px;">
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
                            <select name="elastic_user_id_update_remove" class="form-control"
                                    id="elastic_user_id_update_remove" style="height: 35px;">
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
                        <button class="btn btn-sm btn-success" style="margin-top: 2px;"
                                id="save_elastic_remove">@lang('messages.save')</button>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <hr>
                    </div>
                </div>
            </div>


            {{-- Use admin FTP credentials--}}
            <div class="col-sm-12 col-lg-12 col-xs-12">
                <div class="col-sm-5 col-xs-12">
                    <p class="text">@lang('dashboard::messages.use_admin_ftp_credentials')</p>

                </div>
                <div class="col-sm-5 hidden-lg hidden-sm col-xs-12">
                </div>
                <div class="col-sm-1 col-xs-12">
                    <div class="form-group" style="margin-top: 15px;">
                        @php
                            $strChecked="";
                            if(Auth::user()->admin_setting->use_admin_ftp_credentials=='Y'){
                             $strChecked="checked";
                            }
                        @endphp
                        <div class="material-switch pull-right">
                            <input id="admin_frp_credentials" name="admin_frp_credentials"
                                   type="checkbox" {{$strChecked}}/>
                            <label for="admin_frp_credentials" class="label-success"></label>
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
@section('Menu_icons')
    @include('dashboard::admin_settings.menu_icons')
@stop

@section('scripts')
    @include('dashboard::admin_settings.scripts')
@stop