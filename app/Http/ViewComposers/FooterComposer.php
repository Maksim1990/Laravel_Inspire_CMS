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
        $arrActiveLanguages=Helper::GetActiveLanguages();
        //-- Store default languages collection and additional debugging information into array
        $this->arrData = [
            "appLanguages" => $this->appLanguages,
            "arrActiveLanguages" => $arrActiveLanguages,
        ];

        $this->arrData = collect($this->arrData);
        //-- Add additional collection methods for easily retrieve collection's data
        Collection::macro('getAppLanguages', function () {
            return $this["appLanguages"];
        });

        Collection::macro('getActiveLanguages', function () {
            return $this["arrActiveLanguages"];
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