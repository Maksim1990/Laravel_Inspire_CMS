<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Helper;
use App\Menu\MenuLang;
use App\Office\Export\LabelsExport;
use App\Office\Export\LanguagesExport;
use App\Office\Export\MenusExport;
use App\Office\Export\PostsExport;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Dashboard\Entities\Language;
use Modules\Post\Entities\Post;
use Spatie\TranslationLoader\LanguageLine;

class ExcelController extends Controller
{

    public function index()
    {
        $arrTabs = ['General'];
        $active = "active";

        return view('dashboard::export.index', compact('arrTabs', 'active'));
    }


    /**
     * Reusable exporting functionality
     *
     * @param $type
     * @return mixed
     */
    public function export($type)
    {
        return \Excel::download(new LanguagesExport,'export.'.$type);
    }



    /**
     * Reusable exporting functionality
     *
     * @param $type
     * @return mixed
     */
    public function exportLangs($id)
    {
        $arrTabs = ['General'];
        $active = "active";

        $languages=Language::where('user_id',$id)->first()->toArray();

        //-- Get name of columns in languages table
        $arrKeys=array_keys($languages);

        //-- Remove first element from array of language keys
        array_shift($arrKeys);

        return view('dashboard::export.languages', compact('arrTabs', 'active','arrKeys'));
    }

    public function exportLangsFile(Request $request)
    {


        $strFileType=$request->type;
        $intCount=$request->count;
        $strOrder=$request->order;
        $arrColumns=$request->columns;

        $arrOptions=[
            'type'=>$strFileType,
            'count'=>$intCount,
            'order'=>$strOrder,
            'columns'=>$arrColumns,
        ];
        return \Excel::download(new LanguagesExport($arrOptions),'languages.'.$strFileType);
    }

    public function exportPosts($id)
    {
        $arrTabs = ['General'];
        $active = "active";

        $languages=Post::where('user_id',$id)->first()->toArray();

        //-- Get name of columns in languages table
        $arrKeys=array_keys($languages);

        //-- Remove first element from array of language keys
        array_shift($arrKeys);

        return view('dashboard::export.posts', compact('arrTabs', 'active','arrKeys'));
    }

    public function exportPostsFile(Request $request)
    {
        $strFileType=$request->type;
        $intCount=$request->count;
        $strOrder=$request->order;
        $arrColumns=$request->columns;

        $arrOptions=[
            'type'=>$strFileType,
            'count'=>$intCount,
            'order'=>$strOrder,
            'columns'=>$arrColumns,
        ];

        return \Excel::download(new PostsExport($arrOptions),'posts.'.$strFileType);
    }


    public function exportMenus($id)
    {
        $arrTabs = ['General'];
        $active = "active";
        $arrMenuLangs=array();

        $menu=MenuLang::where('user_id',$id)->first()->toArray();
        $menuItem=MenuLang::where('id',$menu['id'])->where('user_id',$id)->get();

        $allAvailableLanguages = LaravelLocalization::getSupportedLocales();

        if(!empty($menuItem)){
            foreach ($menuItem as $item){
                $arrMenuLangs[$item->lang]=$allAvailableLanguages[strtolower($item->lang)]['native'];
            }
        }


        //-- Get name of columns in languages table
        $arrKeys=array_keys($menu);

        //-- Remove first element from array of language keys
        array_shift($arrKeys);

        return view('dashboard::export.menus', compact('arrTabs', 'active','arrKeys','arrMenuLangs'));
    }

    public function exportMenusFile(Request $request)
    {
        $strFileType=$request->type;
        $intCount=$request->count;
        $strOrder=$request->order;
        $arrColumns=$request->columns;
        $arrLanguages=$request->arrLanguages;

        $arrOptions=[
            'type'=>$strFileType,
            'count'=>$intCount,
            'order'=>$strOrder,
            'columns'=>$arrColumns,
            'languages'=>$arrLanguages,
        ];

        return \Excel::download(new MenusExport($arrOptions),'menus.'.$strFileType);
    }

    public function exportLabels($id)
    {
        $arrTabs = ['General'];
        $active = "active";
        $arrLabelLangs=array();

        $label=LanguageLine::where('user_id',$id)->first()->toArray();

        $allAvailableLanguages = LaravelLocalization::getSupportedLocales();
        if(!empty($label['text'])){
            foreach ($label['text'] as $key=>$item){

                $arrLabelLangs[strtolower($key)]=$allAvailableLanguages[strtolower($key)]['native'];
            }
        }


        //-- Get name of columns in languages table
        $arrKeys=array_keys($label);

        //-- Remove first element from array of language keys
        array_shift($arrKeys);

        //-- Delete text JSON field
        if (($key = array_search('text', $arrKeys)) !== false) {
            unset($arrKeys[$key]);
        }


        return view('dashboard::export.labels', compact('arrTabs', 'active','arrKeys','arrLabelLangs'));
    }


    public function exportLabelsFile(Request $request)
    {
        $strFileType=$request->type;
        $intCount=$request->count;
        $strOrder=$request->order;
        $arrColumns=$request->columns;
        $arrLanguages=$request->arrLanguages;

        $arrOptions=[
            'type'=>$strFileType,
            'count'=>$intCount,
            'order'=>$strOrder,
            'columns'=>$arrColumns,
            'languages'=>$arrLanguages,
        ];

        return \Excel::download(new LabelsExport($arrOptions),'labels.'.$strFileType);
    }


}
