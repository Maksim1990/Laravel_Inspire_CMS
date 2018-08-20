<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Modules\Dashboard\Emails\MailModuleTemplate;
use Modules\Dashboard\Entities\MailEntity;
use Modules\Dashboard\Entities\MailPhoto;
use Modules\Dashboard\Entities\MailTemplate;
use Modules\Dashboard\Http\Requests\CreateMailRequest;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index($id)
    {
        $arrTabs = ['General'];
        $active = "active";
        $mails = MailEntity::where('user_id', $id)->orderBy('id')->paginate(10);

        return view('dashboard::mail.index', compact('arrTabs', 'active', 'mails'));
    }


    /**
     * For sending emails through Mailgun to the not authorized mail addresses
     * than payment credentials should be added in Mailgun account
     */
    public function createEmail()
    {
        $arrTabs = ['General'];
        $active = "active";
        return view('dashboard::mail.create', compact('arrTabs', 'active'));
    }


    /**
     * Store a newly created resource in storage.
     * @param  CreateMailRequest $request
     * @return Response
     */
    public function store(CreateMailRequest $request)
    {

        $input = $request->all();

        $user_id = Auth::id();
        $input['user_id'] = $user_id;
        $mail = new MailEntity;
        $mail->fill($input);
        $mail->save();
        $template = MailTemplate::where('user_id', Auth::id())->where('active', 'Y')->first();
        if ($template) {
            //-- Sent email with mailable template
            Mail::to($input['to'])->send(new MailModuleTemplate($input));

            //-- Check if there are no email failures
            if (!Mail::failures()) {
                //-- Check if necessary to add some images to email as attachment
                $attachments = MailPhoto::where('user_id', Auth::id())->get();
                if (!empty($attachments)) {
                    foreach ($attachments as $attachment) {
                        unlink(storage_path('/app/public/' . $attachment->path));
                        $attachment->delete();
                    }
                }

                //-- Update 'Sent' status of the current email
                $mail->sent = "Y";
                $mail->update();
            } else {
                Session::flash('mail_change', trans('dashboard::messages.mail_sending_failed'));
                return redirect()->back();
            }
        } else {
            Session::flash('mail_change', trans('dashboard::messages.mail_template_not_found'));
            return redirect()->back();
        }


        Session::flash('mail_change', 'Mail was successfully sent!');
        return \Redirect::route('mail', $user_id);
    }


    /**
     * Store images attached to email.
     * @param Request $request
     */
    public function attachImages(Request $request)
    {

        $result = "success";
        $arrAllowedExtension = ['png', 'jpg', 'jpeg'];

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        if (in_array($extension, $arrAllowedExtension)) {
            if (!($file->getClientSize() > 2100000)) {
                $name = time() . "_" . $file->getClientOriginalName();

                request()->file('file')->storeAs(
                    'public/upload/' . Auth::id() . '/emails/images/', $name
                );

                MailPhoto::create([
                    'user_id' => Auth::id(),
                    'name' => $name,
                    'size' => $file->getClientSize(),
                    'path' => 'upload/' . Auth::id() . '/emails/images/' . $name
                ]);

            } else {
                $result = "Images with size bigger than 2 MB can't be uploaded!";
            }
        } else {
            $result = "It's allowed to upload only following formats: " . implode(",", $arrAllowedExtension);
        }

        echo $result;
    }


    public function ajaxGetMailData(Request $request)
    {

        $mailId = $request['mailId'];
        $strError = "";
        $result = "success";


        $mail = MailEntity::find($mailId);
        if (!$mail) {
            $mail = "";
            $strError = "Mail was not found";
            $result = "";
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError,
            'mail' => $mail
        ));

    }

    /**
     * Delete specific mail data
     *
     * @param Request $request
     */
    public function ajaxDeleteMailData(Request $request)
    {
        $mailId = $request['id'];
        $strError = "";
        $result = "success";
        MailEntity::find($mailId)->delete();

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));

    }

    public function customizeMailTemplate($id, $template_id)
    {
        $arrTabs = ['General'];
        $active = "active";
        $template = MailTemplate::where('user_id', Auth::id())->where('active', 'Y')->where('id',$template_id)->first();

        $templates= MailTemplate::where('user_id', Auth::id())->where('active', 'Y')->orderBy('id',"ASC")->first();
        if($templates){
            $lastTemplateId=++$templates->id;
        }else{
            $lastTemplateId=1;
        }
        return view('dashboard::mail.customize_template', compact('arrTabs', 'template_id', 'active', 'template','lastTemplateId'));
    }

    public function mailTemplatesList($id)
    {
        $arrTabs = ['General'];
        $active = "active";
        $templates = MailTemplate::where('user_id', Auth::id())->where('active', 'Y')->get();

        return view('dashboard::mail.template_list', compact('arrTabs', 'templates', 'active'));
    }

    public function ajaxMailTemplateUpdate(Request $request)
    {

        $template_id = $request['template_id'];
        $mailTemplateContent = $request['mailTemplateContent'];
        $strError = "";
        $result = "success";


        $template = MailTemplate::where('user_id',Auth::id())->where('active','Y')->where('id', $template_id)->first();
        if ($template) {
            $template->content = $mailTemplateContent;
            if (!$template->update()) {
                $strError = trans('dashboard::messages.mail_template_can_not_update');
                $result = "";
            }
        }else{
            MailTemplate::create([
                'user_id'=>Auth::id(),
                'active'=>'Y',
                'title'=>'',
                'content'=>$mailTemplateContent
            ]);
        }

        header('Content-Type: application/json');
        echo json_encode(array(
            'result' => $result,
            'error' => $strError
        ));

    }

}
