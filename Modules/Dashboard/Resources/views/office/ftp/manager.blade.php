@extends('dashboard::layouts.master')

@section('General')
    <div class="row">
        <div class="col-sm-12 col-md-10  col-xs-12">
            <div class="col-sm-12 col-md-12  col-xs-12">
                <h3 class="title">@lang('dashboard::messages.ftp_manager')</h3>
                <div id="title_shape"></div>

                <div class="insp_buttons">
                    <a href="{{route("office",['id'=>Auth::id()])}}" class="btn btn-warning">@lang('dashboard::messages.back_to_office_menu')</a>
                </div>


                <div class="col-sm-12 col-md-3 col-md-offset-1  col-xs-12 text-center icon_module">
                    <a href="{{route('office_ftp_content',['id'=>Auth::id()])}}">
                        <p>
                            <img  height="100"
                                 src="{{custom_asset('images/includes/ftp.png')}}" alt="">
                        </p>
                        <span>@lang('dashboard::messages.ftp_browser')</span>
                    </a>
                </div>
                <div class="col-sm-12 col-md-3 col-md-offset-1   col-xs-12 text-center icon_module">
                    <a href="{{route('office_ftp_connection',['id'=>Auth::id()])}}">
                        {{--<p><i class="fa fa-spinner w3-spin" style="font-size:64px"></i></p>--}}
                        <p class="font_icon"><i class="fas fa-wrench"></i></p>
                        @lang('dashboard::messages.ftp_update_credentials')
                    </a>
                </div>

                @if(Auth::user()->admin==1)
                    <div class="col-sm-12 col-md-3 col-md-offset-1 col-xs-12 text-center icon_module">
                        <a href="{{route('office_ftp_connection_admin',['id'=>Auth::id()])}}">
                            <p class="font_icon"><i class="fas fa-cogs"></i></p>
                            @lang('dashboard::messages.ftp_update_credentials_admin')
                        </a>
                    </div>
                @endif
            </div>

        </div>

    </div>
@stop
