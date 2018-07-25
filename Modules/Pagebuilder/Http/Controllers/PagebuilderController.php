<?php

namespace Modules\Pagebuilder\Http\Controllers;

use App\Helper;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;
use Modules\Pagebuilder\Entities\Block;

class PagebuilderController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index($id)
    {

        $user = User::findOrFail($id);
        $arrTabs = ['General','Settings'];
        $active = "active";
        $websiteBlocks = Block::where('user_id', $user->id)->orderBy('sortorder', 'ASC')->get();

        return view('pagebuilder::index', compact('arrTabs', 'active', 'websiteBlocks'));
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

    public function code_editor($block_id)
    {

        $websiteBlock = Block::where('id', $block_id)->first();
        $blockCode = "";
        $arrTabs = ['General'];
        $active = "active";
        if (!empty($websiteBlock->content->first()->content)) {
            $blockCode = $websiteBlock->content->first()->content;
        }


        return view('pagebuilder::codeeditor.index', compact('arrTabs', 'active', 'blockCode', 'block_id'));
    }

    public function codeEditorUpdate(Request $request)
    {
        $codeEditorContent = $request['codeEditorContent'];
        $block_id = $request['block_id'];
        $result = "";

        $websiteBlock = Block::where('id', $block_id)->first();

        $websiteBlockContent = $websiteBlock->content->first();

        // $codeEditorContent=str_replace('@lang',"",$codeEditorContent);

        //-- Prevent XSS JS injection
        //-- Removing not allowed <script> tags
        $codeEditorContent = Purifier::clean($codeEditorContent, array('Attr.EnableID' => true));


        $websiteBlockContent->content = $codeEditorContent;
        if ($websiteBlockContent->save()) {
            $result = "success";
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result
        ));

    }


    public function codeEditorThemeUpdate(Request $request)
    {
        $result = "";
        $codeEditorTheme=$request->codeEditorTheme;


        $settings=Auth::user()->setting;
        $settings->codeeditor_theme=$codeEditorTheme;
        if ($settings->save()) {
            $result = "success";
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result
        ));

    }


    public function contentEditorUpdate(Request $request)
    {
        $codeEditorContent = $request['codeEditorContent'];
        $block_id = $request['block_id'];
        $blockID = $request['blockID'];
        $result = "";

        $websiteBlock = Block::where('block_id', $block_id)->first();

        $websiteBlockContent = $websiteBlock->content->first();
        $websiteBlockContent->content = $codeEditorContent;
        if ($websiteBlockContent->save()) {
            $result = "success";
        }

        //-- Check if necessary remove image from the server that is not anymore in the current block
        Helper::CheckIfImageInBlock($codeEditorContent, $blockID);

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result
        ));

    }

    public function editorUploadImage(Request $request)
    {
        $blockID = $request->blockID;
        $file = $request->file('file');
        $filename = Auth::id() . "_" . $blockID . "_" . time() . "_" . $file->getClientOriginalName();

        request()->file('file')->storeAs(
            'public/upload/' . Auth::id() . '/', $filename
        );

        return json_encode(['location' => asset('storage/upload/' . Auth::id() . '/' . $filename)]);

    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function css($id)
    {

        $arrTabs = ['General'];
        $active = "active";
        $customSetting = Setting::where('user_id', $id)->first();
        $blockCode = "";
        $arrTabs = ['General'];
        $active = "active";
        $cssCode = "";

        return view('pagebuilder::css.index', compact('arrTabs', 'active', 'customSetting'));
    }



    public function customCssUpdate(Request $request)
    {
        $customCssContent = $request['customCssContent'];
        $result = "";

        $customSetting = Setting::where('user_id', Auth::id())->first();


        //-- Prevent XSS JS injection
        //-- Removing not allowed <script> tags
        $customCssContent = Purifier::clean($customCssContent, array('Attr.EnableID' => true));

        $customSetting->custom_css = $customCssContent;
        if ($customSetting->save()) {
            $result = "success";
        }
        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result
        ));
    }


    public function cssCodeeditorSetting($id)
    {
        $arrTabs = ['General'];
        $active = "active";
        $arrThemes=[];
        $arrThemesFull=glob(public_path('/plugins/vendor/codemirror/theme/*.{css}'), GLOB_BRACE);
        if(!empty($arrThemesFull)){
            foreach ($arrThemesFull as $strTheme){
                $arrThemes[]= basename($strTheme,'.css');
            }
        }
       // dd($arrThemes);

        return view('pagebuilder::codeeditor.settings', compact('arrTabs', 'active','arrThemes'));
    }


}
