@extends('dashboard::layouts.master')

@section('General')
    <h3 class="title">@lang('messages.mail_box')</h3>
    <div id="title_shape"></div>

    <div>
        <a href="{{route("create_mail",Auth::id())}}" class="btn btn-success">@lang('messages.create_new_email')</a>
    </div>
@stop
@section('scripts')
    <script>
        @if(Session::has('mail_change'))
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: '{{session('mail_change')}}'

        }).show();
        @endif
    </script>
@endsection