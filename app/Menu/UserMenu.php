<?php

namespace App\Menu;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserMenu extends Model
{
    protected $table = "user_menus";
    protected $primaryKey = ['user_id', 'menu_id'];
    public $incrementing = false;
    protected $guarded = [];


    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('user_id', '=', $this->getAttribute('user_id'))
            ->where('menu_id', '=', $this->getAttribute('menu_id'));
        return $query;
    }

}
