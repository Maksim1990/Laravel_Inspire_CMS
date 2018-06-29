<?php

namespace Modules\Website\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;
use Modules\Pagebuilder\Entities\Block;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {

        $websiteBlocks=Block::where('user_id',Auth::id())->orderBy('sortorder','ASC')->get();

//        $var1='<h2><img title="TinyMCE Logo" src="//www.tinymce.com/images/glyph-tinymce@2x.png" alt="TinyMCE Logo" width="110" height="97" style="float: right"/>TinyMCE Inline Mode</h2>
//        <div class="w3-row">
//            <div class="w3-col s4 w3-green w3-center"><p>s4</p></div>
//            <div class="w3-col s4 w3-dark-grey w3-center"><p>s4</p></div>
//            <div class="w3-col s4 w3-red w3-center"><p>s4</p></div>
//            <script >alert("Hello!");</script>
//        </div>';
//
//        $var2=Purifier::clean($var1, array('Attr.EnableID' => true));
//        //dd($var2);

        return view('website::index',compact('websiteBlocks'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('website::create');
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
        return view('website::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('website::edit');
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



    public function pageNotFound()
    {
        return view('errors.404_g');
    }


}
