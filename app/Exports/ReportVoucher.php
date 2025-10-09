<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportVoucher implements WithMultipleSheets
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
            new ReportQtyExport1($this->results, $this->startDate, $this->endDate, 'Report Penggunaan Voucher'),
            new ReportQtyExport2($this->results, $this->startDate, $this->endDate, 'Transaksi Perjam Mobil'),
            new ReportQtyExport3($this->results, $this->startDate, $this->endDate, 'Transaksi Perjam Motor'),
            new ReportQtyExport4($this->results, $this->startDate, $this->endDate, 'Transaksi Perjam Masuk Mobil'),
        ];
    }
}