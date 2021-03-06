<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'user_id', 'active_left_sidebar','custom_css'
    ];
    public function user(){
        return $this->belongsTo('App\User');
    }
}
