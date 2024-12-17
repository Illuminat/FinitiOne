<?php

namespace App\Console\Commands;

use FinitiOne\Billing\Action\CreatePaymentAction;
use FinitiOne\Billing\DTO\CreatePaymentDTO;
use FinitiOne\Billing\Job\TransferJob;
use Illuminate\Console\Command;

class ProcessPaymentTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:process-transaction {amount} {currency} {--queue=default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(CreatePaymentAction $action): void
    {
        try {
            $paymentId = $action->handle((new CreatePaymentDTO($this->argument('amount'), $this->argument('currency'))));
            TransferJob::dispatch($paymentId);
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }
    }
}
