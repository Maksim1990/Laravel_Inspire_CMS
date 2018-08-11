<?php

namespace App\Http\ViewComposers;

use App\Helper;
use App\Menu\Menu;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FooterComposer
{

    public $appLanguages = [];
    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct()
    {

        $this->appLanguages=Helper::GetDefaultLanguages();
        //-- Store menu collection and additional debugging information into array
        $this->arrData = [
            "appLanguages" => $this->appLanguages
        ];

        $this->arrData = collect($this->arrData);
        //-- Add additional collection methods for easily retrieve collection's data
        Collection::macro('getAppLanguages', function () {
            return $this["appLanguages"];
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
        $view->with('appFooter', $this->arrData);
    }
}