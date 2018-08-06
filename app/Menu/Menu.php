<?php

namespace App\Menu;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = "menus";
    protected $guarded = [];
    protected $with = ['langs','menuActive'];


    public function langs(){
        return $this->hasMany('App\Menu\MenuLang','id')->where('user_id',\Auth::id());
    }

    public function menuActive(){
        return $this->hasMany('App\Menu\UserMenu','menu_id')->where('user_id',\Auth::id());
    }

}
