@extends('dashboard::layouts.master')
@section ('styles')

@endsection
@section('scripts_header')

@stop
@section('General')
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <h3 class="title">@lang('dashboard::messages.customize_mail_template')</h3>
            <div id="title_shape"></div>
            <div class="insp_buttons">
                <a href="{{route("mail",Auth::id())}}" class="btn btn-success">@lang('messages.back_to_mail_module')</a>
                <a href="{{route("create_mail",Auth::id())}}" class="btn btn-warning">@lang('messages.create_new_email')</a>
                <a href="{{route("customize_mail_template",['id'=>Auth::id(),'template_id'=>"new"])}}" class="btn btn-info">@lang('dashboard::messages.new_template')</a>
            </div>
            @if(!empty($templates))
                <ul>
                @foreach($templates as $template)
                    <li>
                        <a href="{{route("customize_mail_template",['id'=>Auth::id(),'template_id'=>$template->id])}}">{{!empty($template->title)?$template->title:trans('messages.no_title')}}</a>
                        <a href="{{route("customize_mail_template",['id'=>Auth::id(),'template_id'=>$template->id])}}" class="btn btn-sm btn-info">@lang('dashboard::messages.customize_mail_template')</a>
                    </li>
                    @endforeach
                </ul>
                @endif
        </div>
    </div>


@stop


@section('scripts')

@stop