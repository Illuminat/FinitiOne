<?php
namespace FinitiOne\User\Job;

use FinitiOne\User\DTO\EmailWelcomeDTO;
use FinitiOne\User\Email\WelcomeEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected EmailWelcomeDTO $data;

    public int $tries;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(EmailWelcomeDTO $data, int $tries = 3)
    {
        $this->data = $data;
        $this->tries = $tries;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $startTime = microtime(true);
        Log::debug(self::class . ' started');
        try {
            Mail::to($this->data->email)->send(new WelcomeEmail($this->data->subject, $this->data->body));
        } catch (\Exception $e) {
            Log::error('Mail Sending Failed | ' . $e->getMessage());
        } finally {
            Log::debug(self::class . ' finished. Total execution time: ' . (microtime(true) - $startTime) / 60);
        }
    }
}
