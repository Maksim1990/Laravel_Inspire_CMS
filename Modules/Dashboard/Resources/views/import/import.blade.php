@extends('dashboard::layouts.master')
@section('styles')

@endsection
@section('General')
    @php
        if(Session::has('import_change')){
        // dd(Session::has('import_change'));
        }

    @endphp
    <div class="row">
        <div class="col-sm-12 col-md-10  col-xs-12">
            <div class="col-sm-12 col-md-12  col-xs-12">
                <h3 class="title">
                    @lang('dashboard::messages.import_module')
                </h3>
                <div id="title_shape"></div>

                <div class="insp_buttons">
                    <a href="{{route("office",['id'=>Auth::id()])}}"
                       class="btn btn-warning">@lang('dashboard::messages.back_to_office_menu')</a>
                </div>

                <div style="padding-top: 100px;" class="col-sm-10 col-sm-offset-1 col-lg-10 col-lg-offset-1">
                    <div class="alert alert-success" role="alert" style="height: 65px;">
                        <span style="float:left;"><strong>Attention!</strong> For correct import use provided example template.</span>
                        <a class="btn btn-success btn-small" style="float:right;"
                           href="{{custom_asset('/files/templates/import_'.$type.'.xlsx')}}"
                           download="import_{{$type}}">Download template
                        </a>
                    </div>
                    <form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 10px;"
                          action="{{ route("import_file",['id'=>Auth::id(),'type'=>$type]) }}" class="form-horizontal"
                          method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" id="type" name="type" value="{{$type}}"/>
                        <input type="file" id="file1" name="file"/>
                        <button class="btn btn-primary" id="import_button" disabled>Import File</button>
                    </form>
                    <div class="col-sm-10 col-sm-offset-1 w3-center" id="file_name" style="height: 60px;"></div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    <script>
        @if(Session::has('import_change'))
        new Noty({
            type: '{{session('import_change')['type']}}',
            layout: '{{session('import_change')['position']}}',
            text: '{{session('import_change')['message']}}'
        }).show();
        @endif
    </script>
    <script>
        $("#file1").change(function () {

            var val = $(this).val();

            switch (val.substring(val.lastIndexOf('.') + 1).toLowerCase()) {
                case 'xlsx':
                    $('#file_name').html('File ' + val + ' is chosen');
                    $('#file_name').css('color', 'green');
                    $('#import_button').prop('disabled', false);
                    break;
                default:
                    $('#file_name').html("File format is not correct! Please try again.");
                    $('#file_name').css('color', 'red');
                    $('#import_button').prop('disabled', true);
                    break;
            }
        });
    </script>
@endsection