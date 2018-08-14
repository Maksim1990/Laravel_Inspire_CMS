@extends('dashboard::layouts.master')

@section('General')
    <div class="row">
        <div class="col-sm-12 col-md-4  col-xs-12">
            <div class="col-sm-12 col-md-12  col-xs-12">
                <h3 class="title">FTP Manager</h3>
                <div id="title_shape"></div>

                <p>
                    <a href="{{route('office_ftp_content',['id'=>Auth::id()])}}" >
                        See FTP folder
                    </a>
                </p>
                <p>
                    <a href="{{route('office_ftp_connection',['id'=>Auth::id()])}}" >
                        Update FTP credentials
                    </a>
                </p>
                @if(Auth::user()->admin==1)
                <p>
                    <a href="{{route('office_ftp_connection_admin',['id'=>Auth::id()])}}" >
                        Update Admin FTP credentials
                    </a>
                </p>
                    @endif
            </div>

        </div>

    </div>
@stop
