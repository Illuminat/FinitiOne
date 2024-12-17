<?php

namespace FinitiOne\Billing;

use Ramsey\Uuid\UuidInterface;
use Random\RandomException;
use function Symfony\Component\Translation\t;

class PaymentService
{
    private PaymentRepository $repository;

    public function __construct(PaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws RandomException
     * @throws \JsonException
     */
    public function process(UuidInterface $id): Payment
    {
        $payment = $this->repository->findById($id);

        if ($payment === null) {
            throw new \RuntimeException('Payment not found' . $id->toString());
        }
        if ($payment->status !== 1) {
            throw new \RuntimeException('Payment already processed' . $id->toString());
        }

        $payment->updateStatus(random_int(0,2));
        $this->repository->save($payment);
        return $payment;
    }

}