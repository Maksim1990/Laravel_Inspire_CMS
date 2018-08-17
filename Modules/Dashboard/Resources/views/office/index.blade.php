@extends('dashboard::layouts.master')

@section('General')
    <h3 class="title">Inspire Office</h3>
    <div id="title_shape"></div>


    <div class="insp_buttons">
        <a href="{{route("office",['id'=>Auth::id()])}}"
           class="btn btn-warning">@lang('dashboard::messages.back_to_office_menu')</a>
    </div>


    <div class="col-sm-12 col-md-4 col-md-offset-1  col-xs-12 text-center icon_module">
        <a href="{{route('office_docs',['id'=>Auth::id()])}}" >
            <p class="font_icon"><i class="fas fa-file-alt"></i></p>
            <span>@lang('dashboard::messages.documents')</span>
        </a>
    </div>

    <div class="col-sm-12 col-md-4 col-md-offset-1  col-xs-12 text-center icon_module">
        <a href="{{route('images',['id'=>Auth::id()])}}" >
            <p class="font_icon"><i class="fas fa-images"></i></p>
            <span>@lang('messages.images')</span>
        </a>
    </div>

    <div class="col-sm-12 col-md-4 col-md-offset-1  col-xs-12 text-center icon_module">
        <a href="{{route('office_ftp_manager',['id'=>Auth::id()])}}">
            <p class="font_icon">
                <img height="100"
                     src="{{custom_asset('images/includes/ftp.png')}}" alt="">
            </p>
            <span> @lang('dashboard::messages.ftp_manager')</span>
        </a>
    </div>

@stop
@section ('scripts')
    <script>
        @if(Session::has('office_change'))
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: '{{session('office_change')}}'

        }).show();
        @endif
    </script>
@endsection
