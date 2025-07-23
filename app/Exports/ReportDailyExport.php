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

class ReportDailyExport implements FromView, WithDrawings, WithTitle, WithStyles
{
    protected $data;
    protected $Date;
    protected $judul;

    public function __construct($data, $Date, $judul)
    {
        $this->data = $data;
        $this->Date = $Date;
        $this->judul = $judul;
    }

    public function view(): View
    {
        return view('exports.reportexceldaily', [
            'data' => $this->data,
            'Date' => $this->Date,
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
        return 'Report Harian';
    }

    public function styles(Worksheet $sheet)
    {
        // Apply border to the data range
        $sheet->getStyle('A2:D15')
              ->getBorders()
              ->getAllBorders()
              ->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('1:2')
              ->getAlignment()
              ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A:C')
              ->getAlignment()
              ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:D15')
                ->getAlignment()
                ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('D3:D15')
              ->getAlignment()
              ->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        

        $sheet->getStyle('1')->getFont()->setSize(13);
        $sheet->getStyle('2:3')->getFont()->setSize(11);
        $sheet->getStyle('1:2')->getFont()->setBold(true);
        $sheet->getStyle('A3:D15')->getFont()->setSize(9);

        $sheet->getRowDimension('1')->setRowHeight(80);
        $sheet->getRowDimension('2')->setRowHeight(25);

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(17);
        $sheet->getColumnDimension('D')->setWidth(25);
    }
}