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
    protected $truck_duration;
    protected $car_datahours_in;
    protected $motorcycle_datahours_in;
    protected $truck_datahours_in;
    protected $startDate;
    protected $endDate;
    protected $judul;

    public function __construct($results, $car_duration, $motorcycle_duration, $truck_duration ,$car_datahours_in, $motorcycle_datahours_in, $truck_datahours_in,
    $startDate, $endDate, $judul)
    {
        $this->results = $results;
        $this->car_duration = $car_duration;
        $this->motorcycle_duration = $motorcycle_duration;
        $this->truck_duration = $truck_duration;
        $this->car_datahours_in = $car_datahours_in;
        $this->motorcycle_datahours_in = $motorcycle_datahours_in;
        $this->truck_datahours_in = $truck_datahours_in;
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
            new ReportAmountExport6($this->truck_duration, $this->startDate, $this->endDate, 'Transaksi Perjam Truck'),
            new ReportAmountExport4($this->car_datahours_in, $this->startDate, $this->endDate, 'Transaksi Perjam Masuk Mobil'),
            new ReportAmountExport5($this->motorcycle_datahours_in, $this->startDate, $this->endDate, 'Transaksi Perjam Masuk Motor'),
            new ReportAmountExport7($this->truck_datahours_in, $this->startDate, $this->endDate, 'Transaksi Perjam Masuk Truck')
        ];
    }
}