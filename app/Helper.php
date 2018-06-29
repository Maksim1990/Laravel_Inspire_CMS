<?php

namespace App;

class Helper{


    /**
     * Return price calculation result based on priority and filters
     *
     * @param string $blockContent
     *
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

            $arrModuleLabel=explode(".",$match[1]);
            $trans=LanguageLine::where("user_id",Auth::id())->where("group",$arrModuleLabel[0])->where("key",$arrModuleLabel[1])->first();

            $arrReplacements[$intKey]['from'] = $strLabel;
            //-- If appropriate translation was not found than display text itself
            $arrReplacements[$intKey]['to'] = isset($trans->text)?$trans->text[App::getLocale()]:$match[1];

        }

        foreach ($arrReplacements as $arrIremReplace) {
            $blockContent = str_replace($arrIremReplace["from"], $arrIremReplace["to"], $blockContent);
        }

        return $blockContent;
    }
}
