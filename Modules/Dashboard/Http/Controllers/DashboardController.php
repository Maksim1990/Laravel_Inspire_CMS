<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Menu\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\TranslationLoader\LanguageLine;

class DashboardController extends Controller
{

    private $arrOfActiveLanguages = [
        "EN" => "English",
        "FR" => "French",
        "RU" => "Russian",
        "TH" => "Thai"
    ];


    /**
     * Display a listing of the resource.
     * @param integer $id
     * @return Response
     */
    public function index($id)
    {
        $arrTabs = ['General', 'Profile'];
        $active = "active";
        return view('dashboard::index',compact('arrTabs', 'active'));
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

    public function aboutUs()
    {
        $arrTabs = ['General'];
        $active = "active";
        return view('dashboard::about',compact('arrTabs', 'active'));
    }

    public function contacts()
    {
        $arrTabs = ['General'];
        $active = "active";
        return view('dashboard::contact_us',compact('arrTabs', 'active'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function menu($id)
    {
        $arrTabs = ['General'];
        $active = "active";


        $translations = LanguageLine::where('user_id',Auth::id())->get();
        $translationLast = LanguageLine::where('id','<>','0')->orderBy('id','DESC')->first();
        if(!empty($translationLast)){
            $intLastLabelId=$translationLast->id;
        }else{
            $intLastLabelId=0;
        }


        $arrOfActiveLanguages = $this->arrOfActiveLanguages;



        //TODO Building dynamic header menu
        $user=Auth::user();
        $userMenu=Menu::where('active','Y')->whereHas('menuActive', function ($query) {
            $query->where('active', 'Y')->where('user_id',Auth::id());
        })->get();
        //dd($userMenu);





        return view('admin.menu',compact('arrTabs', 'active', 'translations', 'arrOfActiveLanguages','intLastLabelId'));
    }


    public function updateMenu(Request $request){

    }

}
