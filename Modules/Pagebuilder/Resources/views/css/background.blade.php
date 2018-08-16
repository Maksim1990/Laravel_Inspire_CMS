@extends('pagebuilder::layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{custom_asset('plugins/vendor/colpick-master/css/colpick.css')}}">
    <script src="{{custom_asset('plugins/vendor/colpick-master/js/colpick.js')}}"></script>
@stop
@section('scripts_header')

@stop
@section('General')

    <div class="row maintab">
        <div class="col-sm-12 col-lg-12 col-xs-12">
            <div class="col-sm-8 col-lg-8 col-xs-12">
                <div>
                    <h3 class="title">Background</h3>
                    <div id="title_shape"></div>
                </div>
                <h3>Button</h3>
                <p>
                    <button id="example-button" value="#00FF00">Show Color Picker</button>
                </p>
                <p>
                    <code>$('#example-button').colpick();</code>
                </p>
                <script>
                    $('#example-button').colpick();
                </script>


                <h3>Flat mode and hex layout</h3>
                <p>
                <div id="example-flat"></div>
                </p>
                <p>
                    <code>$('#example-flat').colpick({
                        color:'123456',
                        flat:true,
                        layout:'hex'
                        });</code>
                </p>
                <script>
                    $('#example-flat').colpick({
                        color:'123456',
                        flat:true,
                        layout:'hex'
                    });
                </script>


                <h3>Text Input and colorScheme 'dark'</h3>
                <p>
                    <input type="text" id="example-text" value="#0000FF">
                </p>
                <p>
                    <code>$('#example-text').colpick({
                        colorScheme:'dark',
                        onChange:function(hsb,hex,rgb,el,bySetColor) {
                        $(el).val('#'+hex);
                        }
                        });</code>
                </p>
                <script>
                    $('#example-text').colpick({
                        colorScheme:'dark',
                        onChange:function(hsb,hex,rgb,el,bySetColor) {
                            $(el).val('#'+hex);
                        }
                    });
                </script>

                <h3>HTML5 Color Input</h3>
                <p>
                    <input type="color" id="example-color" value="#FF0000">
                </p>
                <p>
                    <code>$('#example-color').colpick({
                        onSubmit:function(hsb,hex,rgb,el,bySetColor) {
                        $(el).val('#'+hex);
                        $(el).colpickHide();
                        }
                        });</code>
                </p>
                <script>
                    $('#example-color').colpick({
                        onSubmit:function(hsb,hex,rgb,el,bySetColor) {
                            $(el).val('#'+hex);
                            $(el).colpickHide();
                        }
                    });
                </script>


                <h3>Polyfill</h3>
                <p>
                    <input type="color" id="example-polyfill">
                </p>
                <p>
                    <code>$('#example-polyfill').colpick({
                        polyfill:true
                        });</code>
                </p>
                <script>
                    $('#example-polyfill').colpick({
                        polyfill:true
                    });
                </script>

            </div>
        </div>
    </div>
@stop
@section('scripts')

@stop