<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Subscription;
use Illuminate\Console\Command;
use App\Mail\SendPostMailToUsers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPostsToUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends scheduled posts to Users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $posts = Post::with('website')->whereBetween('sends_at', [Carbon::now()->startOfHour(), Carbon::now()])->get();
        foreach ($posts as $post) {
            $users = Subscription::with('user')->where('website_id', $post->website_id)->get();
            foreach($users as $user) {
                Log::info($user);
                Mail::send(new SendPostMailToUsers($user->user, $post, $post->website));
            }
        }
        
        $this->info('Success');
    }
}
