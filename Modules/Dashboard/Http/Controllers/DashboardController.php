<?php

namespace Modules\Dashboard\Http\Controllers;


use App\Config\ConfigLang;
use App\Config\DefaultMenuLangs;
use App\Helper;
use App\Menu\Menu;
use App\Menu\MenuLang;
use App\Menu\UserMenu;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Dashboard\Entities\Language;
use Modules\Pagebuilder\Entities\Block;
use Modules\Pagebuilder\Entities\BlockContent;
use Modules\Pagebuilder\Entities\BlockDefault;
use Modules\Pagebuilder\Entities\UserBlockPivot;
use Spatie\TranslationLoader\LanguageLine;

class DashboardController extends Controller
{


    /**
     * Display a listing of the resource.
     * @param integer $id
     * @return Response
     */
    public function index($id)
    {
        $arrTabs = ['General'];
        $active = "active";
        return view('dashboard::index', compact('arrTabs', 'active'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('dashboard::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('dashboard::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('dashboard::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    public function aboutUs()
    {
        $arrTabs = ['General'];
        $active = "active";

//        $cache = Cache::tags(['books'])->get('books_1');
//        dd($cache);
//        Cache::tags(['books'])->put('books_1', 30, 22 * 60);

        return view('dashboard::about', compact('arrTabs', 'active'));
    }


    public function contacts()
    {
        $arrTabs = ['General'];
        $active = "active";
        return view('dashboard::contact_us', compact('arrTabs', 'active'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function menu($id)
    {
        $arrTabs = ['General'];
        $active = "active";


        $menuList = Menu::where('id', '<>', '0')->orderBy('id', 'DESC')->first();
        if (!empty($menuList)) {
            $intLastMenuId = $menuList->id;
        } else {
            $intLastMenuId = 0;
        }


        $arrOfActiveLanguages = Helper::GetActiveLanguages();


        $user = Auth::user();

        //TODO For building menu list
//        $userMenus=Menu::where('active','Y')->whereHas('menuActive', function ($query) {
//            $query->where('active', 'Y')->where('user_id',Auth::id());
//        })->get();


        // dd($userMenus);
        $userMenus = Menu::whereHas('menuActive', function ($query) {
            //$query->where('user_id', Auth::id())->whereIn('menu_id',[1,2]);
            $query->where('user_id', Auth::id());
        })->get();


        return view('admin.menu', compact('arrTabs', 'active', 'userMenus', 'intLastMenuId', 'arrOfActiveLanguages'));
    }


    /**
     * @param Request $request
     */
    public function updateMenu(Request $request)
    {

        $arrMenuIds = $request['arrMenuIds'];
        $arrMenuKeys = $request['arrMenuKeys'];
        $arrMenuLangs = $request['arrMenuLangs'];
        $strError = "";
        $result = "success";

        //-- Get all active languages
        $arrOfActiveLanguages = Helper::GetActiveLanguages();


        if (count($arrMenuIds) > 0) {
            foreach ($arrMenuIds as $intId) {
                if(Auth::user()->admin){
                    try {
                        $menu = Menu::findOrFail($intId);
                        $menu->admin = $arrMenuKeys[$intId . "_menu_active_admin"];
                        $menu->update();
                    } catch (\Exception $e) {
                        Menu::create([
                            'id' => $intId,
                            'admin' => $arrMenuKeys[$intId . "_menu_active_admin"]
                        ]);
                    }
                }



                foreach ($arrOfActiveLanguages as $strKey => $strLang) {
                    $menuLang = MenuLang::where('id', $intId)->where('user_id', Auth::id())->where('lang', strtoupper($strKey))->first();
                    $strName = !empty($arrMenuLangs[$intId . "_" . strtolower($strKey)]) ? $arrMenuLangs[$intId . "_" . strtolower($strKey)] : "";
                    if ($menuLang) {
                        $menuLang->name = $strName;
                        $menuLang->update();
                    } else {
                        if (!empty($strName)) {
                            MenuLang::create([
                                'id' => $intId,
                                'user_id' => Auth::id(),
                                'name' => $strName,
                                'lang' => strtoupper($strKey)
                            ]);
                        }
                    }
                }

                $userMenu = UserMenu::where('menu_id', $intId)->where('user_id', Auth::id())->first();
                if ($userMenu) {
                    if(isset($arrMenuKeys[$intId . "_menu_active"])){
                        $userMenu->active = $arrMenuKeys[$intId . "_menu_active"];
                    }

                    if(isset($arrMenuKeys[$intId . "_menu_parent"])) {
                        $userMenu->parent = $arrMenuKeys[$intId . "_menu_parent"];
                    }

                    if(isset($arrMenuKeys[$intId . "_menu_sortorder"])) {
                        $userMenu->sortorder = $arrMenuKeys[$intId . "_menu_sortorder"];
                    }
                    $userMenu->update();
                } else {
                    UserMenu::create([
                        'user_id' => Auth::id(),
                        'menu_id' => $intId,
                        'active' => "Y",
                        'parent' => isset($arrMenuKeys[$intId . "_menu_parent"]) ? $arrMenuKeys[$intId . "_menu_parent"] : 0,
                        'sortorder' => $arrMenuKeys[$intId . "_menu_sortorder"]
                    ]);
                }


            }
        }

        //-- Flush cached header menu for current user
        Cache::tags('menu_'.Auth::id())->flush();


        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));

    }

    
    public function deleteMenu(Request $request)
    {

        $intId = $request['id'];
        $strError = "";
        $result = "success";

        $user = Auth::user();


        $deleteMenu = Menu::find($intId);


        if ($deleteMenu->admin == "Y") {
            if ($user->admin) {
                $deleteMenu->delete();
                MenuLang::where('id', $intId)->where('user_id', $user->id)->delete();
                UserMenu::where('menu_id', $intId)->where('user_id', $user->id)->delete();
            } else {
                $result = "";
                $strError = "This menu can be deleted only by admin!";
            }
        } else {
            $deleteMenu->delete();
            MenuLang::where('id', $intId)->where('user_id', $user->id)->delete();
            UserMenu::where('menu_id', $intId)->where('user_id', $user->id)->delete();
        }


        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));

    }


    public function languages($id)
    {
        $arrTabs = ['General'];
        $active = "active";

        //-- Get all active languages
        $arrOfActiveLanguages = Helper::GetActiveLanguages();
        $arrOfActiveLanguagesKeys = array_keys($arrOfActiveLanguages);

        $arrOfDefaultLanguages = Helper::GetDefaultLanguages();
        $arrOfDefaultLanguagesKeys = array_keys($arrOfDefaultLanguages);


        $config = ConfigLang::LANG_ARRAY;
        //dd($config);

        $allAvailableLanguages = LaravelLocalization::getSupportedLocales();

        return view('dashboard::languages', compact('arrTabs', 'active', 'allAvailableLanguages', 'arrOfActiveLanguagesKeys', 'arrOfDefaultLanguagesKeys'));
    }

    public function updateLanguages(Request $request)
    {
        $selectedLangs = $request['selectedLangs'];
        $strError = "";
        $result = "success";

        $selectedLangsKeys = array();

        if (!empty($selectedLangs)) {
            foreach ($selectedLangs as $langItem) {
                $arrLangDetails = explode('_', $langItem['value']);
                $selectedLangsKeys[$arrLangDetails[0]]['native'] = $arrLangDetails[1];
                $selectedLangsKeys[$arrLangDetails[0]]['native_en'] = $arrLangDetails[2];
            }

        }


        //-- Get all active languages
        $arrOfActiveLanguages = Helper::GetActiveLanguages();
        $arrOfActiveLanguagesKeys = array_keys($arrOfActiveLanguages);

        foreach ($selectedLangsKeys as $strKey => $strLang) {
            $langItem = Language::where('user_id', Auth::id())->where('name', $strKey)->first();
            if ($langItem) {
                $langItem->active = "Y";
                $langItem->update();
            } else {
                Language::create([
                    'user_id' => Auth::id(),
                    'name' => $strKey,
                    'native' => $strLang['native'],
                    'native_en' => $strLang['native_en'],
                    'active' => "Y"
                ]);
            }

            //-- Delete element from array of active language
            if (($key = array_search(strtoupper($strKey), $arrOfActiveLanguagesKeys)) !== false) {
                unset($arrOfActiveLanguagesKeys[$key]);
            }
        }


        $arrOfDefaultLanguages = Helper::GetDefaultLanguages();
        $arrOfDefaultLanguagesKeys = array_keys($arrOfDefaultLanguages);

        //-- Check if some language should be deactivated
        if (count($arrOfActiveLanguagesKeys) > 0) {
            foreach ($arrOfActiveLanguagesKeys as $langCode) {
                $langItem = Language::where('user_id', Auth::id())->where('name', strtolower($langCode))->first();
                if ($langItem && !in_array(strtoupper($langCode), $arrOfDefaultLanguagesKeys)) {
                    $langItem->active = "N";
                    $langItem->update();
                }
            }
        }


        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));
    }

}
