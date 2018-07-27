@extends('dashboard::layouts.master')

@section('styles')
    <style>
        .delete {
            color: #be241a;
            font-size: 23px;
        }
    </style>
@stop
@section('General')
    @php
        $menuActiveOptions=[
        'Y'=>'Y',
        'N'=>'N'
        ];
    @endphp
    <h3>Menu settings</h3>
    <div>
        <p>Module: <b>Website</b></p>
        @if(!empty($userMenus))

            <table class="w3-table-all w3-hoverable ">
                <thead>
                <tr class="w3-light-grey">

                    @foreach($arrOfActiveLanguages as $strLang)
                        <th>{{$strLang}}</th>
                    @endforeach
                    <th>Parent</th>
                    <th>Active</th>
                    <th>Admin <br>active</th>
                    <th>Sortorder</th>
                    <th></th>
                </tr>

                </thead>
                <tbody id="menus_body">
                @foreach($userMenus as $menu)
                    @php
                    //dd();
                    @endphp
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
                                        @if($menuLang->lang==$strKey)
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
                            <select class="form-control" name="menu_parent" id="menu_parent" style="height: 33px;">
                                <option value='0'></option>
                                @foreach($userMenus as $menuSelect)

                                @if(count($menuSelect->langs)>0)
                                    @foreach($menuSelect->langs as $menuLangSelect)

                                            @php
                                                $strSelected="";
                                                if($menu->id==$menuSelect->id){
                                                continue;
                                                }

                                                if($menu->parent==$menuSelect->id){
                                                $strSelected="selected";
                                                }
                                            @endphp
                                            @if(strtolower($menuLangSelect->lang)=== LaravelLocalization::getCurrentLocale())
                                            <option value="{{$menuSelect->id}}" {{$strSelected}}>{{$menuLangSelect->name}}</option>
                                            @endif
                                    @endforeach
                                @endif
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="form-control" name="menu_active" id="{{$menu->id}}_menu_active" style="height: 33px;">
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
                        <td>
                            <select class="form-control" name="menu_active_admin" id="{{$menu->id}}_menu_active_admin" style="height: 33px;">
                                @foreach($menuActiveOptions as $strKey=>$menuActiveOption)
                                    @php
                                        $strSelected="";
                                        if($menu->active==$strKey){
                                        $strSelected="selected";
                                        }
                                    @endphp
                                    <option value="{{$strKey}}" {{$strSelected}}>{{$menuActiveOption}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td style="width:10%;">
                            <input type="number" class="form-control" name="menu_sortorder" id="{{$menu->id}}_menu_sortorder"  value="{{$menu->sortorder}}">
                        </td>
                        <td>

                            <a href="#" id="delete_{{$menu->id}}">
                                <span class="delete">
                                    <i class="fas fa-minus-circle"></i>
                                </span>
                            </a>

                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="border-top mt-4 pt-2 text-right">
                <br>
                <input id="add" value="Add new menu item" class="btn btn-warning">
                <input type="submit" id="submit" value="Save" class="btn btn-success">
            </div>

            </form>
        @endif
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
            var keyFieldParent = "<td> <select class=\"form-control\" name=\"menu_active_admin\" id=\""+newMenuCount+"menu_active_admin\" style=\"height: 33px;\">" +
                "<option value=\"Y\" selected>Y</option><option value=\"N\">N</option></select></td>";
            var keyFieldActive = "<td> <select class=\"form-control\" name=\"menu_active\" id=\""+newMenuCount+"_menu_active\" style=\"height: 33px;\">" +
                "<option value=\"Y\" selected>Y</option><option value=\"N\">N</option></select></td>";
            var keyFieldAdminActive = "<td> <select class=\"form-control\" name=\"menu_active_admin\" id=\""+newMenuCount+"menu_active_admin\" style=\"height: 33px;\">" +
                "<option value=\"Y\" selected>Y</option><option value=\"N\">N</option></select></td>";
            var keyFieldSortOrder = "<td style=\"width:10%;\"><input type=\"text\" class=\"form-control\" id='key_" + newMenuCount + "'></td>";
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

            var url = '{{ route('ajax_delete_label') }}';

            var conf = confirm("Do you want to delete this menu?");
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

                            //-- Hide label line from table
                            $('#menu_' + id).hide();
                            //-- Hide loading image
                            $("div#divLoading").removeClass('show');

                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: 'Menu deleted!'
                            }).show();
                        }
                    }
                });
            }

        }


        function SaveMenu() {
            var arrTranslationsKeys = {};
            var arrTranslations = {};
            $('input[id^="key_"]').each(function () {
                if ($(this).attr('id')) {
                    var id = $(this).attr('id').replace("key_", "").trim();
                    arrTranslationsKeys[id] = $(this).val();
                    var pattern = id + "_text_";

                    $('input[id^=' + pattern + ']').each(function () {
                        var idLabel = $(this).attr('id').replace(id + "_text_", "").trim();
                        arrTranslations[id + "_" + idLabel] = $(this).val();
                    });
                }
            });

            $.ajax({
                method: 'POST',
                url: url,
                data: {
                    arrTranslations: arrTranslations,
                    arrTranslationsKeys: arrTranslationsKeys,
                    module: "website",
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
    </script>
@stop
