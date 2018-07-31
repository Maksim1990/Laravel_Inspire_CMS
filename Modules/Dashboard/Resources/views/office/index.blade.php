@extends('dashboard::layouts.master')

@section('General')
    <h3 class="title">Inspire Office</h3>

    <p>
        <a href="{{route('office_read_file',['id'=>Auth::id()])}}" >
            Read file
        </a>
    </p>
    <p>
        <a href="{{route('office_ftp_connection',['id'=>Auth::id()])}}" >
            Update FTP credentials
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
