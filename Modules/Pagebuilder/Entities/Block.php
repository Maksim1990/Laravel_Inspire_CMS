<?php

namespace Modules\Pagebuilder\Entities;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $table="blocks";
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

}
