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
                @if(Auth::id()==$post->user_id)
                    <a data-toggle="modal" data-target="#delete_post" class="btn btn-danger" >Delete profile</a>
                @endif
                <hr>
            </div>
            <div class="w3-col m12 w3-margin-bottom">
                {!! $post->content!!}
            </div>

        </div>
    </div>

    {{--Delete post modal--}}
    <div class="modal" id="delete_post">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Do you really want to delete this post?</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <p class="confirm_info">
                        All relevant information concerned to this post also will be deleted permanently.
                    </p>
                    <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>

                        {{ Form::open(['method' =>'DELETE' , 'action' => ['\Modules\Post\Http\Controllers\PostController@destroy',$post->id]])}}
                        {!! Form::submit('Delete post',['class'=>'btn btn-danger']) !!}
                        {!! Form::close() !!}

                </div>

                <!-- Modal footer -->
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
@stop
@section('scripts')

@stop