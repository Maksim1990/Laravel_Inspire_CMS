<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Image extends Model
{
    protected $fillable = [
        'user_id', 'path',
    ];


    /**
     * @return array
     */
    public function getFullPathAttribute()
    {
        return asset('storage/upload/' . Auth::id() . '/profile/' . $this->path);
    }


}
