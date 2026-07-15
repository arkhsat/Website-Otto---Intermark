<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportQtyPosExport implements WithMultipleSheets
{
    use Exportable;

    protected $results;
    protected $pmm1;
    protected $pmm2;
    protected $pmmo;
    protected $pkm1;
    protected $pkm2;
    protected $pkmo;
    protected $startDate;
    protected $endDate;
    protected $judul;

    public function __construct($results, $pmm1_datahours, $pmm2_datahours, 
    $pmmo_datahours, $pkm1_datahours, $pkm2_datahours, $pkmo_datahours, $startDate, $endDate, $judul)
    {
        $this->results = $results;
        $this->pmm1 = $pmm1_datahours;
        $this->pmm2 = $pmm2_datahours;
        $this->pmmo = $pmmo_datahours;
        $this->pkm1 = $pkm1_datahours;
        $this->pkm2 = $pkm2_datahours;
        $this->pkmo = $pkmo_datahours;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->judul = $judul;
    }

    public function sheets(): array
    {
        return [
            new ReportQtyPosExport1($this->results, $this->startDate, $this->endDate, $this->judul),
            new ReportQtyPosExport2($this->pmm1, $this->startDate, $this->endDate, 'Pos Masuk Mobil 1'),
            new ReportQtyPosExport3($this->pmm2, $this->startDate, $this->endDate, 'Pos Masuk Mobil 2'),
            new ReportQtyPosExport4($this->pmmo, $this->startDate, $this->endDate, 'Pos Masuk Motor'),
            new ReportQtyPosExport5($this->pkm1, $this->startDate, $this->endDate, 'Pos Keluar Mobil 1'),
            new ReportQtyPosExport6($this->pkm2, $this->startDate, $this->endDate, 'Pos Keluar Mobil 2'),
            new ReportQtyPosExport7($this->pkmo, $this->startDate, $this->endDate, 'Pos Keluar Motor')
            // new ReportQtyMemberExport4($this->car_datahours_in, $this->startDate, $this->endDate, 'Transaksi Perjam Masuk Mobil'),
            // new ReportQtyMemberExport5($this->motorcycle_datahours_in, $this->startDate, $this->endDate, 'Transaksi Perjam Masuk Motor'),
        ];
    }
}