<?php

namespace Modules\Dashboard\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;

class MailTemplate extends Model
{
    protected $table = "mail_templates";
    protected $guarded = [];

}
