<?php

namespace App;

use App\Menu\Menu;
use App\Menu\UserMenu;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Images\Entities\Photo;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function setting(){
        return $this->hasOne('App\Setting');
    }

    public function image(){
        return $this->hasOne('App\Image');
    }

    public function photos(){
        return $this->hasMany(Photo::class);
    }


    public function menu(){
        return $this->hasManyThrough(
            Menu::class,
            UserMenu::class,
            'user_id',
            'id',
            'id',
            'menu_id'
        );
    }

}
