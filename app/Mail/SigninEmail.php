<?php

namespace App\Mail;

use App\Models\Promoter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SigninEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $promoter = null;

    protected $url = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Promoter $promoter, $url)
    {
        $this->promoter = $promoter;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.signin')
                    ->from('mail')
                    ->to($this->promoter->email)
                    ->with(['url' => $this->url]);
    }
}
