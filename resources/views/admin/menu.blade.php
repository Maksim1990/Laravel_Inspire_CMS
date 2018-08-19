@extends('dashboard::layouts.master')

@section('styles')

@stop
@section('General')
    @php
        $menuActiveOptions=[
        'Y'=>'Y',
        'N'=>'N'
        ];
    @endphp
    <h3 class="title">Menu settings</h3>
    <div id="title_shape"></div>
    <div class="row">
        <div class="col-sm-12 col-lg-8 col-xs-12">
            <p>Module: <b>Website</b></p>
            <span id="found_items"></span>
        </div>
        <div class="col-sm-12 col-lg-4 col-xs-12">
            <img height="30" data-toggle="tooltip" data-placement="left" title="Elasticsearch functionality"
                 src="{{custom_asset('images/includes/elastic-elasticsearch.svg')}}" alt="" align="top">
            <input type="text" class="form-control" style="display: inline;width: 85%;" id="search_bar"
                   placeholder="@lang('messages.search')">

        </div>
        <hr>
    </div>
    <div>

        @if(!empty($userMenus))

            <table class="w3-table-all w3-hoverable ">
                <thead>
                <tr class="w3-light-grey">

                    @foreach($arrOfActiveLanguages as $strLang)
                        <th>{{$strLang}}</th>
                    @endforeach
                    <th>Parent</th>
                    @if(Auth::user()->admin!=1)
                        <th>Active</th>
                    @endif
                    @if(Auth::user()->admin==1)
                        <th>Admin <br>active</th>
                    @endif
                    <th>Sortorder</th>
                    <th></th>
                </tr>

                </thead>
                <tbody id="menus_body">
                @foreach($userMenus as $menu)
                    <tr id="menu_{{$menu->id}}">
                        {{--Loop through all active languages--}}
                        @foreach($arrOfActiveLanguages as $strKey=>$strLang)
                            <td style="width:15%;">
                                @php
                                    //-- Set default menu name for current language
                                    $menuName="";
                                @endphp
                                @if(count($menu->langs)>0)
                                    @foreach($menu->langs as $menuLang)
                                        @if($menuLang->lang==$strKey && $menuLang->user_id == Auth::id())
                                            @php
                                                $menuName=$menuLang->name;
                                            @endphp
                                        @endif
                                    @endforeach
                                @endif

                                <input type="text" class="form-control"
                                       id="{{$menu->id}}_text_{{strtolower($strKey)}}"
                                       value="{{$menuName}}">
                            </td>
                        @endforeach

                        <td>
                            <select class="form-control" name="menu_parent" id="{{$menu->id}}_menu_parent"
                                    style="height: 33px;">
                                <option value='0'></option>
                                @foreach($userMenus as $menuSelect)

                                    @if(count($menuSelect->langs)>0)
                                        @foreach($menuSelect->langs as $menuLangSelect)

                                            @php
                                                $strSelected="";
                                                if($menu->id==$menuSelect->id){
                                                continue;
                                                }

                                                if($menu->menuActive->where('user_id',Auth::id())->first()->parent==$menuSelect->id){
                                                $strSelected="selected";
                                                }
                                            @endphp
                                            @if(strtolower($menuLangSelect->lang)=== LaravelLocalization::getCurrentLocale() && $menuLangSelect->user_id == Auth::id())
                                                <option
                                                    value="{{$menuSelect->id}}" {{$strSelected}}>{{$menuLangSelect->name}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        @if(Auth::user()->admin!=1)
                            <td>
                                <select class="form-control" name="menu_active" id="{{$menu->id}}_menu_active"
                                        style="height: 33px;">
                                    @foreach($menuActiveOptions as $strKey=>$menuActiveOption)
                                        @php
                                            $strSelected="";
                                              $menuActive=$menu->menuActive->where('user_id',Auth::id())->first();
                                                if(isset($menuActive) && $menuActive->active==$strKey){
                                            $strSelected="selected";
                                            }
                                        @endphp
                                        <option value="{{$strKey}}" {{$strSelected}}>{{$menuActiveOption}}</option>
                                    @endforeach
                                </select>
                            </td>
                        @endif
                        @if(Auth::user()->admin==1)
                            <td>
                                <select class="form-control" name="menu_active_admin"
                                        id="{{$menu->id}}_menu_active_admin"
                                        style="height: 33px;">
                                    @foreach($menuActiveOptions as $strKey=>$menuActiveOption)
                                        @php
                                            $strSelected="";
                                            if($menu->admin==$strKey){
                                            $strSelected="selected";
                                            }
                                        @endphp
                                        <option value="{{$strKey}}" {{$strSelected}}>{{$menuActiveOption}}</option>
                                    @endforeach
                                </select>
                            </td>
                        @endif
                        <td style="width:10%;">
                            <input type="number" class="form-control" name="menu_sortorder"
                                   id="{{$menu->id}}_menu_sortorder"
                                   value="{{$menu->menuActive->where('user_id',Auth::id())->first()->sortorder}}">
                        </td>
                        <td>

                            @if($menu->admin!="Y" || ($menu->admin=="Y" && Auth::user()->admin==1) )
                                <a href="#" id="delete_{{$menu->id}}">
                                    <span class="delete w3-text-red">
                                        <i class="fas fa-minus-circle"></i>
                                    </span>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tbody id="menus_body_search"></tbody>
            </table>
            <div class="border-top mt-4 pt-2 text-right">
                <br>
                <input id="add" value="Add new menu item" class="btn btn-warning">
                <input type="submit" id="submit" value="Save" class="btn btn-success">
            </div>

            </form>
        @endif
    </div>
    <div class="col-sm-12 col-lg-8 col-xs-12 w3-center" id="links">
        {!! $userMenus->links() !!}
    </div>
@stop
@section('scripts')
    <script>
        var token = '{{\Illuminate\Support\Facades\Session::token()}}';
        var url = '{{ route('ajax_update_menu') }}';

        //-- Functionality to update menus
        $('#submit').click(function () {
            SaveMenu();
        });

        //-- Delete menu functionality
        $('[id^="delete_"]').click(function () {
            DeleteMenu($(this).attr('id').replace('delete_', ""));
        });


        //-- Add new menu functionality
        var newMenuCount = '{{$intLastMenuId}}';

        $('#add').click(function () {
            newMenuCount++;
            var keyFieldParent = "<td><select class=\"form-control\" name=\"menu_parent\" id=\"" + newMenuCount + "_menu_parent\" style=\"height: 33px;\">";
            keyFieldParent += "<option value=\"0\" selected></option>";
            @foreach($userMenus as $menuSelect)
                @if(count($menuSelect->langs)>0)
                @foreach($menuSelect->langs as $menuLangSelect)
                @if(strtolower($menuLangSelect->lang)=== LaravelLocalization::getCurrentLocale() && $menuLangSelect->user_id == Auth::id())
                keyFieldParent += "<option value=\"{{$menuLangSelect->id}}\">{{$menuLangSelect->name}}</option>";
            @endif
                @endforeach
                @endif
                @endforeach
                keyFieldParent += "</select></td>";


            var keyFieldActive = "<td> <select class=\"form-control\" name=\"menu_active\" id=\"" + newMenuCount + "_menu_active\" style=\"height: 33px;\">" +
                "<option value=\"Y\" selected>Y</option><option value=\"N\">N</option></select></td>";
            var keyFieldAdminActive = "<td> <select class=\"form-control\" name=\"menu_active_admin\" id=\"" + newMenuCount + "_menu_active_admin\" style=\"height: 33px;\">" +
                "<option value=\"Y\" selected>Y</option><option value=\"N\">N</option></select></td>";
            var keyFieldSortOrder = "<td style=\"width:10%;\"><input type=\"text\" class=\"form-control\" id='" + newMenuCount + "_menu_sortorder'></td>";
            var langField = "";
            @foreach($arrOfActiveLanguages as $strKey=>$strLang)
                langField += "<td style=\"width:15%;\"><input type='text' id='" + newMenuCount + "_text_{{strtolower($strKey)}}' class=\"form-control\" name='' value=''></td>";
                @endforeach

            var deleteIcon = "<td><a href=\"#\" id='delete_" + newMenuCount + "'><span class=\"delete\"><i class=\"fas fa-minus-circle\"></i></span></a></td>";
            $('<tr id="menu_' + newMenuCount + '">').html(langField + keyFieldParent + keyFieldActive + keyFieldAdminActive + keyFieldSortOrder + deleteIcon + "</tr>").appendTo('#menus_body');

            $('[id^="delete_"]').click(function () {
                DeleteMenu($(this).attr('id').replace('delete_', ""));
            });

        });

        function DeleteMenu(id) {

            var url = '{{ route('ajax_delete_menu') }}';

            var conf = confirm("Do you want to delete this menu?");
            if (conf) {
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

                            //-- Hide menu line from table
                            $('#menu_' + id).remove();


                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: 'Menu deleted!'
                            }).show();
                        } else {
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


        function SaveMenu() {
            var arrMenuKeys = {};
            var arrMenuIds = [];
            var arrMenuLangs = {};
            $('[id^="menu_"]').each(function () {
                if ($(this).attr('id')) {
                    var id = $(this).attr('id').replace("menu_", "").trim();
                    arrMenuIds.push(id);
                    arrMenuKeys[id + '_menu_parent'] = $('#' + id + '_menu_parent').val();
                    arrMenuKeys[id + '_menu_active'] = $('#' + id + '_menu_active').val();
                    arrMenuKeys[id + '_menu_active_admin'] = $('#' + id + '_menu_active_admin').val();
                    arrMenuKeys[id + '_menu_sortorder'] = $('#' + id + '_menu_sortorder').val();


                    var pattern = id + "_text_";

                    $('input[id^=' + pattern + ']').each(function () {
                        var idMenu = $(this).attr('id').replace(id + "_text_", "").trim();
                        arrMenuLangs[id + "_" + idMenu] = $(this).val();
                    });
                }
            });

            console.log(arrMenuIds);
            console.log(arrMenuKeys);
            console.log(arrMenuLangs);
            $.ajax({
                method: 'POST',
                url: url,
                dataType: "json",
                data: {
                    arrMenuIds: arrMenuIds,
                    arrMenuKeys: arrMenuKeys,
                    arrMenuLangs: arrMenuLangs,
                    _token: token
                }, beforeSend: function () {
                    //-- Show loading image while execution of ajax request
                    $("div#divLoading").addClass('show');
                },
                success: function (data) {
                    if (data['result'] === "success") {

                        //-- Hide loading image
                        $("div#divLoading").removeClass('show');

                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: 'Menu updated!'
                        }).show();
                    }
                }
            });
        }


        //-- Functionality when something was typed in Searching bar
        $('#search_bar').keyup(function () {
            var url = '{{ route('ajax_search_bar') }}';
            var strValue = $(this).val();

            if (strValue != "") {
                $.ajax({
                    method: 'POST',
                    url: url,
                    dataType: "json",
                    data: {
                        strValue: strValue,
                        strModule: 'menu',
                        _token: token
                    }, beforeSend: function () {
                        //-- Show loading image while execution of ajax request
                        $("div#divLoading").addClass('show');
                    },
                    success: function (data) {

                        if (data['result'] === "success") {

                            //-- Hide loading image
                            $("div#divLoading").removeClass('show');

                            $("#menus_body,#links").hide();
                            $("#menus_body_search,#found_items").html('');
                            if (data['arrData'].length > 0) {

                                //-- Set number of found items
                                $("#found_items").html('Number of found items:<b>'+data['arrData'].length+'</b>');

                                var arrLangs =@php echo json_encode($arrOfActiveLanguages); @endphp;

                                for (var i = 0; i < data['arrData'].length; i++) {

                                    //console.log(data['arrData'][i]);
                                    //-- Initialize array of currently active languages
                                    var arrLangsKeys = Object.keys(arrLangs);

                                    var newMenuCount = data['arrData'][i]['id'];
                                    var keyFieldParent = "<td><select class=\"form-control\" name=\"menu_parent\" id=\"" + newMenuCount + "_menu_parent\" style=\"height: 33px;\">";
                                    keyFieldParent += "<option value=\"0\" selected></option>";
                                        @foreach($userMenus as $menuSelect)
                                        @if(count($menuSelect->langs)>0)
                                        @foreach($menuSelect->langs as $menuLangSelect)
                                        @if(strtolower($menuLangSelect->lang)=== LaravelLocalization::getCurrentLocale() && $menuLangSelect->user_id == Auth::id())
                                    var strSelected = "";
                                    if (data['arrData'][i]['menu_active'][0]['parent'] === +'{{$menuLangSelect->id}}') {
                                        strSelected = "selected";
                                    }
                                    keyFieldParent += "<option value=\"{{$menuLangSelect->id}}\" " + strSelected + ">{{$menuLangSelect->name}}</option>";
                                    @endif
                                        @endforeach
                                        @endif
                                        @endforeach
                                        keyFieldParent += "</select></td>";


                                    var arrSelectOptions = ["Y", "N"];
                                        @if(Auth::user()->admin!=1)
                                    var keyFieldActive = "<td> <select class=\"form-control\" name=\"menu_active\" id=\"" + newMenuCount + "_menu_active\" style=\"height: 33px;\">";
                                    for (var j = 0; j < arrSelectOptions.length; j++) {
                                        var strSelected = "";
                                        if (data['arrData'][i]['menu_active'][0]["active"] === arrSelectOptions[i]) {
                                            strSelected = "selected";
                                        }
                                        keyFieldActive += "<option value=" + arrSelectOptions[i] + " " + strSelected + ">" + arrSelectOptions[i] + "</option>";
                                    }
                                    keyFieldActive += "</td>";
                                        @else
                                    var keyFieldActive = "";
                                        @endif


                                        @if(Auth::user()->admin==1)
                                    var keyFieldAdminActive = "<td> <select class=\"form-control\" name=\"menu_active_admin\" id=\"" + newMenuCount + "_menu_active_admin\" style=\"height: 33px;\">";
                                    for (var j = 0; j < arrSelectOptions.length; j++) {
                                        var strSelected = "";
                                        if (data['arrData'][i]['admin'] === arrSelectOptions[j]) {
                                            strSelected = "selected";
                                        }
                                        keyFieldAdminActive += "<option value=" + arrSelectOptions[j] + " " + strSelected + ">" + arrSelectOptions[j] + "</option>";
                                    }
                                    keyFieldAdminActive += "</td>";
                                        @else
                                    var keyFieldAdminActive = "";
                                        @endif

                                    var keyFieldSortOrder = "<td style=\"width:10%;\"><input type=\"text\" class=\"form-control\" id='" + newMenuCount + "_menu_sortorder' value='" + data['arrData'][i]['menu_active'][0]['sortorder'] + "'></td>";
                                    var langField = "";

                                    for (var j = 0; j < data['arrData'][i]['langs'].length; j++) {
                                        langField += "<td style=\"width:15%;\"><input type='text' id='" + newMenuCount + "_text_" + data['arrData'][i]['langs'][j]['lang'].toLowerCase() + "' class=\"form-control\" name='' value='" + data['arrData'][i]['langs'][j]['name'] + "'></td>";
                                        arrLangsKeys.remove(data['arrData'][i]['langs'][j]['lang']);

                                    }

                                    //-- Fill in empty menu lang inputs
                                    if (arrLangsKeys.length > 0) {
                                        for (var j = 0; j < arrLangsKeys.length; j++) {
                                            langField += "<td style=\"width:15%;\"><input type='text' id='" + newMenuCount + "_text_" + arrLangsKeys[j].toLowerCase() + "' class=\"form-control\" name='' value=''></td>";
                                        }
                                    }

                                    var deleteIcon = "<td><a href=\"#\" id='delete_" + newMenuCount + "'><span class=\"delete\"><i class=\"fas fa-minus-circle\"></i></span></a></td>";
                                    $('<tr id="menu_' + newMenuCount + '">').html(langField + keyFieldParent + keyFieldActive + keyFieldAdminActive + keyFieldSortOrder + deleteIcon + "</tr>").appendTo('#menus_body_search');
                                }
                            } else {
                                $(' <p class="w3-text-grey not_found_text">').html("{{trans('dashboard::messages.no_files_found')}}</p>").appendTo('#menus_body_search');
                            }
                        }

                        $('[id^="delete_"]').click(function () {
                            DeleteMenu($(this).attr('id').replace('delete_', ""));
                        });
                    }
                });
            } else {
                $("#menus_body_search,#found_items").html('');
                $("#menus_body,#links").show();
            }

        });


        //-- Add remove() method to prototype
        Array.prototype.remove = function () {
            var what, a = arguments, L = a.length, ax;
            while (L && this.length) {
                what = a[--L];
                while ((ax = this.indexOf(what)) !== -1) {
                    this.splice(ax, 1);
                }
            }
            return this;
        };

    </script>
@stop
