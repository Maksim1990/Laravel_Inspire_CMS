<?php

namespace Modules\Website\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;
use Modules\Dashboard\Entities\AdminSettings;
use Modules\Pagebuilder\Entities\Block;
use Modules\Post\Entities\Post;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index($id)
    {

        $websiteBlocks=Block::where('user_id',Auth::id())->where('active','Y')->orderBy('sortorder','ASC')->get();
        $admin=User::where('admin',1)->first();
        $adminSettings=AdminSettings::where('user_id',$admin->id)->first();


        return view('website::index',compact('websiteBlocks','adminSettings'));
    }

    public function posts($id)
    {

        $blnShowContactForm=false;
        $posts=Post::where('user_id',$id)->orderBy('created_at','DESC')->paginate(10);

        return view('website::posts',compact('blnShowContactForm','posts'));
    }

    public function showPost($id,$sitename,$post_id)
    {

        $blnShowContactForm=false;
        $post=Post::where('id',$post_id)->first();

        return view('website::post',compact('blnShowContactForm','post'));
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
