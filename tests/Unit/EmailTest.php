<?php

namespace Tests\Unit;

use FinitiOne\User\DTO\EmailWelcomeDTO;
use FinitiOne\User\Job\SendWelcomeEmailJob;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_is_pushed_queue()
    {
        Queue::fake();
        $payload = new EmailWelcomeDTO('niko@gmail.com', 'test', 'test');
        SendWelcomeEmailJob::dispatch($payload);
        Queue::assertPushed(SendWelcomeEmailJob::class);
    }
}
