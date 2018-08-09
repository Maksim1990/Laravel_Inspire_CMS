<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Modules\Dashboard\Emails\MailModuleTemplate;
use Modules\Dashboard\Entities\MailEntity;
use Modules\Dashboard\Entities\MailPhoto;
use Modules\Dashboard\Http\Requests\CreateMailRequest;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $arrTabs = ['General'];
        $active = "active";
        return view('dashboard::mail.index', compact('arrTabs', 'active'));
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
        $input['user_id']=$user_id;
        $mail = new MailEntity;
        $mail->fill($input);
        $mail->save();


        //-- Sent email with mailable template
        Mail::to($input['to'])->send(new MailModuleTemplate($input));

        //-- Check if there are no email failures
        if (!Mail::failures()) {
            //-- Check if necessary to add some images to email as attachment
            $attachments = MailPhoto::where('user_id', Auth::id())->get();
            if (!empty($attachments)) {
                foreach ($attachments as $attachment) {
                    unlink(storage_path('/app/public/' .$attachment->path));
                    $attachment->delete();
                }
            }

            //-- Update 'Sent' status of the current email
            $mail->sent="Y";
            $mail->update();
        }else{
            Session::flash('mail_change','Mail was failed!');
            return redirect()->back();
        }


        Session::flash('mail_change','Mail was successfully sent!');
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
                $name = time() ."_".$file->getClientOriginalName();

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

        header('Content-Type: application/json');
        echo json_encode(array(
            $result
        ));
    }



}
