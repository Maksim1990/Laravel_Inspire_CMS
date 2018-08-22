<?php

namespace Modules\Post\Entities;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";
    protected $guarded = [];


    public function image(){
        return $this->hasOne(PostImage::class);
    }
}
