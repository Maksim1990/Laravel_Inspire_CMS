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
                    <li style="height: 70px;">
                        <a href="{{route("customize_mail_template",['id'=>Auth::id(),'template_id'=>$template->id])}}" style="display:inline-block;width: 250px;">{{!empty($template->title)?$template->title:trans('messages.no_title')}}</a>
                        <a href="{{route("customize_mail_template",['id'=>Auth::id(),'template_id'=>$template->id])}}" style="display:inline-block;width: 200px;margin-right: 10%;" class="btn btn-sm btn-info">@lang('dashboard::messages.customize_mail_template')</a>
                       @php
                       $strChecked="";
                       if($template->active=="Y"){
                       $strChecked="checked";
                       }
                       @endphp
                        <input type="radio" name="email_active"  {{$strChecked}} onclick="ChangeActiveTemplate('{{$template->id}}')">
                        <span class="checkmark"></span>
                    </li>
                    @endforeach
                </ul>
                @endif
        </div>
    </div>


@stop


@section('scripts')
    <script>
        var token = '{{\Illuminate\Support\Facades\Session::token()}}';
       function ChangeActiveTemplate(id) {

           var url = '{{ route('ajax_mail_template_active_update') }}';

           $.ajax({
               method: 'POST',
               url: url,
               dataType: "json",
               data: {

                   template_id: id,
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
                           text: '{{trans('dashboard::messages.mail_template_activated')}}'
                       }).show();

                   } else {
                       new Noty({
                           type: 'error',
                           layout: 'bottomLeft',
                           text: data['result']
                       }).show();
                   }
                   //-- Hide loading image
                   $("div#divLoading").removeClass('show');
               }
           });
       }


    </script>
@stop