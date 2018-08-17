<?php

namespace Modules\Dashboard\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Document extends Model
{
    protected $table = "documents";
    protected $guarded = [];

    //-- Modify created_at attribute
    public function getCreatedAtAttribute($date)
    {
        $date = Carbon::parse($date);

        return $date->diffForHumans();
    }
}
