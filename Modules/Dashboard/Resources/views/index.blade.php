@extends('dashboard::layouts.master')
@section('styles')
    <style>
        form {
            display: inline;
        }
    </style>
@stop
@section('General')
    <h3 class="title">@lang('messages.dashboard')</h3>
    <div id="title_shape"></div>
    <div class="w3-row">
        <!-- Page Container -->
        <div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">
            <!-- The Grid -->
            <div class="w3-row">
                <!-- Left Column -->
                <div class="w3-col m3">
                    <!-- Profile -->
                    <div class="w3-card w3-round w3-white">
                        <div class="w3-container">
                            <h4 class="w3-center">@lang('messages.my_profile')</h4>
                            <p class="w3-center">
                                <img height="150"
                                     src="{{Auth::user()->image ? Auth::user()->image->full_path : custom_asset("images/includes/noimage.png")}}"
                                     alt="">
                            </p>
                            <hr>
                            <p><a href="{{route('profile',['id'=>Auth::id()])}}"><i
                                            class="fas fa-user w3-margin-right w3-text-theme"></i> {{Auth::user()->name}}
                                </a></p>
                            <p><i class="fas fa-at w3-margin-right w3-text-theme"></i> {{Auth::user()->email}}</p>
                            <p>@lang('profile::messages.registered')<br> {{Auth::user()->created_at->diffForHumans()}}</p>
                        </div>
                    </div>
                    <br>

                    <!-- Accordion -->
                    <div class="w3-card w3-round">
                        <div class="w3-white" style="padding-bottom: 20px;padding-left: 40px;">
                            <a href="{{route('profile_settings',['id'=>Auth::id()])}}">
                                <i class="fas fa-user-edit fa-fw w3-margin-right w3-margin-top"></i> @lang('profile::messages.edit_profile')
                            </a><br>
                            <a href="{{route('change_password',['id'=>Auth::id()])}}">
                                <i class="fas fa-key fa-fw w3-margin-right w3-margin-top"></i> @lang('profile::messages.change_password')
                            </a><br>
                        </div>
                    </div>
                    <br>
                </div>

                <!-- Middle Column -->
                <div class="w3-col m7">

                    <div class="w3-row-padding w3-margin-bottom">
                        <div class="w3-col m12">
                            <div class="w3-card w3-round w3-white">
                                <div class="w3-container w3-padding">
                                    <h6 class="w3-opacity">@lang('messages.change_name_of_site')</h6>
                                    <input type="text" style="width: 80%;" class="form-control" id="website_name"
                                           value="{{Auth::user()->website_setting->website_name}}">
                                    <button type="button" class="w3-button btn-success"
                                            id="save_website_name">@lang('messages.save')</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w3-row-padding  w3-margin-bottom">
                        <div class="w3-col m12">
                            <div class="w3-card w3-round w3-white">
                                <div class="w3-container">
                                    <p><a href="{{route('pagebuilder_order',['id'=>Auth::id()])}}">@lang('messages.active_website_blocks')</a></p>
                                    <p>
                                        @if(!empty($allUserBlocks))
                                            @foreach($allUserBlocks as $block)
                                                <span class="w3-tag w3-small w3-theme-d5">{{$block->block_custom_id}}</span>
                                            @endforeach
                                        @else
                                            No blocks found!
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w3-row-padding  ">
                        <div class="w3-col m6 w3-margin-bottom">
                            <div class="w3-card w3-round w3-white w3-center w3-margin-bottom">
                                <div class="w3-container">
                                    <p>@lang('profile::messages.edit_profile')</p>
                                    <div class="w3-row w3-opacity">
                                        <div class="w3-half">
                                            <a href="{{route('profile_settings',['id'=>Auth::id()])}}"
                                               class="w3-button w3-block w3-green w3-section">Update</a>
                                        </div>
                                        <div class="w3-half">
                                            <a href="#" class="w3-button w3-block w3-red w3-section" data-toggle="modal"
                                               data-target="#delete_profile">@lang('messages.delete')</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w3-card w3-round w3-white w3-padding-32 w3-center">
                                <a href="{{route('mail',['id'=>Auth::id()])}}">
                                    <p style="font-size:45px;">
                                        <img width="100" src="{{custom_asset("images/includes/mail.png")}}" alt="">
                                    </p>
                                    <p class="w3-xxlarge">@lang('messages.mail_box')</p>
                                </a>
                            </div>
                        </div>

                        <div class="w3-col m6 w3-margin-bottom">
                            <div class="w3-card w3-round w3-white w3-margin-bottom">
                                <div class="w3-container">
                                    <a href="{{route('label',['id'=>Auth::id()])}}">
                                    <p>@lang('messages.labels_management')</p>
                                    <p>
                                        @if(!empty($translations))
                                            @foreach($translations as $label)
                                                <span class="w3-tag w3-small w3-theme-d5">{{$label->key}}</span>
                                            @endforeach
                                        @endif
                                    </p>
                                    </a>
                                </div>
                            </div>

                            <div class="w3-card w3-round w3-white w3-padding-32 w3-center">
                                <a href="{{route('office',['id'=>Auth::id()])}}">
                                    <p style="font-size:45px;">
                                        <img width="100" src="{{custom_asset("images/includes/office.png")}}" alt="">
                                    </p>
                                    <p class="w3-xxlarge">@lang('messages.office')</p>
                                </a>
                            </div>
                            <br>
                        </div>
                    </div>
                    <!-- End Middle Column -->
                </div>

                <!-- Right Column -->
                <div class="w3-col m2">
                    <div class="w3-card w3-round w3-white w3-center w3-padding-32">
                        <div class="w3-container">
                            <a href="{{route('pagebuilder_index',['id'=>Auth::id()])}}">
                                <p style="font-size:45px;">
                                    <img width="100" src="{{custom_asset("images/includes/page.png")}}" alt="">
                                </p>
                                <p class="w3-large">@lang('messages.pagebuilder')</p>
                            </a>
                        </div>
                    </div>
                    <br>

                    <div class="w3-card w3-round w3-white w3-center">
                        <div class="w3-container">
                            <a href="{{URL::to('/'.LaravelLocalization::getCurrentLocale())}}">
                                <p style="font-size:45px;">
                                    <img width="100" src="{{custom_asset("images/includes/inspire_grey.png")}}" alt="">
                                </p>
                                <p class="w3-large">INSPIRE CMS</p>
                            </a>
                        </div>
                    </div>
                    <br>

                    <div class="w3-card w3-round w3-white w3-hide-small">
                        <div class="w3-container">
                            <p>
                                <a href="{{route('languages',['id'=>Auth::id()])}}">@lang('messages.active_languages')</a></p>
                            <p>
                                @foreach($arrOfActiveLanguages as $strKey=>$strLang)
                                    <span class="w3-tag w3-small w3-theme-d5">{{$strLang}}</span>
                                @endforeach
                            </p>
                        </div>
                    </div>

                    <!-- End Right Column -->
                </div>

                <!-- End Grid -->
            </div>

            <!-- End Page Container -->
        </div>


        {{--Delete profile modal--}}
        <div class="modal" id="delete_profile">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('profile::messages.want_delete_profile')</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <p class="confirm_info">
                            @lang('profile::messages.all_relevant_data_will_be_deleted')
                        </p>
                        <button type="button" class="btn btn-success"
                                data-dismiss="modal"> @lang('messages.cancel')</button>
                        @if(Auth::id()==$user->id)
                            {!! Form::close() !!}
                            {{ Form::open(['method' =>'DELETE' ,'class'=>'deleteProfile', 'action' => ['\Modules\Profile\Http\Controllers\ProfileController@deleteProfile',$user->id]])}}
                            <input type="hidden" name="user_id" value="{{Auth::id()}}">
                            {!! Form::submit( trans('profile::messages.delete_profile'),['class'=>'btn btn-danger delete_profile']) !!}

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
            <script>
                var token = '{{\Illuminate\Support\Facades\Session::token()}}';

                $('#save_website_name').click(function () {
                    var url = '{{ route('ajax_website_name_update') }}';
                    var website_name = $('#website_name').val();
                    $.ajax({
                        method: 'POST',
                        url: url,
                        dataType: "json",
                        data: {
                            website_name: website_name,
                            _token: token
                        }, beforeSend: function () {
                            //-- Show loading image while execution of ajax request
                            $("div#divLoading").addClass('show');
                        },
                        success: function (data) {
                            if (data['result'] === "success") {
                                new Noty({
                                    type: 'success',
                                    layout: 'topRight',
                                    text: '{{trans('dashboard::messages.website_name_updated')}}!'
                                }).show();
                            }
                            //-- Hide loading image
                            $("div#divLoading").removeClass('show');
                        }
                    });
                });


            </script>
@stop
