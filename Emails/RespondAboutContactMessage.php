<?php

namespace Modules\Contact\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Nwidart\Modules\Facades\Module;

class RespondAboutContactMessage extends Mailable
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

        $module = Module::find('setting');

        if ($module && $module->enabled()) {
            $this->from(setting()->get('mail_from_address', $this->config['response']['from']), setting()->get('mail_from_name', $this->config['response']['from']));
        } else {
            $this->from($this->config['response']['from'], $this->config['response']['from']);
        }

        return $this->view($template, compact('data'));
    }
}