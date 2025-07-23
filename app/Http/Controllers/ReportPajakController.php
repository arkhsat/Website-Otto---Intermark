<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\DB;
use Svg\Tag\Rect;
use Carbon\Carbon;

class ReportPajakController extends Controller
{
    public function index()
    {
        return view('report_pajak.index');
    }

    public function data(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $reportname = 'LAPORAN PAJAK PARKIR BULAN ' . $bulan . ' TAHUN ' . $tahun;
        $results = DB::select("
            SELECT date(dateout) as tanggal_transaksi,
            sum(cost) as amount from transactions
            where MONTH(dateout) = ? and YEAR(dateout) = ?
            group by date(dateout)
            order by date(dateout) asc
        ",[$bulan, $tahun]);
        return view('report_pajak.index',compact('results', 'bulan', 'tahun', 'reportname'));
    }

    public function generate(Request $request)  
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $results = DB::select("
            SELECT date(dateout) as tanggal_transaksi,
            sum(cost) as amount from transactions
            where MONTH(dateout) = ? and YEAR(dateout) = ?
            group by date(dateout)
            order by date(dateout) asc
        ",[$bulan, $tahun]);

        // Load template
        $templatePath = storage_path('app\public\templates\template_laporan.docx');
        $templateProcessor = new TemplateProcessor($templatePath);

        $sampai16 = 0;
        $sampai31 = 0;
        $total = 0;
        for ($i = 1; $i <= 31; $i++) {
            ${"tanggal_$i"} = 0; // membuat $tanggal_1, $tanggal_2, ..., $tanggal_31
        }


        foreach ($results as $row) {
            $hari = Carbon::parse($row->tanggal_transaksi)->day;
            // $templateProcessor->setValue("tanggal_$hari", number_format($row->amount, 0, ',', '.'));
            ${"tanggal_$hari"} = number_format($row->amount, 0, ',', '.');
            if ($hari <= '16') {
                $sampai16 += $row->amount;
            } else {
                $sampai31 += $row->amount;
            }
            $total += $row->amount;
        }

        for ($i = 1; $i <= 31; $i++) {
            $templateProcessor->setValue("tanggal_$i", ${"tanggal_$i"});
        }

        $total_pajak = $total * 0.1;
        
        $namabulan = Carbon::create()->month($bulan)->translatedFormat('F');

        $templateProcessor->setValue("sampai16", number_format($sampai16, 0, ',', '.'));
        $templateProcessor->setValue("sampai31", number_format($sampai31, 0, ',', '.'));
        $templateProcessor->setValue("total", number_format($total, 0, ',', '.'));
        $templateProcessor->setValue("total_pajak", number_format($total_pajak, 0, ',', '.'));
        $templateProcessor->setValue("bulan", $namabulan);
        $templateProcessor->setValue("tahun", $tahun);

        // Simpan hasil ke file sementara
        $outputPath = storage_path('app\public\Laporan Pajak Intermark Bulan '.$namabulan.' '.$tahun.'.docx');
        $templateProcessor->saveAs($outputPath);

        // Kirim file ke user
        return response()->download($outputPath)->deleteFileAfterSend(true);
    }
}
