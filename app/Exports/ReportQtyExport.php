<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportQtyExport implements WithMultipleSheets
{
    use Exportable;

    protected $results;
    protected $car_datahours;
    protected $motorcycle_datahours;
    protected $startDate;
    protected $endDate;
    protected $judul;

    public function __construct($results, $car_datahours, $motorcycle_datahours, $startDate, $endDate, $judul)
    {
        $this->results = $results;
        $this->car_datahours = $car_datahours;
        $this->motorcycle_datahours = $motorcycle_datahours;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->judul = $judul;
    }

    public function sheets(): array
    {
        return [
            new ReportQtyExport1($this->results, $this->startDate, $this->endDate, $this->judul),
            new ReportQtyExport2($this->car_datahours, $this->startDate, $this->endDate, 'Transaksi Perjam Mobil'),
            new ReportQtyExport3($this->motorcycle_datahours, $this->startDate, $this->endDate, 'Transaksi Perjam Motor'),
        ];
    }
}