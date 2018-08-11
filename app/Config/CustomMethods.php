<?php


//-- Custom function that overwrite default asset() method
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

function custom_asset($path, $secure = null){
    return asset('public/'.$path);
}

//-- Functionality for programmatically replace variables in env file
function setEnvironmentValue($envKey, $envValue)
{
    $envFile = app()->environmentFilePath();

    $str = file_get_contents($envFile);

    $oldValue = env($envKey);

    $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}", $str);

    $fp = fopen($envFile, 'w');
    fwrite($fp, $str);
    fclose($fp);
}


/**
 * Function that build menu & submenu items
 *
 * @param integer $intParentNo
 * @param $menuCollection
 *
 * @return string $strMenu
 */
function BuildMenu($intParentNo, $collectionMenu)
{
    //-- Build menu list of all sub menu items for specific $intParentNo
    $strMenu = "";

    //-- Trying to get menu from Redis cache depending on current user
    $userMenu = Cache::tags(['menu_'.Auth::id()])->get('menu_'.$intParentNo);

    if(!$userMenu){
        //dd('normal');
        $strMenu = BuildMenuHTML($collectionMenu, $intParentNo, $strMenu);
        Cache::tags(['menu_'.Auth::id()])->put('menu_'.$intParentNo, $strMenu, 22 * 60);
    }else{

        //dd('FROM CACHE');
        $strMenu=$userMenu;
    }

    return $strMenu;
}

function BuildMenuHTML($collectionMenu, $intParentNo, &$strMenu, $subMenu=false)
{
    if (count($collectionMenu->getMenu()->where('parent', $intParentNo)) > 0) {

        $strMenu .= "<ul class='dropdown-menu'>";
        foreach ($collectionMenu->getMenu()->where('parent', $intParentNo) as $menuItem) {
            $strMenu .= "<li>";

            if($menuItem->route_id_parameter=="Y"){
                $strPath = route($menuItem->route,['id' => \Auth::id()]);
            }else{
                $strPath = route($menuItem->route);
            }

            if (count($collectionMenu->getMenu()->where('parent', $menuItem->id)) > 0) {
                $strMenu .= "  <li class=\"dropdown dropdown-submenu\">
                                <a href='" . $strPath . "' class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$collectionMenu->getMenu()->where('id', $menuItem->id)->first()->langs->where('lang',strtoupper(App::getLocale()))->first()->name."</a>";

                BuildMenuHTML($collectionMenu, $menuItem->id, $strMenu,$subMenu=true);
                $strMenu .= "</li>";
            }else{
                $strMenu .="<a href='" . $strPath . "'>".$menuItem->langs->where('lang',strtoupper(App::getLocale()))->first()->name."</a>";
            }
            $strMenu .= "</li>";
        }
        $strMenu .= "</ul>";

        return $strMenu;
    }
}