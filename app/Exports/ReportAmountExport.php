<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportAmountExport implements WithMultipleSheets
{
    use Exportable;

    protected $results;
    protected $car_duration;
    protected $motorcycle_duration;
    protected $startDate;
    protected $endDate;
    protected $judul;

    public function __construct($results, $car_duration, $motorcycle_duration, $startDate, $endDate, $judul)
    {
        $this->results = $results;
        $this->car_duration = $car_duration;
        $this->motorcycle_duration = $motorcycle_duration;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->judul = $judul;
    }

    public function sheets(): array
    {
        return [
            new ReportAmountExport1($this->results, $this->startDate, $this->endDate, $this->judul),
            new ReportAmountExport2($this->car_duration, $this->startDate, $this->endDate, 'Transaksi Perjam Mobil'),
            new ReportAmountExport3($this->motorcycle_duration, $this->startDate, $this->endDate, 'Transaksi Perjam Motor'),
        ];
    }
}