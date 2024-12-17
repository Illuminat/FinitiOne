<?php

namespace FinitiOne\Billing\Job;

use FinitiOne\Billing\Enum\PaymentStatuses;
use FinitiOne\Billing\PaymentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class TransferJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected UuidInterface $paymentId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(UuidInterface $paymentId)
    {
        $this->paymentId = $paymentId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(PaymentService $service)
    {
        $startTime = microtime(true);
        Log::debug(self::class . ' started');
        try {
            $payment = $service->process($this->paymentId);
            if ($payment->status === PaymentStatuses::FAILED) {
                throw new \Exception('Payment failed');
            }
            if ($payment->status === PaymentStatuses::PROCESSING) {
                $this->release(10);
            }
        } catch (\Exception $e) {
            Log::error('Mail Sending Failed | ' . $e->getMessage());
        } finally {
            Log::debug(self::class . ' finished. Total execution time: ' . (microtime(true) - $startTime) / 60);
        }
    }
}
