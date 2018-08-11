<?php

namespace Modules\Dashboard\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Modules\Dashboard\Entities\AdminSettings;

class AdminSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $arrTabs = ['General'];
        $active = "active";

        $admin=User::where('admin',1)->first();
        $adminSettings=AdminSettings::where('user_id',$admin->id)->first();

        return view('dashboard::admin_settings.index', compact('arrTabs', 'active','adminSettings'));
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

    /**
     * @param $id
     * @return string
     */
    public function resetCache($id){

        //-- Flush cached header menu for current user
        Cache::tags('menu_'.$id)->flush();

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
        $name="";
        $user_id = $request->user_id;
        $user=User::find($user_id);
        if($user){
            //-- Flush cached header menu for current user
            Cache::tags('menu_'.$user_id)->flush();

            $name=$user->name;
        }else{
            $strError = "User with ID ".$user_id." was not found!";
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
     * Reset cache for specific user
     *
     * @param Request $request
     */
    public function ajaxUpdateAppVersion(Request $request)
    {

        $strError = "";
        $result = "success";

        $app_version = $request->app_version;


        $admin=User::where('admin',1)->first();
        $adminSettings=AdminSettings::where('user_id',$admin->id)->first();
        $adminSettings->app_version=$app_version;
        $adminSettings->update();

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));
    }
}
