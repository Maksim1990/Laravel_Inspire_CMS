<?php

namespace Modules\Label\Http\Controllers;

use App\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\TranslationLoader\LanguageLine;

class LabelController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @param integer $id
     * @return Response
     */
    public function index($id)
    {
        $arrTabs = ['General'];
        $active = "active";


        $translations = LanguageLine::where('user_id', Auth::id())->get();
        $translationLast = LanguageLine::where('id', '<>', '0')->orderBy('id', 'DESC')->first();
        if (!empty($translationLast)) {
            $intLastLabelId = $translationLast->id;
        } else {
            $intLastLabelId = 0;
        }

        $arrOfActiveLanguages = Helper::GetActiveLanguages();

        return view('label::index', compact('arrTabs', 'active', 'translations', 'arrOfActiveLanguages', 'intLastLabelId'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('label::create');
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
        return view('label::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('label::edit');
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


    public function ajaxUpdate(Request $request)
    {

        $arrTranslations = $request['arrTranslations'];
        $arrTranslationsKeys = $request['arrTranslationsKeys'];
        $strModule = $request['module'];
        $strError = "";
        $result = "success";

        if (!empty($arrTranslations)) {
            $arrKeys = array_keys($arrTranslations);
            $arrIDs = array();
            foreach ($arrKeys as $strKey) {
                $arrKeyItem = explode("_", $strKey);
                $arrIDs[] = $arrKeyItem[0];
            }
            $arrIDs = array_values(array_unique($arrIDs));




            foreach ($arrIDs as $intId) {

                //-- Get all active languages
                $arrOfActiveLanguages = Helper::GetActiveLanguages();

                $i = 0;
                $arrNewTranslation = array();
                foreach ($arrOfActiveLanguages as $strKey => $strLang) {
                    //-- Check if key for current language is exist
                    //-- Key with empty value is also allowed
                    if (isset($arrTranslations[$intId . "_" . strtolower($strKey)]) || $arrTranslations[$intId . "_" . strtolower($strKey)] == "") {

                        try {

                            $labelToCheck = LanguageLine::where('id','!=',$intId)->where('user_id', Auth::id())->where('key', $arrTranslationsKeys[$intId])->where('group', $strModule)->first();
                            if (!$labelToCheck) {
                                $translateItem = LanguageLine::findOrFail($intId);

                                $translateItem->key = $arrTranslationsKeys[$intId];
                                $translateItem->user_id = Auth::id();
                                $arrTranslationUpdated = $translateItem->text;

                                foreach ($arrTranslationUpdated as $lang => $item) {
                                    if ($lang == strtolower($strKey)) {
                                        $arrTranslationUpdated[$lang] = $arrTranslations[$intId . "_" . strtolower($strKey)];
                                    }

                                    //-- Temporarily delete lang from active languages
                                        unset($arrOfActiveLanguages[strtoupper($lang)]);
                                }

                                //-- Insert values from active languages that are not yet in translation
                                if(count($arrOfActiveLanguages)>0){
                                    foreach ($arrOfActiveLanguages as $langActive => $strValue) {
                                        if(isset($arrTranslations[$intId . "_" . strtolower($strKey)])){
                                            $arrTranslationUpdated[strtolower($langActive)] = $arrTranslations[$intId . "_" . strtolower($strKey)];
                                        }
                                    }
                                }

                                $translateItem->text = $arrTranslationUpdated;
                                $translateItem->update();
                            }else{
                                $result="";
                                $strError="Label name '".$arrTranslationsKeys[$intId]."'' in group '".$strModule."' already exist";
                                continue;
                            }

                        } catch (\Exception $e) {

                            $labelToCheck = LanguageLine::where('user_id', Auth::id())->where('key', $arrTranslationsKeys[$intId])->where('group', $strModule)->first();
                            if (!$labelToCheck) {

                            $arrNewTranslation[strtolower($strKey)] = $arrTranslations[$intId . "_" . strtolower($strKey)];
                            if (++$i === count($arrOfActiveLanguages)) {
                                LanguageLine::create([
                                    'user_id' => Auth::id(),
                                    'group' => $strModule,
                                    'key' => $arrTranslationsKeys[$intId],
                                    'text' => $arrNewTranslation
                                ]);
                            }

                            }else{
                                $result="";
                                $strError="Label name '".$arrTranslationsKeys[$intId]."'' in group '".$strModule."' already exist";
                                continue;
                            }
                        }
                    }
                }
            }
        }


        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));
    }

    public function ajaxDelete(Request $request)
    {
        $indId = $request['id'];
        $lable = LanguageLine::find($indId);
        if ($lable) {
            $lable->delete();
        }

        $result = "success";
        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result
        ));
    }


}
