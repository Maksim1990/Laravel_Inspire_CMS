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
use Modules\Dashboard\Entities\Document;
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
    public function docs($id)
    {
        $arrTabs = ['General'];
        $active = "active";

        $documents=Document::where('user_id',$id)->orderBy('id')->paginate(10);
        return view('dashboard::office.documents.index', compact('arrTabs', 'active','documents'));
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function uploadDoc()
    {
        $arrTabs = ['General'];
        $active = "active";

        return view('dashboard::office.documents.upload', compact('arrTabs', 'active'));
    }


    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function storeDocs(Request $request)
    {
        $result = "success";
        $arrAllowedExtension = ['pdf', 'xls','xlsx','csv', 'txt','doc','docx'];

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        if (in_array($extension, $arrAllowedExtension)) {
            if (!($file->getClientSize() > 3100000)) {
                $name = time() ."_".$file->getClientOriginalName();

                request()->file('file')->storeAs(
                    'public/upload/' . Auth::id() . '/documents/', $name
                );

                Document::create([
                    'user_id' => Auth::id(),
                    'name' => $name,
                    'size' => $file->getClientSize(),
                    'extension' => $extension,
                    'path' => 'upload/' . Auth::id() . '/documents/' . $name
                ]);

            } else {
                $result = trans('dashboard::messages.document_can_not_be_bigger_than')." 3 MB !";
            }
        } else {
            $result = trans('messages.document_can_not_be_bigger_than').": " . implode(",", $arrAllowedExtension);
        }

        echo $result;


    }

    /**
     * Delete specific mail data
     *
     * @param Request $request
     */
    public function ajaxDeleteFile(Request $request)
    {
        $fileId = $request->id;
        $strError = "";
        $result = "success";
        $file=Document::find($fileId);

        if($file->path){
            unlink(storage_path('/app/public/'.$file->path));
            $file->delete();
        }else{
            $strError = trans('dashboard::messages.file_not_found');
            $result = "";
        }


        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));

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


    /**
     * Get content of FTP root folder
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function ftpContent()
    {
        $arrTabs = ['General'];
        $active = "active";

        try {
            //-- Choose what type of FTP credentials to use
            if (!isset(Auth::user()->admin_setting->use_admin_ftp_credentials) || Auth::user()->admin_setting->use_admin_ftp_credentials == 'N') {
                config(['filesystems.disks.ftp' => [
                    'driver' => 'ftp',
                    'host' => Auth::user()->setting->ftp_host,
                    'username' => Auth::user()->setting->ftp_user_name,
                    'password' => Auth::user()->setting->ftp_password
                ]]);
            }

            $arrData = array();

            $arrFolders = Storage::disk('ftp')->directories('/');
            if (!empty($arrFolders)) {
                foreach ($arrFolders as $key => $folder) {
                    $arrData[] = [
                        'id' => "root_" . $key . "_folder",
                        'data' => $folder,
                        'text' => $folder,
                        'icon' => ""
                    ];
                }
            }

            $arrFiles = Storage::disk('ftp')->files('/');
            if (!empty($arrFiles)) {
                foreach ($arrFiles as $key => $file) {
                    $arrData[] = [
                        'id' => "root_" . $key . "_file",
                        'text' => $file,
                        'data' => "",
                        'icon' => "jstree-file"
                    ];
                }
            }

            if (!empty($arrData)) {
                $arrData = json_encode($arrData, true);
            }

        } catch (\Exception $e) {
            Session::flash('ftp_change', trans('dashboard::messages.ftp_could_not_connect'));
            return redirect()->route('office_ftp_connection', ['id' => Auth::id()]);
        }

        return view('dashboard::office.ftp.browser', compact('arrTabs', 'active', 'arrData'));
    }


    /**
     * Generate folder content for specific FTP folder
     *
     * @param Request $request
     */
    public function ajaxGetFolderContent(Request $request)
    {

        $strId = $request['id'];
        $strPath = $request['path'];
        $strError = "";
        $result = "success";


        //-- Initialize array of folder children
        $arrData = array();
        try {
            $arrFolders = Storage::disk('ftp')->directories('/' . $strPath);
            if (!empty($arrFolders)) {
                foreach ($arrFolders as $key => $path) {
                    $arrPath = explode("/", $path);
                    $folder = $arrPath[count($arrPath) - 1];
                    $arrData[] = [
                        'id' => $strId . "_" . $key . "_folder",
                        'data' => $path,
                        'text' => $folder,
                        'icon' => ""
                    ];
                }
            }

            $arrFiles = Storage::disk('ftp')->files('/' . $strPath);
            if (!empty($arrFiles)) {
                foreach ($arrFiles as $key => $path) {
                    $arrPath = explode("/", $path);
                    $file = $arrPath[count($arrPath) - 1];
                    $arrData[] = [
                        'id' => $strId . "_" . $key . "_file",
                        'text' => $file,
                        'data' => "",
                        'icon' => "jstree-file"
                    ];
                }
            }
        } catch (\Exception $e) {
            $strError = "Can not connect to remote server";
            $result = "";
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError,
            'arrData' => $arrData,
        ));

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
        return redirect()->route('office_ftp_manager', ['id' => $user->id]);

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

        if (!$settings->update()) {
            Session::flash('office_change', trans('dashboard::messages.option_was_not_updated'));
        } else {
            Session::flash('office_change', trans('dashboard::messages.ftp_credentials_were_updated'));
        }

        return redirect()->route('office_ftp_manager', ['id' => $user->id]);

    }


}
