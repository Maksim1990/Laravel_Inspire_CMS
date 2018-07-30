@extends('post::layouts.master')

@section('General')
    <div class="row">
        <div class="col-sm-8 col-xs-10">
            <h3 class="title">Posts</h3>


            <div>
                <a href="{{route("posts.create",Auth::id())}}" class="btn btn-success">New post</a>
            </div>
        </div>
    </div>
@stop
