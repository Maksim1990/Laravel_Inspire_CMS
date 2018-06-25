<?php

namespace Modules\Pagebuilder\Entities;

use Illuminate\Database\Eloquent\Model;

class BlockContent extends Model
{
    protected $guarded = [];

    public function block()
    {
        //-- Get translation for current menu only for active language
        return $this->belongsTo(Block::class);
    }

}
