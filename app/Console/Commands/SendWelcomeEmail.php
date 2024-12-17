<?php

namespace App\Console\Commands;

use FinitiOne\User\DTO\EmailWelcomeDTO;
use FinitiOne\User\Job\SendWelcomeEmailJob;
use Illuminate\Console\Command;

class SendWelcomeEmail extends Command
{
    protected $signature = 'user:welcome-email {email} {subject="Welcome to Our Service"} {body="Thank you for signing up for our service"} {--retry=3} {--queue=default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending welcome email to tenant after registration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }



    public function handle(): void
    {
        try {
            $data = new EmailWelcomeDTO($this->argument('email'), $this->argument('subject'), $this->argument('body'));
            SendWelcomeEmailJob::dispatch($data, $this->option('retry'))->OnQueue($this->option('queue'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
