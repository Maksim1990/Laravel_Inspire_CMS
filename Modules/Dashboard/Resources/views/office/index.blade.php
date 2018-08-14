@extends('dashboard::layouts.master')

@section('General')
    <h3 class="title">Inspire Office</h3>
    <div id="title_shape"></div>
    <p>
        <a href="{{route('office_read_file',['id'=>Auth::id()])}}" >
            Read file
        </a>
    </p>
    <p>
        <a href="{{route('office_ftp_manager',['id'=>Auth::id()])}}" >
            FTP Manager
        </a>
    </p>
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
