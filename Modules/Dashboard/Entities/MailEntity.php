<?php

namespace Modules\Dashboard\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MailEntity extends Model
{
    protected $table = "mails";
    protected $guarded = [];

    //-- Modify created_at attribute
    public function getCreatedAtAttribute($date)
    {
        $date = Carbon::parse($date);

        return $date->diffForHumans();
    }

}
