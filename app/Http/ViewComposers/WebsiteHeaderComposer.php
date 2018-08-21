<?php
/**
 * Created by PhpStorm.
 * User: narus
 * Date: 18.08.2018
 * Time: 21:26
 */

namespace App\Http\ViewComposers;
use App\Setting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Modules\Dashboard\Entities\SocialIcon;
use Modules\Pagebuilder\Entities\Block;

class WebsiteHeaderComposer
{

    private $arrBlocks;

    private $arrData;

    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct()
    {


        $this->arrBlocks=Block::where('user_id',Auth::id())->get();
        $arrSocialIcons=SocialIcon::where('user_id',Auth::id())->first();
        $customSetting = Setting::where('user_id', Auth::id())->first();



        //-- Store user blocks collection and additional debugging information into array
        $this->arrData = [
            "arrBlocks" => $this->arrBlocks,
            "arrWebsiteSettings" => Auth::user()->website_setting,
            "arrSocialIcons" => $arrSocialIcons,
            "customSettings" => $customSetting,
        ];

        $this->arrData = collect($this->arrData);
        //-- Add additional collection methods for easily retrieve collection's data
        Collection::macro('getBlocks', function () {
            return $this["arrBlocks"];
        });

        Collection::macro('getWebsiteSettings', function () {
            return $this["arrWebsiteSettings"];
        });

        Collection::macro('getSocialIcons', function () {
            return $this["arrSocialIcons"];
        });

        Collection::macro('getCustomSettings', function () {
            return $this["customSettings"];
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
        $view->with('dataWebsite', $this->arrData);
    }

}