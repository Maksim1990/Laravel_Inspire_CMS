<?php

namespace App;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Modules\Dashboard\Entities\Language;
use Spatie\TranslationLoader\LanguageLine;

class Helper
{


    /**
     * Converting @lang() labels in block content that
     * is being retrieved from DB content to appropriate label
     * depending on the current locale value
     *
     * @param string $blockContent
     * @return string $blockContent
     */
    public static function convertLabelsInBlockContent($blockContent)
    {
        $lastPos = 0;
        $positions = array();
        $needle = '@lang';
        while (($lastPos = strpos($blockContent, $needle, $lastPos)) !== false) {
            $positions[] = $lastPos;
            $lastPos = $lastPos + strlen($needle);
        }

        //-- Initialize array of occurrences
        $arrLangOccurrence = [];

        foreach ($positions as $key => $intPos) {
            $strTemp = substr($blockContent, $intPos);
            $intEndPos = strpos($strTemp, ")");
            $arrLangOccurrence[$key]["startPos"] = $intPos;
            $arrLangOccurrence[$key]["endPos"] = ($intEndPos + $intPos) + 1;

        }

        //-- Initialize array of replacements
        $arrReplacements = [];
        foreach ($arrLangOccurrence as $intKey => $strTranslation) {
            $strLabel = substr($blockContent, $strTranslation["startPos"], ($strTranslation["endPos"] - $strTranslation["startPos"]));

            //-- Using regex for replacing double brackets
            preg_match('#\((.*?)\)#', $strLabel, $match);

            //-- Remove additional double quotes from the match
            $match[1] = str_replace('"', "", $match[1]);

            $arrModuleLabel = explode(".", $match[1]);

            $trans = LanguageLine::where("user_id", Auth::id())->where("group", $arrModuleLabel[0])->where("key", $arrModuleLabel[1])->first();

            if (App::getLocale() && isset($trans->text[App::getLocale()])) {
                $arrReplacements[$intKey]['from'] = $strLabel;
                //-- If appropriate translation was not found than display text itself
                $arrReplacements[$intKey]['to'] = isset($trans->text) ? $trans->text[App::getLocale()] : $match[1];
            }


        }

        foreach ($arrReplacements as $arrItemReplace) {
            if (isset($arrItemReplace["from"]) && isset($arrItemReplace["to"])) {
                $blockContent = str_replace($arrItemReplace["from"], $arrItemReplace["to"], $blockContent);
            }
        }

        return $blockContent;
    }

    /**
     * Check if input image is still in the current block
     * If image is not in the block than physically reove image from the server
     *
     * @param string $codeEditorContent
     * @param string $blockID
     * @return void
     */
    public static function CheckIfImageInBlock($codeEditorContent, $blockID)
    {
        //-- Get list of all images for this user and current block
        $arrImagesList = glob(storage_path('/app/public/upload/' . Auth::id() . "/" . Auth::id() . "_" . $blockID . "*.{jpg,png,gif}"), GLOB_BRACE);
        foreach ($arrImagesList as $image) {
            $imageName = str_replace(storage_path('/app/public/upload/' . Auth::id() . "/"), "", $image);
            //-- Check if this image is still in the block
            if (strpos($codeEditorContent, $imageName) == false) {
                //-- If image already not in the block than remove it from the server
                unlink($image);
            }
        }
    }


    /**
     * Get array of currently active languages
     *
     * @return array
     */
    public static function GetActiveLanguages()
    {

        $activeLangs = Language::where('user_id', Auth::id())->where('active', 'Y')->get()->toArray();

        if (!empty($activeLangs)) {
            foreach ($activeLangs as $langItem) {
                $arrOfActiveLanguages[strtoupper($langItem['name'])] = $langItem['native_en'];
            }

        } else {
            $arrOfActiveLanguages = [
                "EN" => "English",
                "FR" => "French",
                "RU" => "Russian",
                "TH" => "Thai"
            ];
        }


        return $arrOfActiveLanguages;

    }

    /**
     * Get array of default languages that can't be deactivated
     *
     * @return array
     */
    public static function GetDefaultLanguages()
    {
        $arrOfDefaultLanguages = [
            "EN" => "English",
            "FR" => "French",
            "RU" => "Russian",
            "TH" => "Thai"
        ];

        return $arrOfDefaultLanguages;
    }


    /**
     * Get array of default languages that can't be deactivated
     *
     * @return array
     */
    public static function GetDefaultLanguagesWithNativeNames()
    {
        $arrOfDefaultLanguages = [
            "EN" => [
                'native_en' => "English",
                'native' => "English",
            ],
            "FR" => [
                'native_en' => "French",
                'native' => "Français",
            ],
            "RU" => [
                'native_en' => "Russian",
                'native' => "Русский",
            ],
            "TH" => [
                'native_en' => "Thai",
                'native' => "ไทย",
            ]
        ];

        return $arrOfDefaultLanguages;
    }

}
