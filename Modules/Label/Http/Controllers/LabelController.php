<?php

namespace Modules\Label\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Spatie\TranslationLoader\LanguageLine;

class LabelController extends Controller
{

    private $arrOfActiveLanguages = [
        "EN" => "English",
        "FR" => "French",
        "DE" => "German",
        "NL" => "Dutch"
    ];


    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $arrTabs = ['General', 'Profile', 'Messages', 'Settings'];
        $active = "active";


//        LanguageLine::create([
//            'group' => 'website',
//            'key' => 'title',
//            'text' => [
//                'en' => 'This is a title',
//                'nl' => 'Dit is title NL',
//                'fr' => 'This is a title FR',
//                'de' => 'This is a title DE'
//            ],
//        ]);

        $translations = LanguageLine::all();

        $arrOfActiveLanguages = $this->arrOfActiveLanguages;

        return view('label::index', compact('arrTabs', 'active', 'translations', 'arrOfActiveLanguages'));
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

        if (!empty($arrTranslations)) {
            $arrKeys = array_keys($arrTranslations);
            $arrIDs = array();
            foreach ($arrKeys as $strKey) {
                $arrKeyItem = explode("_", $strKey);
                $arrIDs[] = $arrKeyItem[0];
            }
            $arrIDs = array_values(array_unique($arrIDs));


            foreach ($arrIDs as $intId) {
                $i = 0;
                $arrNewTranslation = array();
                foreach ($this->arrOfActiveLanguages as $strKey => $strLang) {
                    if (isset($arrTranslations[$intId . "_" . strtolower($strKey)])) {

                        try {
                            $translateItem = LanguageLine::findOrFail($intId);

                            $translateItem->key = $arrTranslationsKeys[$intId];
                            $arrTranslationUpdated = $translateItem->text;
                            foreach ($arrTranslationUpdated as $lang => $item) {
                                if ($lang == strtolower($strKey)) {
                                    $arrTranslationUpdated[$lang] = $arrTranslations[$intId . "_" . strtolower($strKey)];
                                }
                            }
                            $translateItem->text = $arrTranslationUpdated;
                            $translateItem->update();
                        } catch (\Exception $e) {

                            $arrNewTranslation[strtolower($strKey)] = $arrTranslations[$intId . "_" . strtolower($strKey)];
                            if (++$i === count($this->arrOfActiveLanguages)) {
                                LanguageLine::create([
                                    'group' => $strModule,
                                    'key' => $arrTranslationsKeys[$intId],
                                    'text' => $arrNewTranslation
                                ]);
                            }

                        }


                    }

                }
            }


        }


        $result = "success";
        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result
        ));
    }


}
