@extends('dashboard::layouts.master')
@section('styles')

@endsection
@section('General')
    <div class="row">
        <div class="col-sm-12 col-md-10  col-xs-12">
            <div class="col-sm-12 col-md-12  col-xs-12">
                <h3 class="title">
                    @lang('dashboard::messages.import_module')
                </h3>
                <div id="title_shape"></div>

                <div class="insp_buttons">
                    <a href="{{route("office",['id'=>Auth::id()])}}"
                       class="btn btn-warning">@lang('dashboard::messages.back_to_office_menu')</a>
                </div>
                <div class="col-sm-12 col-md-3 col-md-offset-1  col-xs-12 text-center icon_module">
                    <a href="{{route('import_page',['id'=>Auth::id(),'type'=>'langs'])}}" >
                        <p class="font_icon"><i class="fas fa-file-alt"></i></p>
                        <span>@lang('dashboard::messages.import_languages')</span>
                    </a>
                </div>

                <div class="col-sm-12 col-md-3 col-md-offset-1  col-xs-12 text-center icon_module">
                    <a href="{{route('import_page',['id'=>Auth::id(),'type'=>'labels'])}}" >
                        <p class="font_icon"><i class="fas fa-file-alt"></i></p>
                        <span>@lang('dashboard::messages.import_labels')</span>
                    </a>
                </div>

            </div>
        </div>
    </div>


@endsection
@section('scripts')

@endsection