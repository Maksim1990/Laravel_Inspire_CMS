@extends('profile::layouts.master')


@section('scripts_header')
@stop

@section('styles')
@stop

@section('General')
    <h1>My Profile</h1>

    <p>
        This view is loaded from module: {!! config('profile.name') !!}
    </p>
@stop
@section ('scripts')
    <script>
        @if(Session::has('user_change'))
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: '{{session('user_change')}}'

        }).show();
        @endif
    </script>
@endsection