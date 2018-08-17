@extends('dashboard::layouts.master')
@section('styles')

@endsection
@section('General')
    <div class="row">
        <div class="col-sm-12 col-md-10  col-xs-12">
            <h3 class="title">@lang('dashboard::messages.documents')</h3>
            <div id="title_shape"></div>

            <div class="insp_buttons">
                <a href="{{route("office",['id'=>Auth::id()])}}"
                   class="btn btn-warning">@lang('dashboard::messages.back_to_office_menu')</a>
                <a href="{{route("upload_document",Auth::id())}}" class="btn btn-success">@lang('dashboard::messages.upload_new_document')</a>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-8 col-xs-12">
                </div>
                <div class="col-sm-12 col-lg-4 col-xs-12">
                    <input type="text" class="form-control" style="display: inline;" id="search_bar"
                           placeholder="@lang('messages.search')">

                </div>
                <hr>
            </div>
        </div>
    </div>


@endsection
@section('scripts')

@endsection