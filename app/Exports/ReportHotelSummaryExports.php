<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReportHotelSummaryExports implements FromView, WithDrawings, WithTitle, WithStyles
{
    protected $data;
    protected $startDate;
    protected $endDate;
    protected $judul;
    protected $summaryByDate;
    protected $totalMobil;
    protected $totalMotor;
    protected $hotel;

    public function __construct($data, $startDate, $endDate, $judul, $hotel)
    {   
        $this->data = $data;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->judul = $judul;
        $this->hotel = $hotel;

        $summaryByDate = [];
        $totalMobil = 0;
        $totalMotor = 0;
        if ($hotel == 'SCSR') {
           foreach ($data as $result) {
                $tgl = date('Y-m-d', strtotime($result->tanggal)); 
                if (!isset($summaryByDate[$tgl])) {
                    $summaryByDate[$tgl] = ['mobil' => 0, 'motor' => 0, 'total' => 0];
                }
                if ($result->Mobil == 1) {
                    $summaryByDate[$tgl]['mobil']++;
                    $totalMobil++;
                } elseif ($result->Motor == 1) {
                    $summaryByDate[$tgl]['motor']++;
                    $totalMotor++;
                }
                $summaryByDate[$tgl]['total']++;
            }
        } else if ($hotel == 'SBSR') {
            foreach ($data as $result) {
                $tgl = date('Y-m-d', strtotime($result->tanggal_keluar));
                if (!isset($summaryByDate[$tgl])) {
                    $summaryByDate[$tgl] = ['mobil' => 0, 'motor' => 0, 'total' => 0];
                }
                if (strtolower($result->jenis_kendaraan) == 'mobil') {
                    $summaryByDate[$tgl]['mobil']++;
                    $totalMobil++;
                } elseif (strtolower($result->jenis_kendaraan) == 'motor') {
                    $summaryByDate[$tgl]['motor']++;
                    $totalMotor++;
                }
                $summaryByDate[$tgl]['total']++;
            }
        }

        ksort($summaryByDate);

        $this->summaryByDate = $summaryByDate;
        $this->totalMobil = $totalMobil;
        $this->totalMotor = $totalMotor;
    }

    public function view(): View
    {
        return view('exports.reportsummaryhotel', [
            'summaryByDate' => $this->summaryByDate,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'judul' => $this->judul,
            'totalMobil' => $this->totalMobil,
            'totalMotor' => $this->totalMotor,
        ]);
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(public_path('images/Logo Utama.png')); // Path to your logo file
        $drawing->setHeight(50); // Set the height of the logo
        $drawing->setCoordinates('A1'); // Position the logo at cell A1

        return $drawing;
    }

    public function title(): string
    {
        return 'Report QTY Amount';
    }

    public function styles(Worksheet $sheet)
    {
        $jumlahData = count($this->summaryByDate);
        // Apply border to the data range
        $sheet->getStyle('A2:E' . $jumlahData + 3)
              ->getBorders()
              ->getAllBorders()
              ->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A1:E' . $jumlahData + 3)
              ->getAlignment()
              ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:E' . $jumlahData + 3)
                ->getAlignment()
                ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getRowDimension('1')->setRowHeight(80);
        $sheet->getStyle('1')->getFont()->setSize(13);
        $sheet->getStyle('2')->getFont()->setSize(11);
        $sheet->getStyle('1:2')->getFont()->setBold(true);
        $sheet->getStyle('A3:E' . $jumlahData + 3)->getFont()->setSize(9);
        $sheet->getColumnDimension('A')->setWidth(7);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(9);
        $sheet->getColumnDimension('D')->setWidth(9);
        $sheet->getColumnDimension('E')->setWidth(15);
    }
}