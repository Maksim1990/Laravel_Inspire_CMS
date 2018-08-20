<?php

namespace Modules\Dashboard\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Modules\Dashboard\Entities\MailPhoto;

class MailModuleTemplate extends Mailable
{
    use Queueable, SerializesModels;


    protected $content;
    protected $title;
    protected $mail_from;
    protected $mail_to;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($arrParams)
    {
        $this->content = $arrParams['content'];
        $this->title = $arrParams['title'];
        $this->mail_from = $arrParams['from'];
        $this->mail_to = $arrParams['to'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $email = $this->view('dashboard::mail.templates.mail_1')
            ->with('content', $this->content)
            ->from($this->mail_from, Auth::user()->name)
            ->replyTo($this->mail_from, Auth::user()->name)
            ->subject($this->title);


        //-- Check if necessary to add some images to email as attachment
        $attachments = MailPhoto::where('user_id', Auth::id())->get();
        if (!empty($attachments)) {
            foreach ($attachments as $attachment) {
                $email->attach(custom_asset('storage/' . $attachment->path));
            }
        }

        return $email;
    }
}
