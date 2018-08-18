@extends('pagebuilder::layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{custom_asset('plugins/vendor/colpick-master/css/colpick.css')}}">
    <script src="{{custom_asset('plugins/vendor/colpick-master/js/colpick.js')}}"></script>
@stop
@section('scripts_header')

@stop
@section('General')

    <div class="row maintab">
        <div class="col-sm-12 col-lg-12 col-xs-12">
            <div class="col-sm-8 col-lg-8 col-xs-12">
                <div>
                    <h3 class="title">@lang('pagebuilder::messages.background')</h3>
                    <div id="title_shape"></div>
                </div>
                <div class="insp_buttons">
                    <a href="{{route("pagebuilder_index",['id'=>Auth::id()])}}"
                       class="btn btn-warning">@lang('pagebuilder::messages.back_to_pagebuilder')</a>
               </div>
                {{-- Website name--}}
                @php
                    $strDisplay="none";
                    if(!empty($blockBackground) && $blockBackground->background_type=='color'){
                     $strChecked="block";
                    }
                @endphp
                <div class="col-sm-12 col-lg-12 col-xs-12" id="background_color_block" style="display:{{$strDisplay}};">
                    <div class="col-sm-5 col-xs-12">
                        <p class="text">@lang('pagebuilder::messages.background_color')</p>

                    </div>
                    <div class="col-sm-5 col-xs-12">
                        <div class="form-group">
                            <p>
                                <input type="hidden" id="block_id" value="{{$block_id}}">
                                <input type="hidden" id="background_type"
                                       value="{{(!empty($blockBackground) && $blockBackground->background_type=='image')?'image':'color'}}">
                                @php
                                    $strColor="";
                                    if(!empty($blockBackground) && !empty($strColor=$blockBackground->color)){
                                    $strColor=$blockBackground->color;
                                    }
                                @endphp
                                <input type="color" style="margin-top: 10px;" id="bg_color" value="{{$strColor}}">
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-12">
                        <button class="btn btn-sm btn-success" style="margin-top: 2px;"
                                id="save_bg_color">@lang('messages.save')</button>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <hr>
                    </div>
                </div>

                {{-- Use image background --}}
                <div class="col-sm-12 col-lg-12 col-xs-12">
                    <div class="col-sm-5 col-xs-12">
                        <p class="text">@lang('pagebuilder::messages.use_image_background')</p>

                    </div>
                    <div class="col-sm-5 hidden-lg hidden-sm col-xs-12">
                    </div>
                    <div class="col-sm-1 col-xs-12">
                        <div class="form-group" style="margin-top: 15px;">
                            @php
                                $strChecked="";
                                if(!empty($blockBackground) && $blockBackground->background_type=='image'){
                                 $strChecked="checked";
                                }
                            @endphp
                            <div class="material-switch pull-right">
                                <input id="background_image" name="background_image" type="checkbox" {{$strChecked}}/>
                                <label for="background_image" class="label-success"></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <hr>
                    </div>
                </div>

                {{-- Use background block --}}
                @php
                    $strDisplay="none";
                    if(!empty($blockBackground) && $blockBackground->background_type=='image'){
                     $strChecked="block";
                    }
                @endphp
                <div class="col-sm-12 col-lg-12 col-xs-12" id="background_image_block" style="display:{{$strDisplay}};">

                    <div class="col-sm-7 col-xs-12">
                        <div class="form-group" style="margin-top: 15px;">
                            <a href="#" id="upload_image" class="btn btn-warning w3-margin-bottom">@lang('pagebuilder::messages.upload_image')</a>
                            @php
                                $strButtonName=trans('pagebuilder::messages.insert_image');
                                if(!empty($blockBackground) && !empty($blockBackground->image_path)){
                                 $strButtonName=trans('pagebuilder::messages.change_image');
                                }
                            @endphp
                            <a href="#" class="btn btn-info w3-margin-bottom" data-toggle="modal"
                               data-target="#image_modal">{{$strButtonName}}</a>
                            @php
                                $strDisplayDeleteButton="none";
                                if(!empty($blockBackground) && !empty($blockBackground->image_path)){
                                 $strDisplayDeleteButton="inline";
                                }
                            @endphp
                            <span style="display:{{$strDisplayDeleteButton}};" id="delete_image_button">
                                <a href="#" class="btn btn-danger w3-margin-bottom" data-toggle="modal"
                                   data-target="#delete_image">@lang('pagebuilder::messages.background_image_delete')</a>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-5 col-xs-12">
                        <div id="used_block_image">
                            @if(!empty($blockBackground) && !empty($blockBackground->image_path))
                                <img src="{{custom_asset("storage/".$blockBackground->image_path)}}"
                                     class="w3-border w3-hover-opacity" style="width:100%">
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <hr>
                    </div>
                </div>

                <div class="col-sm-12 col-lg-12 col-xs-12" id="background_image_upload_block" style="display:none;">

                    <div class="col-sm-7 col-xs-12">
                        {{ Form::model(Auth::user(), ['method' =>'PATCH' , 'action' => ['\Modules\Pagebuilder\Http\Controllers\PagebuilderController@storeBackgroundImage',Auth::id()],'files'=>true])}}
                        <input type="hidden" name="user_id" value="{{Auth::id()}}">
                        <input type="hidden" name="block_id" value="{{$block_id}}">
                        <div class="group-form">
                            {!! Form::label('photo_id',trans('messages.image').':') !!}
                            {!! Form::file('photo_id') !!}
                        </div>

                        <br>
                        {!! Form::submit('Upload image',['class'=>'btn btn-warning']) !!}
                    </div>

                    <div class="col-sm-12 col-xs-12">
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--Images modal--}}
    <div class="modal" id="image_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h3 class="title">@lang('pagebuilder::messages.select_image')</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="row">
                        <div class="row w3-margin-left">
                            @if(count($userImages)>0)
                                @foreach($userImages as $image)
                                    <a class="insert_image" data-toggle="modal"
                                       data-target="#image_modal_{{$image->id}}" data-path="{{$image->path}}">
                                        <img src="{{custom_asset("storage/".$image->path)}}" width="100" height="100"
                                             class="w3-border w3-hover-opacity">
                                    </a>
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('messages.close')</button>
                </div>
            </div>
        </div>
    </div>

    {{--Delete background image modal--}}
    <div class="modal" id="delete_image">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">@lang('pagebuilder::messages.background_want_delete')</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <p class="confirm_info">
                    </p>
                    <button type="button" class="btn btn-success" data-dismiss="modal">@lang('messages.cancel')</button>
                    @if(!empty($blockBackground) && Auth::id()==$blockBackground->user_id)
                        {!! Form::close() !!}
                        {{ Form::open(['method' =>'DELETE' ,'class'=>'deleteProfile', 'style'=>'display:inline;', 'action' => ['\Modules\Pagebuilder\Http\Controllers\PagebuilderController@deleteBackgroundImage',Auth::id()]])}}
                        <input type="hidden" name="user_id" value="{{Auth::id()}}">
                        <input type="hidden" name="block_id" value="{{$block_id}}">
                        {!! Form::submit(trans('pagebuilder::messages.background_image_delete'),['class'=>'btn btn-danger delete_image']) !!}

                        {!! Form::close() !!}
                    @endif
                </div>

                <!-- Modal footer -->
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    @include('pagebuilder::css.bg_scripts')
@stop
