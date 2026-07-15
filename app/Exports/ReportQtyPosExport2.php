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

class ReportQtyPosExport2 implements FromView, WithDrawings, WithTitle, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $judul;
    protected $pmm1;

    public function __construct($pmm1_datahours, $startDate, $endDate, $judul)
    {   
        $this->pmm1 = $pmm1_datahours;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->judul = $judul;
    }

    public function view(): View
    {
        return view('exports.reportexcelposqty2', [
            'datahours' => $this->pmm1,
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
        $lastRow = count($this->pmm1) + 3;

        $sheet->getStyle("A2:AA{$lastRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $sheet->getStyle("A1:AA{$lastRow}")
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle("A1:AA{$lastRow}")
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getRowDimension('1')->setRowHeight(80);

        $sheet->getStyle('1')->getFont()->setSize(13);
        $sheet->getStyle('2')->getFont()->setSize(11);
        $sheet->getStyle('1:2')->getFont()->setBold(true);

        $sheet->getStyle("A3:AA{$lastRow}")
            ->getFont()
            ->setSize(9);

        // Width column
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(15);

        foreach (range('C', 'Z') as $column) {
            $sheet->getColumnDimension($column)->setWidth(10);
        }

        $sheet->getColumnDimension('AA')->setWidth(12);

        // Highlight Sunday
        foreach ($this->pmm1 as $row => $result) {
            $excelRow = $row + 3;

            if (date('w', strtotime($result->tanggal)) == 0) {
                $sheet->getStyle("A{$excelRow}:AA{$excelRow}")
                    ->getFont()
                    ->getColor()
                    ->setARGB('FFFF0000');
            }
        }
    }
}
