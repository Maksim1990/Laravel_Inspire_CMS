<?php

function custom_asset($path, $secure = null){
    return asset('public/'.$path);
}