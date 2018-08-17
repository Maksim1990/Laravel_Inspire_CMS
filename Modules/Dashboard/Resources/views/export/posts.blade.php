@extends('dashboard::layouts.master')
@section('styles')


@endsection
@section('General')
    <div class="row">
        <div class="col-sm-12 col-md-10  col-xs-12">
            <h3 class="title">
                @lang('dashboard::messages.export_posts')
            </h3>
            <div id="title_shape"></div>
            <div class="insp_buttons">
                <a href="{{route("export",['id'=>Auth::id()])}}"
                   class="btn btn-warning">@lang('dashboard::messages.back_to_export_module')</a>
            </div>

            <div class="col-sm-12 col-md-8  col-xs-12">
                {!! Form::open(['method'=>'POST','action'=>['\Modules\Dashboard\Http\Controllers\ExcelController@exportPostsFile','id'=>Auth::id()], 'files'=>true])!!}
                <div class="group-form col-sm-12">
                    {!! Form::label('type',trans('dashboard::messages.export_file_type')) !!}<br>
                    {!! Form::radio('type', 'xls', true,['id'=>'xls']) !!} {!! Form::label('xls','XLS',['style'=>'font-weight: 100;']) !!}<br>
                    {!! Form::radio('type', 'csv', false,['id'=>'csv']) !!} {!! Form::label('csv','CSV',['style'=>'font-weight: 100;']) !!}
                    <hr>
                </div>
                <div class="group-form col-sm-12 col-md-8  col-xs-12">
                    {!! Form::label('count',trans('dashboard::messages.export_number_records')) !!}
                    {!! Form::number('count', "", ['class'=>'form-control', 'style'=>'width:80%;']) !!}
                    <span class="w3-text-green"><i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="@lang('dashboard::messages.export_leave_empty')"></i></span>
                    <hr>
                </div>
                <div class="group-form col-sm-12">
                    {!! Form::label('type',trans('dashboard::messages.export_order_type')) !!}<br>
                    {!! Form::radio('order', 'ASC', true,['id'=>'normal']) !!} {!! Form::label('normal',trans('dashboard::messages.export_normal'),['style'=>'font-weight: 100;']) !!}<br>
                    {!! Form::radio('order', 'DESC', false,['id'=>'recent']) !!} {!! Form::label('recent',trans('dashboard::messages.export_recent_first'),['style'=>'font-weight: 100;']) !!}
                    <hr>
                </div>

                <div class="group-form col-sm-12">
                    {!! Form::label('type',trans('dashboard::messages.export_chose_columns')) !!}<br>
                    @foreach($arrKeys as $key)
                        {!! Form::checkbox('columns[]', $key, true,['id'=>$key]) !!} {!! Form::label($key,$key,['style'=>'font-weight: 100;']) !!}<br>
                    @endforeach
                    <hr>
                </div>

                <div class="col-sm-12">
                    <br>
                    {!! Form::submit(trans('dashboard::messages.export'),['class'=>'btn btn-success']) !!}
                </div>

                {!! Form::close() !!}
            </div>

        </div>
    </div>


@endsection
@section('scripts')

@endsection