<?php

namespace FinitiOne\Billing\DTO;

class CreatePaymentDTO
{
    public float  $amount;
    public string $currency;

    public function __construct(float $amount, string $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }
}