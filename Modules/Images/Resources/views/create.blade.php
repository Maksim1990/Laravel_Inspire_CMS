@extends('images::layouts.master')
@section ('styles')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.0/min/dropzone.min.css" rel="stylesheet">
@endsection
@section ('General')
    <div class="row">
        <div class="col-sm-8 col-xs-10">
        <div>
            <h3 class="title">Upload photo</h3>
            <div id="title_shape"></div>
        </div>


        {!! Form::open(['method'=>'POST','action'=>['\Modules\Images\Http\Controllers\ImagesController@store','userId'=>Auth::id()],'id'=>'uploadForm', 'class'=>'dropzone'])!!}

        {{ Form::hidden('user_id', Auth::id() ) }}
        {!! Form::close() !!}
            <br>
            <a href="{{route("images",Auth::id())}}" class="btn btn-success">Back to all images</a>
    </div>

    @include('includes.formErrors')
    </div>
@stop
@section ('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.0/min/dropzone.min.js"></script>
    <script>
            Dropzone.options.uploadForm = {
                dataType: "json",
                success: function(file, response){
                    if (response == "success") {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: 'Images updated!'
                        }).show();
                    }else{
                        new Noty({
                            type: 'error',
                            layout: 'bottomLeft',
                            text: response
                        }).show();
                    }
                }
            };
    </script>
@endsection