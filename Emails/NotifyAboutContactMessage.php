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
        $template = $this->config['notify']['email_template'] ?: 'contact::emails.contact-notification';
        $subject = $this->config['notify']['email_subject'];
        foreach ($this->data as $key => $value) {
            if ($key == 'created_at') {
                $subject = str_replace(':' . strtoupper($key), \Carbon\Carbon::parse($value)->format('Y, j M, H:i'),
                    $subject);
            } elseif ($key == 'message') {
                if (str_word_count($value) > 7) {
                    $message = implode(' ', array_slice(explode(' ', $value), 0, 7)) . '...';
                } else {
                    $message = $value;
                }

                $subject = str_replace(':' . strtoupper($key), $message, $subject);
            } else {
                $subject = str_replace(':' . strtoupper($key), $value, $subject);
            }
        }

        $this->subject($subject);
        $this->from($this->data['email'], array_get($this->data, 'name'));

        return $this->view($template, compact('data'));
    }
}
