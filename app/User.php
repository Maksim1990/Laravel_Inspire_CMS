<?php

namespace App;

use App\Menu\Menu;
use App\Menu\UserMenu;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Dashboard\Entities\AdminSettings;
use Modules\Dashboard\Entities\MailEntity;
use Modules\Dashboard\Entities\SocialIcon;
use Modules\Images\Entities\Photo;
use Modules\Website\Entities\WebsiteSetting;

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

    public function website_setting(){
        return $this->hasOne(WebsiteSetting::class);
    }

    public function admin_setting(){
        return $this->hasOne(AdminSettings::class);
    }

    public function social_icons(){
        return $this->hasOne(SocialIcon::class);
    }

    public function image(){
        return $this->hasOne('App\Image');
    }

    public function photos(){
        return $this->hasMany(Photo::class);
    }

    public function mails(){
        return $this->hasMany(MailEntity::class);
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
