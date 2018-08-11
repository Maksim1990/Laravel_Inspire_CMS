<?php

namespace App\Http\ViewComposers;

use App\Helper;
use App\Menu\Menu;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Modules\Dashboard\Entities\AdminSettings;

class SidebarComposer
{

    public $appVersion ="";
    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct()
    {

        $admin=User::where('admin',1)->first();
        $adminSettings=AdminSettings::where('user_id',$admin->id)->first();
        $this->appVersion=$adminSettings->app_version;

        //-- Store admin settings collection and additional debugging information into array
        $this->arrData = [
            "appVersion" => $this->appVersion
        ];

        $this->arrData = collect($this->arrData);
        //-- Add additional collection methods for easily retrieve collection's data
        Collection::macro('getAppVersion', function () {
            return $this["appVersion"];
        });
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('dataSidebar', $this->arrData);
    }
}