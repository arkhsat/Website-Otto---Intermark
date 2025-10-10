<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportVoucherExports implements WithMultipleSheets
{
    use Exportable;

    protected $results;
    protected $startDate;
    protected $endDate;
    protected $judul;

    public function __construct($results, $startDate, $endDate, $judul)
    {
        $this->results = $results;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->judul = $judul;
    }

    public function sheets(): array
    {
        return [
            new ReportVoucher1($this->results, $this->startDate, $this->endDate, 'Report Penggunaan Voucher'),
            new ReportVoucher1($this->results, $this->startDate, $this->endDate, 'Penggunaan Voucher Mobil'),
            new ReportVoucher1($this->results, $this->startDate, $this->endDate, 'Penggunaan Voucher Motor'),
            new ReportVoucher1($this->results, $this->startDate, $this->endDate, 'Penggunaan Voucher Truk'),
        ];
    }
}