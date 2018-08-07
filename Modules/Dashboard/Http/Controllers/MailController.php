<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;

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
    public function sendEmail()
    {
        Mail::raw('Sending emails with Mailgun and Laravel is easy!', function($message)
        {
            $message->subject('Mailgun and Laravel are awesome!');
            $message->from('maksim@website_name.com', 'DiscoveringWorld');
            //$message->to('narushevich.maksim@gmail.com');

            $message->to('maxim@digitalmind.be');
        });
    }


}
