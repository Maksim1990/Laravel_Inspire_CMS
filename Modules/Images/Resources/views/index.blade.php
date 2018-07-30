@extends('images::layouts.master')

@section('General')
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <h3 class="title">Images</h3>


            <div class="w3-col m12 w3-margin-bottom">
               @if(count($userImages)>0)
                   @foreach($userImages as $image)
                        <div id="image_block_{{$image->id}}">
                        <div class="w3-col m3 w3-margin-left">
                            <div class="w3-card" >
                                <div class="card_item">
                                <a data-toggle="modal" data-target="#image_modal_{{$image->id}}" >
                                <img src="{{custom_asset("storage/".$image->path)}}" class="w3-border w3-hover-opacity" style="width:100%;">
                                </a>
                                </div>
                                <div class="w3-container icons">
                                      <span class="delete" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                    <a href="#" onclick="DeleteImage('{{$image->id}}')" class="w3-text-red"><i class="fas fa-minus-circle"></i></a>
                                          </span>
                                    <span data-toggle="tooltip" data-placement="bottom" title="Image details">
                                        <a data-toggle="modal" data-target="#image_modal_{{$image->id}}" ><i class="fas fa-expand-arrows-alt"></i></a>
                                    </span>
                                   <span data-toggle="tooltip" data-placement="bottom" title="Big size">
                                       <a href="#" ><i class="fas fa-info-circle"></i></a>
                                   </span>



                                </div>
                            </div>
                        </div>
                        <div class="modal" id="image_modal_{{$image->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Modal Heading</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <img src="{{custom_asset("storage/".$image->path)}}" class="w3-border w3-hover-opacity" style="width:100%">
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        </div>
                       @endforeach
                   @endif
            </div>
            <div>
                <a href="{{route("images.create",Auth::id())}}" class="btn btn-success">Upload new image</a>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script>

        function DeleteImage(id) {
            var url = '{{ route('ajax_delete_image') }}';
            var token = '{{\Illuminate\Support\Facades\Session::token()}}';

            var conf = confirm("Do you want to delete this image?");
            if (conf) {
                $.ajax({
                    method: 'POST',
                    url: url,
                    data: {
                        id: id,
                        _token: token
                    }, beforeSend: function () {
                        //-- Show loading image while execution of ajax request
                        $("div#divLoading").addClass('show');
                    },
                    success: function (data) {
                        if (data['result'] === "success") {

                            //-- Remove image
                            $('#image_block_' + id).remove();
                            $('[data-toggle="tooltip"], .tooltip').tooltip("hide");


                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: 'Image was deleted!'
                            }).show();
                        }else{
                            new Noty({
                                type: 'error',
                                layout: 'bottomLeft',
                                text: data['error']
                            }).show();
                        }

                        //-- Hide loading image
                        $("div#divLoading").removeClass('show');
                    }
                });
            }

        }
    </script>

@stop
