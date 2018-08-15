<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Menu\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Dashboard\Entities\MailEntity;

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
        $arrData = "";
        $result = "success";

        $strValue = $request->strValue;
        $strModule = $request->strModule;

        switch ($strModule) {
            case "menu":
                if (!empty($strValue)) {
                    $userMenus = Menu::whereHas('menuActive', function ($query) {
                        $query->where('user_id', Auth::id())->whereIn('menu_id', [1, 2, 3]);
                    })->get();
                } else {
                    $userMenus = Menu::whereHas('menuActive', function ($query) {
                        $query->where('user_id', Auth::id());
                    })->get();
                }
                $arrData = $userMenus;
                break;
            case "mail":
                $arrMails=MailEntity::where('user_id',Auth::id())->where(function ($query)use($strValue){
                    $query->where('from','like', '%'.$strValue.'%')
                        ->orWhere('to','like', '%'.$strValue.'%')
                        ->orWhere('title','like', '%'.$strValue.'%')
                        ->orWhere('content','like', '%'.$strValue.'%');
                })->get();
                $arrData = $arrMails;
                break;
        }


        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError,
            'arrData' => $arrData
        ));
    }
}
