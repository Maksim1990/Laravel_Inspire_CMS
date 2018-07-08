@extends('pagebuilder::layouts.master')

@section('styles')

@stop
@section('scripts_header')


@stop
@section('General')
    <div class="col-sm-6">
        TEST
    </div>
@stop
@section('scripts')
    <script>
        {{--var token = '{{\Illuminate\Support\Facades\Session::token()}}';--}}
        {{--var url = '{{ route('ajax_codeeditor_update') }}';--}}
        {{--$('#submit').click(function () {--}}
            {{--var codeEditorContent=editor.getValue();--}}
            {{--var block_id='{{$block_id}}';--}}


            {{--$.ajax({--}}
                {{--method: 'POST',--}}
                {{--url: url,--}}
                {{--data: {--}}
                    {{--codeEditorContent: codeEditorContent,--}}
                    {{--block_id: block_id,--}}
                    {{--_token: token--}}
                {{--},--}}
                {{--success: function (data) {--}}
                    {{--if (data['result'] === "success") {--}}
                        {{--new Noty({--}}
                            {{--type: 'success',--}}
                            {{--layout: 'topRight',--}}
                            {{--text: 'Code updated!'--}}
                        {{--}).show();--}}
                    {{--}--}}
                {{--}--}}
            {{--});--}}



        {{--});--}}
    </script>
@stop