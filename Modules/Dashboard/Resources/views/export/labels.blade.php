@extends('dashboard::layouts.master')
@section('styles')


@endsection
@section('General')
    <div class="row">
        <div class="col-sm-12 col-md-10  col-xs-12">
            <h3 class="title">
                @lang('dashboard::messages.export_labels')
            </h3>
            <div id="title_shape"></div>
            <div class="insp_buttons">
                <a href="{{route("export",['id'=>Auth::id()])}}"
                   class="btn btn-warning">@lang('dashboard::messages.back_to_export_module')</a>
            </div>

            <div class="col-sm-4 col-sm-offset-1 search_block users">
                <a href="{{route('export_file',['type'=>'xls'])}}" class="text-uppercase">
                    <i class="fas fa-search"></i><br>
                    Export languages
                </a>

            </div>
        </div>
    </div>


@endsection
@section('scripts')

@endsection