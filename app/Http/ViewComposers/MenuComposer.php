<?php

namespace App\Http\ViewComposers;

use App\Menu\Menu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MenuComposer
{
    public $menuList = [];

    private $strCache = "";

    private $arrData = [];
    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct()
    {
        $user=Auth::user();
        $this->menuList="";

        //-- Check if menu data is available from cache
        if (empty($this->menuList)) {
            $this->menuList = Menu::
            //-- Build SQL query for admin user
            when($user->admin == 1, function ($query) use ($user) {
                $query->where(function ($query) {
                    return $query->where("admin", "Y")->where(function ($query) {
                        $query->whereHas('menuActive', function ($query) {
                            $query->where('user_id',Auth::id());
                        })->whereHas('langs', function ($query) {
                            $query->where('user_id',Auth::id());
                        });
                    });
                });
            })
                //-- Build SQL query for NON admin user
                 ->when($user->admin == 0, function ($query) use ($user) {
                     $query->where(function ($query) {
                         return $query->where("admin", "Y")->where(function ($query) {
                             $query->whereHas('menuActive', function ($query) {
                                 $query->where("active", "Y")->where('user_id',Auth::id());
                             })->whereHas('langs', function ($query) {
                                 $query->where('user_id',Auth::id());
                             });
                         });
                     });
                 })
                ->orderBy('id')->get()->keyBy('id');

        } else {
            $this->strCache = "Cached menu";
        }

        //-- Store menu collection and additional debugging information into array
        $this->arrData = [
            "menuList" => $this->menuList
        ];

        $this->arrData = collect($this->arrData);
        //-- Add additional collection methods for easily retrieve collection's data
        Collection::macro('getMenu', function () {

            $this["menuList"]->map(function ($menu) {
                $menu['parent'] = $menu->menuActive[0]->parent;
                return $menu;
            });

            return $this["menuList"];
        });

//        //-- Add additional collection methods for easily retrieve collection's data
//        Collection::macro('getModulesMenu', function () {
//            $collectMenu=[];
//            foreach ($this["menuList"] as $menu){
//
//                if($menu->menuActive[0]->parent==1){
//                    $collectMenu[]=$menu;
//                }
//            }
//            return $collectMenu;
//        });
//
//        //-- Add additional collection methods for easily retrieve collection's data
//        Collection::macro('getSettingsMenu', function () {
//            $collectMenu=[];
//            foreach ($this["menuList"] as $menu){
//
//                if($menu->menuActive[0]->parent==2){
//                    $collectMenu[]=$menu;
//                }
//            }
//            return $collectMenu;
//        });


    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('menuCollection', $this->arrData);
    }
}