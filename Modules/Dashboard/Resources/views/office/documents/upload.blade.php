@extends('dashboard::layouts.master')
@section ('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.0/min/dropzone.min.css" rel="stylesheet">
@endsection
@section('General')
    <div class="row">
        <div class="col-sm-12 col-md-10  col-xs-12">
            <h3 class="title">@lang('dashboard::messages.upload_new_document')</h3>
            <div id="title_shape"></div>

            <div class="insp_buttons">
                <a href="{{route("office",['id'=>Auth::id()])}}"
                   class="btn btn-warning">@lang('dashboard::messages.back_to_office_menu')
                </a><a href="{{route("office_docs",['id'=>Auth::id()])}}"
                   class="btn btn-info">@lang('dashboard::messages.back_to_all_documents')</a>
            </div>
            <div class="row">
                <div class="col-sm-12 col-lg-8 col-xs-12">

                    {!! Form::open(['method'=>'POST','action'=>['\Modules\Dashboard\Http\Controllers\OfficeController@storeDocs','id'=>Auth::id()],'id'=>'uploadForm', 'class'=>'dropzone'])!!}

                    {{ Form::hidden('user_id', Auth::id() ) }}
                    {!! Form::close() !!}
                </div>

                <hr>
            </div>
        </div>
    </div>


@endsection
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
                        text: '{{trans('dashboard::messages.file_uploaded')}}'
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