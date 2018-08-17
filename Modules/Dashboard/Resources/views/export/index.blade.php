@extends('dashboard::layouts.master')
@section('styles')
    <style>
        .search_main {
            padding-top: 100px;
        }

        #search_header {
            margin-bottom: 50px;
        }

        .search_block {
            border-radius: 20px;
            background-color: lightgreen;
            padding: 0px 10px 0px 10px;
            margin-bottom: 30px;
        }

        .search_block:hover {
            background-color: darkseagreen;
        }

        .search_block a {
            display: block;
            height: 200px;
            width: 100%;
            padding-top: 60px;
        }


    </style>

@endsection
@section('General')
    <div class="row">
        <div class="col-sm-12 col-md-10  col-xs-12">
            <div class="col-sm-12 col-md-12  col-xs-12">
                <h3 class="title">
                    @lang('dashboard::messages.export_module')
                </h3>
                <div id="title_shape"></div>

                <div class="insp_buttons">
                    <a href="{{route("office",['id'=>Auth::id()])}}"
                       class="btn btn-warning">@lang('dashboard::messages.back_to_office_menu')</a>
                </div>


                <div class="col-sm-12 col-md-4 col-md-offset-1  col-xs-12 text-center icon_module">
                    <a href="{{route('export_menus',['id'=>Auth::id()])}}">
                        <p class="font_icon"><i class="fas fa-bars"></i></p>
                        <span>@lang('dashboard::messages.export_menus')</span>
                    </a>
                </div>

                <div class="col-sm-12 col-md-4 col-md-offset-1   col-xs-12 text-center icon_module">
                    <a href="{{route('export_langs',['id'=>Auth::id()])}}">
                        <p>
                            <img height="100"
                                 src="{{custom_asset('images/includes/languages.png')}}" alt="">
                        </p>
                        @lang('dashboard::messages.export_langs')
                    </a>
                </div>

                <div class="col-sm-12 col-md-4 col-md-offset-1   col-xs-12 text-center icon_module">
                    <a href="{{route('export_labels',['id'=>Auth::id()])}}">
                        {{--<p><i class="fa fa-spinner w3-spin" style="font-size:64px"></i></p>--}}
                        <p class="font_icon"><i class="fas fa-tags"></i></p>
                        @lang('dashboard::messages.export_labels')
                    </a>
                </div>

                <div class="col-sm-12 col-md-4 col-md-offset-1   col-xs-12 text-center icon_module">
                    <a href="{{route('export_posts',['id'=>Auth::id()])}}">
                        {{--<p><i class="fa fa-spinner w3-spin" style="font-size:64px"></i></p>--}}
                        <p class="font_icon"><i class="fas fa-th-list"></i></p>
                        @lang('dashboard::messages.export_posts')
                    </a>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    <script src="{{asset('js/app.js')}}"></script>
@endsection