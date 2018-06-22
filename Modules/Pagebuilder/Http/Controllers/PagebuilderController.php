<?php

namespace Modules\Pagebuilder\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PagebuilderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $arrTabs = ['General'];
        $active = "active";


        return view('pagebuilder::index', compact('arrTabs', 'active'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('pagebuilder::create');
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
        return view('pagebuilder::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('pagebuilder::edit');
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


    public function editor()
    {
        $arrTabs = ['General'];
        $active = "active";


        return view('pagebuilder::editor.index', compact('arrTabs', 'active'));
    }

    public function editorUploadImage(Request $request)
    {
        $file = $request->file('file');
        $filename = Auth::id()."_".time() . "_" . $file->getClientOriginalName();

        request()->file('file')->storeAs(
            'public/upload/'.Auth::id().'/', $filename
        );

        return json_encode(['location' => asset('storage/upload/'.Auth::id().'/'.$filename)]);



    }
}
