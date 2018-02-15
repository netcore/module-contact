<?php

namespace Modules\Contact\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAboutContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $data;

    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    private $config;

    /**
     * Create a new message instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->config = config('netcore.module-contact');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template = $this->config['response']['email_template'] ?: 'contact::emails.contact-notification';
        $this->subject($this->config['response']['email_subject']);

        $this->from($this->config['response']['from'], $this->config['response']['from']);

        return $this->view($template, compact('data'));
    }
}
