<?php

namespace App\Menu;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class MenuLang extends Model
{
    protected $table = "menu_langs";
    protected $primaryKey = ['user_id', 'id','lang'];
    public $incrementing = false;
    protected $guarded = [];

    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('user_id', '=', $this->getAttribute('user_id'))
            ->where('id', '=', $this->getAttribute('id'))
            ->where('lang', '=', $this->getAttribute('lang'));
        return $query;
    }

}
