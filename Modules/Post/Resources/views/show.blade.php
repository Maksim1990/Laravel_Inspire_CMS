@extends('post::layouts.master')
@section('styles')
    <style>
        form{
            display: inline;
        }
    </style>
@stop
@section('General')
    <div class="row">
        <div class="col-sm-9 col-xs-12">
            <h3 class="title">{{$post->title}}</h3>
            <div id="title_shape"></div>
            <div>
                <a href="{{route("posts",Auth::id())}}" class="btn btn-success">Back to all posts</a>
                <a href="{{route('posts.edit',['userId'=>Auth::id(),'id'=>$post->id])}}" class="btn btn-warning">Edit post</a>

                {{ Form::open(['method' =>'DELETE' , 'action' => ['\Modules\Post\Http\Controllers\PostController@destroy',$post->id]])}}
                {!! Form::submit('Delete post',['class'=>'btn btn-danger']) !!}
                {!! Form::close() !!}
                <hr>
            </div>
            <div class="w3-col m12 w3-margin-bottom">
                {!! $post->content!!}
            </div>

        </div>
    </div>
@stop
@section('scripts')

@stop