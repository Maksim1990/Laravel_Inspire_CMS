@extends('dashboard::layouts.master')
@section('styles')
    <style>
        .search_main {
            padding-top: 100px;
        }

        #search_header {
            margin-bottom: 50px;
        }

        .search_block {
            border-radius: 20px;
            background-color: lightgreen;
            padding: 0px 10px 0px 10px;
            margin-bottom: 30px;
        }

        .search_block:hover {
            background-color: darkseagreen;
        }

        .search_block a {
            display: block;
            height: 200px;
            width: 100%;
            padding-top: 60px;
        }



    </style>

@endsection
@section('General')
    <div class="col-sm-12 " id="search_header">
        <h3 class="title">
            @lang('dashboard::messages.export_module')
        </h3>
    </div>
    <div class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1 w3-center search_main">

        <div class="col-sm-4 col-sm-offset-1 search_block users">
            <a href="{{route('export_file',['type'=>'xls'])}}" class="text-uppercase">
                <i class="fas fa-search"></i><br>
                Export languages
            </a>

        </div>
        <div class="col-sm-4 col-sm-offset-1 search_block books">
            <a href="{{URL::to(LaravelLocalization::getCurrentLocale() .'/import_movies_main')}}" class="text-uppercase">
                <i class="fas fa-search"></i><br>
                @lang('messages.movies')
            </a>
        </div>
    </div>


@endsection
@section('scripts')
    <script src="{{asset('js/app.js')}}"></script>
@endsection