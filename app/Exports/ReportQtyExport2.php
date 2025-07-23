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

class ReportQtyExport2 implements FromView, WithDrawings, WithTitle, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $judul;
    protected $car_datahours;

    public function __construct($car_datahours, $startDate, $endDate, $judul)
    {   
        $this->car_datahours = $car_datahours;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->judul = $judul;
    }

    public function view(): View
    {
        return view('exports.reportexcelqty2', [
            'datahours' => $this->car_datahours,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'judul' => $this->judul,
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
        // Apply border to the data range
        $sheet->getStyle('A2:P' . (count($this->car_datahours) + 3))
              ->getBorders()
              ->getAllBorders()
              ->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A1:P' . (count($this->car_datahours) + 3))
              ->getAlignment()
              ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:P' . (count($this->car_datahours) + 3))
                ->getAlignment()
                ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getRowDimension('1')->setRowHeight(80);
        $sheet->getStyle('1')->getFont()->setSize(13);
        $sheet->getStyle('2')->getFont()->setSize(11);
        $sheet->getStyle('1:2')->getFont()->setBold(true);
        $sheet->getStyle('A3:P' . (count($this->car_datahours) + 3))->getFont()->setSize(9);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(10);
        $sheet->getColumnDimension('I')->setWidth(10);
        $sheet->getColumnDimension('J')->setWidth(10);
        $sheet->getColumnDimension('K')->setWidth(10);
        $sheet->getColumnDimension('L')->setWidth(10);
        $sheet->getColumnDimension('M')->setWidth(10);
        $sheet->getColumnDimension('N')->setWidth(10);
        $sheet->getColumnDimension('O')->setWidth(10);
        $sheet->getColumnDimension('P')->setWidth(20);
    }
}
