@extends('images::layouts.master')

@section('General')
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <h3 class="title">@lang('messages.images')</h3>
            <div id="title_shape"></div>
            <div class="insp_buttons">
                <a href="{{route("office",['id'=>Auth::id()])}}"
                   class="btn btn-warning">@lang('dashboard::messages.back_to_office_menu')</a>
                <a href="{{route("images.create",Auth::id())}}" class="btn btn-success">@lang('images::messages.upload_image')</a>
            </div>

            <div class="w3-col m12 w3-margin-bottom">
               @if(count($userImages)>0)
                   @foreach($userImages as $image)
                        <div id="image_block_{{$image->id}}">
                        <div class="w3-col m3 w3-margin-left">
                            <div class="w3-card" >
                                <div class="card_item">
                                <a data-toggle="modal" data-target="#image_modal_{{$image->id}}" >
                                <img src="{{custom_asset("storage/".$image->path)}}" class="w3-border w3-hover-opacity" >
                                </a>
                                </div>
                                <div class="w3-container icons">
                                      <span class="delete" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                             <a data-toggle="modal" data-target="#image_modal_delete_{{$image->id}}" ><i class="fas fa-minus-circle"></i></a>
                                          </span>
                                    <span data-toggle="tooltip" data-placement="bottom" title="Big size">
                                        <a data-toggle="modal" data-target="#image_modal_{{$image->id}}" ><i class="fas fa-expand-arrows-alt"></i></a>
                                    </span>
                                   <span data-toggle="tooltip" data-placement="bottom" title="Image details">
                                       <a data-toggle="modal" data-target="#image_modal_details_{{$image->id}}"><i class="fas fa-info-circle"></i></a>
                                   </span>
                                </div>
                            </div>
                        </div>

                            {{--Image big size modal--}}
                        <div class="modal" id="image_modal_{{$image->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title"></h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <img src="{{custom_asset("storage/".$image->path)}}" class="w3-border w3-hover-opacity" style="width:100%">
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('messages.close')</button>
                                    </div>

                                </div>
                            </div>
                        </div>

                            {{--Image details modal--}}
                            <div class="modal" id="image_modal_details_{{$image->id}}">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h3 class="title">{{$image->name}}</h3>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <!-- Modal body -->
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-4"><b>Name</b></div>
                                                <div class="col-sm-8">{{$image->name}}</div>

                                                <div class="col-sm-4"><b>Size</b></div>
                                                <div class="col-sm-8">{{$image->size}} kB</div>

                                                <div class="col-sm-4"><b>Full path</b></div>
                                                <div class="col-sm-8">{{$image->path}}</div>

                                                <div class="col-sm-4"><b>Uploaded at</b></div>
                                                <div class="col-sm-8">{{$image->created_at->diffForHumans()}}</div>
                                            </div>
                                        </div>

                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">@lang('messages.close')</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        {{--Image delete modal--}}
                        <div class="modal" id="image_modal_delete_{{$image->id}}">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title"> @lang('images::messages.image_want_deleted')</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <p class="confirm_info">
                                            @lang('images::messages.image_will_be_deleted')
                                        </p>
                                        <button type="button" class="btn btn-success" data-dismiss="modal">@lang('messages.cancel')</button>
                                        <a href="#" onclick="DeleteImage('{{$image->id}}')" class="btn btn-danger">@lang('images::messages.image_delete')</a>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer"></div>
                                </div>
                            </div>
                        </div>

                       @endforeach
                   @else
                   <p class="w3-text-grey not_found_text">@lang('images::messages.no_images_found')</p>
                   @endif
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script>

        function DeleteImage(id) {
            var url = '{{ route('ajax_delete_image') }}';
            var token = '{{\Illuminate\Support\Facades\Session::token()}}';


                $.ajax({
                    method: 'POST',
                    url: url,
                    dataType: "json",
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
                                text: '{{trans('images::messages.image_deleted')}}'
                            }).show();
                        }else{
                            new Noty({
                                type: 'error',
                                layout: 'bottomLeft',
                                text: data['error']
                            }).show();
                        }

                        $('#image_modal_delete_'+id).modal('toggle');
                        //-- Hide loading image
                        $("div#divLoading").removeClass('show');
                    }
                });

        }
    </script>

@stop
