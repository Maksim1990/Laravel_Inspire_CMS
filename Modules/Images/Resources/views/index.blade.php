@extends('images::layouts.master')

@section('General')
    <div class="row">
        <div class="col-sm-8 col-xs-10">
            <h3 class="title">Images</h3>


            <div>
                <a href="{{route("images.create",Auth::id())}}" class="btn btn-success">Upload new image</a>
            </div>
        </div>
    </div>
@stop
