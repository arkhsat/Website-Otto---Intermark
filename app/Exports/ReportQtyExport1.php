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

class ReportQtyExport1 implements FromView, WithDrawings, WithTitle, WithStyles
{
    protected $data;
    protected $startDate;
    protected $endDate;
    protected $judul;
    protected $car_datahours;
    protected $motorcycle_datahours;
    protected $truck_datahours;

    public function __construct($data, $startDate, $endDate, $judul)
    {   
        $this->data = $data;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->judul = $judul;
    }

    public function view(): View
    {
        return view('exports.reportexcelqty', [
            'data' => $this->data,
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
        $sheet->getStyle('A2:R' . (count($this->data) + 4))
              ->getBorders()
              ->getAllBorders()
              ->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A1:R' . (count($this->data) + 4))
              ->getAlignment()
              ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:R' . (count($this->data) + 4))
                ->getAlignment()
                ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getRowDimension('1')->setRowHeight(80);
        $sheet->getStyle('1')->getFont()->setSize(13);
        $sheet->getStyle('2:3')->getFont()->setSize(11);
        $sheet->getStyle('1:3')->getFont()->setBold(true);
        $sheet->getStyle('A4:R' . (count($this->data) + 3))->getFont()->setSize(9);
        $sheet->getColumnDimension('B')->setWidth(15);

        $sheet->getStyle('B' . (count($this->data) + 6) . ':C' . (count($this->data) + 8))
              ->getBorders()
              ->getAllBorders()
              ->setBorderStyle(Border::BORDER_THIN);

        foreach ($this->data as $row => $result) {
            $excelRow = $row + 4;
            if (date('w', strtotime($result->date)) == 0) {
                $sheet->getStyle("A{$excelRow}:R{$excelRow}")->getFont()->getColor()->setARGB('FFFF0000');
            }
        }
    }
}