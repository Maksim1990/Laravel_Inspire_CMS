<?php

namespace App\Http\Controllers\Auth;

use App\Config\DefaultMenuLangs;
use App\Helper;
use App\Menu\Menu;
use App\Menu\MenuLang;
use App\Menu\UserMenu;
use App\Setting;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Dashboard\Entities\Language;
use Modules\Dashboard\Entities\SocialIcon;
use Modules\Pagebuilder\Entities\Block;
use Modules\Pagebuilder\Entities\BlockContent;
use Modules\Pagebuilder\Entities\BlockDefault;
use Modules\Pagebuilder\Entities\UserBlockPivot;
use Modules\Website\Entities\WebsiteSetting;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;


    /**
     * @return string
     */
    public function redirectTo()
    {
        return '/'.LaravelLocalization::getCurrentLocale().'/admin/'.Auth::id().'/dashboard';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user=User::create([
            'name' => $data['name'],
            'admin' => 0,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        //****** END USER ******//


        //-- Create SETTINGS details for new user
        Setting::create([
            'user_id' => $user->id,
            'custom_css' => '/* Your custom CSS will be here */'
        ]);
        //****** END SETTINGS ******//

        //-- Create WEBSITE SETTINGS details for new user
        WebsiteSetting::create([
            'user_id' => $user->id,
            'website_name' => date("Y_m_d_h_i_s")."_".$user->id."_website",
        ]);
        //****** END WEBSITE SETTINGS ******//

        //-- Create SOCIAL ICONS details for new user
        SocialIcon::create([
            'user_id' => $user->id
        ]);
        //****** END SOCIAL ICONS ******//

        //-- Create MENU details for new user
        $menuList = Menu::where('id', '<>', '0')->orderBy('id', 'DESC')->first();
        if (!empty($menuList)) {
            $intLastMenuId = $menuList->id;
        } else {
            $intLastMenuId = 0;
        }

        $arrOfDefaultMenus = DefaultMenuLangs::DEFAULT_LANGS;
        $arrOfDefaultLanguages = Helper::GetDefaultLanguages();

        $menuNew = Menu::where('id', $intLastMenuId)->first();
        foreach ($arrOfDefaultMenus as $menuID => $strMenuDetails) {
            $intLastMenuId++;
            if ($menuNew->id) {
                foreach ($arrOfDefaultLanguages as $strLang => $strFullLang) {
                    MenuLang::create([
                        'id' => $menuID,
                        'user_id' => $user->id,
                        'name' => $strMenuDetails['languages'][strtoupper($strLang)],
                        'lang' => strtoupper($strLang)
                    ]);
                }
                UserMenu::create([
                    'menu_id' => $menuID,
                    'user_id' => $user->id,
                    'active'=>'Y',
                    'parent' => $strMenuDetails['parent'],
                    'sortorder' => $strMenuDetails['sortorder']
                ]);
            }
        }
        //****** END MENU ******//



        //-- Create PAGEBUILDER BLOCKS default details for new user
        $blockDefaults=BlockDefault::all();
        if(!empty($blockDefaults)){
            foreach ($blockDefaults as $defaultBlock){
                $block=Block::create([
                    'user_id' => $user->id,
                    'block_id' => $defaultBlock->block_id."_".$user->id,
                    'block_custom_id' => $defaultBlock->block_custom_id,
                    'sortorder' => $defaultBlock->id
                ]);

                $blockContent=BlockContent::create([
                    'id' => $block->id,
                    'content' => $defaultBlock->content,
                    'block_template' => $defaultBlock->block_template
                ]);

                UserBlockPivot::create([
                    'block_id' => $block->id,
                    'block_content_id' => $blockContent->id
                ]);
            }
        }
        //****** END PAGEBUILDER BLOCKS ******//




        //-- Create DEFAULT LANGUAGES default details for new user
        //-- Get all active languages
        $arrOfDefaultLanguages = Helper::GetDefaultLanguagesWithNativeNames();
        if(!empty($arrOfDefaultLanguages)){
            foreach ($arrOfDefaultLanguages as $strKey=>$arrLangDetails){
                Language::create([
                    'user_id' => $user->id,
                    'name'=>strtolower($strKey),
                    'native' => $arrLangDetails['native'],
                    'native_en' => $arrLangDetails['native_en'],
                    'active' => 'Y'
                ]);
            }
        }
        //****** END DEFAULT LANGUAGES ******//


        return $user;

    }
}
