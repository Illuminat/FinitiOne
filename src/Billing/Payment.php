<?php

namespace FinitiOne\Billing;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Payment
{
    public UuidInterface $id;
    public int $amount;
    public string $currency;

    public int $status = 0;

    public function __construct(UuidInterface $id, int $amount, string $currency, int $status = 0)
    {
        $this->id = $id;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->status = $status;
    }

    public function updateStatus($status): void
    {
        $this->status = $status;
    }

}