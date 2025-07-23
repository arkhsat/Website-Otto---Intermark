<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportHotelUtama implements WithMultipleSheets
{
    use Exportable;

    protected $data;
    protected $startDate;
    protected $endDate;
    protected $judul;
    protected $hotel;

    public function __construct($data, $startDate, $endDate, $judul, $hotel)
    {   
        $this->data = $data;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->judul = $judul;
        $this->hotel = $hotel;
    }

    public function sheets(): array
    {   
        if ($this->hotel == 'SCSR') {
            return [
                new ReportSCSRExports($this->data, $this->startDate, $this->endDate, 'Detail Transaksi Hotel'),
                new ReportHotelSummaryExports($this->data, $this->startDate, $this->endDate, 'Summary Transaksi Hotel SCSR', $this->hotel),
            ];
        } else if ($this->hotel == 'SBSR') {
            return [
                new ReportSBSRExports($this->data, $this->startDate, $this->endDate, 'Detail Transaksi Hotel'),
                new ReportHotelSummaryExports($this->data, $this->startDate, $this->endDate, 'Summary Transaksi Hotel SBSR', $this->hotel),
            ];
        }
        
        return [];
    }

}
