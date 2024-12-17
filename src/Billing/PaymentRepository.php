<?php

namespace FinitiOne\Billing;

use Illuminate\Support\Facades\Redis;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class PaymentRepository
{
    private \Illuminate\Redis\Connections\Connection $connection;
    public function __construct()
    {
        $this->connection = Redis::connection();
    }

    /**
     * @throws \JsonException
     */
    public function findById(UuidInterface $id): ?Payment
    {
        $data = $this->connection->get('transaction_' . $id->toString());
        if (empty($data)) {
            return null;
        }
        $data = json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        return new Payment(Uuid::fromString($data['id']), $data->amount, $data->currency);
    }

    /**
     * @throws \JsonException
     */
    public function save(Payment $payment): void
    {
        $this->connection->set('transaction_' . $payment->id->toString(), json_encode($payment, JSON_THROW_ON_ERROR));
    }
}