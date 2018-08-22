<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Config\Elastic;
use App\Helper;
use App\Menu\Menu;
use App\Menu\MenuLang;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Modules\Dashboard\Entities\AdminSettings;
use Modules\Post\Entities\Post;

class AdminSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $arrTabs = ['General','Menu_icons'];
        $active = "active";

        $admin = User::where('admin', 1)->first();
        $adminSettings = AdminSettings::where('user_id', $admin->id)->first();

        $arrElasticSearch = [
            '1' => 'MenuLang'
        ];

        $users=User::pluck('name','id')->all();
        $appMenus=Menu::where('id','>',2)->get();


        return view('dashboard::admin_settings.index', compact('arrTabs', 'active', 'adminSettings', 'arrElasticSearch','users','appMenus'));
    }

    public function search()
    {
        $arrTabs = ['General'];
        $active = "active";


        //$deleteMenu = Menu::find(18);


        $elastic = app(Elastic::class);

//        $posts=MenuLang::where('user_id',Auth::id())->get();
//        $arrErrorDelete=[];
//        foreach ($posts as $post) {
//            try{
//                $elastic->delete([
//                    'index' => 'inspirecms_menus_'.$post->user_id,
//                    'type' => 'menu',
//                    'id' => $post->id."_".$post->user_id."_".$post->lang
//                ]);
//            }catch (\Exception $e) {
//                $arrErrorDelete[]=$post->id."_".$post->user_id."_".$post->lang;
//            }
//        }
//
//        dd($arrErrorDelete);

//        $elastic->index([
//            'index' => 'inspirecms',
//            'type' => 'menu',
//            'id' => 1,
//            'body' => [
//                'title' => 'Hello world!',
//                'content' => 'My first indexed post!'
//    ]
//]);
//
//        $posts=MenuLang::where('user_id',Auth::id())->get();
//            foreach ($posts as $post) {
//                $elastic->index([
//                    'index' => 'inspirecms_menus_'.$post->user_id,
//                    'type' => 'menu',
//                    'id' => $post->id."_".$post->user_id."_".$post->lang,
//                    'body' => $post->toArray()
//                ]);
//            }


        //====== Search by multiple fields ==============//
//        $query = [
//            'multi_match' => [
//                'query' => 'Settings TH',
//                'fields' => ['name', 'lang'],
//                "fuzziness"=> "AUTO",
//            ],
//        ];

        //====== Search by specific field ==============//
        $query = [
            'match' => [
                'user_id' => '3'
            ],
        ];
        //====== Search by wildcard (beginning of each word according to template) ==============//
//        $query = [
//            'wildcard' => [
//                'content' => 'aspernatu*'
//            ],
//        ];

        //====== Search by regex ==============//
//        $query = [
//            'regexp' => [
//                'content' => '[a-z]'
//            ],
//        ];
        //====== Search by phrase ==============//
//        $query = [
//            'multi_match' => [
//                "query" => "Images module",
//                "fields" => ["name", "lang"],
//                "type" => "phrase",
//                "slop" => 3 //Specify range between searching words
//            ],
//        ];


        $parameters = [
            'index' => 'inspirecms_menus_' . Auth::id(),
            'type' => 'menu',
            'body' => [
                'query' => $query,
                'highlight' => [
                    'fields' => [
                        'name' => (object)[],
                        'lang' => (object)[],
                    ]
                ],
                "sort" => [
                    "id" => ["order" => "ASC"]
                ]
            ]
        ];

        $response = $elastic->search($parameters);
        if (!empty($response["hits"]["hits"])) {
            var_dump($response["hits"]["hits"][0]["_id"]);
        }

        var_dump($response);


        //return view('dashboard::search.index', compact('arrTabs', 'active'));
        return view('home');
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


    public function updateAdminFtpCredentials(Request $request)
    {
        $strAdminFtpCredentials = $request->admin_frp_credentials;
        $strError = "";
        $result = "success";

        $adminSetting=AdminSettings::findOrFail(Auth::id());
        $adminSetting->use_admin_ftp_credentials=$strAdminFtpCredentials;

        if(!$adminSetting->update()){
            $result = "";
            $strError = trans('dashboard::messages.option_was_not_updated');
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));
    }


    /**
     * @param $id
     * @return string
     */
    public function resetCache($id)
    {

        //-- Flush cached header menu for current user
        Cache::tags('menu_' . $id)->flush();

        return "Cache was flushed!";
    }

    /**
     * Reset cache for specific user
     *
     * @param Request $request
     */
    public function ajaxResetCache(Request $request)
    {

        $strError = "";
        $result = "success";
        $name = "";
        $user_id = $request->user_id;
        $user = User::find($user_id);
        if ($user) {
            //-- Flush cached header menu for current user
            Cache::tags('menu_' . $user_id)->flush();

            $name = $user->name;
        } else {
            $strError = trans('dashboard::messages.user_with_id')." " . $user_id . " ".strtolower(trans('dashboard::messages.was_not_found'))."!";
            $result = "";
        }


        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'name' => $name,
            'error' => $strError
        ));
    }

    /**
     * Update application version
     *
     * @param Request $request
     */
    public function ajaxUpdateAppVersion(Request $request)
    {
        $strError = "";
        $result = "success";

        $app_version = $request->app_version;


        $admin = User::where('admin', 1)->first();
        $adminSettings = AdminSettings::where('user_id', $admin->id)->first();
        $adminSettings->app_version = $app_version;
        $adminSettings->update();

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));
    }

    public function ajaxUpdateUseRemoteServer(Request $request)
    {
        $strError = "";
        $result = "success";

        $use_remote_server = $request->use_remote_server;


        $admin = User::where('admin', 1)->first();
        $adminSettings = AdminSettings::where('user_id', $admin->id)->first();
        $adminSettings->use_remote_server = $use_remote_server;
        $adminSettings->update();

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));
    }

    public function ajaxUpdateMenuIcon(Request $request)
    {
        $strError = "";
        $result = "success";

        $menuId = $request->menuId;
        $strMenuIcon = $request->strMenuIcon;


        $menu=Menu::where('id',$menuId)->first();
        if($menu){
            $menu->icon=$strMenuIcon;
            $menu->update();
        }else{
            $strError = trans('dashboard::messages.no_menu_items');
            $result = "";
        }


        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));
    }

    public function ajaxUpdateUseElasticSearch(Request $request)
    {
        $strError = "";
        $result = "success";

        $use_elasticsearch = $request->use_elasticsearch;


        $admin = User::where('admin', 1)->first();
        $adminSettings = AdminSettings::where('user_id', $admin->id)->first();
        $adminSettings->use_elasticsearch = $use_elasticsearch;
        $adminSettings->update();

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));
    }

    public function ajaxUpdateRemoteServer(Request $request)
    {
        $strError = "";
        $result = "success";

        $remote_server = $request->remote_server;


        $admin = User::where('admin', 1)->first();
        $adminSettings = AdminSettings::where('user_id', $admin->id)->first();
        $adminSettings->remote_server = $remote_server;
        $adminSettings->update();

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));
    }

    /**
     * Update data for Elastic search cluster
     *
     * @param Request $request
     */
    public function ajaxUpdateElasticSearch(Request $request)
    {

        $strError = "";
        $result = "success";

        $elastic_model = $request->elastic_model;
        $elastic_user_id_update = $request->elastic_user_id_update;


        $elastic = app(Elastic::class);

        if ($elastic_model == 1) {
            $user = User::find($elastic_user_id_update);
            if ($user) {
                $manus = MenuLang::where('user_id', Auth::id())->get();
                foreach ($manus as $manu) {
                    $elastic->index([
                        'index' => 'inspirecms_menus_' . $manu->user_id,
                        'type' => 'menu',
                        'id' => $manu->id . "_" . $manu->user_id . "_" . $manu->lang,
                        'body' => $manu->toArray()
                    ]);
                }
            } else {
                $strError = trans('dashboard::messages.user_with_id')." " . $elastic_user_id_update . " ".strtolower(trans('dashboard::messages.was_not_found'))."!";
                $result = "";
            }

        }


        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));
    }

    /**
     * Update data for Elastic search cluster
     *
     * @param Request $request
     */
    public function ajaxTruncateElasticSearch(Request $request)
    {

        $strError = "";
        $elasticIndex = "";
        $result = "success";

        $elastic_model_remove = $request->elastic_model_remove;
        $elastic_user_id_update_remove = $request->elastic_user_id_update_remove;


        $elastic = app(Elastic::class);

        $menus = MenuLang::where('user_id', Auth::id())->get();
        $arrErrorDelete = [];
        if ($elastic_model_remove == 1) {
            $user = User::find($elastic_user_id_update_remove);
            if ($user) {
                foreach ($menus as $menu) {
                    try {
                        $elastic->delete([
                            'index' => 'inspirecms_menus_' . $menu->user_id,
                            'type' => 'menu',
                            'id' => $menu->id . "_" . $menu->user_id . "_" . $menu->lang
                        ]);
                    } catch (\Exception $e) {
                        $arrErrorDelete[] = $menu->id . "_" . $menu->user_id . "_" . $menu->lang;
                    }
                }

                if (!empty($arrErrorDelete)) {
                    $strError = trans('dashboard::messages.elasticsearch_truncating_was_not_succeed')."!";
                    $result = "";
                    $elasticIndex = 'inspirecms_menus_' . $menu->user_id;
                }

            }else {
                $strError = trans('dashboard::messages.user_with_id')." " . $elastic_user_id_update_remove . " ".strtolower(trans('dashboard::messages.was_not_found'))."!";
                $result = "";
            }
        }else{
            $strError = trans('dashboard::messages.elasticsearch_index_undefined')."!";
            $result = "";
        }





        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError,
            'arrErrorDelete' => $arrErrorDelete,
            'index' => $elasticIndex,
        ));
    }
}
