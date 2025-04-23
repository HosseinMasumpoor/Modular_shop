<?php

namespace Modules\User\Jobs;

use App\Notifications\ChangeEmailNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;

class SendVerificationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $email, protected string $url) {}

    /**
     * Execute the job.
     */
    public function handle(): void {
        Notification::route('mail', $this->email)->notify(new ChangeEmailNotification($this->url));
    }
}
