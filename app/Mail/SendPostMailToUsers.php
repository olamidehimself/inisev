<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPostMailToUsers extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $post;
    public $website;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $post, $website)
    {
        $this->user = $user;
        $this->post = $post;
        $this->website = $website;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::info($this->user->email);
        return $this->to($this->user->email)->subject('New Post!!!')->view('emails.email')->with(['user' => $this->user, 'post', $this->post, 'website' => $this->website]);
    }
}
