<?php

namespace Modules\Pagebuilder\Entities;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $table = "blocks";
    protected $guarded = [];

    protected $with = ['content'];

    public function content()
    {
        //return $this->hasOne(BlockContent::class);
        return $this->hasManyThrough(
            BlockContent::class,
            UserBlockPivot::class,
            'block_id',
            'id',
            'id',
            'block_content_id'
        );
    }


    public function filteredContent($blockContent)
    {

        $lastPos = 0;
        $positions = array();
        $needle = '@lang';
        while (($lastPos = strpos($blockContent, $needle, $lastPos)) !== false) {
            $positions[] = $lastPos;
            $lastPos = $lastPos + strlen($needle);
        }

        $arrLangOccurance = [];

        foreach ($positions as $key => $intPos) {
            $strTemp = substr($blockContent, $intPos);
            $intEndPos = strpos($strTemp, ")");
            $arrLangOccurance[$key]["startPos"] = $intPos;
            $arrLangOccurance[$key]["endPos"] = ($intEndPos + $intPos) + 1;

        }
        $arrReplacements = [];
        foreach ($arrLangOccurance as $intKey => $strTranslation) {
            $text = substr($blockContent, $strTranslation["startPos"], ($strTranslation["endPos"] - $strTranslation["startPos"]));
            preg_match('#\((.*?)\)#', $text, $match);

            //-- Remove additional double quotes from the match
            $match[1] = str_replace('"', "", $match[1]);

            $arrReplacements[$intKey]['from'] = $text;
            $arrReplacements[$intKey]['to'] = trans($match[1]);

        }
        foreach ($arrReplacements as $arrIremReplace) {
            $blockContent = str_replace($arrIremReplace["from"], $arrIremReplace["to"], $blockContent);
        }


        return $blockContent;
    }

}
