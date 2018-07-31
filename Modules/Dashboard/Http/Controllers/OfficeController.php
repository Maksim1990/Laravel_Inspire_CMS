<?php

namespace Modules\Dashboard\Http\Controllers;

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


    public function setFTPCredentials()
    {
        $arrTabs = ['General'];
        $active = "active";


        return view('dashboard::office.ftp', compact('arrTabs', 'active', 'test'));
    }

    public function storeFTPCredentials(CreateFTPRequest $request)
    {

        $user=Auth::user();
        $ftp_host = $request->ftp_host;
        $ftp_user_name = $request->ftp_user_name;
        $ftp_password = $request->ftp_password;

        setEnvironmentValue('FTP_HOST', $ftp_host);
        setEnvironmentValue('FTP_USER_NAME', $ftp_user_name);
        setEnvironmentValue('FTP_PASS', $ftp_password);

        Session::flash('office_change','FTP credentials were successfully updated!');
        return redirect('admin/'.$user->id.'/office');

    }


}
