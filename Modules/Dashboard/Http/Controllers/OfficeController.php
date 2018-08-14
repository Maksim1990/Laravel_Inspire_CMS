<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Modules\Dashboard\Http\Requests\CreateFTPRequest;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $arrTabs = ['General'];
        $active = "active";


        return view('dashboard::office.index', compact('arrTabs', 'active'));
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function ftpManager()
    {
        $arrTabs = ['General'];
        $active = "active";


        return view('dashboard::office.ftp.manager', compact('arrTabs', 'active'));
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function folderTree()
    {
        $arrTabs = ['General'];
        $active = "active";


        return view('dashboard::office.ftp.tree', compact('arrTabs', 'active'));
    }

    public function readFile()
    {

        //TODO How to change env value programmatically
        //$this->setEnvironmentValue('DEPLOY_SERVER', 'forge@122.11.244.10');


        $content_types = [
            'application/octet-stream', // txt etc
            'application/msword', // doc
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', //docx
            'application/vnd.ms-excel', // xls
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // xlsx
            'application/pdf', // pdf
        ];


        $file = "Vim Cheat sheet.pdf";
        //$file="test.doc";
        //$test = Storage::disk('local')->exists('/public/office/'.$file);

        if (Storage::disk('local')->exists('/public/office/' . $file)) {
            $file = Storage::disk('local')->get('/public/office/' . $file);

            $response = Response::make($file, 200);
            // using this will allow you to do some checks on it (if pdf/docx/doc/xls/xlsx)
            //$response->header('Content-Type', 'application/msword');
            $response->header('Content-Type', 'application/pdf');

            return $response;
        }

// Or to download

//        if (File::isFile($file))
//        {
//            return Response::download($file, "test");
//        }
    }


    public function setFTPCredentialsAdmin()
    {
        $arrTabs = ['General'];
        $active = "active";


        return view('dashboard::office.ftp.credentials_admin', compact('arrTabs', 'active', 'test'));
    }

    public function setFTPCredentials()
    {
        $arrTabs = ['General'];
        $active = "active";


        return view('dashboard::office.ftp.credentials', compact('arrTabs', 'active', 'test'));
    }

    public function ftpContent()
    {
        $arrTabs = ['General'];
        $active = "active";



            try{
                //-- Choose what type of FTP credentials to use
                if (!isset(Auth::user()->admin_setting->use_admin_ftp_credentials) || Auth::user()->admin_setting->use_admin_ftp_credentials == 'Y') {
                config(['filesystems.disks.ftp' => [
                    'driver' => 'ftp',
                    'host' => Auth::user()->setting->ftp_host,
                    'username' => Auth::user()->setting->ftp_user_name,
                    'password' => Auth::user()->setting->ftp_password
                ]]);
                }

                //$files = Storage::disk('ftp')->allFiles('/');
                $arrFolders = Storage::disk('ftp')->directories('/');
                buildFTPFolderTree($arrFolders);

            }catch (\Exception $e){
                Session::flash('ftp_change', trans('dashboard::messages.ftp_could_not_connect'));
                return redirect()->route('office_ftp_connection',['id'=>Auth::id()]);
            }




        return view('dashboard::office.ftp.content', compact('arrTabs', 'active', 'test'));
    }


    /**
     * Store FTP password for admin user (in .env file)
     *
     * @param CreateFTPRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeFTPCredentialsAdmin(CreateFTPRequest $request)
    {

        $user = Auth::user();
        $ftp_host = $request->ftp_host;
        $ftp_user_name = $request->ftp_user_name;
        $ftp_password = $request->ftp_password;

        setEnvironmentValue('FTP_HOST', $ftp_host);
        setEnvironmentValue('FTP_USER_NAME', $ftp_user_name);
        setEnvironmentValue('FTP_PASS', $ftp_password);

        Session::flash('office_change', trans('dashboard::messages.ftp_credentials_were_updated'));
        return redirect()->route('office_ftp_manager',['id'=>$user->id]);

    }

    /**
     * Store FTP password for specific user
     *
     * @param CreateFTPRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeFTPCredentials(CreateFTPRequest $request)
    {

        $user = Auth::user();
        $ftp_host = $request->ftp_host;
        $ftp_user_name = $request->ftp_user_name;
        $ftp_password = $request->ftp_password;

        $settings = Setting::where('user_id', $user->id)->first();

        $settings->ftp_host = $ftp_host;
        $settings->ftp_user_name = $ftp_user_name;
        $settings->ftp_password = $ftp_password;

        if(!$settings->update()){
            Session::flash('office_change', trans('dashboard::messages.option_was_not_updated'));
        }else{
            Session::flash('office_change', trans('dashboard::messages.ftp_credentials_were_updated'));
        }

        return redirect()->route('office_ftp_manager',['id'=>$user->id]);

    }


}
