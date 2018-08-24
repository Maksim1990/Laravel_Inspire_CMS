@extends('post::layouts.master')

@section('General')
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <h3 class="title">Posts</h3>
            <div id="title_shape"></div>

            <div class="insp_buttons">
                <a href="{{route("posts.create",Auth::id())}}" class="btn btn-success">New post</a>
                <hr>
            </div>
            <div class="row post_block">
                @if(count($posts)>0)
                    @foreach($posts as $post)
                        <div class="col-sm-8 col-xs-12 post_item">
                            <div class="col-sm-4 col-sm-md-8 col-xs-12 post_item_image">
                                <img src="{{$post->image ? custom_asset('storage/' . $post->image->path) :custom_asset("images/includes/noimage_post.png")}}"
                                     class="image-responsive" alt="">
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
