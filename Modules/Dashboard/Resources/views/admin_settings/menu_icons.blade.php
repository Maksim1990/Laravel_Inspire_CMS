<div class="row maintab">
    <div class="col-sm-12 col-lg-12 col-xs-12">
        <div class="alert alert-danger" role="alert" id="alert_settings" style="display:none;"></div>
        <div>
            <h3 class="title">@lang('dashboard::messages.menu_icons_settings')</h3>
            <div id="title_shape"></div>
        </div>


        @if(!empty($appMenus))
            @foreach($appMenus as $menu)
        <div class="col-sm-12 col-lg-12 col-xs-12">
            <div class="col-sm-5 col-xs-12">
                <p class="text">
                    {{$menu->route}}
                </p>
            </div>
            <div class="col-sm-5 col-xs-12">
                <div class="form-group">
                    <input type="text" class="form-control" id="menu_icon_{{$menu->id}}"
                           value="{{$menu->icon}}">
                </div>
            </div>
            <div class="col-sm-2 col-xs-12">
                <button class="btn btn-sm btn-success" style="margin-top: 2px;" id="save_icon_{{$menu->id}}">@lang('messages.save')</button>
            </div>
            <div class="col-sm-12 col-xs-12">
                <hr>
            </div>
        </div>
            @endforeach
         @else
            <div class="col-sm-12 col-lg-12 col-xs-12">
                <p class="text">@lang('dashboard::messages.no_menu_items')</p>
            </div>
        @endif
    </div>
</div>