<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Dashboard\Entities\SocialIcon;
use Modules\Website\Entities\WebsiteSetting;

class WebsiteSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $arrTabs = ['General','Social','Google_map_and_Contact_form','Footer'];
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
            $strError = trans('dashboard::messages.website_name_not_updated');
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
            $strError = trans('dashboard::messages.option_was_not_updated');
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));
    }

    public function updateWebsiteGoToTheTopButton(Request $request)
    {
        $strWebsiteGoToTheTopButton = $request->website_go_to_the_top;
        $strError = "";
        $result = "success";

        $websiteSetting=WebsiteSetting::findOrFail(Auth::id());
        $websiteSetting->go_top_button=$strWebsiteGoToTheTopButton;

        if(!$websiteSetting->update()){
            $result = "";
            $strError = trans('dashboard::messages.option_was_not_updated');
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));
    }

    public function updateWebsitePostsPage(Request $request)
    {
        $strWebsitePostsPage = $request->website_posts_page;
        $strError = "";
        $result = "success";

        $websiteSetting=WebsiteSetting::findOrFail(Auth::id());
        $websiteSetting->posts_page=$strWebsitePostsPage;

        if(!$websiteSetting->update()){
            $result = "";
            $strError = trans('dashboard::messages.option_was_not_updated');
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));
    }

    public function updateWebsiteGoogleMap(Request $request)
    {
        $strWebsiteGoogleMap = $request->website_google_map;
        $strError = "";
        $result = "success";

        $websiteSetting=WebsiteSetting::findOrFail(Auth::id());
        $websiteSetting->google_map=$strWebsiteGoogleMap;

        if(!$websiteSetting->update()){
            $result = "";
            $strError = trans('dashboard::messages.option_was_not_updated');
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));
    }


    public function updateWebsiteGoogleMapKey(Request $request)
    {
        $strWebsiteGoogleMapKey = $request->website_google_map_key;
        $strError = "";
        $result = "success";

        $websiteSetting=WebsiteSetting::findOrFail(Auth::id());
        $websiteSetting->google_map_key=$strWebsiteGoogleMapKey;

        if(!$websiteSetting->update()){
            $result = "";
            $strError = trans('dashboard::messages.website_google_maps_key_not_updated');
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));
    }


    /**
     * Update Github social icon URL for specific user
     *
     * @param Request $request
     */
    public function updateWebsiteGithub(Request $request)
    {
        $strGithub = $request->github;
        $strError = "";
        $result = "success";

        $socialIcons=SocialIcon::findOrFail(Auth::id());
        $socialIcons->github=$strGithub;

        if(!$socialIcons->update()){
            $result = "";
            $strError = "Option was not updated. Please try again!";
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));
    }

    /**
     * Update Facebook social icon URL for specific user
     *
     * @param Request $request
     */
    public function updateWebsiteFacebook(Request $request)
    {
        $strFacebook = $request->facebook;
        $strError = "";
        $result = "success";

        $socialIcons=SocialIcon::findOrFail(Auth::id());
        $socialIcons->facebook=$strFacebook;

        if(!$socialIcons->update()){
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
     * Update VK social icon URL for specific user
     *
     * @param Request $request
     */
    public function updateWebsiteVk(Request $request)
    {
        $strVK = $request->vk;
        $strError = "";
        $result = "success";

        $socialIcons=SocialIcon::findOrFail(Auth::id());
        $socialIcons->vk=$strVK;

        if(!$socialIcons->update()){
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
     * Update LinkedIn social icon URL for specific user
     *
     * @param Request $request
     */
    public function updateWebsiteLinkedin(Request $request)
    {
        $strLinkedIn = $request->linkedin;
        $strError = "";
        $result = "success";

        $socialIcons=SocialIcon::findOrFail(Auth::id());
        $socialIcons->linkedin=$strLinkedIn;

        if(!$socialIcons->update()){
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
     * Update Line social icon URL for specific user
     *
     * @param Request $request
     */
    public function updateWebsiteLine(Request $request)
    {
        $strLine = $request->line;
        $strError = "";
        $result = "success";

        $socialIcons=SocialIcon::findOrFail(Auth::id());
        $socialIcons->line=$strLine;

        if(!$socialIcons->update()){
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
     * Update Instagram social icon URL for specific user
     *
     * @param Request $request
     */
    public function updateWebsiteInstagram(Request $request)
    {
        $strInstagram = $request->instagram;
        $strError = "";
        $result = "success";

        $socialIcons=SocialIcon::findOrFail(Auth::id());
        $socialIcons->instagram=$strInstagram;

        if(!$socialIcons->update()){
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
     * Update Pinterest social icon URL for specific user
     *
     * @param Request $request
     */
    public function updateWebsitePinterest(Request $request)
    {
        $strPinterest = $request->pinterest;
        $strError = "";
        $result = "success";

        $socialIcons=SocialIcon::findOrFail(Auth::id());
        $socialIcons->pinterest=$strPinterest;

        if(!$socialIcons->update()){
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
     * Update Twitter social icon URL for specific user
     *
     * @param Request $request
     */
    public function updateWebsiteTwitter(Request $request)
    {
        $strTwitter = $request->twitter;
        $strError = "";
        $result = "success";

        $socialIcons=SocialIcon::findOrFail(Auth::id());
        $socialIcons->twitter=$strTwitter;

        if(!$socialIcons->update()){
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
     * Update Google social icon URL for specific user
     *
     * @param Request $request
     */
    public function updateWebsiteGoogle(Request $request)
    {
        $strGoogle = $request->google;
        $strError = "";
        $result = "success";

        $socialIcons=SocialIcon::findOrFail(Auth::id());
        $socialIcons->google=$strGoogle;

        if(!$socialIcons->update()){
            $result = "";
            $strError = trans('dashboard::messages.option_was_not_updated');
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));
    }
}
