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

class ReportAmountExport1 implements FromView, WithDrawings, WithTitle, WithStyles
{
    protected $data;
    protected $startDate;
    protected $endDate;
    protected $judul;

    public function __construct($data, $startDate, $endDate, $judul)
    {
        $this->data = $data;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->judul = $judul;

    }

    public function view(): View
    {
        return view('exports.reportexcelamount', [
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
        $drawing->setHeight(70); // Set the height of the logo
        $drawing->setCoordinates('A1'); // Position the logo at cell A1

        return $drawing;
    }

    public function title(): string
    {
        return 'Report Pendapatan';
    }

    public function styles(Worksheet $sheet)
    {
        // Apply border to the data range
        $sheet->getStyle('A2:M' . (count($this->data) + 4))
              ->getBorders()
              ->getAllBorders()
              ->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A1:M' . (count($this->data) + 4))
              ->getAlignment()
              ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:M' . (count($this->data) + 4))
                ->getAlignment()
                ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getRowDimension('1')->setRowHeight(80);
        $sheet->getStyle('1')->getFont()->setSize(13);
        $sheet->getStyle('2:3')->getFont()->setSize(11);
        $sheet->getStyle('1:3')->getFont()->setBold(true);
        $sheet->getStyle('A4:M' . (count($this->data) + 3))->getFont()->setSize(9);
        
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(15);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);
        $sheet->getColumnDimension('M')->setWidth(15);

        $sheet->getStyle('B' . (count($this->data) + 6) . ':C' . (count($this->data) + 7))
              ->getBorders()
              ->getAllBorders()
              ->setBorderStyle(Border::BORDER_THIN);
    }
}