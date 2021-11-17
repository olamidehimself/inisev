<?php

namespace App\Jobs;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use App\Mail\SendPostMailToUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Log;

class SendPostMailToUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $post;
    public $website;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post, $website)
    {
        $this->post = $post;
        $this->website = $website;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = Subscription::with('user')->where('website_id', $this->post->website_id)->get();
        foreach($users as $user) {
            Mail::send(new SendPostMailToUsers($user->user, $this->post, $this->website));
        }
    }
}
