<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Menu\Menu;
use App\Menu\MenuLang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Dashboard\Entities\Document;
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

                    $userMenusLangs = MenuLang::where('name','like', '%'.$strValue.'%')->where('user_id',Auth::id())->pluck('id')->unique();

                    $userMenus = Menu::whereHas('menuActive', function ($query) use ($userMenusLangs) {
                        $query->where('user_id', Auth::id())->whereIn('menu_id', $userMenusLangs);
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
            case "file":
                $arrMails=Document::where('user_id',Auth::id())->where(function ($query)use($strValue){
                    $query->where('name','like', '%'.$strValue.'%')
                        ->orWhere('size','like', '%'.$strValue.'%')
                        ->orWhere('extension','like', '%'.$strValue.'%');
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
