<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Menu\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{


    /**
     * Searching functionality depending on specific module
     *
     * @param Request $request
     */
    public function ajaxSearchBar(Request $request)
    {
        $strError = "";
        $result = "success";

        $strValue = $request->strValue;
        $strModule = $request->strModule;

        if(!empty($strValue)){
            $userMenus = Menu::whereHas('menuActive', function ($query) {
                $query->where('user_id', Auth::id())->whereIn('menu_id',[1,2,3]);
            })->get();
        }else{
            $userMenus = Menu::whereHas('menuActive', function ($query) {
                $query->where('user_id', Auth::id());
            })->get();
        }




        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError,
            'userMenus' => $userMenus,
        ));
    }
}
