<?php

namespace FinitiOne\Supplier;

use FinitiOne\Supplier\DTO\SupplierReportDTO;
use FinitiOne\Supplier\Enum\ReportTypes;
use FinitiOne\Supplier\Query\SalesQuery;
use \Exception;

class ReportService
{

    private array $reportTypesClasses = [
        ReportTypes::SALES => SalesQuery::class,
    ];
    public function __construct()
    {

    }
    public function generateReport(SupplierReportDTO $data): void
    {
        if (!array_key_exists($data->type, $this->reportTypesClasses)) {
            throw new Exception('undefined report type');
        }
        $report = (new $this->reportTypesClasses[$data->type]())->handle($data->dateFrom, $data->dateTo);
        // Logic with sending email, save like excel etc;
    }
}