<?php

namespace Modules\Pagebuilder\Entities;

use Illuminate\Database\Eloquent\Model;

class UserBlockPivot extends Model
{
    protected $table="block_pivot";
    protected $guarded = [];

    public function block()
    {
        //-- Get translation for current menu only for active language
        return $this->belongsTo(Block::class);
    }
}
