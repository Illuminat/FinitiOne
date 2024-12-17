<?php

namespace FinitiOne\Billing\Action;

use FinitiOne\Billing\DTO\CreatePaymentDTO;
use FinitiOne\Billing\Payment;
use FinitiOne\Billing\PaymentRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class CreatePaymentAction
{
    private PaymentRepository $repository;

    public function __construct(PaymentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws \JsonException
     */
    public function handle(CreatePaymentDTO $dto): UuidInterface
    {
        if ($dto->amount < 0) {
            throw new \RuntimeException('invalid amount');
        }

        if ($dto->currency !== 'USD') {
            throw new \RuntimeException('invalid currency');
        }
        $id = Uuid::uuid4();
        $payment = new Payment($id, round($dto->amount * 100, 0), $dto->currency);
        $this->repository->save($payment);
        return $id;
    }
}