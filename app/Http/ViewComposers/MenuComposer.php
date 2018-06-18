<?php

namespace App\Http\ViewComposers;

use App\Menu\Menu;
use Illuminate\View\View;

class MenuComposer
{
    public $menuList = [];
    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->menuList=[1,2,3];
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('menu', $this->menuList);
    }
}