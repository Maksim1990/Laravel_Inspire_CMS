@extends('website::layouts.master')
@section('styles')
    <style>
        .post_block {
            margin-left: 20px;
        }

        .post_item {
            background-color: rgba(3, 12, 4, 0.02);
            margin-bottom: 30px;
            border-radius: 20px;
            padding-bottom: 20px;
            padding-top: 20px;
        }
        .post_item:hover {
            box-shadow: 0 0 11px rgba(33,33,33,.2);
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
@section('content')
    <div id="top"></div>
    <div class="row ">
        <div class="col-sm-6 col-sm-offset-2 col-lg-12 col-xs-12">
            <div class=" w3-center col-sm-12 col-lg-12 col-xs-12" style="width: 70%;height: 100px;padding-top: 40px;">
                <a href="{{route("website",['id'=>Auth::id(),'sitename'=>Auth::user()->website_setting->website_name])}}" style="float: left;">@lang('website::messages.back_to_home')</a>
                <h3 class="title">@lang('website::messages.posts')</h3>
            </div>
            <div class="row post_block">
                @if(count($posts)>0)
                    @foreach($posts as $post)
                        <div class="col-sm-8 col-xs-12 post_item">

                            <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1">
                                <a href="{{route('website_post',['id'=>Auth::id(),'sitename'=>Auth::user()->website_setting->website_name,'post_id'=>$post->id])}}">{{$post->title}}</a>
                            </div>
                            <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 post_item_image">
                                <a href="{{route('website_post',['id'=>Auth::id(),'sitename'=>Auth::user()->website_setting->website_name,'post_id'=>$post->id])}}"> <img
                                    src="{{$post->image ? custom_asset('storage/' . $post->image->path) :custom_asset("images/includes/noimage_post.png")}}"
                                    class="image-responsive" alt=""></a>
                            </div>
                            <div
                                class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 post_info">
                                <div class="col-sm-12 col-xs-12">
                                    {{ str_limit(preg_replace('/[<]+[\/|\w|\d|\s!@#$%^&*(),.?":{}|="-:\/]+[>]/', '', $post->content),200,' [...]') }}
                                    <hr>
                                </div>
                                <div class="col-sm-10 col-xs-8">
                                    <span class="post_tech_info">
                                    Created {{$post->created_at->diffForHumans()}} |
                                    Last modified {{$post->created_at->diffForHumans()}}
                                    </span>

                                </div>
                            </div>

                        </div>

                    @endforeach
                @endif
            </div>
            <div class="w3-center" style="width: 70%;">
                {!! $posts->links() !!}
            </div>
        </div>
    </div>
@stop