<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportQtyMemberExport implements WithMultipleSheets
{
    use Exportable;

    protected $results;
    protected $car_datahours;
    protected $motorcycle_datahours;
    protected $car_datahours_in;
    protected $motorcycle_datahours_in;
    protected $startDate;
    protected $endDate;
    protected $judul;

    public function __construct($results, $car_datahours, $motorcycle_datahours, 
    $car_datahours_in, $motorcycle_datahours_in, $startDate, $endDate, $judul)
    {
        $this->results = $results;
        $this->car_datahours = $car_datahours;
        $this->motorcycle_datahours = $motorcycle_datahours;
        $this->car_datahours_in = $car_datahours_in;
        $this->motorcycle_datahours_in = $motorcycle_datahours_in;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->judul = $judul;
    }

    public function sheets(): array
    {
        return [
            new ReportQtyMemberExport1($this->results, $this->startDate, $this->endDate, $this->judul),
            new ReportQtyMemberExport2($this->car_datahours, $this->startDate, $this->endDate, 'Transaksi Perjam Mobil'),
            new ReportQtyMemberExport3($this->motorcycle_datahours, $this->startDate, $this->endDate, 'Transaksi Perjam Motor'),
            new ReportQtyMemberExport4($this->car_datahours_in, $this->startDate, $this->endDate, 'Transaksi Perjam Masuk Mobil'),
            new ReportQtyMemberExport5($this->motorcycle_datahours_in, $this->startDate, $this->endDate, 'Transaksi Perjam Masuk Motor'),
        ];
    }
}