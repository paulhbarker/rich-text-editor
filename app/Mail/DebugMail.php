<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DebugMail extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var string
	 */
	public $input;

	/**
	 * @var string
	 */
	public $output;

	/**
	 * Create a new message instance.
	 *
	 * @param $input
	 * @param $output
	 */
    public function __construct($input, $output)
    {
	    $this->input = $input;
	    $this->output = $output;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@paulular.com')
                    ->subject('A new debug request')
                    ->markdown('emails.debug');
    }
}
