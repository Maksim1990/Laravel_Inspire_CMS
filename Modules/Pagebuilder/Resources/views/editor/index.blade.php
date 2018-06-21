@extends('pagebuilder::layouts.master')

@section('styles')
    <style>
        h2.mce-content-body {
            font-size: 200%;
            padding: 0 25px 0 25px;
            margin: 10px 0 10px 0;
        }

        body {
            background: transparent;
        }

        .content {
            overflow: visible;
            position: relative;
            width: auto;
            margin-left: 0;
            min-height: auto;
            padding: inherit;
        }
    </style>
@stop
@section('scripts_header')
<script src="{{asset('plugins/vendor/tinymce/js/tinymce/tinymce.min.js')}}" type="text/javascript"></script>
<script>
    tinymce.init({
        selector: 'h2.editable',
        inline: true,
        toolbar: 'undo redo',
        menubar: false
    });

    tinymce.init({
        selector: '#block1,#block2',
        inline: true,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste'
        ],
        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        // we override default upload handler to simulate successful upload
        images_upload_handler: function (blobInfo, success, failure) {

 console.log(blobInfo.filename());
 console.log(blobInfo.blob());
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '{{route("editor_upload_image")}}');
            xhr.setRequestHeader("X-CSRF-Token", "{{ csrf_token() }}");

            xhr.onload = function() {
                var json;

                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }

                json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }


                success(json.location);
            };

            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        },


        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css']
    });
    // tinymce.activeEditor.uploadImages(function(success) {
    //     $.post('ajax/post.php', tinymce.activeEditor.getContent()).done(function() {
    //         console.log("Uploaded images and posted content as an ajax request.");
    //     });
    // });
</script>
@stop
@section('General')

    <h2 class="editable">Editable header</h2>
    {{--<img src="{{asset("storage/upload/12.jpeg")}}" >--}}

    <div class="col-sm-6">


    <div class="editable" id="block1">
        <h2><img title="TinyMCE Logo" src="//www.tinymce.com/images/glyph-tinymce@2x.png" alt="TinyMCE Logo" width="110" height="97" style="float: right"/>TinyMCE Inline Mode</h2>
        <p>
            This is an editable div element.
        </p>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam tincidunt est ac dolor condimentum vitae laoreet ante accumsan. Nullam tincidunt tincidunt ante tempus commodo. Duis rutrum, magna non lacinia tincidunt, risus lacus tempus ipsum, sit amet euismod justo metus ut metus. Donec feugiat urna non leo laoreet in tincidunt lectus gravida. Sed semper ante sed dui consectetur eget commodo eros imperdiet. Mauris magna diam, scelerisque at ornare vel, dignissim ac sem. Fusce id congue lacus. Duis sit amet tellus erat. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Phasellus mattis facilisis pretium. In in nibh eu urna ornare semper. Sed imperdiet felis vitae nibh sagittis eu pulvinar metus facilisis. Sed dolor orci, aliquet sagittis auctor id, faucibus at justo.
        </p>

        <hr>
    </div>
    <div class="editable" id="block2">
        <h2><img title="TinyMCE Logo" src="//www.tinymce.com/images/glyph-tinymce@2x.png" alt="TinyMCE Logo" width="110" height="97" style="float: right"/>TinyMCE Inline Mode</h2>
        <p>
            This is an editable div element.
        </p>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam tincidunt est ac dolor condimentum vitae laoreet ante accumsan. Nullam tincidunt tincidunt ante tempus commodo. Duis rutrum, magna non lacinia tincidunt, risus lacus tempus ipsum, sit amet euismod justo metus ut metus. Donec feugiat urna non leo laoreet in tincidunt lectus gravida. Sed semper ante sed dui consectetur eget commodo eros imperdiet. Mauris magna diam, scelerisque at ornare vel, dignissim ac sem. Fusce id congue lacus. Duis sit amet tellus erat. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Phasellus mattis facilisis pretium. In in nibh eu urna ornare semper. Sed imperdiet felis vitae nibh sagittis eu pulvinar metus facilisis. Sed dolor orci, aliquet sagittis auctor id, faucibus at justo.
        </p>

        <hr>
    </div>
    </div>
@stop
@section('scripts')

@stop