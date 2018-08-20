<?php
/**
 * Created by PhpStorm.
 * User: Maxim.Narushevich
 * Date: 20.08.2018
 * Time: 10:45
 */

namespace App\Http\ViewComposers;

use App\Helper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Modules\Dashboard\Entities\MailTemplate;

class MailComposer
{

    private $arrData;
    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct()
    {

        $template=MailTemplate::where('user_id',Auth::id())->where('active','Y')->first();

        $this->arrData = [
            "template" => $template
        ];

        $this->arrData = collect($this->arrData);
        //-- Add additional collection methods for easily retrieve collection's data
        Collection::macro('getTemplate', function () {
            return $this["template"];
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
        $view->with('appMail', $this->arrData);
    }
}