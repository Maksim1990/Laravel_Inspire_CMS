@extends('pagebuilder::layouts.master')

@section('styles')

@stop
@section('scripts_header')


@stop
@section('General')

    <div class="row maintab">
        <div class="col-sm-12 col-lg-12 col-xs-12">
            <div class="col-sm-6 col-lg-6 col-xs-12">
                <div class="col-sm-8">
                    <p class="text">Choose fovorite stile of code editor</p>

                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        @if(count($arrThemes)>0)
                            <select id="editorCSS" class="custom-select" style="height: 40px;">
                                @foreach($arrThemes as $strTheme)
                                    <option value="{{$strTheme}}">{{$strTheme}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>
                <div class="col-sm-12">
                    <hr>
                </div>
            </div>
        </div>
    </div>

@stop
@section('scripts')
    <script>

    </script>
@stop