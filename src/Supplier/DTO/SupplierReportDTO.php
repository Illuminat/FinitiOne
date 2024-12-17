<?php

namespace FinitiOne\Supplier\DTO;

use DateTimeImmutable;

class SupplierReportDTO
{
    public string $type = '';
    public DateTimeImmutable $dateFrom;
    public DateTimeImmutable $dateTo;

    public function __construct(string $type, DateTimeImmutable $dateFrom, DateTimeImmutable $dateTo)
    {
        if ($dateFrom > $dateTo) {
            throw new \InvalidArgumentException("Expected dateTo to be greater than dateFrom");
        }
        $this->type = $type;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }
}