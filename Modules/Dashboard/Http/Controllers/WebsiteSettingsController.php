<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Website\Entities\WebsiteSetting;

class WebsiteSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $arrTabs = ['General','Social'];
        $active = "active";
        return view('dashboard::website_settings.index', compact('arrTabs', 'active'));
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


    public function updateWebsiteName(Request $request)
    {
        $strWebsiteName = $request->website_name;
        $strError = "";
        $result = "success";

        $websiteSetting=WebsiteSetting::findOrFail(Auth::id());
        $websiteSetting->website_name=$strWebsiteName;

        if(!$websiteSetting->update()){
            $result = "";
            $strError = "Website name was not update. Please try again!";
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));
    }

    public function updateWebsiteEmailForm(Request $request)
    {
        $strWebsiteEmailForm = $request->website_email_form;
        $strError = "";
        $result = "success";

        $websiteSetting=WebsiteSetting::findOrFail(Auth::id());
        $websiteSetting->email_form=$strWebsiteEmailForm;

        if(!$websiteSetting->update()){
            $result = "";
            $strError = "Option was not update. Please try again!";
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));
    }
}
