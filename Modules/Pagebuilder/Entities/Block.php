<?php

namespace Modules\Pagebuilder\Entities;

use App\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Spatie\TranslationLoader\LanguageLine;

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
        //-- Call custom method for converting labels in block content
        $blockContent = Helper::convertLabelsInBlockContent($blockContent);
        return $blockContent;
    }

    public function background(){
        return $this->hasOne(Background::class);
    }


}
