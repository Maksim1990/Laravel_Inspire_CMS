<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Helper;
use App\Menu\Menu;
use App\Menu\MenuLang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Dashboard\Entities\Document;
use Modules\Dashboard\Entities\MailEntity;
use Spatie\TranslationLoader\LanguageLine;

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

                    $userMenusLangs = MenuLang::where('name', 'like', '%' . $strValue . '%')->where('user_id', Auth::id())->pluck('id')->unique();

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
                $arrMails = MailEntity::where('user_id', Auth::id())->where(function ($query) use ($strValue) {
                    $query->where('from', 'like', '%' . $strValue . '%')
                        ->orWhere('to', 'like', '%' . $strValue . '%')
                        ->orWhere('title', 'like', '%' . $strValue . '%')
                        ->orWhere('content', 'like', '%' . $strValue . '%');
                })->get();
                $arrData = $arrMails;
                break;
            case "file":
                $arrMails = Document::where('user_id', Auth::id())->where(function ($query) use ($strValue) {
                    $query->where('name', 'like', '%' . $strValue . '%')
                        ->orWhere('size', 'like', '%' . $strValue . '%')
                        ->orWhere('extension', 'like', '%' . $strValue . '%');
                })->get();
                $arrData = $arrMails;
                break;
            case "label":
                $arrOfActiveLanguages = Helper::GetActiveLanguages();
                $arrOfActiveLanguagesKeys = array_keys($arrOfActiveLanguages);


                //=================
                $labels = LanguageLine::where('user_id', Auth::id())->get();

                $label = LanguageLine::where('user_id', Auth::id())->first()->toArray();

                $allAvailableLanguages = LaravelLocalization::getSupportedLocales();
                if (!empty($label['text'])) {
                    foreach ($label['text'] as $key => $item) {

                        $arrLabelLangs[strtolower($key)] = $allAvailableLanguages[strtolower($key)]['native'];
                    }
                }
                $arrLangs = array_keys($arrLabelLangs);


                //-- Get name of columns in languages table
                $arrColumns = array_keys($label);

                //-- Remove first element from array of language keys
                array_shift($arrColumns);

                //-- Delete text JSON field
                if (($key = array_search('text', $arrColumns)) !== false) {
                    unset($arrColumns[$key]);
                }

                if (!empty($arrColumns)) {
                    //-- Add id column to the list of exported columns
                    array_unshift($arrColumns, 'id');

                } else {
                    $arrColumns = ['id'];
                }


                //-- Add language columns to exporting array
                if (!empty($arrLangs)) {
                    foreach ($arrLangs as $column) {
                        $arrColumns[$column] = strtoupper($column);
                    }
                }

                $arrColumns['langs'] = 'langs';
                //-- Sort resulting collection and add language elements
                $labelsSearch = $labels->map(function ($label) use ($arrColumns, $strValue, $arrLangs, $arrOfActiveLanguagesKeys, $allAvailableLanguages) {
                    if (!empty($arrLangs)) {
                        $collection = collect($label->toArray());
                        $arrLangsItem = [];
                        foreach ($label->text as $strKey => $translation) {
//                            if (strpos($strValue, $translation)) {
                            if (in_array(strtolower($strKey), $arrLangs) && in_array(strtoupper($strKey), $arrOfActiveLanguagesKeys)) {

                                $key = $allAvailableLanguages[strtolower($strKey)]['native'];
                                $arrLangsItem[] = [
                                    'langNative' => $key,
                                    'langKey' => strtolower($strKey),
                                    'translation' => $translation
                                ];
                            }
                            //}
                        }
                        $collection->put('langs', $arrLangsItem);
                        return $collection->only($arrColumns)->all();
                    }
                    return array();
                });

                $labelsResult = [];

                foreach ($labelsSearch as $item) {
                    $addStatus = false;
                    if (!empty($strValue)) {
                        //-- Check searching for keys
                        $pos = strpos(strtolower($item['key']), strtolower($strValue));
                        if ($pos !== false) {
                            $addStatus = true;
                        }

                        //-- Check searching for language translations
                        foreach ($item['langs'] as $translate) {
                            $pos = strpos(strtolower($translate['translation']), strtolower($strValue));
                            if ($pos !== false) {
                                $addStatus = true;
                            }
                        }
                    } else {
                        $addStatus = true;
                    }

                    if ($addStatus) {
                        $labelsResult[] = $item;
                    }
                }


                $arrData = $labelsResult;
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
