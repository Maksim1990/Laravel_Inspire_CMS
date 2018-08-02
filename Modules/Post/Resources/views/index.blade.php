@extends('post::layouts.master')
@section('styles')
    <style>
        .post_block {
            margin-left: 20px;
        }

        .post_item {
            background-color: rgba(34, 114, 38, 0.29);

        }

        .post_item_image {
            min-height: 200px;
        }

        .post_item img {
            width: 90%;
            border-radius: 15px;
        }

        .post_info {
            padding-top: 15px;
        }

        .post_info a {
            font-size: 23px;
        }

        .post_icons .fa-edit {
            font-size: 30px;
        }

        .post_tech_info {
            font-size: 10px;
        }
    </style>
@stop
@section('General')
    <div class="row">
        <div class="col-sm-8 col-xs-10">
            <h3 class="title">Posts</h3>

            <div>
                <a href="{{route("posts.create",Auth::id())}}" class="btn btn-success">New post</a>
                <hr>
            </div>
            <div class="row post_block">
                @if(count($posts)>0)
                    @foreach($posts as $post)
                        <div class="col-sm-12 col-xs-12 post_item">
                            <div class="col-sm-4 col-xs-12 post_item_image">
                                <img
                                        src="{{custom_asset("images/includes/noimage_post.png")}}"
                                        alt="">
                            </div>
                            <div class="col-sm-8 col-xs-12 post_info">
                                <div class="col-sm-12 col-xs-12">

                                    <div class="col-sm-10 col-xs-8">
                                        <a href="{{route('posts.show',['userId'=>Auth::id(),'id'=>$post->id])}}">{{$post->title}}</a>
                                        <br>
                                        <span class="post_tech_info">
                                    Created {{$post->created_at->diffForHumans()}} |
                                    Last modified {{$post->created_at->diffForHumans()}}
                                    </span>
                                        <hr>
                                    </div>
                                    <div class="col-sm-2 col-xs-4 post_icons">
                                    <span>
                                        <a href="{{route('posts.edit',['userId'=>Auth::id(),'id'=>$post->id])}}">
                                            <i class="fas fa-edit" data-toggle="tooltip" data-placement="right"
                                               title="Edit post"></i>
                                        </a>
                                    </span>
                                    </div>

                                    <div class="col-sm-12 col-xs-12">
                                        {{ str_limit(preg_replace('/[<]+[\/|\w|\d|\s!@#$%^&*(),.?":{}|="-:\/]+[>]/', '', $post->content),200,' [...]') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach
                @endif
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script>
        @if(Session::has('post_change'))
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: '{{session('post_change')}}'
        }).show();
        @endif
    </script>
@endsection
