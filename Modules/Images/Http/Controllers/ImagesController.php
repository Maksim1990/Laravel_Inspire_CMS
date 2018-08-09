<?php

namespace Modules\Images\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Images\Entities\Photo;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index($id)
    {
        $arrTabs = ['General'];
        $active = "active";

        $userImages = Auth::user()->photos;


        return view('images::index', compact('arrTabs', 'active', 'userImages'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $arrTabs = ['General'];
        $active = "active";

        return view('images::create', compact('arrTabs', 'active'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $result = "success";
        $arrAllowedExtension = ['png', 'jpg', 'jpeg'];

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        if (in_array($extension, $arrAllowedExtension)) {
            if (!($file->getClientSize() > 2100000)) {
                $name = time() ."_".$file->getClientOriginalName();

                request()->file('file')->storeAs(
                    'public/upload/' . Auth::id() . '/photos/', $name
                );

                Photo::create([
                    'user_id' => Auth::id(),
                    'name' => $name,
                    'size' => $file->getClientSize(),
                    'path' => 'upload/' . Auth::id() . '/photos/' . $name
                ]);

            } else {
                $result = "Images with size bigger than 2 MB can't be uploaded!";
            }
        } else {
            $result = "It's allowed to upload only following formats: " . implode(",", $arrAllowedExtension);
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            $result
        ));


    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('images::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('images::edit');
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


    public function deleteImage(Request $request)
    {

        $strError = "";
        $result = "success";

        $photoId = $request->id;
        $photo=Photo::findOrFail($photoId);

        if($photo->path){
            unlink(storage_path('/app/public/'.$photo->path));
            $photo->delete();
        }else{
            $strError = "Image was not found!";
            $result = "";
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));


    }
}
