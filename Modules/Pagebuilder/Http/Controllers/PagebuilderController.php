<?php

namespace Modules\Pagebuilder\Http\Controllers;

use App\Helper;
use App\Setting;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mews\Purifier\Facades\Purifier;
use Modules\Dashboard\Entities\AdminSettings;
use Modules\Pagebuilder\Entities\Background;
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
        $arrTabs = ['General','Settings','Social'];
        $active = "active";
        $websiteBlocks = Block::where('user_id', $user->id)->where('active','Y')->orderBy('sortorder', 'ASC')->get();

        $admin=User::where('admin',1)->first();
        $adminSettings=AdminSettings::where('user_id',$admin->id)->first();
        $customSetting = Setting::where('user_id', $id)->first();

        return view('pagebuilder::index', compact('arrTabs', 'active', 'websiteBlocks','adminSettings','customSetting'));
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function blockOrderAndNew($id)
    {

        $arrTabs = ['General'];
        $active = "active";
        $hideScript=true;

        return view('pagebuilder::block_order', compact('arrTabs', 'active','hideScript'));
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

        return json_encode(['location' => custom_asset('storage/upload/' . Auth::id() . '/' . $filename)]);

    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function css($id)
    {

        $customSetting = Setting::where('user_id', $id)->first();
        $arrTabs = ['General'];
        $active = "active";

        return view('pagebuilder::css.index', compact('arrTabs', 'active', 'customSetting'));
    }

    /**
     * Functionality to change block background
     *
     * @param $id
     * @return Response
     */
    public function background($id)
    {
        $arrTabs = ['General'];
        $active = "active";

        $block_id=$id;
        $blockBackground = Background::where('user_id', Auth::id())->where('block_id',$id)->first();
        $userImages = Auth::user()->photos;

        return view('pagebuilder::css.background', compact('arrTabs', 'active','block_id','blockBackground','userImages'));
    }

    /**
     * Functionality for update background color for specific block
     *
     * @param Request $request
     */
    public function blockBackgroundUpdate(Request $request)
    {
        $bg_color = $request['bg_color'];
        $background_type = $request['background_type'];
        $block_id = $request['block_id'];
        $result = "";


        $background = Background::firstOrNew(array('user_id' => Auth::id(),'block_id'=>$block_id));
        $background->background_type = $background_type;
        $background->color = $bg_color;
        $background->user_id = Auth::id();

        if ($background->save()) {
            $result = "success";
        }
        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result
        ));
    }

    /**
     * Functionality for update background type for specific block
     *
     * @param Request $request
     */
    public function blockBackgroundTypeUpdate(Request $request)
    {
        $background_type = $request['background_type'];
        $block_id = $request['block_id'];
        $result = "";


        $background = Background::firstOrNew(array('user_id' => Auth::id(),'block_id'=>$block_id));
        $background->background_type = $background_type;
        $background->user_id = Auth::id();

        if ($background->save()) {
            $result = "success";
        }
        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result
        ));
    }

    /**
     * Functionality for update background image for specific block
     *
     * @param Request $request
     */
    public function blockBackgroundImageUpdate(Request $request)
    {
        $background_type = $request['background_type'];
        $block_id = $request['block_id'];
        $imagePath = $request['imagePath'];
        $result = "";


        $background = Background::firstOrNew(array('user_id' => Auth::id(),'block_id'=>$block_id));
        if(!empty( $background->image_name)){
            $background->image_name = null;
            $background->image_size = null;
            $background->image_extension = null;
            if(file_exists(storage_path('/app/public/' . $background->image_path))){
                unlink(storage_path('/app/public/' . $background->image_path));
            }
        }
        $background->background_type = $background_type;
        $background->user_id = Auth::id();
        $background->image_path = $imagePath;

        if ($background->save()) {
            $result = "success";
        }
        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result
        ));
    }

    /**
     * Functionality for delete background image for specific block
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteBackgroundImage(Request $request)
    {
        $user_id = $request->user_id;
        $block_id = $request->block_id;
        $background = Background::where('user_id',$user_id)->where('block_id',$block_id)->first();
        if($background){
            if(!empty( $background->image_name)){
                $background->image_name = null;
                $background->image_size = null;
                $background->image_extension = null;
                if(file_exists(storage_path('/app/public/' . $background->image_path))){
                    unlink(storage_path('/app/public/' . $background->image_path));
                }
            }
            $background->image_path = null;
            $background->update();
        }

        //-- Build notification array
        $arrOptions=[
            'message'=>trans('pagebuilder::messages.background_image_deleted'),
            'type'=>'success',
            'position'=>'topRight'
        ];
        Session::flash('background_change', $arrOptions);
        return redirect()->route('background',['id'=>$block_id]);
    }

    /**
     * Functionality for upload background image for specific block
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeBackgroundImage(Request $request)
    {
        $user_id = $request->user_id;
        $block_id = $request->block_id;

        $background = Background::where('user_id',$user_id)->where('block_id',$block_id)->first();

        if ($file = $request->file('photo_id')) {
            $extension = $file->getClientOriginalExtension();
            if (!($file->getClientSize() > 2100000)) {
                if (!empty($background->image_path)) {
                    if(file_exists(storage_path('/app/public/' . $background->image_path))){
                        unlink(storage_path('/app/public/' . $background->image_path));
                    }
                    $background->image_name = null;
                    $background->image_size = null;
                    $background->image_extension = null;
                    $background->image_path=null;
                    $background->update();
                }

                $name = time() . $file->getClientOriginalName();
                request()->file('photo_id')->storeAs(
                    'public/upload/' . Auth::id() . '/background/', $name
                );

                if($background){
                    $background->image_name = $name;
                    $background->image_size = $file->getClientSize();
                    $background->image_extension = $extension;
                    $background->image_path='upload/' . Auth::id() . '/background/'. $name;
                    $background->update();
                }else{
                    Background::create([
                        'user_id' => $user_id,
                        'block_id' => $block_id,
                        'background_type' => 'image',
                        'image_name' => $name,
                        'image_size' => $file->getClientSize(),
                        'image_extension' => $extension,
                        'image_path' => 'upload/' . Auth::id() . '/background/'. $name
                    ]);
                }


                //-- Build notification array
                $arrOptions=[
                    'message'=>trans('pagebuilder::messages.background_image_updated'),
                    'type'=>'success',
                    'position'=>'topRight'
                ];

                Session::flash('background_change', $arrOptions);
                return redirect()->route('background',['id'=>$block_id]);
            } else {
                //-- Build notification array
                $arrOptions=[
                    'message'=>trans('pagebuilder::messages.background_image_size_error'),
                    'type'=>'error',
                    'position'=>'bottomLeft'
                ];
                Session::flash('background_change', $arrOptions);
                return redirect()->route('background',['id'=>$block_id]);
            }
        }
    }

    /**
     * Functionality to dispaly info about specific pagebuilder block
     *
     * @param $id
     * @return Response
     */
    public function blockInfo($id)
    {
        $arrTabs = ['General'];
        $active = "active";
        $user_id=Auth::id();


        return view('pagebuilder::css.info', compact('arrTabs', 'active'));
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

    public function blocksSortOrderUpdate(Request $request)
    {
        $arrIDs = $request['arrIDs'];
        $result = "success";

        if(count($arrIDs)>0){
            $intSortOrder=1;
            foreach ($arrIDs as $id){
                $block=Block::findOrFail($id);
                $block->sortorder=$intSortOrder;
                if(!$block->update()){
                    $result = "";
                }
                $intSortOrder++;
            }
        }


        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result
        ));
    }


    public function codeeditorSetting($id)
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
